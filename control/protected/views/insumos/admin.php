<?php
/* @var $this InsumosController */
/* @var $model Insumos */

$this->breadcrumbs=array(
	'Insumoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Insumos', 'url'=>array('index')),
	array('label'=>'Create Insumos', 'url'=>array('create')),
);
?>

<h1>Administración de insumos</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('insumos/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'insumos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'unidad_medida',
		'cantidad',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
