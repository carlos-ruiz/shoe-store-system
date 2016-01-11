<?php
/* @var $this FormasPagoController */
/* @var $model FormasPago */

$this->breadcrumbs=array(
	'Formas Pagos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FormasPago', 'url'=>array('index')),
	array('label'=>'Create FormasPago', 'url'=>array('create')),
	array('label'=>'View FormasPago', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FormasPago', 'url'=>array('admin')),
);
?>

<h1>Actualizar forma de pago: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>