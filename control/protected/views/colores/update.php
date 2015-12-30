<?php
/* @var $this ColoresController */
/* @var $model Colores */

$this->breadcrumbs=array(
	'Colores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Colores', 'url'=>array('index')),
	array('label'=>'Create Colores', 'url'=>array('create')),
	array('label'=>'View Colores', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Colores', 'url'=>array('admin')),
);
?>

<h1>Actualizar color: <?php echo $model->color; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>