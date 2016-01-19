<?php
/* @var $this MaterialesController */
/* @var $model Materiales */

$this->breadcrumbs=array(
	'Materiales'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Materiales', 'url'=>array('index')),
	array('label'=>'Create Materiales', 'url'=>array('create')),
	array('label'=>'View Materiales', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Materiales', 'url'=>array('admin')),
);
?>

<h1>Actualizar material: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', 
	array(
		'model'=>$model,
		'colores'=>$colores,
		)); ?>