<?php
/* @var $this OjillosController */
/* @var $model Ojillos */

$this->breadcrumbs=array(
	'Ojilloses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ojillos', 'url'=>array('index')),
	array('label'=>'Create Ojillos', 'url'=>array('create')),
	array('label'=>'View Ojillos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Ojillos', 'url'=>array('admin')),
);
?>

<h1>Actualizar ojillo: <?php echo $model->id.' - '.$model->nombre; ?></h1>

<?php $this->renderPartial('_form', 
	array(
	'model'=>$model,
	'colores'=>$colores,
	'mensaje_error'=>$mensaje_error,
	)
); ?>