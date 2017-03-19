# This is dirty and assumes state: Field does not exist, and order of execution. ¯\_(ツ)_/¯
Feature: Configuring the attendee organization fields
  Conferences allow for attendees to list organiztion info
  So that attendees can rep their companies.

  @api
  Scenario: As an admin, I can add a bio field.
    Given I am logged in as a user with the "administer conference attendees" permission
    And I am on "/admin/conference/config/attendees"
    Then I check the box "Allow attendees to enter organization info"
    And I press "Save configuration"
    Then I should see "The configuration options have been saved."
    # Local tasks block just won't clear.
    And the cache has been cleared

  @api
  Scenario: As an attendee, I can set a bio
    Given I am logged in as a user with the "verified attendee" permission
    When I edit my account
    And I click "Organization"
    Then I should see "Job title"
    Then I should see "Organization"
    Then I should see "Organization website"
