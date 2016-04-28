<?php
/* @var $this ProvedoresController */
/* @var $model Provedores */

$this->breadcrumbs=array(
	'Proveedores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Provedores', 'url'=>array('index')),
	array('label'=>'Manage Provedores', 'url'=>array('admin')),
);
?>

<h1>Nuevo proveedor</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'direccion'=>$direccion,
	'materiales'=>$materiales,
	'tacones'=>$tacones,
	'suelas'=>$suelas,
	)); ?>