<?php
/* @var $this ClientesController */
/* @var $model Clientes */

$this->breadcrumbs=array(
	'Clientes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Clientes', 'url'=>array('index')),
	array('label'=>'Create Clientes', 'url'=>array('create')),
	array('label'=>'Update Clientes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Clientes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Clientes', 'url'=>array('admin')),
);
?>

<h1>Cliente #<?php echo $model->id.' - '.$model->nombre.' '.$model->apellido_paterno; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'apellido_paterno',
		'apellido_materno',
		'rfc',
		'razon_social',
		'descuento',
		array(
	        'name'=>'Calle',
	        'value'=>$model->direccion->calle.' #'.$model->direccion->numero_ext.((isset($model->direccion->numero_int) && strlen($model->direccion->numero_int)>0)?(' INT '.$model->direccion->numero_int):''),
    	),
    	array(
	        'name'=>'Colonia',
	        'value'=>$model->direccion->colonia,
    	),
    	array(
	        'name'=>'Ciudad',
	        'value'=>$model->direccion->ciudad,
    	),
    	array(
	        'name'=>'C&oacute;digo postal',
	        'value'=>$model->direccion->codigo_postal,
    	),
    	array(
	        'name'=>'Pa&iacute;s',
	        'value'=>$model->direccion->pais,
    	),
		'telefono',
		'celular',
		'correo_electronico',
	),
)); ?>
