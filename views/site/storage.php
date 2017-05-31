<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Things;
use yii\helpers\Url;
use yii\helpers;
use yii\web\helpers\CHtml;

$this->title = 'Storage';

$this->registerCssFile('css/style.css');

$cookies = Yii::$app->request->cookies;
$n = 1;
if (!$cookies->has('cook')){
	Yii::$app->response->redirect('index.php');
}

function logoutT(){
	Yii::$app->response->cookies->remove('cook');
	
}

?>
<style type="text/css">
    table {width: 900px;}
    thead>tr>td:not(:nth-child(1)) {
        width: 60px;
        height: 50px;
        margin: 0px;
        padding: 0px;
    }

    #hidden {
        display: none;
        width: 0px !important;
        height: 0px !important;
        padding: 0 !important;
        font-size: 0%;
        position: absolute !important;
        margin: 0 !important;
    }

</style>
    <div class="wrapper">
        <div class="header">
            <div class="logo">
                <a href="https://sport-form.ru/" target="_blank"><img src="img/logo.png" alt="logo"></a>
            </div>

			         <div class="center" style="display: inline-block; width: 520px">
						<h1>Склад</h1>
						<button style = "margin-top:5%" name="button" id="add">Добавить товар</button>
                        <button style = "margin-top:5%" name="button" id="inventar">Инвентаризация</button>
					</div>
					<div class="exit">
						<a onclick = "<?php Yii::$app->user->logout();//ТУТА ДОДЕЛАТЬ ?>" href="index.php" title="">
							<span color="red">Выход</span>
								<img src="img/exit.png" alt="" />
						</a>
					</div>
					

        </div>
        <div class="clear"></div>
    
        <?php $f2 = ActiveForm::begin();?>
        <!--tableRussia-->
        <div class="" style="margin-top: 40px">
            <div class="table-title" id="headRu">
                <span class="country">Россия</span>
                <div class="warhouse"><span class="sklad"><?=$russiaAmount?></span>
                    <span class="reserv">(7)</span></div>
            </div>
            <div class="table-wrap" id="tableRussia">
                <table class="Russia" style="border-collapse: separate; border-spacing: 3px;">
                    <thead>
                        <tr>
                            <td><span>Название</span></td>
                            <td>S</td>
                            <td>M</td>
                            <td>L</td>
                            <td>XL</td>
                            <td>XXL</td>
                            <td>XXXL</td>
                            <td>к-во</td>
                            <td>цена</td>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        foreach ($russia as $thing) { ?>
                        
                        <tr>
                            <td><span>
                            <? echo '<div class="" name="showField" style="margin-left:5%">'.$thing->name.'</div>'; ?>
                            <?=$f2->field($editForm, 'editNames[]')->textInput(['style'=>'width:98%' ,'value' => $thing->name, 'class' => 'inputField'])->label('')?>

                            </span></td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->s.'</div>'; ?>
                            <?=$f2->field($editForm, 'editSs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->s, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>                            
                            </td> 
                           <td>
                            <? echo '<div class="" name="showField">'.$thing->m.'</div>'; ?>
                            <?=$f2->field($editForm, 'editMs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->m, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->l.'</div>'; ?>
                            <?=$f2->field($editForm, 'editLs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->l, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                             <td>
                            <? echo '<div class="" name="showField">'.$thing->xl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->xxl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXxls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xxl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->xxxl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXxxls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xxxl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->amount.'</div>'; ?>
                            <?=$f2->field($editForm, 'editAmounts[]')->textInput(['style'=>'width:98%' ,'value' => $thing->amount, 'type'=>'number', 'min' => '0', 'class' => 'inputField', 'disabled' => true])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->price.'</div>'; ?>
                            <?=$f2->field($editForm, 'editPrices[]')->textInput(['style'=>'width:98%' ,'value' => $thing->price, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--tableCCCP-->

            <div class="table-title" id="headCccp">
                <span class="country">СССР</span>
                <div class="warhouse"><span class="sklad"><?=$ussrAmount ?></span>
                    <span class="reserv">(4)</span></div>
            </div>
            <div class="table-wrap" id="tableCccp">
            
            
               <table class="Russia" style="border-collapse: separate; border-spacing: 3px;"> 
                    <thead>
                        <tr>
                            <td><span>Название</span></td>
                            <td>S</td>
                            <td>M</td>
                            <td>L</td>
                            <td>XL</td>
                            <td>XXL</td>
                            <td>XXXL</td>
                            <td>к-во</td>
                            <td>цена</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ussr as $thing) { ?>
                        <?=$f2->field($editForm, 'editCategory[]')->textInput(['value' => 'ussr', 'class' => 'hidden'])->label('')?>
                        <tr>
                            <td><span>
                            <? echo '<div class="" name="showField" style="margin-left:5%">'.$thing->name.'</div>'; ?>
                            <?=$f2->field($editForm, 'editNames[]')->textInput(['style'=>'width:98%' ,'value' => $thing->name, 'class' => 'inputField'])->label('')?>
                            </span></td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->s.'</div>'; ?>
                            <?=$f2->field($editForm, 'editSs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->s, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                           <td>
                            <? echo '<div class="" name="showField">'.$thing->m.'</div>'; ?>
                            <?=$f2->field($editForm, 'editMs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->m, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                           <td>
                            <? echo '<div class="" name="showField">'.$thing->l.'</div>'; ?>
                            <?=$f2->field($editForm, 'editLs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->l, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->xl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                           <td>
                            <? echo '<div class="" name="showField">'.$thing->xxl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXxls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xxl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->xxxl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXxxls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xxxl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->amount.'</div>'; ?>
                            <?=$f2->field($editForm, 'editAmounts[]')->textInput(['style'=>'width:98%' ,'value' => $thing->amount, 'type'=>'number', 'min' => '0', 'class' => 'inputField', 'disabled' => true])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->price.'</div>'; ?>
                            <?=$f2->field($editForm, 'editPrices[]')->textInput(['style'=>'width:98%' ,'value' => $thing->price, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                        </tr>
                        <?php } ?>
                    
                    </tbody>
                </table>
            
            </div>

            <!--tableОлимпиада-->

            <div class="table-title" id="headOlimp">
                <span class="country">Олимпиада 80</span>
                <div class="warhouse"><span class="sklad"><?=$olympiad80Amount?></span>
                    <span class="reserv">(4)</span></div>
            </div>
            <div class="table-wrap" id="tableOlimpiada">
                <table class="Russia" style="border-collapse: separate; border-spacing: 3px;">
                    <thead>
                        <tr>
                            <td><span>Название</span></td>
                            <td>S</td>
                            <td>M</td>
                            <td>L</td>
                            <td>XL</td>
                            <td>XXL</td>
                            <td>XXXL</td>
                            <td>к-во</td>
                            <td>цена</td>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        foreach ($olympiad80 as $thing) { ?>
                        <?=$f2->field($editForm, 'editCategory[]')->textInput(['value' => 'olympiad80', 'class' => 'hidden'])->label('')?>
                        <tr>
                            <td><span>
                            <? echo '<div class="" name="showField" style="margin-left:5%">'.$thing->name.'</div>'; ?>
                            <?=$f2->field($editForm, 'editNames[]')->textInput(['style'=>'width:98%' ,'value' => $thing->name, 'class' => 'inputField'])->label('')?>
                            </span></td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->s.'</div>'; ?>
                            <?=$f2->field($editForm, 'editSs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->s, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                           <td>
                            <? echo '<div class="" name="showField">'.$thing->m.'</div>'; ?>
                            <?=$f2->field($editForm, 'editMs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->m, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->l.'</div>'; ?>
                            <?=$f2->field($editForm, 'editLs[]')->textInput(['style'=>'width:98%' ,'value' => $thing->l, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->xl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->xxl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXxls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xxl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->xxxl.'</div>'; ?>
                            <?=$f2->field($editForm, 'editXxxls[]')->textInput(['style'=>'width:98%' ,'value' => $thing->xxxl, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->amount.'</div>'; ?>
                            <?=$f2->field($editForm, 'editAmounts[]')->textInput(['style'=>'width:98%' ,'value' => $thing->amount, 'type'=>'number', 'min' => '0', 'class' => 'inputField', 'disabled' => true])->label('')?>
                            </td>
                            <td>
                            <? echo '<div class="" name="showField">'.$thing->price.'</div>'; ?>
                            <?=$f2->field($editForm, 'editPrices[]')->textInput(['style'=>'width:98%' ,'value' => $thing->price, 'type'=>'number', 'min' => '0', 'class' => 'inputField'])->label('')?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <?= Html::submitButton('Сохранить', ['style' => 'margin-top: 50px; margin-left:40%', 'name' => 'btn_save']) ?>
    <?php ActiveForm::end();?>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>


    <div id="dark">
	<?php $f = ActiveForm::begin()?>
	
        <div class="spaceWrapper">
            <div class="text_form"><a style = "float:left; margin-left:0.5%">Выберите категорию:</a>
				<?=$f->field($form, 'dropDownList')->dropDownList(['russia'=>'Россия', 'ussr' =>'СССР', 'olympiad80'=>'Олимпиада 80'], ['style'=>'width:30%;margin-left:0.5%','options' => ['Россия'=>['selected'=>true]]])->label('');?>
            </div>
			
            <button name="button_close" id="close">X</button>
            <div id="modal-table">
                <div class="table-wrap-hidden">
                        <table class="Russia" style="border-collapse: separate; border-spacing: 1px;">
                            <thead>
                                <tr>
                                    <td><span>Название</span></td>
                                    <td>S</td>
                                    <td>M</td>
                                    <td>L</td>
                                    <td>XL</td>
                                    <td>XXL</td>
                                    <td>XXXL</td>
                                    <td>цена</td>
                                </tr>
                            </thead>
                            <tbody class="hidden_table">
                                <tr class="hidden-row">
									<datalist id="names">
                                    <?php foreach ($russiaNames as $name1) { ?>
                                        <option value=<? echo $name1; ?>>
                                    <?php } ?>
                                    <?php foreach ($ussrNames as $name2) { ?>
                                        <option value=<? echo $name2; ?>>
                                    <?php } ?>
                                    <?php foreach ($olympiad80Names as $name3) { ?>
                                        <option value=<? echo $name3; ?>>
                                    <?php } ?>
									</datalist>
									<td><?=$f->field($form, 'names[]')->textInput(['style'=>'width:95%', 'list'=>'names'])->label('');?></td>
									<td><?=$f->field($form, 'ss[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
									<td><?= $f->field($form, 'ms[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
									<td><?= $f->field($form, 'ls[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
									<td><?= $f->field($form, 'xls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
									<td><?= $f->field($form, 'xxls[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
									<td><?= $f->field($form, 'xxxls[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
									<td><?= $f->field($form, 'prices[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
									
                                </tr>

                                <tr class="hidden-row">
                                  
                                    <td><?=$f->field($form, 'names[]')->textInput(['style'=>'width:95%', 'list'=>'names'])->label('');?></td>
                                    <td><?=$f->field($form, 'ss[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'ms[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'ls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'xls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'xxls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'xxxls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'prices[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                </tr>

                                <tr class="hidden-row">
                                    
                                    <td><?=$f->field($form, 'names[]')->textInput(['style'=>'width:95%', 'list'=>'names'])->label('');?></td>
                                    <td><?= $f->field($form, 'ss[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'ms[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'ls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'xls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'xxls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'xxxls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                    <td><?= $f->field($form, 'prices[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div><!--<button type="submit" name="button_add" id="future">Добавить</button>-->
			<?= Html::submitButton('Добавить', ['id'=>'future', 'name' => 'button_save']) ?>
			<?php ActiveForm::end(); ?>
           <!-- <button name="row_add" id="add_row">+</button>-->
            
        </div>
    </div>

    <script>
    var open = false;

   

    $(function() {

        var show = []; var hide = [];

        show = Array.from(document.getElementsByClassName('inputField'));
        console.log(show);
        show.forEach(function(entry) {
            entry.setAttribute('class', 'hidden');
            entry.setAttribute('height', '0%');
        });

        $('#inventar').click(function(event) {
            if (!open) {

                hide = Array.from(document.getElementsByName('showField'));

                hide.forEach(function(entry) {
                    entry.setAttribute('class', 'hidden');
                    entry.style.height = "0px";
                });
                show.forEach(function(entry) {
                    entry.setAttribute('class', 'inputField');
                    entry.style.height = "50px";

                });

                $('#tableRussia').toggle();
                $('#tableCccp').toggle();
                $('#tableOlimpiada').toggle();

                open = true;
            }
        });
    });

    </script>
	

	<style>		
       a {
        color: #000000; /* Цвет обычной ссылки */ 
        text-decoration: none; /* Убираем подчеркивание у ссылок */
       }

       a:hover {
        color: #000000; /* Цвет обычной ссылки */ 
        text-decoration: none; /* Убираем подчеркивание у ссылок */
       }
    </style>
