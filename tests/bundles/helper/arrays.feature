@Ub\Helper\Arrays
Feature: Check for array helper

  Scenario Outline: Check array merge
    Given a have main array with key "<key>" and value "<value>"
    Given other array has key "<new_key>" and value "<new_value>"
    When I merge them recursive
    Then I expect '<serialized_result>'

  Examples:
    | key | value | new_key | new_value | serialized_result                        |
    | a   | a1    | b       | b1        | a:2:{s:1:"a";s:2:"a1";s:1:"b";s:2:"b1";} |
    | 12  | 5     | 13      | 1         | a:2:{i:12;s:1:"5";i:13;s:1:"1";}         |
    | 1   | 1     | 1       | 1         | a:1:{i:1;s:1:"1";}                       |
