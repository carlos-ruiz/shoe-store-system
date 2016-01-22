<?php
/* @var $this TaconesController */
/* @var $model Tacones */

$this->breadcrumbs=array(
	'Tacones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tacones', 'url'=>array('index')),
	array('label'=>'Manage Tacones', 'url'=>array('admin')),
);
?>

<h1>Create Tacones</h1>

<?php $this->renderPartial('_form', 
	array(
	'model'=>$model,
	'colores'=>$colores,
	)
); ?>