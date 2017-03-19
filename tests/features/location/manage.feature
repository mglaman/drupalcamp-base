Feature: Manage locations
  As a conference organize
  I can add venues and rooms
  So I can say where events and sessions are happening

  @api
  Scenario: Add a venue
    Given I am logged in as a user with the "administer conference_location" permission
    When I am on "/admin/conference"
      And I click "Locations"
    And I should see the link "Add"