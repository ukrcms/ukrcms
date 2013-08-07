### Url - клас для роботи з посиланнями
Клас ініціалізується в автолодері при старті системи з параметрами, які вказані в конфігурації, наприклад:
```
      'url' => array(
        'rules' => array(
          '/admin-panel/' => 'ub/admin/index',
          '/admin-panel/<controller:.*>/<action:[^/]+>' => '<controller>/admin/<action>',
          '/rss.xml' => 'ub/simpleblog/posts/rss',
          '/' => 'ub/simpleblog/posts/mainpage',
          '/<catsef>-c<catpk>/<postsef>-p<postpk:\d+>.html' => 'ub/simpleblog/posts/view',
          '/<catsef>-c<catpk:\d+>/' => 'ub/simpleblog/posts/category',
          '/<sef>.html' => 'ub/site/pages/view',
          '/<controller:.*>/<action:[^/]+>' => '<controller>/<action>',
        ),
        'baseUrl' => '/ukrcms/blog-pack'
      ),
```
В конфігурації потрібно вказати правила, за якими будуть здійснюватись переходи до контроллерів відповідних пакунків, наприклад:
```
  '/admin-panel/' => 'ub/admin/index'
```
вказує на те що при переході по посиланню site_name/ukrcms/blog-pack/admin-panel/, буде здійснений перехід до контроллера, який знаходить в неймспейсі ub/admin із екшином index.
