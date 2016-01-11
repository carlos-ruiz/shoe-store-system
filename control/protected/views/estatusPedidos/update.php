<?php
/* @var $this EstatusPedidosController */
/* @var $model EstatusPedidos */

$this->breadcrumbs=array(
	'Estatus Pedidoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EstatusPedidos', 'url'=>array('index')),
	array('label'=>'Create EstatusPedidos', 'url'=>array('create')),
	array('label'=>'View EstatusPedidos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EstatusPedidos', 'url'=>array('admin')),
);
?>

<h1>Actualizar estatus de pedido: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>