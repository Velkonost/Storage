<?php

namespace app\models;


use Yii;
use yii\base\Model;

class AddThingForm extends Model {

	public $category;
	public $name;
	public $s;
	public $m;
	public $l;
	public $xl;
	public $xxl;
	public $xxxl;
	public $amount;
	public $price;


	public function rules() {
		return [
			[['name', 's', 'm', 'l', 'xl', 'xxl', 'xxxl', 'amount', 'price'], 'required'],
		];
	}

}

?>