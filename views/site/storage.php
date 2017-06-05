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


function logoutT(){
	Yii::$app->response->cookies->remove('cook');
	Yii::$app->response->redirect('index.php');
}
?>
<script>
	setInterval(request, 5000);
</script>
<script> function request(){<?php
	if (!Yii::$app->getRequest()->getCookies()->has('cook')){
		Yii::$app->response->redirect('index.php');
}?>}</script>

<style type="text/css">
    table {width: 900px;}



    #hidden {
        display: none;
        overflow:hidden;

        width: 0px !important;
        height: 0px !important;
        padding: 0 !important;
        font-size: 0%;
        position: absolute !important;
        margin: 0 !important;
    }
    .form-group {
        
        padding: 0;
        margin: 0;
        text-align: center;
        vertical-align: middle;
        display: inline-block;

    }
    div[name='showField'] {
        display: inline-block;
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
						<a onclick = 'return location.href = "<?php Yii::$app->user->logout();?>"' href="index.php?log=true" title="">
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
                <table name="russiaContent" class="Russia" style="border-collapse: separate; border-spacing: 3px;">
                    <thead>
                        <tr>
                            <td style="text-align: center"><span>Артикул</span></td>
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
                            <? echo '<div class="" name="showField" style="margin-left:5%">'.$thing->article.'</div>'; ?>
                            <?=$f2->field($editForm, 'editArticle[]')->textInput(['style'=>'width:98%' ,'value' => $thing->article, 'class' => 'inputField'])->label('')?>
                            </span></td>
                            <td style="background-color: #f7f6e7; width: 25%"><span>
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
            
            
               <table name="ussrContent" class="Russia" style="border-collapse: separate; border-spacing: 3px;"> 
                    <thead>
                        <tr>
                            <td style="text-align: center"><span>Артикул</span></td>
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
                            <td><span>
                            <? echo '<div class="" name="showField" style="margin-left:5%">'.$thing->article.'</div>'; ?>
                            <?=$f2->field($editForm, 'editArticle[]')->textInput(['style'=>'width:98%' ,'value' => $thing->article, 'class' => 'inputField'])->label('')?>
                            </span></td>
                            <td style="background-color: #f7f6e7; width: 25%"><span>
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
                <table name="olympiad80Content" class="Russia" style="border-collapse: separate; border-spacing: 3px;">
                    <thead>
                        <tr>
                            <td style="text-align: center"><span>Артикул</span></td>
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
                            <td><span>
                            <? echo '<div class="" name="showField" style="margin-left:5%">'.$thing->article.'</div>'; ?>
                            <?=$f2->field($editForm, 'editArticle[]')->textInput(['style'=>'width:98%' ,'value' => $thing->article, 'class' => 'inputField'])->label('')?>
                            </span></td>
                            <td style="background-color: #f7f6e7; width: 25%"><span>
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
        <?= Html::submitButton('Сохранить', ['style' => 'margin-top: 50px; margin-left:40%', 'name' => 'btn_save', 'id' => 'btnSave', 'class' => 'hidden']) ?>
    <?php ActiveForm::end();?>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>


    <div id="dark">
	<?php $f = ActiveForm::begin()?>
	
        <div class="spaceWrapper">
            <div class="text_form"><a style = "float:left; margin-left:0.5%">Выберите категорию:</a>
				<?=$f->field($form, 'dropDownList')->dropDownList(['russia'=>'Россия', 'ussr' =>'СССР', 'olympiad80'=>'Олимпиада 80'], ['style'=>'width:100%;margin-left: -300%;display:inline-block;','options' => ['Россия'=>['selected'=>true]]])->label('');?>
            </div>
			
            <button name="button_close" id="close">X</button>
            <div id="modal-table">
                <div class="table-wrap-hidden">
                        <table class="Russia" style="border-collapse: separate; border-spacing: 1px;">
                            <thead>
                                <tr>
                                    <td style="text-align: center;  width: 25%"><span>Артикул</span></td>
                                    <td style="width: 25%">Название</td>
                                    <td>S</td>
                                    <td>M</td>
                                    <td>L</td>
                                    <td>XL</td>
                                    <td>XXL</td>
                                    <td>XXXL</td>
                                    <td>цена</td>
                                </tr>
                            </thead>
							
							<script>var names1 = [<?php foreach ($russiaNames as $name1){ echo '"'.$name1.'",';} ?>]</script>
							<script>var names1 = [<?php foreach ($ussrNames as $name2){ echo '"'.$name2.'",';} ?>]</script>
							<script>var names1 = [<?php foreach ($olympiad80Names as $name3){ echo '"'.$name3.'",';} ?>]</script>
                            <tbody class="hidden_table">
									
									<?php $list = [];$names1 = []; $names2 = []; $names3 = [];?>
									<datalist id="names">
                                    <?php foreach ($russiaNames as $name1) { array_push($list, $name1); array_push($names1, $name1); ?> 
                                        <option value=<? echo $name1; ?>>
                                    <?php } ?>
                                    <?php foreach ($ussrNames as $name2) {  array_push($list, $name2);array_push($names2, $name2); ?>
                                        <option value=<? echo $name2; ?>>
                                    <?php } ?>
                                    <?php foreach ($olympiad80Names as $name3) {  array_push($list, $name3);array_push($names3, $name3);?>
                                        <option value=<? echo $name3; ?>>
                                    <?php } ?>
									
									
								<?php for($i=0;$i<3; $i++){?>
										<tr class='hidden-row'>
											<td><?=$f->field($form, 'article[]')->dropDownList($allarticles, ['id' => "selectName$i", 'style'=>'width:201%; margin-left:2%;','options' => ['0'=>['selected'=>true]]])->label('');?></td>
											<td style="background-color: #f7f6e7"><?=$f->field($form, 'names[]')->dropDownList($allclothes, ['id' => "selectArticle$i", 'style'=>' width:96%; margin-left:2%', 'options' => ['0'=>['selected'=>true]]])->label('');?></td>

											<td><?=$f->field($form, 'ss[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
											<td><?= $f->field($form, 'ms[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
											<td><?= $f->field($form, 'ls[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
											<td><?= $f->field($form, 'xls[]')->textInput(['style'=>'width:98%' ,'value' =>'0', 'type'=>'number', 'min' => '0'])->label('')?></td>
											<td><?= $f->field($form, 'xxls[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
											<td><?= $f->field($form, 'xxxls[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
											<td><?= $f->field($form, 'prices[]')->textInput(['style'=>'width:98%' , 'value' =>'0','type'=>'number', 'min' => '0'])->label('')?></td>
											
										</tr>
									<?php } ?>
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

        $('#selectName0').on("change", function()
        {
            var selectName = document.getElementById('selectName0');
            $('#selectArticle0').val(selectName.options.selectedIndex);
        });
        $('#selectArticle0').on("change", function()
        {
            var selectArticle = document.getElementById('selectArticle0');
            $('#selectName0').val(selectArticle.options.selectedIndex);
        }); 

        $('#selectName1').on("change", function()
        {
            var selectName = document.getElementById('selectName1');
            $('#selectArticle1').val(selectName.options.selectedIndex);
        });
        $('#selectArticle1').on("change", function()
        {
            var selectArticle = document.getElementById('selectArticle1');
            $('#selectName1').val(selectArticle.options.selectedIndex);
        });  

        $('#selectName2').on("change", function()
        {
            var selectName = document.getElementById('selectName2');
            $('#selectArticle2').val(selectName.options.selectedIndex);
        });
        $('#selectArticle2').on("change", function()
        {
            var selectArticle = document.getElementById('selectArticle2');
            $('#selectName2').val(selectArticle.options.selectedIndex);
        });   
  
    $(function() {

        var show = []; var hide = [];

        show = Array.from(document.getElementsByClassName('inputField'));

        show.forEach(function(entry) {
            entry.setAttribute('class', 'hidden');
        });

        $('#inventar').click(function(event) {
            

                hide = Array.from(document.getElementsByName('showField'));

                if (!open) {
                    hide.forEach(function(entry) {
                        entry.setAttribute('class', 'hidden');
                        
                    });
                    show.forEach(function(entry) {
                        entry.setAttribute('class', 'inputField');
                        

                    });

                    document.getElementById('btnSave').setAttribute('class', '');

                    open = true;
                } else {

                    hide.forEach(function(entry) {
                        entry.setAttribute('class', '');
                        
                    });
                    show.forEach(function(entry) {
                        entry.setAttribute('class', 'hidden');
                        entry.style.height = "50px";

                    });
                    document.getElementById('btnSave').setAttribute('class', 'hidden');

                    open = false;
                }

                $('#tableRussia').toggle(
                    function () {
                        if ($("russiaContent").is(':visible') && open) {
                            $('#tableRussia').toggle();
                        } 
                    }
                );
                $('#tableCccp').toggle(
                    function () {
                        if ($("ussrContent").is(':visible') && open) {
                            $('#tableRussia').toggle();
                        } 
                    }
                );
                $('#tableOlimpiada').toggle(
                    function () {
                        if ($("olympiad80Content").is(':visible') && open) {
                            $('#tableRussia').toggle();
                        } 
                    }
                );

                // open = true;
            
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
