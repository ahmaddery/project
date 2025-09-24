<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\Account;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // Public access untuk read
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    // Hanya user yang login bisa create/update/delete
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Admin dan Author bisa create post
                            // Update/Delete akan dicek di action masing-masing
                            return !Yii::$app->user->isGuest;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Post::find()->with('author')->orderBy(['date' => SORT_DESC]);
        
        // If user is logged in but not admin, show only their posts in admin view
        if (!Yii::$app->user->isGuest && Yii::$app->request->get('manage') === '1') {
            if (!Yii::$app->user->identity->isAdmin()) {
                $query->andWhere(['username' => Yii::$app->user->identity->username]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $manageMode = Yii::$app->request->get('manage') === '1';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'manageMode' => $manageMode,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        
        // Set current user as author
        if (!Yii::$app->user->isGuest) {
            $model->username = Yii::$app->user->identity->username;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Post created successfully.');
            return $this->redirect(['view', 'id' => $model->idpost]);
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
     * @throws ForbiddenHttpException if access is denied
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        // Check if user can edit this post
        if (!$this->canEditPost($model)) {
            throw new ForbiddenHttpException('You are not allowed to edit this post.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Post updated successfully.');
            return $this->redirect(['view', 'id' => $model->idpost]);
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
     * @throws ForbiddenHttpException if access is denied
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        // Check if user can delete this post
        if (!$this->canEditPost($model)) {
            throw new ForbiddenHttpException('You are not allowed to delete this post.');
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Post deleted successfully.');

        return $this->redirect(['index', 'manage' => 1]);
    }

    /**
     * Check if current user can edit the post
     * @param Post $model
     * @return bool
     */
    protected function canEditPost($model)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $user = Yii::$app->user->identity;
        
        // Admin can edit all posts
        if ($user->isAdmin()) {
            return true;
        }
        
        // Author can edit only their own posts
        if ($user->isAuthor() && $model->username === $user->username) {
            return true;
        }

        return false;
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