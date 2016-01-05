<?php
/* @var $this PedidosController */
/* @var $model Pedidos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pedidos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_clientes'); ?>
		<?php echo $form->textField($model,'id_clientes'); ?>
		<?php echo $form->error($model,'id_clientes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_pedido'); ?>
		<?php echo $form->textField($model,'fecha_pedido'); ?>
		<?php echo $form->error($model,'fecha_pedido'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_entrega'); ?>
		<?php echo $form->textField($model,'fecha_entrega'); ?>
		<?php echo $form->error($model,'fecha_entrega'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_formas_pago'); ?>
		<?php echo $form->textField($model,'id_formas_pago'); ?>
		<?php echo $form->error($model,'id_formas_pago'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->textField($model,'total'); ?>
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_estatus_pedidos'); ?>
		<?php echo $form->textField($model,'id_estatus_pedidos'); ?>
		<?php echo $form->error($model,'id_estatus_pedidos'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->