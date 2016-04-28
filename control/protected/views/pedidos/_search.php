<?php
/* @var $this PedidosController */
/* @var $model Pedidos */
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
		<?php echo $form->label($model,'id_clientes'); ?>
		<?php echo $form->textField($model,'id_clientes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_pedido'); ?>
		<?php echo $form->textField($model,'fecha_pedido'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_entrega'); ?>
		<?php echo $form->textField($model,'fecha_entrega'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_formas_pago'); ?>
		<?php echo $form->textField($model,'id_formas_pago'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total'); ?>
		<?php echo $form->textField($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_estatus_pedidos'); ?>
		<?php echo $form->textField($model,'id_estatus_pedidos'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->