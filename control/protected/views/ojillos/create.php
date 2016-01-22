<?php
/* @var $this OjillosController */
/* @var $model Ojillos */

$this->breadcrumbs=array(
	'Ojilloses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ojillos', 'url'=>array('index')),
	array('label'=>'Manage Ojillos', 'url'=>array('admin')),
);
?>

<h1>Nuevo ojillo</h1>

<?php $this->renderPartial('_form', 
	array(
	'model'=>$model,
	'colores'=>$colores,
	'mensaje_error'=>$mensaje_error,
	)
); ?>