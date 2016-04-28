<?php
/* @var $this ZapatosController */
/* @var $data Zapatos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:</b>
	<?php echo CHtml::encode($data->numero); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio')); ?>:</b>
	<?php echo CHtml::encode($data->precio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_barras')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_barras); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_modelos_colores')); ?>:</b>
	<?php echo CHtml::encode($data->id_modelos_colores); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_suelas')); ?>:</b>
	<?php echo CHtml::encode($data->id_suelas); ?>
	<br />


</div>