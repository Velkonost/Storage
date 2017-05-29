<?php

	use yii\helpers\Html;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\assets\AppAsset;



$this->title = 'Storage';


?>

<?php
	if(Yii::$app->user->isGuest){

       echo "<a href = 'index.php?r=site%2Flogin'>ppp</a>";
	}else{
		echo  '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
	}
?>