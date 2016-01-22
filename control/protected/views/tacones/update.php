<?php
/* @var $this TaconesController */
/* @var $model Tacones */

$this->breadcrumbs=array(
	'Tacones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tacones', 'url'=>array('index')),
	array('label'=>'Create Tacones', 'url'=>array('create')),
	array('label'=>'View Tacones', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Tacones', 'url'=>array('admin')),
);
?>

<h1>Update Tacones <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', 
	array(
		'model'=>$model,
		'colores'=>$colores,
	)
); ?>