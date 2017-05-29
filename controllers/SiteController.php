<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Things;
use app\models\AddThingForm;
use app\models\FormAdd;

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
		$form = new FormAdd();
		if (($form->load(Yii::$app->request->post())) && ($form->validate())){
			$name = Html::encode($form->name);
			$s = Html::encode($form->s);
			$m = Html::encode($form->m);
			$l = Html::encode($form->l);
			$xl = Html::encode($form->xl);
			$xxl = Html::encode($form->xxl);
			$xxxl = Html::encode($form->xxxl);
			$amount = Html::encode($form->amount);
			$price = Html::encode($form->price);
			
			$post=new Things;
			$post->name=$name;
			$post->s=$s;
			$post->m=$m;
			$post->l=$l;
			$post->xl=$xl;
			$post->xxl=$xxl;
			$post->xxxl=$xxxl;
			$post->amount=$amount;
			$post->price=$price;
			
			$form->name='';
			$form->s='';
			$form->m='';
			$form->l='';
			$form->xl='';
			$form->xxl='';
			$form->xxxl='';
			$form->amount='';
			$form->price='';
		}else{
			$name = '';
			$s = '';
			$m = '';
			$l = '';
			$xl = '';
			$xxl = '';
			$xxxl = '';
			$amount = '';
			$price = '';
		}


        $russia = Things::find()->where("category='russia'")->all();
		$ussr = Things::find()->where("category='ussr'")->all();
		$olympiad80 = Things::find()->where("category='olympiad80'")->all();
		
		

		return $this->render('storage', [
    		'russia' => $russia,
    		'ussr' => $ussr,
    		'olympiad80' => $olympiad80,
			'form' => $form,
			'name' => $name,
			's' => $s,
			'm' => $m,
			'l' => $l,
			'xl' => $xl,
			'xxl' => $xxl,
			'xxxl' => $xxxl,
			'amount' => $amount,
			'price' => $price
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
