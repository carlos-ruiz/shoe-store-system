<?php
/* @var $this EstatusZapatosController */
/* @var $model EstatusZapatos */

$this->breadcrumbs=array(
	'Estatus Zapatoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EstatusZapatos', 'url'=>array('index')),
	array('label'=>'Create EstatusZapatos', 'url'=>array('create')),
);
?>

<h1>Administración de estatus de zapatos</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('estatusZapatos/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'estatus-zapatos-grid',
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
