<?php

namespace frontend\controllers;

use Yii;
use common\models\Post;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public $photo;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
              'class' => AccessControl::className(),
              'rules' => [
                  [
                      'actions' => ['login', 'error', 'show', 'view', 'search'],
                      'allow' => true,
                  ],
                  [
                      'actions' => ['logout', 'create','index'],
                      'allow' => true,
                      'roles' => ['@'],
                  ],
                  [
                    'actions' => ['delete', 'update'],
                    'allow' => true,
                    'roles' => ['@'],

                ],
              ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function allowOnlyOwner(){
        $post = Post::model()->findByPk($_GET["id"]);
        $this->post = $post; 
        return $post->userId === Yii::app()->user->id;
      
  }
    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = new \yii\db\Query;
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->from('post')->where(['userId' => Yii::$app->user->identity->id])
            ->count(),
        ]);

        $posts = $query->select(['post.id', 'title', 'perex', 'publishedAt', 'userId', 'tags','username','about'])
            ->from('post')
            ->innerJoin('user', 'user.id = post.userId')
            ->where(['post.userId' => Yii::$app->user->identity->id])
            ->orderBy(['publishedAt' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
            
        return $this->render('index', [
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionSearch()
    {
      $query = new \yii\db\Query;
      $pagination = new Pagination([
          'defaultPageSize' => 5,
          'totalCount' => $query->from('post')->count(),
      ]);

      $posts = $query->select(['post.id', 'title', 'perex', 'publishedAt', 'userId', 'tags','username','about'])
          ->from('post')
          ->innerJoin('user', 'user.id = post.userId')
          ->where(['like', 'tags', '%' . $_GET['keyword'] . '%', false])
          ->orderBy(['publishedAt' => SORT_DESC])
          ->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
          
      return $this->render('show', [
          'posts' => $posts,
          'pagination' => $pagination,
      ]);
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionShow()
    {
      $query = new \yii\db\Query;
      $pagination = new Pagination([
          'defaultPageSize' => 5,
          'totalCount' => $query->from('post')->count(),
      ]);

      $posts = $query->select(['post.id', 'title', 'perex', 'publishedAt', 'userId', 'tags','username','about'])
          ->from('post')
          ->innerJoin('user', 'user.id = post.userId')
          ->orderBy(['publishedAt' => SORT_DESC])
          ->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
          
      return $this->render('show', [
          'posts' => $posts,
          'pagination' => $pagination,
      ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $query = new \yii\db\Query;
        $post = $query->select(['post.id', 'title', 'content', 'perex', 'publishedAt', 'userId', 'tags','username','about'])
            ->from('post')
            ->innerJoin('user', 'user.id = post.userId')
            ->where(['post.id' => $id])
            ->one();
            
        return $this->render('view', [
            'post' => $post,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        $model->photoFile = UploadedFile::getInstance($model, 'photo');

        $model->userId = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->photoFile = UploadedFile::getInstance($model, 'photo');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
