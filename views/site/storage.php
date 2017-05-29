<?php
session_start();
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Things;
use yii\helpers\Url;
use yii\helpers;


$this->title = 'Storage';

$this->registerCssFile('css/style.css');
$n = 1;





?>
<?= Html::csrfMetaTags() ?>
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <div class="wrapper">
        <div class="header">
            <div class="logo">
                <a href="https://sport-form.ru/" target="_blank"><img src="img/logo.png" alt="logo"></a>
            </div>
            
			<div class="center">
						<h1>Склад</h1>
						<button style = "margin-top:5%" name="button" id="add">Добавить товар</button>
					</div>
					<div class="exit">
						<a onclick = "<?php Yii::$app->user->logout(); ?>" href="index.php" title="">
							<span color="red">Выход</span>
								<img src="img/exit.png" alt="" />
						</a>
					</div>
					

        </div>
        <div class="clear"></div>


        <!--tableRussia-->
        <div class="container">
            <div class="table-title" id="headRu">
                <span class="country">Россия</span>
                <div class="warhouse"><span class="sklad">42</span>
                    <span class="reserv">(7)</span></div>
            </div>
            <div class="table-wrap" id="tableRussia">
                <table class="Russia">
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
                            <td><span><?=$thing->name ?></span></td>
                            <td><?=$thing->s ?></td>
                            <td><?=$thing->m ?></td>
                            <td><?=$thing->l ?></td>
                            <td><?=$thing->xl ?></td>
                            <td><?=$thing->xxl ?></td>
                            <td><?=$thing->xxxl ?></td>
                            <td><?=$thing->amount ?></td>
                            <td><?=$thing->price ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--tableCCCP-->

            <div class="table-title" id="headCccp">
                <span class="country">СССР</span>
                <div class="warhouse"><span class="sklad">21</span>
                    <span class="reserv">(4)</span></div>
            </div>
            <div class="table-wrap" id="tableCccp">
                <table class="Russia">
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
                        <tr>
                            <td><span><?=$thing->name ?></span></td>
                            <td><?=$thing->s ?></td>
                            <td><?=$thing->m ?></td>
                            <td><?=$thing->l ?></td>
                            <td><?=$thing->xl ?></td>
                            <td><?=$thing->xxl ?></td>
                            <td><?=$thing->xxxl ?></td>
                            <td><?=$thing->amount ?></td>
                            <td><?=$thing->price ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--tableОлимпиада-->

            <div class="table-title" id="headOlimp">
                <span class="country">Олимпиада 80</span>
                <div class="warhouse"><span class="sklad">21</span>
                    <span class="reserv">(4)</span></div>
            </div>
            <div class="table-wrap" id="tableOlimpiada">
                <table class="Russia">
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
                        <tr>
                            <td><span><?=$thing->name ?></span></td>
                            <td><?=$thing->s ?></td>
                            <td><?=$thing->m ?></td>
                            <td><?=$thing->l ?></td>
                            <td><?=$thing->xl ?></td>
                            <td><?=$thing->xxl ?></td>
                            <td><?=$thing->xxxl ?></td>
                            <td><?=$thing->amount ?></td>
                            <td><?=$thing->price ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>


    <div id="dark">
	<?php $f = ActiveForm::begin()?>
	
        <div class="spaceWrapper">
            <div class="text_form"><a style = "float:left; margin-left:0.5%">Выберите категорию:</a>
               <!-- <select>
                    <option value="none">---</option>
                    <option value="first">Россия</option>
                    <option value="second">СССР</option>
                    <option value="third">Олимпиада 80</option>
                </select>-->
				<?=$f->field($form, 'dropDownList')->dropDownList(['Россия'=>'Россия', 'СССР' =>'СССР', 'Олимпиада 80'=>'Олимпиада 80'], ['style'=>'width:30%;margin-left:0.5%','options' => ['Россия'=>['selected'=>true]]])->label('');?>
            </div>
			
            <button name="button_close" id="close">X</button>
            <div id="modal-table">
                <div class="table-wrap-hidden">
                        <table class="Russia">
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
                            <tbody class="hidden_table">
                                <tr class="hidden-row">
									
									<td><?= $f->field($form, 'name')->textInput(['style'=>'width:95%' ])->label('')?></td>
									<td><?= $f->field($form, 's')->textInput(['style'=>'width:98%' ])->label('')?></td>
									<td><?= $f->field($form, 'm')->textInput(['style'=>'width:98%' ])->label('')?></td>
									<td><?= $f->field($form, 'l')->textInput(['style'=>'width:98%' ])->label('')?></td>
									<td><?= $f->field($form, 'xl')->textInput(['style'=>'width:98%' ])->label('')?></td>
									<td><?= $f->field($form, 'xxl')->textInput(['style'=>'width:98%' ])->label('')?></td>
									<td><?= $f->field($form, 'xxxl')->textInput(['style'=>'width:98%' ])->label('')?></td>
									<td><?= $f->field($form, 'amount')->textInput(['style'=>'width:98%' ])->label('')?></td>
									<td><?= $f->field($form, 'price')->textInput(['style'=>'width:98%' ])->label('')?></td>
									
									
                                   <!-- <td><input name="name1" type="text"></td>
                                    <td><input name="s1" type="text"></td>
                                    <td><input name="m1" type="text"></td>
                                    <td><input name="l1" type="text"></td>
                                    <td><input name="xl1" type="text"></td>
                                    <td><input name="xxl1" type="text"></td>
                                    <td><input name="xxxl1" type="text"></td>
                                    <td><input name="amount1" type="text"></td>
                                    <td><input name="price1" type="text"></td>-->
                                </tr>
                            </tbody>
							
							
                        </table>
                        
                    
                </div>
            </div><!--<button type="submit" name="button_add" id="future">Добавить</button>-->
			<?= Html::submitButton('Добавить', ['id'=>'future', 'name' => 'button_add']) ?>
			<?php ActiveForm::end(); ?>
           <!-- <button name="row_add" id="add_row">+</button>-->
            
        </div>
    </div>

    <script>

    </script>
	

	<style>		
       a {
        color: #000000; /* Цвет обычной ссылки */ 
        text-decoration: none; /* Убираем подчеркивание у ссылок */
       }
    </style>
