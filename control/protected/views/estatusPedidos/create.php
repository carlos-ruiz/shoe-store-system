<?php
/* @var $this EstatusPedidosController */
/* @var $model EstatusPedidos */

$this->breadcrumbs=array(
	'Estatus Pedidoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EstatusPedidos', 'url'=>array('index')),
	array('label'=>'Manage EstatusPedidos', 'url'=>array('admin')),
);
?>

<h1>Nuevo estatus de pedido</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>