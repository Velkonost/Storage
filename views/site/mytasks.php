<?php
	$this->title = "My tasks";
	$this->params['breadcrumbs'][] = $this->title;
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\widgets\LinkPager;
?>
<style>
	@font-face {
		font-family: 'MyFont';
		src: url('fonts/myfont.ttf');
	}
	.fontss{
		font-size: 350%;
		font-family: MyFont, 'Citrica Cyrillic', cursive;
	}

</style>
<div class="site-index">

    <div class="jumbotron">
	<?php
		echo "<div class = 'fontss'><b>All my tasks:</b></div>";
		foreach($tasksbd as $task){?>
				<b>Task: </b><?php echo $task->task;?><br /><b>Date ending: </b><?php echo $task->dateEnd;?><br/><hr>
		<?php }
		
	?>
	</div>

</div>
