Schedule of things in Event
* Allows making sense of Event and Sessions

Entity Schedule
* References assignments
* Each assignment is technically, mostly, unique
* Bundles: could be event schedule, or volunteer schedule

Entity: Assignment
* Has DateTime+Entity reference
* Allows scheduling of the program
* Adds metadata

Custom field: DateTime + Location
* On validation check if anything references location at that time, or overlap
* Allow duplicate scheduling
** Has to respect its it, and others
* Let the target entity type be configurable, so it could to schedule Events @ Time, or USERS @ Time like volunteers