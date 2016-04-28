<?php
/* @var $this ProvedoresController */
/* @var $model Provedores */

$this->breadcrumbs=array(
	'Provedores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Provedores', 'url'=>array('index')),
	array('label'=>'Create Provedores', 'url'=>array('create')),
	array('label'=>'View Provedores', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Provedores', 'url'=>array('admin')),
);
?>

<h1>Actualizar provedor <?php echo $model->id.' - '.$model->nombre; ?></h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'direccion'=>$direccion,
	'materiales'=>$materiales,
	'tacones'=>$tacones,
	'suelas'=>$suelas,
	)); ?>