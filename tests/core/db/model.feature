@Uc\Db\Model
Feature: Check Model class

  # set one_to_one or many_to_many relation object
  @Uc\Db\Model-Set/Get-Relations
  Scenario: Set relations select
    Given I create test data

    When I set passport 5 to user 1
    Then I expect user 1 has 1 Passport

    When I set user 1 to cars 1
    And I set user 1 to cars 2
    Then I expect user 1 has 2 Cars

    When I set user 1 to cars 3
    Then I expect user 1 has 3 Cars


  # add connections in many_to_many relations
  @Uc\Db\Model-Add/Get-Relations
  Scenario: Relations select
    Given I create test data

    When I add house 5 to user 2
    And I add house 3 to user 2
    And I add house 4 to user 2
    Then I expect user 2 has 3 Houses

    When I add house 2 to user 2
    Then I expect user 2 has 4 Houses

    When I add house 2 to user 2
    And I add house 2 to user 2
    And I add house 2 to user 2
    Then I expect user 2 has 4 Houses
    And I expect user 1 has 0 Houses

