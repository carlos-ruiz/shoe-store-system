<?php
/* @var $this PedidosController */
/* @var $data Pedidos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_clientes')); ?>:</b>
	<?php echo CHtml::encode($data->id_clientes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_pedido')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_pedido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_entrega')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_entrega); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_formas_pago')); ?>:</b>
	<?php echo CHtml::encode($data->id_formas_pago); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_estatus_pedidos')); ?>:</b>
	<?php echo CHtml::encode($data->id_estatus_pedidos); ?>
	<br />


</div>