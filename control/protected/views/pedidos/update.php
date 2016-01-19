<?php
/* @var $this PedidosController */
/* @var $model Pedidos */

$this->breadcrumbs=array(
	'Pedidoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pedidos', 'url'=>array('index')),
	array('label'=>'Create Pedidos', 'url'=>array('create')),
	array('label'=>'View Pedidos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pedidos', 'url'=>array('admin')),
);
?>

<h1>Actualizar Pedido <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', 
		array(
			'model'=>$model,
			'pedidoZapato'=>$pedidoZapato,
		)
	); ?>