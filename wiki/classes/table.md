# Table - таблиця

Клас таблиці призначений для опису співвідношення моделей
і спрощенню вибірок з бази даних.


## Опис звязків
Існує 3 типи звязків.
- RELATIONS_HAS_ONE - вказує що модель має звязок з однією моделлю
- RELATIONS_HAS_MANY - вказує що модель має звязок з багатьма моделями
- RELATIONS_MANY_MANY - вказує що модель має звязок з багатьма моделями через звязкову таблицю

Розглянемо ці приклади детальніше:

### RELATIONS_HAS_ONE
Для прикладу у нас є таблиця користувачів і таблиця паспортів.
Кожен користувач має один паспорт. Відповідно паспорт
належить тільки одному користувачу.

Давайте розглянемо приклад моделі Користувачі.
Памятаємо що користувач має один паспорт.

```php
# user table
public function relations(){
  return array(
   'Passport'=>array(
     'type'=>static::RELATIONS_HAS_ONE,
     'table'=>\App\Passport\Table::N,
     'myField'=>'passport_id',
   )
  );
}
```
Задати звязок дуже просто. Розглянемо детально даний приклад.

Отже ключ масиву - Passport.
Ця назва буде використовуватись для отримання паспорту користувача.
```
# Вибираємо користувача під номером 1
$user = \App\Users\Table::instance()->fetchOne(1);

# Виводимо дату реєстрації паспорту який належить користувачу 1
echo $user->Passport->registrationDate;
```
type  - тип звязку.
table - назва звязкової таблиці.
myField - поле по якому звязані моделі. myField означає, що поле знаходиться в таблиці Users.
Тобто в цій в якій описий даний звязок.

```
$userSelect->joinWithPassport()->idGt(55);
join with passport where passport.id = users.passport_id
```

Наступний крок це задати звязки для таблиці паспорти.
Ми знаємо що у користувача є 1н паспорт.
Отже у кожного паспорта є користувач.

```php
public function relations(){
  return array(
   'User'=>array(
     'type'=>static::RELATIONS_HAS_ONE,
     'table'=>\App\User\Table::N,
     'foreignField'=>'passport_id',
   )
  );
}
Ми уже знаємо що ключ Users вказує на назву звязка.
foreignField - означає що поле passport_id знаходиться у звязковій таблиці, яка вказана table

```
$passportSelect->joinWithUser()->idGt(5);
join with users where passport.id = users.passport_id

```


### RELATIONS_MANY_MANY
Для прикладу розглянемо реалізацію блогу з тегами.
У нас є статті Articles які мають багато тегів Tags. В свою чергу
Один тег може мати багато статтей. Дане співвідношення називається багато до багатьох.
Іншими словами всю суть звязка можа передати в наступному реченні:
один тег має багато статтей одна стаття має багато тегів.

Дані сутності повязані між собою через додаткову табилцю.
Структура нашої бази:
- uc_articles - таблиця статтей
- uc_tags - таблиця тегів
- uc_articles_tags - таблиця звякзів, яка містить номер тегу і номер статті.

Отже задамо звязок для статтей

```php
# articles table
public function relations(){
  return array(
   'Tags'=>array(
     'type'=>static::RELATIONS_MANY_MANY,
     'table'=>\App\Tags\Table::N,
     'reference'=>array(
       'tableName'=>'uc_articles_tags',
       'myField'=>'article_id',
       'foreignField'=>'tag_id',
     )
   )
  );
}
```
В даному прикладі появляється невідомі нам ключі.
Масив з ключом `reference` описує звязкову таблицю.
- tableName - назва звязкової таблиці
- myField - вказує що ключ з таблиці Articles записується у поле article_id
- foreignField - вказує що ключ з таблиці Tags записується у поле tag_id

Дуже просто тримати список всіх тегів для статті під номером 1:

```php
# Вибираємо статтю під номером 1
$article = \App\Articles\Table::instance()->fetchOne(1);

# виводимо назви тегів
foreach($user->Tags as $tag){
  echo $tag->title . "<br>";
}


echo "Кількість тегів: ".count($user->Tags)."<br>";
```
Тепер задамо звязок тегів з статтями.

```php
# tags table
public function relations(){
  return array(
   'Articles'=>array(
     'type'=>static::RELATIONS_MANY_MANY,
     'table'=>\App\Article\Table::N,
     'reference'=>array(
       'tableName'=>'uc_tags_articles',
       'myField'=>'tag_id',
       'foreignField'=>'article_id',
     )
   )
  );
}
```
Як бачимо все досить просто і зрозуміло.


## Користь звязків
Звязки дуже потужна і корисна річ при розробці веб сайту.
В першу чергу вони допомагають реалізувати принцип DRY і звісно підвищити читабельність коду.
