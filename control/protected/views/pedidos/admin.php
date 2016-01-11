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
		array(
	        'name'=>'id_clientes',
	        'value'=>'$data->cliente->nombre',
    	),
		'fecha_pedido',
		'fecha_entrega',
		array(
	        'name'=>'id_formas_pago',
	        'value'=>'$data->formaPago->nombre',
    	),
    	array(
	        'name'=>'id_estatus_pedidos',
	        'value'=>'$data->estatus->nombre',
    	),
		'total',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
