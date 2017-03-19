<?php

namespace Drupal\conference_attendees\Form;

use Drupal\commerce\ConfigurableFieldManagerInterface;
use Drupal\conference_attendees\ConfigurableBundles;
use Drupal\conference_attendees\ConfigurableFields;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SettingsForm extends ConfigFormBase {

  /**
   * The configurable field manager.
   *
   * @var \Drupal\commerce\ConfigurableFieldManagerInterface
   */
  protected $configurableFieldManager;

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $profileTypeStorage;

  /**
   * protected $profileTypeStorage;
   *
   * /**
   * Constructs a new SettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\commerce\ConfigurableFieldManagerInterface $configurable_field_manager
   *   The configurable field manager.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ConfigurableFieldManagerInterface $configurable_field_manager, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($config_factory);
    $this->configurableFieldManager = $configurable_field_manager;
    $this->profileTypeStorage = $entity_type_manager->getStorage('profile_type');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('commerce.configurable_field_manager'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'conference_attendees_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $config = $this->config('conference_attendees.settings');
    $form['general'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('General information'),
      '#summary' => $this->t('Allows attendees to add general information about themselves'),
    ];
    // @todo disable if it has data, so it cannot be removed.
    $form['general']['enable_attendee_bio'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow attendees to provide a personal bio'),
      '#default_value' => $config->get('enable_attendee_bio'),
    ];
    // @todo disable if it has data, so it cannot be removed.
    $form['general']['enable_organization_info'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow attendees to enter organization info'),
      '#description' => $this->t('This allows attendees to provide information about their employer or the organization they will be representing.'),
      '#default_value' => $config->get('enable_organization_info'),
    ];

    $form['preferences'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Preference options'),
      '#summary' => $this->t('Allows attendees to specify specific preferences'),
    ];
    $form['preferences']['enable_dietary_preference'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow attendees to specify and dietary needs'),
      '#description' => $this->t('If there will be snacks, lunch, or dinner served this allows attendees to specify any dietary needs they have.'),
      '#default_value' => $config->get('enable_dietary_preference'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('conference_attendees.settings');
    $form_state->cleanValues();
    foreach ($form_state->getValues() as $key => $value) {
      switch ($key) {
        case 'enable_attendee_bio':
          // @todo uninstall if unchecked.
          if ($value) {
            $this->installAttendeeBioField();
          }
          break;
        case 'enable_organization_info':
          // @todo uninstall if unchecked.
          if ($value) {
            $this->installOrganizationFields();
          }
          break;
        case 'enable_dietary_preference':
          if ($value) {
            $this->installPreferenceDietaryField();
          }
          break;
      }

      $config->set($key, $value);
    }
    $config->save();

    // @todo inject. makes links appear on user page because it has perm cache
    \Drupal::entityTypeManager()->getViewBuilder('block')->resetCache();
    // @todo inject, try to just do setRebuildNeeded.
    // Need to rebuild so that new profile types show up in user tabs.
    \Drupal::getContainer()->get('router.builder')->rebuild();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['conference_attendees.settings'];
  }

  /**
   * Ensures that the general profile type bundle is present.
   *
   * @return \Drupal\profile\Entity\ProfileTypeInterface
   *   The profile type.
   */
  protected function ensureGeneralProfileType() {
    $bundle = $this->profileTypeStorage->load('general');
    if (!$bundle) {
      $bundle = ConfigurableBundles::getGeneralProfileType();
      $this->profileTypeStorage->save($bundle);
    }
    return $bundle;
  }

  /**
   * Installs the attendee bio field on general profile type.
   */
  protected function installAttendeeBioField() {
    $bundle = $this->ensureGeneralProfileType();
    try {
      $bundle_field = ConfigurableFields::getBioField($bundle);
      $this->configurableFieldManager->createField($bundle_field);
    }
    catch (\RuntimeException $e) {
      // @todo properly check if field exists first instead of just catching.
    }
    catch (\Exception $e) {
      drupal_set_message($this->t('There was an error adding the attendee bio field'), 'error');
    }
  }

  /**
   * Ensures that the organization profile type bundle is present.
   *
   * @return \Drupal\profile\Entity\ProfileTypeInterface
   *   The profile type.
   */
  protected function ensureOrganizationProfileType() {
    $bundle = $this->profileTypeStorage->load('organization');
    if (!$bundle) {
      $bundle = ConfigurableBundles::getOrganizationProfileType();
      $this->profileTypeStorage->save($bundle);
    }
    return $bundle;
  }

  /**
   * Installs the attendee bio field on general profile type.
   */
  protected function installOrganizationFields() {
    $bundle = $this->ensureOrganizationProfileType();
    try {
      $bundle_field = ConfigurableFields::getOrganizationNameField($bundle);
      $this->configurableFieldManager->createField($bundle_field);
    }
    catch (\RuntimeException $e) {
      // @todo properly check if field exists first instead of just catching.
    }
    catch (\Exception $e) {
      drupal_set_message($this->t('There was an error adding the organization name field'), 'error');
    }
    try {
      $bundle_field = ConfigurableFields::getOrganizationWebsiteField($bundle);
      $this->configurableFieldManager->createField($bundle_field);
    }
    catch (\RuntimeException $e) {
      // @todo properly check if field exists first instead of just catching.
    }
    catch (\Exception $e) {
      drupal_set_message($this->t('There was an error adding the organization website field'), 'error');
    }
    try {
      $bundle_field = ConfigurableFields::getOrganizationJobTitleField($bundle);
      $this->configurableFieldManager->createField($bundle_field);
    }
    catch (\RuntimeException $e) {
      // @todo properly check if field exists first instead of just catching.
    }
    catch (\Exception $e) {
      drupal_set_message($this->t('There was an error adding the organization job title field'), 'error');
    }
  }

  /**
   * Ensures that the general profile type bundle is present.
   *
   * @return \Drupal\profile\Entity\ProfileTypeInterface
   *   The profile type.
   */
  protected function ensurePreferencesProfileType() {
    $bundle = $this->profileTypeStorage->load('preferences');
    if (!$bundle) {
      $bundle = ConfigurableBundles::getPreferencesProfileType();
      $this->profileTypeStorage->save($bundle);
    }
    return $bundle;
  }

  /**
   * Installs the attendee bio field on general profile type.
   */
  protected function installPreferenceDietaryField() {
    $bundle = $this->ensurePreferencesProfileType();
    try {
      $bundle_field = ConfigurableFields::getPreferenceDietaryField($bundle);
      $this->configurableFieldManager->createField($bundle_field);
    }
    catch (\RuntimeException $e) {
      // @todo properly check if field exists first instead of just catching.
    }
    catch (\Exception $e) {
      drupal_set_message($e->getMessage(), 'error');
      drupal_set_message($this->t('There was an error adding the dietary needs field'), 'error');
    }
  }

}
