<?php
/* @var $this EstatusZapatosController */
/* @var $model EstatusZapatos */

$this->breadcrumbs=array(
	'Estatus Zapatoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EstatusZapatos', 'url'=>array('index')),
	array('label'=>'Create EstatusZapatos', 'url'=>array('create')),
	array('label'=>'View EstatusZapatos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EstatusZapatos', 'url'=>array('admin')),
);
?>

<h1>Actualizar estatus de zapatos: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>