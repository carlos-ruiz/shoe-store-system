<?php
/* @var $this ZapatosController */
/* @var $model Zapatos */

$this->breadcrumbs=array(
	'Zapatoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Zapatos', 'url'=>array('index')),
	array('label'=>'Manage Zapatos', 'url'=>array('admin')),
);
?>

<h1>Configurar nuevo precio</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>