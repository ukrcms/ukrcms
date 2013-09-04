@Uc\Db\Table
Feature: Check table class

  Scenario: save items
    Given i clean office users
    Given i create office user 1
    Then i expect number of office users equal 1

