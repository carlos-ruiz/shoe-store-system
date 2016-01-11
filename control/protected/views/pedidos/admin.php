<?php
/* @var $this PedidosController */
/* @var $model Pedidos */

$this->breadcrumbs=array(
	'Pedidoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Pedidos', 'url'=>array('index')),
	array('label'=>'Create Pedidos', 'url'=>array('create')),
);
?>

<h1>Administración de pedidos</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('pedidos/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pedidos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'cliente.nombre',
		'fecha_pedido',
		'fecha_entrega',
		'formaPago.nombre',
		'total',
		/*
		'id_estatus_pedidos',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
