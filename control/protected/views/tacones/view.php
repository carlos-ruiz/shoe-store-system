<?php
/* @var $this TaconesController */
/* @var $model Tacones */

$this->breadcrumbs=array(
	'Tacones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Tacones', 'url'=>array('index')),
	array('label'=>'Create Tacones', 'url'=>array('create')),
	array('label'=>'Update Tacones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tacones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tacones', 'url'=>array('admin')),
);
?>

<h1>Tacon #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
