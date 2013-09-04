<?php

  namespace Test;

  use Behat\Behat\Context\BehatContext;

  class MainContext extends BehatContext {

    public function plural($word) {
      $word = trim(strtolower($word));
      $words = $this->getWordsForms();
      return isset($words[$word]) ? $words[$word] : $word;
    }

    public function singular($word) {
      $word = trim(strtolower($word));
      $words = $this->getWordsForms();
      $wordForm = array_search($word, $words);
      return !empty($wordForm) ? $wordForm : $word;
    }

    protected function getWordsForms() {
      $words = array(
        'car' => 'cars',
        'house' => 'houses',
        'passport' => 'passports',
        'user' => 'users',
      );
      return $words;
    }

  }
