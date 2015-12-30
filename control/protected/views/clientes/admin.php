<?php
/* @var $this ClientesController */
/* @var $model Clientes */

$this->breadcrumbs=array(
	'Clientes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Clientes', 'url'=>array('index')),
	array('label'=>'Create Clientes', 'url'=>array('create')),
);
?>

<h1>Administración de clientes</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('clientes/create'), array('class'=>'btn btn-red-stripped')); ?>
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Tipos de cliente', array('tipocliente/admin'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clientes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'apellido_paterno',
		'apellido_materno',
		'rfc',
		'razon_social',
		/*
		'id_tipo_cliente',
		'id_direcciones',
		'telefono',
		'celular',
		'correo_electronico',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
