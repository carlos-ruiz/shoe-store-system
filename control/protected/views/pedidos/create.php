<?php
/* @var $this PedidosController */
/* @var $model Pedidos */

$this->breadcrumbs=array(
	'Pedidoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pedidos', 'url'=>array('index')),
	array('label'=>'Manage Pedidos', 'url'=>array('admin')),
);
?>

<h1>Create Pedidos</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>