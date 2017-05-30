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

        $russiaNames = Things::find()->where("category='russia'")->all();
        $ussrNames = Things::find()->where("category='ussr'")->all();
        $olympiad80Names = Things::find()->where("category='olympiad80'")->all();       

        $russiaExist = array();
        $ussrExist = array();
        $olympiad80Exist = array();

        $russiaAmount = 0; $ussrAmount = 0; $olympiad80Amount = 0;

        foreach ($russiaNames as $key) {
            array_push($russiaExist, $key->name);
            $russiaAmount += $key->amount;
        }

        foreach ($ussrNames as $key) {
            array_push($ussrExist, $key->name);
            $ussrAmount += $key->amount;

        }

        foreach ($olympiad80Names as $key) {
            array_push($olympiad80Exist, $key->name);
            $olympiad80Amount += $key->amount;
        }

		$form = new FormAdd();
		if (($form->load(Yii::$app->request->post())) && ($form->validate())){

            $i = 0;

            for(; $i < 3; $i++) {
    			$name = Html::encode($form->names[$i]);
    			$s = Html::encode($form->ss[$i]);
    			$m = Html::encode($form->ms[$i]);
    			$l = Html::encode($form->ls[$i]);
    			$xl = Html::encode($form->xls[$i]);
    			$xxl = Html::encode($form->xxls[$i]);
    			$xxxl = Html::encode($form->xxxls[$i]);
    			$price = Html::encode($form->prices[$i]);
    			$dropDownList = Html::encode($form->dropDownList);

                if ($name == NULL || $s == NULL || $m == NULL 
                    || $l == NULL || $xl == NULL || $xxl == NULL 
                    || $xxxl == NULL || $price == NULL) continue;
                
                if(in_array($name, $russiaExist)) {
                    $update = Things::find()->where("name='$name'")->one();
                    $update->s=$s;
                    $update->m=$m;
                    $update->l=$l;
                    $update->xl=$xl;
                    $update->xxl=$xxl;
                    $update->xxxl=$xxxl;
                    $update->amount=$s+$m+$l+$xl+$xl+$xxl+$xxxl;
                    $update->price=$price;
                    $update->category=$dropDownList;

                    $update->save();

                } else {
                    $post=new Things;
                    $post->name=$name;
                    $post->s=$s;
                    $post->m=$m;
                    $post->l=$l;
                    $post->xl=$xl;
                    $post->xxl=$xxl;
                    $post->xxxl=$xxxl;
                    $post->amount=$s+$m+$l+$xl+$xl+$xxl+$xxxl;
                    $post->price=$price;
                    $post->category=$dropDownList;
                    $post->save();    
                }
    			
    			// $form->name='';
    			// $form->s='';
    			// $form->m='';
    			// $form->l='';
    			// $form->xl='';
    			// $form->xxl='';
    			// $form->xxxl='';
    			// $form->amount='';
    			// $form->price='';
            }
		} else {
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
            'russiaNames' => $russiaExist,
            'ussrNames' => $ussrExist,
            'olympiad80Names' => $olympiad80Exist,
			'form' => $form,
            'russiaAmount' => $russiaAmount,
            'ussrAmount' => $ussrAmount,
            'olympiad80Amount' => $olympiad80Amount
		]);

    }
	public function actionIndex()
    {

       if (!Yii::$app->user->isGuest) {
           return Yii::$app->response->redirect('index.php?r=site%2Fstorage');
        }

       $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			
			
			Yii::$app->response->cookies->add(new \yii\web\Cookie([
				'name' => 'cook',
				'value' => 'cooksAreGood',
			]));
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
            'model' => $model
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
