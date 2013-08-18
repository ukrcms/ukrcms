#Простий пакунок

Опис пакунків в системі знаходиться [тут] (../bundles/index.md)

Мені, на багатьох сайтах, зустрічались так звані "крилаті вислови", які при обновленні сторінки також оновлюються, 
В цій статті розглянуто, процес створення просто пакунку `Phrases`, який показуватиме випакову фразу.

Все що необхідно:
<pre>
* зручний редактор з підсвічуванням тексту.
* бажання створити щось корисне
* також будем вважати, що веб-сервер налаштовано і працює.
</pre>

Оскільки робота в цього пакунку досить примітивна, йому все одно необхідна таблиця в базі даних.
В Linux терміналі, добавлення нової таблиці виглядає так:
<pre>
muhasjo@E430:~$ sudo -i
Enter password:
root@E430:~# mysql -p
Enter password: 
...
...
...
mysql> use uc_site БАЗА ДАНИХ СИСТЕМИ
Database changed
mysql> CREATE TABLE IF NOT EXISTS `uc_phrases`(`id` int(8) NOT NULL AUTO_INCREMENT, `phrase` text NOT NULL, PRIMARY KEY(`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
Query OK, 0 rows affected (0.01 sec)
</pre>
Якщо комусь зручніше, можна і через панель управління `phpmyadmin`, вибір за Вами :).

Оскільки пакунок повинен десь знаходитись, потрібно для нього створити каталог: 
<pre>
muhasjo@E430:~$cd ~/www/site/protected/bundles && mkdir Phrases
</pre>
В цьому каталозі будуть розміщені всі файли, які потрібні для роботи пакунку.
Перш за все потрібен файл для роботи з таблицею в базі даних, це буде `Table.php`
<pre>
muhasjo@E430:~/www/uc-site/protected/bundles/Phrases$ gedit Table.php
</pre>
із таким вмістом:
<pre>
namespace App\Phrases; ///Обовязкого оголошение неймспейс для майбутнього підключення цієї таблиці.

class Table extends \Uc\Db\Table {
  const N= __CLASS__;

  protected $modelClass = \App\Phrases\Model::N; /// модель фрази, розписана трішки нижче.

  public function getTableName(){
    return \Uc::app()->db->tablePrefix.'phrases'; /// підключення до самої таблиці з назвою `uc_phrases`
  }
}
</pre>
Також для використання записів із створеної таблиці, потрібен файл з моделлю "Фрази", вона буде у файлі Model.php:
<pre>
muhasjo@E430:~/www/uc-site/protected/bundles/Phrases$ gedit Model.php
</pre>
із вмістом:
<pre>
namespace App\Phrases;
class Model extends \Uc\Db\Model{
  const N = __CLASS__;
}
</pre>
Оскільки суть данного пакунка дуже проста і не несе ніякого смислового навантаження на саму фразу, окрім як, тільки її виведення.
Тому дана модель існує тільки для звязку з іншими обєктами системи. Незнаю можливо закручено сказано :), але далі все стане на свої місця з питаннями чому? і як? :).

Також для роботи потрібен головний файл, який звязує всі попередні між собою, це Controller.php:

<pre>
muhasjo@E430:~/www/uc-site/protected/bundles/Phrases$ gedit Controller.php
</pre>
із вмістом:
<pre>
namespace App\Phrases;
class Controller extends \Uc\Controller{

  /**
   * Отримання випадкової фрази
   */
  static function getPhrase(){
    $phrasesTable = \App\Phrases\Table::instance();
    $select =$phrasesTable->select();               /// берем таблицю описану вище
    $select->order('RAND()');                       /// групуєм по випадковому значенню
    $select->limit(0,1);                            /// тільки один запис
    $data = $phrasesTable->fetchOne($select);       /// витагуєм запис з таблиці
                                                    /// говорячи запитом SQL, це рівносильне запису:
                                                    /// SELECT FROM uc_phrases ORDER BY RAND() LIMIT 1;

    if(!empty($data))                               ///якщо в таблиці є запис
      return $data->phrase;                         /// повертаєм його
    return '';                                      /// інакше повертаєм пусту стрічку
  }
}
Ось і все, пакунок для виведення випадкової фрази готовий. Використовувати його можна так: \App\Phrases\Controller::getPhrase().
Але перед нами постає інша проблема, ми немаєм можливості додавати чи видаляти нові фрази. Потрібно робити запити напряму в базу даних, що для нас є не зовсім зручно.

Для цього потрібна панель адміністрування для даного пакунка. Для її створення в каталозі `Phrases` потрібен новий каталог:
<pre>
muhasjo@E430:~/www/uc-site/protected/bundles/Phrases$ mkdir Admin
</pre>
В якому також буде контроллер для панелі адміністрування:
<pre>
muhasjo@E430:~/www/uc-site/protected/bundles/Phrases$cd Admin && gedit Controller.php
</pre>
із таким вмістом:
<pre>
<?
  namespace App\Phrases\Admin;


  class Controller extends \Ub\Admin\Crud {

    protected function getConnectedTable() {
      return \App\Phrases\Table::instance();
    }

  }
</pre>
Тут описано тільки підключення таблиці із нашими фразами. Всю іншу роботу повязано з додаванням видаленням та редагуванням записів,
бере на себе так званий контроллер Crud.

Оскільки панель адміністрування не знає про те скільки в таблиці колонок із даними для фрази потрібно додати вигляди
для створення та редагування одного запису, та для перегляду всього списку фраз із записами. Для цього потрібен каталог `view` із файлами
`edit.php`  - вигляд для створення та редакування однієї фрази.
`list.php`  - вигляд для перегляду всіх фраз.
<pre>
muhasjo@E430:~/www/uc-site/protected/bundles/Phrases/Admin$ mkdir view && cd view
muhasjo@E430:~/www/uc-site/protected/bundles/Phrases/Admin/view$ touch edit.php
muhasjo@E430:~/www/uc-site/protected/bundles/Phrases/Admin/view$ touch list.php
</pre>

edit.php містить поле для редагування фрази, в нас це буде звичайна форма з полем типу textarea та кнопки для збереження:
<pre>
<div class="full_w">
  <div class="h_title">Редагування</div>
  <form action="" method="post" enctype="multipart/form-data">

    <div class="element">
      <label for="phrase">Фраза <span class="red">(обов'язково)</span></label>
      <textarea id="phrase" name="data[phrase]" class="textarea" rows="10"><?php echo $model->phrase ?></textarea>
    </div>

    <div class="entry">
      <button type="submit" name="save_and_list" class="add">Зберегти</button>
      <button type="submit" name="save_and_stay" class="add">Зберегти і продовжити</button>
    </div>
  </form>

</div>
</pre>
list.php містить тільки опис колонок які будуть показуватить при показі всіх записів:
<pre>
<?
  $widget = new \Ub\Admin\WidgetCrudList();
  $widget->setData($data);
  $widget->setOptions(array(
    'showFields' => array(
      'Фраза' => 'phrase', /// показуєм таблицю з однією колонкою
    ),
    'controllerRoute' => \Uc::app()->url->getControllerName()
  ));
  echo $widget->render();
</pre>
Ось і все панель адміністрування для даного пакунка готова. Залишилось добавити пункти меню для панелі адміністрування:
 <pre>
 muhasjo@E430:~/www/uc-site/protected/bundles/Phrases/Admin/view$ cd ~/www/uc-site/protected/bundles/Phrases/ && touch Bundle.php
 </pre>
 в файлі Bundle.php описаний масив із назвами пунктів меню та посиланнями на таблицю з редагуванням:
<pre>
<?php
  namespace App\Phrases;

  class Bundle {

    const N = __CLASS__;

    /**
     * @return array
     */
    public static function getAdminMenu() {
      $menu = array();

      $menu['Список фраз'] = array(
        array(
          'route' => 'app/phrases/admin/list',
          'text' => 'Фрази',
          'icon' => 'page'
        ),
      );
      return $menu;
    }
  }
</pre>
Оскільки пакунок вже готовий, для того щоб він запрацював потрібно підключити його в загальній конфігурації системи, у файлі `site/protected/config/main.php`
розділ `bundles` добавити наш пакунок, тобто дописати до даного масиву таке: `App\Phrases\Bundle::N`.
Щоб використати пакунок, потріно в файлі `site/themes/theme/views/layouts/main.php`, головний файл шаблон нашої теми, у потрібному місці викликати `<?echo \App\Phrases\Controller::getPhrase();?>`.
