<?php
  namespace Ub\Simpleblog\Posts;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Site\Controller {

    const N = __CLASS__;

    /**
     *
     * @var Model[]
     */
    public $category = null;

    public $commentsErrors = array();


    /**
     * Main page action. Set meta and show list
     */
    public function actionMainPage() {

      $meta = \Ub\Site\Metatags\Table::instance()->fetchForMainPage();

      if (!empty($meta)) {
        $this->setSeoMetaFromModel($meta);
      }

      $this->showPostList();
    }

    /**
     * @author  Ivan Scherbak <dev@funivan.com> 8/22/12
     * @throws \Exception
     */
    public function actionCategory() {

      $params = \Uc::app()->url->getParams();

      if (!empty($params['catpk']) and $pk = $params['catpk']) {
        $categories = \Ub\Simpleblog\Categories\Table::instance()->getAllFromCache();
        $currentCategory = isset($categories[$pk]) ? $categories[$pk] : false;
      }

      if (empty($currentCategory)) {
        throw new \Exception('No category', 404);
      }

      \Uc::app()->theme->setValue('simpleblog_category_id', $currentCategory->pk());

      //@todo make redirect if current sef is not valid (/aaaaa-c1/ to /test-category-c1/)
      # set meta tags for this category
      $this->setSeoMetaFromModel($currentCategory);

      $this->category = $currentCategory;

      $this->showPostList($currentCategory->pk());
    }

    /**
     *
     * @throws \Exception
     * @internal param string $sef
     */
    public function actionView() {
      $params = \Uc::app()->url->getParams();

      if (!empty($params['postpk'])) {
        $postTable = Table::instance();
        $post = $postTable->fetchOne($params['postpk']);
      }

      if (empty($post)) {
        throw new \Exception('Post not found', 404);
      }

      if (isset($_GET['addcomment'])) {
        return $this->actionAddComment($post);
      }
      \Uc::app()->theme->setValue('simpleblog_post_id', $post->pk());
      \Uc::app()->theme->setValue('simpleblog_category_id', $post->category->pk());

      # set meta tags
      $this->setSeoMetaFromModel($post);
      # init comments

      $this->render('view', array(
        'model' => $post,
      ));
    }

    public function actionAddComment($post = null) {

      $message = 'Ой. сталась помилка, спробуйте через декілька хвилин.';

      if (empty($post) and !empty($_POST['postpk'])) {
        $postTable = Table::instance();
        $post = $postTable->fetchOne($_POST['postpk']);
      }

      if (empty($post)) {
        $message = 'Ви додаєте коментар до неіснуючого допису. Поверністься назад і спробуйте ще раз';
      }

      if (empty($_POST['comment'])) {
        $message = 'Напишіть коментар';
      }

      if (!empty($_POST['comment']) and !empty($post)) {
        $comment = \Ub\Simpleblog\Comments\Table::instance()->createModel();
        $commentData = array();
        foreach (array('name', 'email', 'url', 'comment') as $field) {
          $commentData[$field] = !empty($_POST['comment'][$field]) ? $_POST['comment'][$field] : false;
        }
        $commentData['post_id'] = $post->pk();
        $comment->setFromArray($commentData);
        $comment->save();
        $message = 'Коментар успішно добавлений. Після модерації він буде опублікований';
      }

      $this->render('addComment', array(
        'message' => $message,
        'post' => $post,
      ));
    }

    public function actionRss() {
      $postTable = Table::instance();
      $postsSelect = $postTable->select();
      $postsSelect->publishedIs(1);
      $postsSelect->pageLimit(1, 50);
      $postsSelect->order('date', 'DESC');
      $items = array();
      $posts = $postTable->fetchAll($postsSelect);
      foreach ($posts as $item) {
        if (empty($item->title)) {
          continue;
        }

        if (!empty($item->image)) {
          $image = '<img src="' . $item->image->tiny()->getUrl($item->sef) . '" alt="' . $item->title . '">';
        } else {
          $image = '';
        }
        $item->getViewUrl();

        $items[] = array(
          'title' => addslashes($item->title),
          'link' => $item->getViewUrl(),
          'description' => htmlspecialchars($image . '<p>' . strip_tags($item->shorttext, '<br><b>') . '</p>'),
          'pubDate' => date('r', $item->date),
        );
      }

      header('Content-Type:text/xml; charset=UTF-8');
      echo $this->renderPartial('rss', array('items' => $items));
      die();
    }

    private function showPostList($catPk = false) {

      #get posts
      $postTable = Table::instance();
      $postsSelect = $postTable->select();

      $postsSelect->publishedIs(1);
      if (!empty($catPk)) {
        $postsSelect->category_idIs($catPk);
      }

      $postsSelect->order('date', 'DESC');

      $currentPage = (!empty($_GET['page']) and $_GET['page'] > 1) ? intval($_GET['page']) : 1;
      $onPage = 10;
      $postsSelect->pageLimit($currentPage, $onPage);

      $data = $postTable->fetchPage($postsSelect);

      $data['currentPage'] = $currentPage;
      $data['onPage'] = $onPage;

      $this->render('list', $data);
    }

  }