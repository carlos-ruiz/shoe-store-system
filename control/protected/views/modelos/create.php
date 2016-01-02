<?php
/* @var $this ModelosController */
/* @var $model Modelos */

$this->breadcrumbs=array(
	'Modeloses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Modelos', 'url'=>array('index')),
	array('label'=>'Manage Modelos', 'url'=>array('admin')),
);
?>

<h1>Nuevo modelo</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model, 
	'colores'=>$colores, 
	'suelas'=>$suelas,
	'materiales'=>$materiales,
	)); ?>