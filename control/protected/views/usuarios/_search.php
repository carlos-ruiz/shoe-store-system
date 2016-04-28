<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */
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
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contrasenia'); ?>
		<?php echo $form->textField($model,'contrasenia',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creacion'); ?>
		<?php echo $form->textField($model,'creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ultima_modificacion'); ?>
		<?php echo $form->textField($model,'ultima_modificacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_perfiles_usuarios'); ?>
		<?php echo $form->textField($model,'id_perfiles_usuarios'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->