<?php
/* @var $this ZapatoPreciosController */
/* @var $model ZapatoPrecios */

$this->breadcrumbs=array(
	'Zapato Precioses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ZapatoPrecios', 'url'=>array('index')),
	array('label'=>'Create ZapatoPrecios', 'url'=>array('create')),
	array('label'=>'Update ZapatoPrecios', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ZapatoPrecios', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ZapatoPrecios', 'url'=>array('admin')),
);
?>

<h1>View ZapatoPrecios #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'precio_extrachico',
		'precio_chico',
		'precio_mediano',
		'precio_grande',
		'zapatos_id',
	),
)); ?>
