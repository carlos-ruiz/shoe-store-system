<?php
/* @var $this TaconesController */
/* @var $model Tacones */

$this->breadcrumbs=array(
	'Tacones'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Tacones', 'url'=>array('index')),
	array('label'=>'Create Tacones', 'url'=>array('create')),
);
?>

<h1>Administración de tacones</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('tacones/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tacones-grid',
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
