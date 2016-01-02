<?php
/* @var $this MaterialesController */
/* @var $model Materiales */

$this->breadcrumbs=array(
	'Materiales'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Materiales', 'url'=>array('index')),
	array('label'=>'Create Materiales', 'url'=>array('create')),
);
?>

<h1>Administración de materiales</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('materiales/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'materiales-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'unidad_medida',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
