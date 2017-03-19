<?php

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements SnippetAcceptingContext {

  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct() {
  }

  /**
   * Goes to logged in user's edit page.
   *
   * @When I edit my account
   */
  public function whenIEditMyAccount() {
    if (!$this->loggedIn()) {
      throw new \Exception('Not logged in');
    }

    $this->getSession()->visit($this->locatePath('/user'));
    $this->getSession()->getPage()->clickLink('Edit');
  }

}
