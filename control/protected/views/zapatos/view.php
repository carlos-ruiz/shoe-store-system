<?php
/* @var $this ZapatosController */
/* @var $model Zapatos */

$this->breadcrumbs=array(
	'Zapatoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Zapatos', 'url'=>array('index')),
	array('label'=>'Create Zapatos', 'url'=>array('create')),
	array('label'=>'Update Zapatos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Zapatos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Zapatos', 'url'=>array('admin')),
);
?>

<h1>Configuración de precios #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
	        'name'=>'Modelo',
	        'value'=>$model->modeloColor->modelo->nombre,
    	),
    	array(
	        'name'=>'Color',
	        'value'=>$model->modeloColor->color->color,
    	),
		array(
	        'name'=>'id_suelas',
	        'value'=>$model->suela->nombre,
    	),
		'numero',
		'precio',
		'codigo_barras',
	),
)); ?>
