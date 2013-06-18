@Install\Main
Feature: Check installer

  Scenario Outline: : Check installation
    Given I check <type> installation of package "blog-pack-1.0.zip"
    Given I am on "/install/install.php"
    Then the response should contain "Встановлення UkrCms"
    When I press "Встановити"
    Then the response should contain "Не вказано назву бази даних"
  Examples:
    | type      |
    | domain    |
    | directory |