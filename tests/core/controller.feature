@Uc\Controller
Feature: Check controller class

  Scenario Outline: check view from theme
    Given i use users controller
    Given i check theme view file <name>
    Then i expect view path contain <path>

  Examples:
    | name        | path                                        |
    | list        | views/bundles/testapp/office/users/list.php |
    | list/       | users/list.php                              |
    | /cars/list  | views/bundles/cars/list.php                 |
    | /cars/list/ | /cars/list.php                              |

  Scenario Outline: check view from bundles
    Given i use users controller
    Given i check class view file <name>
    Then i expect view path contain <path>

  Examples:
    | name       | path                              |
    | list       | /Office/Users/views/list.php      |
    | /other     | /Office/Users/views/other.php     |
    | /custom/   | /Office/Users/views/custom.php    |
    | /cars/list | /Office/Users/views/cars/list.php |