<?php
/* @var $this EstatusPagosController */
/* @var $model EstatusPagos */

$this->breadcrumbs=array(
	'Estatus Pagoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EstatusPagos', 'url'=>array('index')),
	array('label'=>'Create EstatusPagos', 'url'=>array('create')),
	array('label'=>'View EstatusPagos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EstatusPagos', 'url'=>array('admin')),
);
?>

<h1>Actualizar estatus de pagos: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>