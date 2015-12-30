<?php
/* @var $this SuelasController */
/* @var $model Suelas */

$this->breadcrumbs=array(
	'Suelases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Suelas', 'url'=>array('index')),
	array('label'=>'Manage Suelas', 'url'=>array('admin')),
);
?>

<h1>Nueva suela</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>