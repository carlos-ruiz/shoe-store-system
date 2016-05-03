<?php
/* @var $this ProvedoresController */
/* @var $model Provedores */

$this->breadcrumbs=array(
	'Provedores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Provedores', 'url'=>array('index')),
	array('label'=>'Create Provedores', 'url'=>array('create')),
);
?>

<h1>Administración de Provedores</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('provedores/create'), array('class'=>'btn btn-red-stripped')); ?>
	<!-- <?php echo CHtml::link('<i class="fa fa-eye"></i> Ver adeudos', array('provedores/verAdeudos'), array('class'=>'btn btn-red-stripped')); ?> -->
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'provedores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'telefono',
		'correo_electronico',
		'id_direcciones',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
