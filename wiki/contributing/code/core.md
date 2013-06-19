Розвиток ядра
====
Ядро - сама головна складова всієї системи.


*Для ознайомлення з даним розділом ви маєте знати такі терміни:*

* [Cинглтон](/glossary#Cинглтон)
* [Application](/glossary#Application)
* [Ядро](/glossary#Ядро)


## Uc - клас синглтон 

Клас синглтон, виконує такі функції:

* реєстрація автолодера для автоматичного завантаження класів пакунків 
  та класів ядра системи
* ініціалізації сайту з певними налаштуваннями
* доступ до обгортки сайту `App`  

Клас Uc знаходиться у файлу `Uc.php` 

Зверніть увагу. *Цей клас знаходиться в глобальному просторі імен, 
всі інші файли ядра знаходяться в просторі імен Uc*

## App - application (обгортка сайту) 