@Uc\Db\Select
Feature: Check select class

  @Uc\Db\Select-RelationOneOne
  Scenario: Relations select
    Given I create test data

    When I set passport 5 to user 1
    Then I expect 1 item of passport in user 1
    Then I expect 1 item of user in passport 5

    When I set passport 4 to user 2
    When I set passport 3 to user 2
    Then I expect 1 item of passport in user 2

    And I expect 0 items of passport in user 3


  @Uc\Db\Select-RelationOneMany
  Scenario: Relations select
    Given I create test data

    When I set user 1 to car 2
    When I set user 1 to car 3
    Then I expect 2 items of cars in user 1


  @Uc\Db\Select-RelationManyMany
  Scenario: Relations select
    Given I create test data
    When I add house 5 to user 2
    And I add house 3 to user 2
    And I add house 4 to user 2
    And I add house 4 to user 3
    And I add house 3 to user 3
    And I add house 4 to user 4

    Then I expect 3 items of houses in user 2
    Then I expect 1 item of houses in user 4
    Then I expect 0 item of houses in user 5

    When I add house 4 to user 2
    Then I expect 3 items of houses in user 2

    When I add house 1 to user 2
    Then I expect 4 items of houses in user 2

  @Code\Db\Select\Build
  Scenario: Check select build
    Given I init select
    Then I call status is 10, 20
    Then I select with Houses 14
    Then I expect same select on build twice


  @Code\Db\Select\WhereIs
  Scenario: Check where Is condition
    Given I init select
    When I call status is 10, 20
    Then I expect: .status IN ('10', '20')

    Given I init select
    When I call status is 5
    Then I expect: .status = '5'


  @Code\Db\Select\WhereNot
  Scenario: Check Not condition
    Given I init select
    When I call user_id not 11
    Then I expect: .user_id != '11'

    Given I init select
    When I call user_id not 13, 44
    Then I expect: .user_id NOT IN ('13', '44')


  @Code\Db\Select\WhereGt
  Scenario: Check Gt condition
    Given I init select
    When I call comments_num gt 44
    Then I expect: .comments_num > '44'

    Given I init select
    When I call comments_num gt 80, 90
    Then I expect: .comments_num > '80'
    Then I expect:  OR
    Then I expect: .comments_num > '90'

    Given I init select
    When I call authors gt 5
    When I call authors gt 1
    Then I expect: .authors > '1'
    Then I don't expect: .authors > '5'


  @Code\Db\Select\WhereGtEq
  Scenario: Check GtEq condition

    Given I init select
    When I call revision gtEq 48
    Then I expect: .revision >= '48'

    Given I init select
    When I call revision gtEq 80, 90
    Then I expect: .revision >= '80'
    Then I expect:  OR
    Then I expect: .revision >= '90'

    Given I init select
    When I call authors gtEq 3
    When I call authors gtEq 4
    When I call authors gtEq 6
    Then I expect: .authors >= '6'
    Then I don't expect: .authors >= '4'


  @Code\Db\Select\WhereLt
  Scenario: Check Lt condition

    Given I init select
    When I call revision lt 44
    Then I expect: .revision < '44'

    Given I init select
    When I call revision lt 80, 90
    Then I expect: .revision < '80'
    Then I expect:  OR
    Then I expect: .revision < '90'

    Given I init select
    When I call authors lt 5
    When I call authors lt 1
    When I call authors lt 8
    Then I expect: .authors < '8'
    Then I don't expect: .authors < '1'
    Then I don't expect: .authors < '5'


  @Code\Db\Select\WhereLtEq
  Scenario: Check LtEq condition

    Given I init select
    When I call revision ltEq 48
    Then I expect: .revision <= '48'

    Given I init select
    When I call revision ltEq 80, 90
    Then I expect: .revision <= '80'
    Then I expect:  OR
    Then I expect: .revision <= '90'

    Given I init select
    When I call authors ltEq 5
    When I call authors ltEq 1
    When I call authors ltEq 8
    Then I expect: .authors <= '8'
    Then I don't expect: .authors <= '1'
    Then I don't expect: .authors <= '5'


  @Code\Db\Select\WhereLike
  Scenario: Check Like condition
    Given I init select
    When I call name like ad%
    Then I expect: .name like 'ad%'

    Given I init select
    When I call name like rt%
    When I call name like %user%
    Then I expect: .name like '%user%'
    Then I don't expect: .name like 'rt%'


  @Code\Db\Select\Where
  Scenario: Check where condition
    Given I init select
    When I call name like F'in%
    Then I expect: .name like 'F\'in%'

    Given I init select
    When I call name is Co'mpl''ex \"st'\"ring
    Then I expect: .name = 'Co\'mpl\'\'ex \\\"st\'\\\"ring'

  @Code\Db\Select\CheckFoundRows
  Scenario: Check found condition

    Given I create test data
    And I init select
    Then I expect 5 rows

    Given I init select
    When I call name like F'in%
    Then I expect 0 rows

    Given I init select
    When I call id is 1
    Then I expect 1 rows
