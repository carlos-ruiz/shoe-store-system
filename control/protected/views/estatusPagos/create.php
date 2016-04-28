<?php
/* @var $this EstatusPagosController */
/* @var $model EstatusPagos */

$this->breadcrumbs=array(
	'Estatus Pagoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EstatusPagos', 'url'=>array('index')),
	array('label'=>'Manage EstatusPagos', 'url'=>array('admin')),
);
?>

<h1>Nuevo estatus de pago</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>