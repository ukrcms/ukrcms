### Theme - клас для роботи з темою системи.
Клас ініціалізується в автолодері при старті системи з параметрами, які вказані в конфігу, наприклад:
```
      'theme' => array(
        'themeName' => 'azmind',
        'layout' => 'main',
        'basePath' => dirname(__FILE__) . '/../../themes',
        'baseUrl' => '/themes',
      ),
```
Теми знаходить в каталозі themes/theme