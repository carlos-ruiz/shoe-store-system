<?php
/* @var $this AgujetasController */
/* @var $model Agujetas */

$this->breadcrumbs=array(
	'Agujetases'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Agujetas', 'url'=>array('index')),
	array('label'=>'Create Agujetas', 'url'=>array('create')),
);
?>

<h1>Administración de agujetas</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevas', array('agujetas/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'agujetas-grid',
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
