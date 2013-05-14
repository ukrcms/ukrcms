<?php

  namespace Ub\Helper;

  class Arrays {

    /**
     * This function does indeed merge arrays, but it converts values with duplicate
     * keys to arrays rather than overwriting the value in the first array with the duplicate
     * value in the second array, as array_merge does. I.e., with array_merge_recursive,
     * this happens (documented behavior):
     *
     * <code>
     * array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
     * $result = array('key' => array('org value', 'new value'));
     * </code>
     *
     * Arrays::mergeRecursive does not change the datatypes of the values in the arrays.
     * Matching keys' values in the second array overwrite those in the first array, as is the
     * case with array_merge, i.e.:
     * <code>
     * Arrays::mergeRecursive(array('key' => 'org value'), array('key' => 'new value'));
     * $result =  array('key' => 'new value');
     * </code>
     * Parameters are passed by reference, though only for performance reasons. They're not
     * altered by this function.
     *
     * @param array $firstArray
     * @param array $secondArray
     * @return array
     * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
     * @author Funivan <dev (at) funivan (dot) com>
     */
    public static function mergeRecursive(array $firstArray, array $secondArray) {
      $merged = $firstArray;

      foreach ($secondArray as $key => $value) {
        if (is_array($value) && isset ($merged[$key]) && is_array($merged[$key])) {
          $merged[$key] = Arrays::mergeRecursive($merged[$key], $value);
        } else {
          $merged[$key] = $value;
        }
      }

      return $merged;
    }

  }