<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;
	
	class FormAdd extends Model
	{
		public $name, $m, $s, $l, $xl, $xxl, $xxxl, $amount, $price, $dropDownList;
		
		public function rules(){
			return [
				// username and password are both required
				[['name', 'm', 's', 'l', 'xl', 'xxl', 'xxxl', 'amount', 'price', 'dropDownList'], 'required', message => ''],
				// rememberMe must be a boolean value
				['name', 'default', message => ''],
				['s', 'number', message => ''],
				['m', 'number', message => ''],
				['l', 'number', message => ''],
				['xl', 'number', message => ''],
				['xxl', 'number', message => ''],
				['xxxl', 'number', message => ''],
				['amount', 'number', message => ''],
				['price', 'number', message => ''],
				['dropDownList','default', message=>'']
			];
		}
		
	}
?>
