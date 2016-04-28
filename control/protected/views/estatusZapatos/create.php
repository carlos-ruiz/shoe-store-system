<?php
/* @var $this EstatusZapatosController */
/* @var $model EstatusZapatos */

$this->breadcrumbs=array(
	'Estatus Zapatoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EstatusZapatos', 'url'=>array('index')),
	array('label'=>'Manage EstatusZapatos', 'url'=>array('admin')),
);
?>

<h1>Nuevo estatus de zapatos</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>