<?php

namespace app\models;

use yii\db\ActiveRecord;

class Wp_postmeta extends ActiveRecord {
	public function getDbConnection(){
        return Yii::app()->db2; // db2 - имя базы из конфига
    }
	public static function tableName(){
         return 'rusich.wp_postmeta';
    }
}

?>