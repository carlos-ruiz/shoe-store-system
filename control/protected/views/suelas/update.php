<?php
/* @var $this SuelasController */
/* @var $model Suelas */

$this->breadcrumbs=array(
	'Suelases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Suelas', 'url'=>array('index')),
	array('label'=>'Create Suelas', 'url'=>array('create')),
	array('label'=>'View Suelas', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Suelas', 'url'=>array('admin')),
);
?>

<h1>Actualizar suela: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', 
		array(
			'model'=>$model,
			'colores'=>$colores,
			'mensaje_error'=>$mensaje_error,
		)
	); ?>