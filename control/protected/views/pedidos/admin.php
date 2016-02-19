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
	        'name'=>'var_cliente_nombre',
	        'value'=>'$data->cliente->obtenerNombreCompleto()',
    	),
		'fecha_pedido',
		'fecha_entrega',
		array(
	        'name'=>'var_forma_pago',
	        'value'=>'$data->formaPago->nombre',
    	),
    	array(
	        'name'=>'var_estatus',
	        'value'=>'$data->estatus->nombre',
    	),
    	array(
	        'name'=>'var_estatus_pago',
	        'value'=>'$data->estatusPago->nombre',
    	),
    	array(
	        'name'=>'total',
	        'value'=>'\'$\'.$data->total',
    	),
    	array(
	        'name'=>'var_adeudo',
	        'value'=>array($this, 'calcularAdeudo'),
    	),
    	'prioridad',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
