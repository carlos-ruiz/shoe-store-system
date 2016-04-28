<?php
/* @var $this ZapatoPreciosController */
/* @var $data ZapatoPrecios */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio_extrachico')); ?>:</b>
	<?php echo CHtml::encode($data->precio_extrachico); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio_chico')); ?>:</b>
	<?php echo CHtml::encode($data->precio_chico); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio_mediano')); ?>:</b>
	<?php echo CHtml::encode($data->precio_mediano); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio_grande')); ?>:</b>
	<?php echo CHtml::encode($data->precio_grande); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zapatos_id')); ?>:</b>
	<?php echo CHtml::encode($data->zapatos_id); ?>
	<br />


</div>