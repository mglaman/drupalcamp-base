Feature: Manage locations
  As a conference organize
  I can add venues and rooms
  So I can say where events and sessions are happening

  @api
  Scenario: A venue can be added
    Given I am logged in as a user with the "access conference administration pages,administer conference_location" permissions
    When I am on "/admin/conference"
    Then I click "Locations"
    And I click "Add location"

  @javascript @api
  Scenario: Add a venue
    Given I am logged in as a user with the "access conference administration pages,administer conference_location" permissions
      And I am on "/location/add"
    Then I fill in "Name" with "University of Testing"
    When I select "United States" from "Country"
      And I wait for AJAX to finish
    Then I fill in the following:
    | Street address  | 1098 Alta Ave |
    | State | CA                      |
    | City  | Mountain View           |
    | Zip code | 94043                |
    Then I press "Add new room"
      And I wait for AJAX to finish
    And I fill in "rooms[form][inline_entity_form][name][0][value]" with "Room 1A"
      And I press "Create room"
      And I wait for AJAX to finish
    Then I press "Add new room"
      And I wait for AJAX to finish
    And I fill in "rooms[form][inline_entity_form][name][0][value]" with "Room 1B"
      And I press "Create room"
      And I wait for AJAX to finish
    Then I press "Save"
      And I should see "Saved the University of Testing location"