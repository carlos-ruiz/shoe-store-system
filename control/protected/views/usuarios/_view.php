<?php
/* @var $this UsuariosController */
/* @var $data Usuarios */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario')); ?>:</b>
	<?php echo CHtml::encode($data->usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contrasenia')); ?>:</b>
	<?php echo CHtml::encode($data->contrasenia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creacion')); ?>:</b>
	<?php echo CHtml::encode($data->creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ultima_modificacion')); ?>:</b>
	<?php echo CHtml::encode($data->ultima_modificacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_perfiles_usuarios')); ?>:</b>
	<?php echo CHtml::encode($data->id_perfiles_usuarios); ?>
	<br />


</div>