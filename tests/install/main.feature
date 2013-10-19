@Install\Main
Feature: Check installer

  Scenario Outline: Check installation
    Given I check <type> installation of package "blog-pack-1.1.zip"
    Given I am on "/install/install.php"
    Then I should see "Встановлення UkrCms"

    When I press "Встановити"
    Then I should see "Не вказано назву бази даних"

    Given I fill form with test data and admin url "<admin-url>"
    When I press "Встановити"
    Then I should see "Вітаю, Ваш сайт успішно встановлено"

    Given I am on "/"
    Then I should see "Сайт працює на системі"

    Given I am on "<admin-url>"
    Then I should see "Логін"
    And I should see "Пароль"

    Given I am on "<admin-url>"
    Then I fill in "login" with "admin"
    And I fill in "password" with "1111"
    And I press "submit"
    Then I should see "SimpleAdmin"

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
    Then I should see "Пароль"

  # test visible site part
    Given I test page /

    Given I follow "Про нас"
    And I test page

  # test login directly. Direct access disabled
    Given I am on "/ub/users/login"
    Then I should not see "Пароль"

  Examples:
    | type      | admin-url    |
    | domain    | /admin/      |
    | directory | /manager-77/ |