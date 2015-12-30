<?php
/* @var $this ColoresController */
/* @var $model Colores */

$this->breadcrumbs=array(
	'Colores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Colores', 'url'=>array('index')),
	array('label'=>'Create Colores', 'url'=>array('create')),
	array('label'=>'Update Colores', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Colores', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Colores', 'url'=>array('admin')),
);
?>

<h1>Color #<?php echo $model->id.' - '.$model->color; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'color',
	),
)); ?>
