@Install\Main
Feature: Check installer

  Scenario Outline: : Check installation
    Given I check <type> installation of package "blog-pack-1.1.zip"
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

    Given I am on "<admin-url>"
    Then I fill in "login" with "admin"
    And I fill in "password" with "1111"
    And I press "submit"
    Then the response should contain "SimpleAdmin"

    Given I follow "Категорії"
    Then I should not see "Error:"
    Given I follow "Редагувати"
    Then I should not see "Error:"


    Given I follow "Дописи"
    Then I should not see "Error:"
    Given I follow "Редагувати"
    Then I test page

  # test logout
    Given I am on "<admin-url>"
    Then I follow "вихід"
    When I go to "<admin-url>"
    Then the response should contain "Пароль"

  # test visible site part
    Given I test page /

    Given I follow "Про нас"
    And I test page

  Examples:
    | type      | admin-url    |
    | domain    | /admin/      |
    | directory | /manager-77/ |