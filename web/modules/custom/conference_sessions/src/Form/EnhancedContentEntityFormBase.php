<?php

namespace Drupal\conference_sessions\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\EntityOwnerInterface;

abstract class EnhancedContentEntityFormBase extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $form = parent::form($form, $form_state);
    $form['#tree'] = TRUE;
    $form['#theme'] = ['conference_sessions_entity_form'];
    $form['#attached']['library'][] = 'conference_sessions/entity_form';
    $form['meta'] = [
      '#attributes' => ['class' => ['entity-meta__header']],
      '#type' => 'container',
      '#group' => 'advanced',
      '#weight' => -100,
      'published' => [
        '#type' => 'html_tag',
        '#tag' => 'h3',
        '#value' => $entity->isPublished() ? $this->t('Published') : $this->t('Not published'),
        '#access' => !$entity->isNew(),
        '#attributes' => [
          'class' => 'entity-meta__title',
        ],
      ],
      'changed' => [
        '#type' => 'item',
        '#wrapper_attributes' => [
          'class' => ['entity-meta__last-saved', 'container-inline']
        ],
        '#markup' => '<h4 class="label inline">' . $this->t('Last saved') . '</h4> ' . $entity->getChangedTime(),
      ],
    ];
    if ($this->entity instanceof EntityOwnerInterface) {
      $form['meta']['author'] = [
        '#type' => 'item',
        '#wrapper_attributes' => [
          'class' => ['author', 'container-inline']
        ],
        '#markup' => '<h4 class="label inline">' . $this->t('Author') . '</h4> ' . $entity->getOwner()->getDisplayName(),
      ];
    }

    $form['advanced'] = [
      '#type' => 'container',
      '#attributes' => ['class' => ['entity-meta']],
      '#weight' => 99,
    ];
    $form['visibility_settings'] = [
      '#type' => 'details',
      '#title' => t('Visibility settings'),
      '#open' => TRUE,
      '#group' => 'advanced',
      '#access' => !empty($form['stores']['#access']),
      '#attributes' => [
        'class' => ['product-visibility-settings'],
      ],
      '#weight' => 30,
    ];
    $form['path_settings'] = [
      '#type' => 'details',
      '#title' => t('URL path settings'),
      '#open' => !empty($form['path']['widget'][0]['alias']['#value']),
      '#group' => 'advanced',
      '#access' => !empty($form['path']['#access']) && $entity->get('path')->access('edit'),
      '#attributes' => [
        'class' => ['path-form'],
      ],
      '#attached' => [
        'library' => ['path/drupal.path'],
      ],
      '#weight' => 60,
    ];
    $form['author'] = [
      '#type' => 'details',
      '#title' => t('Authoring information'),
      '#group' => 'advanced',
      '#attributes' => [
        'class' => ['product-form-author'],
      ],
      '#attached' => [
        'library' => ['commerce_product/drupal.commerce_product'],
      ],
      '#weight' => 90,
      '#optional' => TRUE,
    ];
    if (isset($form['uid'])) {
      $form['uid']['#group'] = 'author';
    }
    if (isset($form['created'])) {
      $form['created']['#group'] = 'author';
    }
    if (isset($form['path'])) {
      $form['path']['#group'] = 'path_settings';
    }

    return $form;
  }

  /**
   * Entity builder: updates the product status with the submitted value.
   *
   * @param string $entity_type
   *   The entity type.
   * @param \Drupal\commerce_product\Entity\ProductInterface $entity
   *   The product updated with the submitted values.
   * @param array $form
   *   The complete form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @see \Drupal\node\NodeForm::form()
   */
  public static function updateStatus($entity_type, EntityInterface $entity, array $form, FormStateInterface $form_state) {
    $element = $form_state->getTriggeringElement();
    if (isset($element['#published_status'])) {
      $entity->setPublished($element['#published_status']);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $element = parent::actions($form, $form_state);
    $entity = $this->entity;

    $element['delete']['#access'] = $entity->access('delete');
    $element['delete']['#weight'] = 100;
    // Add a "Publish" button.
    $element['publish'] = $element['submit'];
    $element['publish']['#published_status'] = TRUE;
    $element['publish']['#dropbutton'] = 'save';
    $element['publish']['#weight'] = 0;
    // Add an "Unpublish" button.
    $element['unpublish'] = $element['submit'];
    $element['unpublish']['#published_status'] = FALSE;
    $element['unpublish']['#dropbutton'] = 'save';
    $element['unpublish']['#weight'] = 10;
    // isNew | prev status » primary   & publish label             & unpublish label
    // 1     | 1           » publish   & Save and publish          & Save as unpublished
    // 1     | 0           » unpublish & Save and publish          & Save as unpublished
    // 0     | 1           » publish   & Save and keep published   & Save and unpublish
    // 0     | 0           » unpublish & Save and keep unpublished & Save and publish
    if ($entity->isNew()) {
      $element['publish']['#value'] = $this->t('Save and publish');
      $element['unpublish']['#value'] = $this->t('Save as unpublished');
    }
    else {
      $element['publish']['#value'] = $entity->isPublished() ? $this->t('Save and keep published') : $this->t('Save and publish');
      $element['unpublish']['#value'] = !$entity->isPublished() ? $this->t('Save and keep unpublished') : $this->t('Save and unpublish');
    }
    // Set the primary button based on the published status.
    if ($entity->isPublished()) {
      unset($element['unpublish']['#button_type']);
    }
    else {
      unset($element['publish']['#button_type']);
      $element['unpublish']['#weight'] = -10;
    }
    // Hide the now unneeded "Save" button.
    $element['submit']['#access'] = FALSE;

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $entity->save();
    drupal_set_message($this->t('The %label has been successfully saved.', ['%label' => $entity->label()]));
    $form_state->setRedirectUrl($entity->toUrl());
  }
}