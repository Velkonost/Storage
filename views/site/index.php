<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\assets\AppAsset;



$this->title = 'Storage';

?>
<div class="site-index">
	<div class="body-content">
		
			<div class="jumbotron">
			<div class="goCenter">
				<p style="">Please fill out the following fields to login:</p>
			</div>
				<?php $form = ActiveForm::begin([
					'id' => 'login-form',
					'layout' => 'horizontal',
					'fieldConfig' => [
						'labelOptions' => ['style' => ''],
					],
				]); ?>

 					<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'style'=>'width:40%;' ])->label('Username', ['style'=>'margin-left:20%'])?>

					<?= $form->field($model, 'password')->passwordInput([ 'style'=>'width:40%;' ])->label('Password', ['style'=>'margin-left:20%']) ?>

				<div class="goCenter2">
					<div class="form-group">
						<div class="col-lg-offset-1 col-lg-11">
							<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button', 'style'=>'margin-top:1%; width:20%; height:5%']) ?>
						</div>
					</div>

				<?php ActiveForm::end(); ?>
				</div>
			
		</div>
	</div>
</div>

<style>
	.goCenter{
		margin-left:30%;
	}
	.goCenter2{
		margin-left:40%;
	}
</style>
