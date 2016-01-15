<?php
/* @var $this ZapatoPreciosController */
/* @var $model ZapatoPrecios */

$this->breadcrumbs=array(
	'Zapato Precioses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ZapatoPrecios', 'url'=>array('index')),
	array('label'=>'Manage ZapatoPrecios', 'url'=>array('admin')),
);
?>

<h1>Create ZapatoPrecios</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>