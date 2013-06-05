<?php
  namespace Ub\Site\Pages;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Site\Controller {

    const  MAIN_PAGE_SEF = '/';

    /**
     *
     * @throws \Exception
     */
    public function actionMainPage() {
      return $this->actionView(static::MAIN_PAGE_SEF);
    }

    /**
     *
     * @throws \Exception
     */
    public function actionView($sef = null) {
      $params = \Uc::app()->url->getParams();
      if (!empty($params['sef'])) {
        $sef = $params['sef'];
      }

      if (empty($sef)) {
        throw new \Exception('Сторінка не знайдена', 404);
      }

      $postTable = \Ub\Site\Pages\Table::instance();
      $select = $postTable->select();
      $select->where('sef = ? ', $sef);

      $select->where('published = ? ', \Ub\Site\Pages\Model::STATUS_PUBLISHED);
      $page = $postTable->fetchOne($select);

      if (empty($page)) {
        throw new \Exception('Сторінка не знайдена', 404);
      }

      $this->setSeoMetaFromModel($page);
      \Uc::app()->theme->setValue('site_page_id', $page->pk());

      if (!empty($page->template)) {
        $template = $page->template;
      } else {
        $template = 'view';
      }

      $this->render($template, array(
        'model' => $page,
      ));
    }

    /**
     * @author muhasjo <muhasjo@gmail.com>
     */
    public function actionContact() {
      $message = null;
      if (empty($_POST['email']) or (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)) {
        $message = 'Поле email заповнено невірно';
      }
      if (!$message  and empty($_POST['message'])) {
        $message = 'Заповність поле "повідомлення"';
      }

      if (empty($message)) {
        $mailFrom = $_POST['email'];
        $userName = !empty($_POST['name']) ? $_POST['name'] : 'noname';
        $message = $_POST['message'];
        $subject = "[UkrCMS]::[ContactForm] user " . $userName;
        $mailTo = \Ub\Site\Settings\Table::get('adminEmail');
        mail($mailTo, $subject, $message, "From: " . $mailFrom . "\r\n");

        $message = 'Ваші дані успішно відправлені';
      }

      \Uc::app()->theme->setValue('seo_meta_title', 'Зворотній звязок');

      $this->render('message', array('message' => $message));
    }
  }

