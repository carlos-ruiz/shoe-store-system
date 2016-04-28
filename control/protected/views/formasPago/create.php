<?php
/* @var $this FormasPagoController */
/* @var $model FormasPago */

$this->breadcrumbs=array(
	'Formas Pagos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FormasPago', 'url'=>array('index')),
	array('label'=>'Manage FormasPago', 'url'=>array('admin')),
);
?>

<h1>Nueva formas de pago</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>