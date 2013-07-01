@Install\Main
Feature: Check installer

  Scenario Outline: : Check installation
    Given I check <type> installation of package "blog-pack-1.0.zip"
    Given I am on "/install/install.php"
    Then the response should contain "Встановлення UkrCms"

    When I press "Встановити"
    Then the response should contain "Не вказано назву бази даних"

    Given I fill form with test data and admin url "<admin-url>"
    When I press "Встановити"
    Then the response should contain "Вітаю, Ваш сайт успішно встановлено"

    Given I am on "/"
    Then the response should contain "Сайт працює на системі"

    Given I am on "<admin-url>"
    Then the response should contain "Логін"
    And the response should contain "Пароль"


  Examples:
    | type      | admin-url    |
    | domain    | /admin/      |
    | directory | /manager-77/ |