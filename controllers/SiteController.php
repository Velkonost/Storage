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
use app\models\WpPostmeta;
use app\models\WpPosts;
use app\models\AddThingForm;
use app\models\FormAdd;
use app\models\EditForm;


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

    // вот жта штука отлючает проверку CSRF для POST запроса, который делает AMOCRM
    public function beforeAction($action)
    {
        if ($action->id == 'web-hook') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
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
		
		$russiaExistArt = array();
        $ussrExistArt = array();
        $olympiad80ExistArt = array();

        $russiaAmount = 0; $ussrAmount = 0; $olympiad80Amount = 0;

        foreach ($russiaNames as $key) {
            array_push($russiaExist, $key->article);
            $russiaAmount += $key->amount;
        }

        foreach ($ussrNames as $key) {
            array_push($ussrExist, $key->article);
            $ussrAmount += $key->amount;

        }

        foreach ($olympiad80Names as $key) {
            array_push($olympiad80Exist, $key->article);
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
    			$article = Html::encode($form->article[$i]);
    			$dropDownList = Html::encode($form->dropDownList);

                if ($article == NULL || $name == NULL || $s == NULL || $m == NULL 
                    || $l == NULL || $xl == NULL || $xxl == NULL || $xxxl == NULL || $price == NULL
                    || ($s == 0 && $m == 0 && $l == 0 && $xl == 0 && $xxl == 0 && $xxxl == 0)) continue;
                
                
                if(in_array($article, $russiaExist) || in_array($article, $ussrExist) || in_array($article, $olympiad80Exist)) { //tut
					$update = Things::find()->where("article='$article'")->one();
                    $update->name = $name;
                    $update->s += $s;
                    $update->m += $m;
                    $update->l += $l;
                    $update->xl += $xl;
                    $update->xxl += $xxl;
                    $update->xxxl += $xxxl;
                    $update->amount += $s + $m + $l + $xl + $xxl + $xxxl;
                    $update->price += $price;
                    $update->category = $dropDownList;

                    $update->save();
					
					$form->name = '0';
					$form->s = '0';
					$form->m = '0';
					$form->l = '0';
					$form->xl = '0';
					$form->xxl = '0';
					$form->xxxl = '0';
					$form->price = '0';
					$form->article = '';


					$wpPosts = WpPostmeta::find()->where("(meta_key='article') AND (meta_value='$article') ")->one();
                    $postId = $wpPosts->post_id;
                    
                    $sizes = WpPostmeta::find()->where("(meta_key='sizes') AND (post_id='$postId')")->one();

                    $newSizes = [];

                    if ($update->s > 0) {
                        array_push($newSizes, 1);
                    } 
                    if ($update->m > 0) {
                        array_push($newSizes, 2);
                    }
                    if ($update->l > 0) {
                        array_push($newSizes, 3);
                    }
                    if ($update->xl > 0) {
                        array_push($newSizes, 4);
                    }
                    if ($update->xxl > 0) {
                        array_push($newSizes, 5);
                    }
                    if ($update->xxxl > 0) {
                        array_push($newSizes, 6);
                    }

                    $sizes->meta_value = serialize($newSizes);
                    $sizes->save();

                } else { // tut
                    $post = new Things;
                    $post->name = $name;
                    $post->article = $article;
                    $post->s = $s;
                    $post->m = $m;
                    $post->l = $l;
                    $post->xl = $xl;
                    $post->xxl = $xxl;
                    $post->xxxl = $xxxl;
                    $post->amount = $s + $m + $l + $xl + $xxl + $xxxl;
                    $post->price = $price;
                    $post->category = $dropDownList;
                    $post->save(); 

					$form->name = '0';
					$form->s = '0';
					$form->m = '0';
					$form->l = '0';
					$form->xl = '0';
					$form->xxl = '0';
					$form->xxxl = '0';
					$form->price = '0';	
					$form->article = '';	

                }
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
			$article = '';
		}

        $editForm = new EditForm();
        if (($editForm->load(Yii::$app->request->post())) && ($editForm->validate())){
            $amountThings = Things::find()->all();
            $amountRussia = count(Things::find()->where("category='russia'")->all());
            $amountUssr = count(Things::find()->where("category='ussr'")->all());
            $amountOlympiad80 = count(Things::find()->where("category='olympiad80'")->all());

            Things::deleteAll();
            for ($i = 0; $i < $amountRussia; $i++) { // tut
                
                $post = new Things;
				$post->article = Html::encode($editForm->editArticle[$i]);
                $post->name = Html::encode($editForm->editNames[$i]);
                $post->s = Html::encode($editForm->editSs[$i]);
                $post->m = Html::encode($editForm->editMs[$i]);
                $post->l = Html::encode($editForm->editLs[$i]);
                $post->xl = Html::encode($editForm->editXls[$i]);
                $post->xxl = Html::encode($editForm->editXxls[$i]);
                $post->xxxl = Html::encode($editForm->editXxxls[$i]);
                $post->price = Html::encode($editForm->editPrices[$i]);
                $post->category = 'russia';
                $amount = ($post->s + $post->m + $post->l + $post->xl + $post->xxl + $post->xxxl);
                $post->amount = $amount; 

                $post->save();
                $article = $editForm->editArticle[$i];

                $wpPosts = WpPostmeta::find()->where("(meta_key='article') AND (meta_value='$article') ")->one();
                $postId = $wpPosts->post_id;
                
                $sizes = WpPostmeta::find()->where("(meta_key='sizes') AND (post_id='$postId')")->one();

                $newSizes = [];
                

                if ($editForm->editSs[$i] > 0) {
                    array_push($newSizes, 1);
                
                } 
                if ($editForm->editMs[$i] > 0) {
                    array_push($newSizes, 2);
                
                }
                if ($editForm->editLs[$i] > 0) {
                    array_push($newSizes, 3);
                
                }
                if ($editForm->editXls[$i] > 0) {
                    array_push($newSizes, 4);
                
                }
                if ($editForm->editXxls[$i] > 0) {
                    array_push($newSizes, 5);
                
                }
                if ($editForm->editXxxls[$i] > 0) {
                    array_push($newSizes, 6);
                
                }

                $sizes->meta_value = serialize($newSizes);
                
                $sizes->save();

            }
            for ($i = $amountRussia; $i < ($amountRussia + $amountUssr); $i++) {
                $post = new Things;
				$post->article = Html::encode($editForm->editArticle[$i]);
                $post->name = Html::encode($editForm->editNames[$i]);
                $post->s = Html::encode($editForm->editSs[$i]);
                $post->m = Html::encode($editForm->editMs[$i]);
                $post->l = Html::encode($editForm->editLs[$i]);
                $post->xl = Html::encode($editForm->editXls[$i]);
                $post->xxl = Html::encode($editForm->editXxls[$i]);
                $post->xxxl = Html::encode($editForm->editXxxls[$i]);
                $post->price = Html::encode($editForm->editPrices[$i]);
                $post->category = 'ussr';
                $amount = ($post->s + $post->m + $post->l + $post->xl + $post->xxl + $post->xxxl);
                $post->amount = $amount; 

                $post->save();
                $article = $editForm->editArticle[$i];

                $wpPosts = WpPostmeta::find()->where("(meta_key='article') AND (meta_value='$article') ")->one();
                $postId = $wpPosts->post_id;
                
                $sizes = WpPostmeta::find()->where("(meta_key='sizes') AND (post_id='$postId')")->one();

                $newSizes = [];


                if ($editForm->editSs[$i] > 0) {
                    array_push($newSizes, 1);
                } 
                if ($editForm->editMs[$i] > 0) {
                    array_push($newSizes, 2);
                }
                if ($editForm->editLs[$i] > 0) {
                    array_push($newSizes, 3);
                }
                if ($editForm->editXls[$i] > 0) {
                    array_push($newSizes, 4);
                }
                if ($editForm->editXxls[$i] > 0) {
                    array_push($newSizes, 5);
                }
                if ($editForm->editXxxls[$i] > 0) {
                    array_push($newSizes, 6);
                }

                $sizes->meta_value = serialize($newSizes);
                $sizes->save();

            }
            for ($i = ($amountUssr + $amountRussia); $i < ($amountRussia + $amountUssr + $amountOlympiad80); $i++) {
                $post = new Things;
				$post->article = Html::encode($editForm->editArticle[$i]);
                $post->name = Html::encode($editForm->editNames[$i]);
                $post->s = Html::encode($editForm->editSs[$i]);
                $post->m = Html::encode($editForm->editMs[$i]);
                $post->l = Html::encode($editForm->editLs[$i]);
                $post->xl = Html::encode($editForm->editXls[$i]);
                $post->xxl = Html::encode($editForm->editXxls[$i]);
                $post->xxxl = Html::encode($editForm->editXxxls[$i]);
                $post->price = Html::encode($editForm->editPrices[$i]);
                $post->category = 'olympiad80';
                $amount = ($post->s + $post->m + $post->l + $post->xl + $post->xxl + $post->xxxl);
                $post->amount = $amount; 

                $post->save();

                $article = $editForm->editArticle[$i];

                $wpPosts = WpPostmeta::find()->where("(meta_key='article') AND (meta_value='$article') ")->one();
                $postId = $wpPosts->post_id;
                
                $sizes = WpPostmeta::find()->where("(meta_key='sizes') AND (post_id='$postId')")->one();

                $newSizes = [];
                $i = 1;

                if ($editForm->editSs[$i] > 0) {
                    array_push($newSizes, 1);
                } 
                if ($editForm->editMs[$i] > 0) {
                    array_push($newSizes, 2);
                }
                if ($editForm->editLs[$i] > 0) {
                    array_push($newSizes, 3);
                }
                if ($editForm->editXls[$i] > 0) {
                    array_push($newSizes, 4);
                }
                if ($editForm->editXxls[$i] > 0) {
                    array_push($newSizes, 5);
                }
                if ($editForm->editXxxls[$i] > 0) {
                    array_push($newSizes, 6);
                }

                $sizes->meta_value = serialize($newSizes);
                $sizes->save();

            }
        }
		
		$allarticles = [];
		$artics = Things::find()->all();
		foreach($artics as $key){
			$allarticles[$key->article] = $key->article;
		}
		
        $russia = Things::find()->where("category='russia'")->all();
		$ussr = Things::find()->where("category='ussr'")->all();
		$olympiad80 = Things::find()->where("category='olympiad80'")->all();
		$allclths = Things::find()->all();
		$allclothes = [];
		foreach($allclths as $key){
			$allclothes[$key->name] = $key->name;
		}
		
		

		return $this->render('storage', [
    		'russia' => $russia,
    		'ussr' => $ussr,
    		'olympiad80' => $olympiad80,
            'russiaNames' => $russiaExist,
            'ussrNames' => $ussrExist,
            'olympiad80Names' => $olympiad80Exist,
			'form' => $form,
            'editForm' => $editForm,
            'russiaAmount' => $russiaAmount,
            'ussrAmount' => $ussrAmount,
            'olympiad80Amount' => $olympiad80Amount,
			'allarticles' => $allarticles,
			'allclothes' => $allclothes
		]);

    }


	public function actionWelcome()
    {

       if (!Yii::$app->user->isGuest) {
           return Yii::$app->response->redirect('storage');
        }

       $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			
			
			Yii::$app->response->cookies->add(new \yii\web\Cookie([
				'name' => 'cook',
				'value' => 'cooksAreGood',
			]));
           return Yii::$app->response->redirect('storage');
        }
       return $this->render('welcome', [
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
		if (Yii::$app->getRequest()->getCookies()->has('cook')){
			Yii::$app->response->redirect('welcome');
		}
        if (!Yii::$app->user->isGuest) {
            Yii::$app->response->redirect('storage');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			if (!isset($_COOKIE['cook'])){
			//	Yii::app()->request->cookies['cook'] = new CHttpCookie('cook', 'cook');
			}
           // Yii::$app->response->redirect('index.php?r=site%2Fstorage');
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

     /**
     * Webhooks AMO CRM
     */
    public function actionWebhook()
    {
        if (empty($_POST)) {
            // не получено данных
            exit('FAIL');
        }
        
        // далее анализ полученнх данных
        var_dump($_POST);

        $post = new Things;
        $post->article = "1223megaunicum";
        $post->name = $data;
        $post->s = 3;
        $post->m = 4;
        $post->l = 5;
        $post->xl = 6;
        $post->xxl = 7;
        $post->xxxl = 8;
        $post->price = 9;
        $post->category = 'bitch3';
        $amount = 123;
        $post->amount = $amount; 

        $post->save();


        return $this->render('webhook');
    }
}
