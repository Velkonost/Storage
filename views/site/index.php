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
						'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
						'labelOptions' => ['class' => 'col-lg-1 control-label', 'style' => 'text-align: center;'],
						
					],
				]); ?>

					<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

					<?= $form->field($model, 'password')->passwordInput() ?>

				<div class="goCenter">
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
		text-align: center;
		display: block;
	}
	.goCenter2{
		margin-right:20%;
		text-align: center;
		display: block;
	}
</style>
