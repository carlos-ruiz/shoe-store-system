<?php
/* @var $this ZapatoPreciosController */
/* @var $model ZapatoPrecios */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'precio_extrachico'); ?>
		<?php echo $form->textField($model,'precio_extrachico',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'precio_chico'); ?>
		<?php echo $form->textField($model,'precio_chico',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'precio_mediano'); ?>
		<?php echo $form->textField($model,'precio_mediano',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'precio_grande'); ?>
		<?php echo $form->textField($model,'precio_grande',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'zapatos_id'); ?>
		<?php echo $form->textField($model,'zapatos_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->