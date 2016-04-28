<?php
/* @var $this ModelosMaterialesPredeterminadosController */
/* @var $data ModelosMaterialesPredeterminados */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_modelos_colores')); ?>:</b>
	<?php echo CHtml::encode($data->id_modelos_colores); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_suelas_colores')); ?>:</b>
	<?php echo CHtml::encode($data->id_suelas_colores); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tacones_colores')); ?>:</b>
	<?php echo CHtml::encode($data->id_tacones_colores); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_ojillos_colores')); ?>:</b>
	<?php echo CHtml::encode($data->id_ojillos_colores); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_agujetas_colores')); ?>:</b>
	<?php echo CHtml::encode($data->id_agujetas_colores); ?>
	<br />


</div>