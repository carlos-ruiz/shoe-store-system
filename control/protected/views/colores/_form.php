<?php
/* @var $this ColoresController */
/* @var $model Colores */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'colores-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<hr/>
		<div class="form-group <?php if($form->error($model,'color')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'color', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'color',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'color', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->