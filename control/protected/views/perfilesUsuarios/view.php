<?php
/* @var $this PerfilesUsuariosController */
/* @var $model PerfilesUsuarios */

$this->breadcrumbs=array(
	'Perfiles Usuarioses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PerfilesUsuarios', 'url'=>array('index')),
	array('label'=>'Create PerfilesUsuarios', 'url'=>array('create')),
	array('label'=>'Update PerfilesUsuarios', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PerfilesUsuarios', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PerfilesUsuarios', 'url'=>array('admin')),
);
?>

<h1>Perfil de usuario #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
