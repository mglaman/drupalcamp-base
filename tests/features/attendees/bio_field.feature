# This is dirty and assumes state: Field does not exist, and order of execution. ¯\_(ツ)_/¯
Feature: Configuring the attendee bio field
  Conferences allow for attendee bios
  So that attendees can get all personal and stuff.

  @api
  Scenario: As an admin, I can add a bio field.
    Given I am logged in as a user with the "administer conference attendees" permission
    And I am on "/admin/conference/config/attendees"
    Then I check the box "Allow attendees to provide a personal bio"
    And I press "Save configuration"
    Then I should see "The configuration options have been saved."
    # Local tasks block just won't clear.
    And the cache has been cleared

  @api
  Scenario: As an attendee, I can set a bio
    Given I am logged in as a user with the "authenticated" role
    When I edit my account
      And I click "General"
    Then I should see "Bio"
