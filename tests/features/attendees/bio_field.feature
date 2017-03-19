# This is dirty and assumes state: Field does not exist, and order of execution. ¯\_(ツ)_/¯
Feature: Configuring the attendee bio field
  Conferences allow for attendee bios
  So that attendees can get all personal and stuff.

  @api
  Scenario: As an admin, I can add a bio field.
    Given I am logged in as a user with the "administer conference attendees" permission
    And I am on "/admin/conference/attendees/settings"
    Then I check the box "Allow attendees to provide a personal bio"
    And I press "Save configuration"
    Then I should see "The configuration options have been saved."

  @api
  Scenario: As an attendee, I can set a bio
    Given I am logged in as a user with the "verified attendee" permission
    When I edit my account
    Then I should see "Bio"
