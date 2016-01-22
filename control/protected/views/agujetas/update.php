<?php
/* @var $this AgujetasController */
/* @var $model Agujetas */

$this->breadcrumbs=array(
	'Agujetases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Agujetas', 'url'=>array('index')),
	array('label'=>'Create Agujetas', 'url'=>array('create')),
	array('label'=>'View Agujetas', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Agujetas', 'url'=>array('admin')),
);
?>

<h1>Actualizar agujetas: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', 
	array(
		'model'=>$model,
		'colores'=>$colores,
		'mensaje_error'=>$mensaje_error,
	)
); ?>