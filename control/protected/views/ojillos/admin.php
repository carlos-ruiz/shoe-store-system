<?php
/* @var $this OjillosController */
/* @var $model Ojillos */

$this->breadcrumbs=array(
	'Ojilloses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Ojillos', 'url'=>array('index')),
	array('label'=>'Create Ojillos', 'url'=>array('create')),
);
?>

<h1>Administración de Ojillos</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('ojillos/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ojillos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
