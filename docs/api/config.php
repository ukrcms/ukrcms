<?php


  $iterator = Symfony\Component\Finder\Finder::create()
    ->files()
    ->name('*.php')
    ->in(array(
      __DIR__ . '/../../../ukrcms/core',
      __DIR__ . '/../../../ukrcms/bundles',
    ))
  ;

  return new Sami\Sami($iterator, array(
    'theme' => 'UkrCmsApiTheme',
    'template_dirs' => array(__DIR__ . ''),
    'build_dir' => __DIR__ . '/build',
    'cache_dir' => '/tmp/sami-cache',
    'title' => 'UkrCms core API',
    'default_opened_level' => 2,
  ));