<?php
  namespace Ub\Site;

  class Controller extends \Uc\Controller {

    public function actionError($exception = null) {
      /* @var $exception \Exception */
      if (!empty($exception)) {
        $code = $exception->getCode();
      } else {
        $code = 503;
      }

      switch ($code) {
        case '404':
          $message = 'Нажаль така сторінка не знайдена. Спробуйте повернутись назад або ж користуючись категоріями рухайтесь далі =)';
          break;
        default :
          $message = 'Не хвилюйтесь, ми уже знаємо в чому помилка і в найближчі декілька хвилин її виправимо ;)<br>Спробейте виконати дію ще раз ;)';
          break;
      }

      $this->render('error', array(
        'message' => $message
      ));
    }


    /**
     *
     * @param $model
     */
    protected function setSeoMetaFromModel($model) {
      foreach (array('meta_title', 'meta_description', 'meta_keywords') as $property) {
        if (!empty($model->$property)) {
          \Uc::app()->theme->setValue('seo_' . $property, $model->$property);
        }
      }

      if (empty($model->meta_title) and !empty($model->title)) {
        \Uc::app()->theme->setValue('seo_meta_title', $model->title);
      }
    }

  }

