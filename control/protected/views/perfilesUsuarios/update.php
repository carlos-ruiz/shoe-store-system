<?php
/* @var $this PerfilesUsuariosController */
/* @var $model PerfilesUsuarios */

$this->breadcrumbs=array(
	'Perfiles Usuarioses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PerfilesUsuarios', 'url'=>array('index')),
	array('label'=>'Create PerfilesUsuarios', 'url'=>array('create')),
	array('label'=>'View PerfilesUsuarios', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PerfilesUsuarios', 'url'=>array('admin')),
);
?>

<h1>Actualizar perfil de usuario: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>