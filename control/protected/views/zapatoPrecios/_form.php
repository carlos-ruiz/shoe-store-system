<?php
/* @var $this ZapatoPreciosController */
/* @var $model ZapatoPrecios */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'zapato-precios-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'precio_extrachico'); ?>
		<?php echo $form->textField($model,'precio_extrachico',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'precio_extrachico'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precio_chico'); ?>
		<?php echo $form->textField($model,'precio_chico',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'precio_chico'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precio_mediano'); ?>
		<?php echo $form->textField($model,'precio_mediano',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'precio_mediano'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precio_grande'); ?>
		<?php echo $form->textField($model,'precio_grande',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'precio_grande'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zapatos_id'); ?>
		<?php echo $form->textField($model,'zapatos_id'); ?>
		<?php echo $form->error($model,'zapatos_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->