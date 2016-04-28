<?php
/* @var $this ModelosMaterialesPredeterminadosController */
/* @var $model ModelosMaterialesPredeterminados */

$this->breadcrumbs=array(
	'Modelos Materiales Predeterminadoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ModelosMaterialesPredeterminados', 'url'=>array('index')),
	array('label'=>'Manage ModelosMaterialesPredeterminados', 'url'=>array('admin')),
);
?>

<h1>Definir materiales por modelo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>