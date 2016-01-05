<?php
/* @var $this InsumosController */
/* @var $model Insumos */

$this->breadcrumbs=array(
	'Insumoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Insumos', 'url'=>array('index')),
	array('label'=>'Create Insumos', 'url'=>array('create')),
	array('label'=>'Update Insumos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Insumos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Insumos', 'url'=>array('admin')),
);
?>

<h1>Insumo #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'unidad_medida',
		'cantidad',
	),
)); ?>
