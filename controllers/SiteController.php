<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Things;
use app\models\AddThingForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionStorage()
    {



        $russia = Things::find()->where("category='russia'")->all();
		$ussr = Things::find()->where("category='ussr'")->all();
		$olympiad80 = Things::find()->where("category='olympiad80'")->all();

		return $this->render('storage', [
    		'russia' => $russia,
    		'ussr' => $ussr,
    		'olympiad80' => $olympiad80
		]);

    }
	public function actionIndex()
     {

       if (!Yii::$app->user->isGuest) {
           return Yii::$app->response->redirect('index.php?r=site%2Fstorage');
        }

       $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
           return Yii::$app->response->redirect('index.php?r=site%2Fstorage');
        }
       return $this->render('index', [
            'model' => $model
        ]);
     }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
