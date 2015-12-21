<?php
/* @var $this InsumosController */
/* @var $model Insumos */

$this->breadcrumbs=array(
	'Insumoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Insumos', 'url'=>array('index')),
	array('label'=>'Manage Insumos', 'url'=>array('admin')),
);
?>

<h1>Create Insumos</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>