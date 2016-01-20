<?php
/* @var $this ModelosController */
/* @var $model Modelos */

$this->breadcrumbs=array(
	'Modeloses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Modelos', 'url'=>array('index')),
	array('label'=>'Create Modelos', 'url'=>array('create')),
	array('label'=>'View Modelos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Modelos', 'url'=>array('admin')),
);
?>

<h1>Actualizar modelo: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model, 
	'colores'=>$colores, 
	'suelas'=>$suelas,
	'materiales'=>$materiales,
	'mensaje_error'=>$mensaje_error,
	)); ?>