<?php
/* @var $this EstatusPedidosController */
/* @var $model EstatusPedidos */

$this->breadcrumbs=array(
	'Estatus Pedidoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EstatusPedidos', 'url'=>array('index')),
	array('label'=>'Create EstatusPedidos', 'url'=>array('create')),
);
?>

<h1>Administración de estatus de los pedidos</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('estatusPedidos/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'estatus-pedidos-grid',
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
