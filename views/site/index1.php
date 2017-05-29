<?php
	use yii\helpers\Html;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\assets\AppAsset;
?>

<?php
	if(Yii::$app->user->isGuest){
		echo Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']);
       echo "<div class = 'btn btn-link logout'> <a href = 'index.php?r=site%2Flogin'>ppp</a></div>";
	}else{
		echo 
                 Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                ;
	}
?>