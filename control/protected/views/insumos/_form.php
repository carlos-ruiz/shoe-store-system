<?php
/* @var $this InsumosController */
/* @var $model Insumos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'insumos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<hr/>
		<div class="form-group <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
			</div>
		</div>
		<div class="form-group <?php if($form->error($model,'unidad_medida')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'unidad_medida', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'unidad_medida',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'unidad_medida', array('class'=>'help-block')); ?>
			</div>
		</div>
		<div class="form-group <?php if($form->error($model,'cantidad')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'cantidad', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'cantidad',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'cantidad', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-red-stripped')); ?>
		</div>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->