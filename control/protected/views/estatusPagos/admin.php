<?php
/* @var $this EstatusPagosController */
/* @var $model EstatusPagos */

$this->breadcrumbs=array(
	'Estatus Pagoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EstatusPagos', 'url'=>array('index')),
	array('label'=>'Create EstatusPagos', 'url'=>array('create')),
);
?>

<h1>Administración de estatus de pago</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('estatusPagos/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'estatus-pagos-grid',
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
