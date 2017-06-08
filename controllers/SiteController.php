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
        if ($action->id == 'webhook') {
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
            //  Yii::app()->request->cookies['cook'] = new CHttpCookie('cook', 'cook');
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
        // if (empty($_POST)) {
        //     // не получено данных
        //     exit('FAIL');
        // }
        
        // // далее анализ полученнх данных
        // var_dump($_POST);
        $Response = [];

        try {
            $listener = new \AmoCRM\Webhooks\Listener();

            // Добавление обработчика на уведомление contacts->add
            $listener->on('add_lead', function ($domain, $id, $data) {
                // $domain Поддомен amoCRM
                // $id Id объекта связанного с уведомлением
                $post = new Things;
                $data = '{"response":{"leads":[{"id":"16564313","name":"test","date_create":1496820322,"created_user_id":"1178568","last_modified":1496820322,"account_id":"12988836","price":"","responsible_user_id":"1178568","linked_company_id":"","group_id":0,"pipeline_id":378687,"date_close":0,"closest_task":0,"deleted":0,"tags":[],"status_id":"12988842","custom_fields":[{"id":"1589586","name":"\u0411\u0440\u0435\u043d\u0434","values":[{"value":"Everlast","enum":"3764652"}]},{"id":"1589588","name":"\u0420\u0430\u0437\u043c\u0435\u0440","values":[{"value":"M","enum":"3764664"}]},{"id":"1933627","name":"\u041d\u0430\u0438\u043c\u0435\u043d\u043e\u0432\u0430\u043d\u0438\u0435 \u0442\u043e\u0432\u0430\u0440\u0430","values":[{"value":"\u0421\u043f\u043e\u0440\u0442\u0438\u0432\u043d\u044b\u0439 \u043a\u043e\u0441\u0442\u044e\u043c \u2116 \u0443\u043f\u0430\u043a\u043e\u0432\u043a\u0438"}]},{"id":"1589608","name":"\u0411\u0440\u0435\u043d\u0434","values":[{"value":"Tapout","enum":"3773036"}]},{"id":"1589636","name":"\u0420\u0430\u0437\u043c\u0435\u0440","values":[{"value":"L","enum":"3764806"}]},{"id":"1589640","name":"\u0411\u0440\u0435\u043d\u0434","values":[{"value":"\u0420\u043e\u0441\u0441\u0438\u044f","enum":"3764820"}]},{"id":"1589644","name":"\u0420\u0430\u0437\u043c\u0435\u0440","values":[{"value":"M","enum":"3764826"}]},{"id":"1895370","name":"\u0412\u0435\u0441 \u0432 \u0433\u0440.","values":[{"value":"1000"}]},{"id":"1920100","name":"\u0414\u043e\u043c\u0430\u0448\u043d\u044f\u044f \u043f\u0440\u0438\u043c\u0435\u0440\u043a\u0430","values":[{"value":"1"}]},{"id":"1920102","name":"\u0414\u043e\u043c\u0430\u0448\u043d\u044f\u044f \u043f\u0440\u0438\u043c\u0435\u0440\u043a\u0430","values":[{"value":"1"}]},{"id":"1920106","name":"\u041e\u0441\u043c\u043e\u0442\u0440 \u0432\u043b\u043e\u0436\u0435\u043d\u0438\u044f","values":[{"value":"1"}]}],"main_contact_id":false}],"server_time":1496820332}}';
                
                $data = unparse($data);
                $post ->article = $id;
                $post ->name =  $data[0]['brand'];
                
        
                
                $post -> save();
                
                

               // $data = unparse($data);//ТУТ РАСПАРСИНГ JSON-массива
                
                //echo $data[0]['brand'];
            });
         
         $listener -> listen();
         //echo $data['response'];
            
        
        } catch (\AmoCRM\Exception $e) {
            printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
        }

        #Массив с параметрами, которые нужно передать методом POST к API системы
        $user=array(
          'USER_LOGIN'=>'kranfear@mail.ru', #Ваш логин (электронная почта)
          'USER_HASH'=>'38f2e3461e664db15032bcab8b7c26e8' #Хэш для доступа к API (смотрите в профиле пользователя)
        );
 
        $subdomain='new584549b112ca4'; #Наш аккаунт - поддомен
 
        #Формируем ссылку для запроса
        $link='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';

        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__DIR__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__DIR__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
         
        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Завершаем сеанс cURL
                
        echo $code;

        $id = 16577287;
        $link2 = 'https://'.$subdomain.'.amocrm.ru/private/api/v2/json/leads/list?id='.$id;

        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link2);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__DIR__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__DIR__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);

        $d = unparse($out);
        
        return $this->render('webhook',['resp'=>$Response]);
    
    }
  }  
    function unparse($data){    
        
        
        $data = json_decode($data);
        // echo $data['response']['leads'][0]['custom_fields'];
        $data = ($data->{'response'}->{'leads'}[0]->{'custom_fields'});
        echo "<br/>";
        $array = [];
        $g = 0;
        
        for($i = 0; $i<count($data); $i++){
            if(strcmp($data[$i]->{'name'}, "Бренд")==0){
                $array[$g]['brand'] = $data[$i]->{'values'}[0]->{'value'};
            }
            
            if(strcmp($data[$i]->{'name'}, "Размер")==0){
                $array[$g]['size'] = $data[$i]->{'values'}[0]->{'value'};
            }
            
            if(strcmp($data[$i]->{'name'}, "Наименование товара")==0){
                $array[$g]['name'] = $data[$i]->{'values'}[0]->{'value'};
                $g++;
            }
            
            
            
            
          /*  array_push($array[$g], )
            print_r($data[$i]->{'name'}."  :::  ");
            print_r($data[$i]->{'values'}[0]->{'value'});
            echo "<br/>";*/
        }
        return $array;
    }
    




    


    
    
    


