<?php
/* @var $this PerfilesUsuariosController */
/* @var $model PerfilesUsuarios */

$this->breadcrumbs=array(
	'Perfiles Usuarioses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PerfilesUsuarios', 'url'=>array('index')),
	array('label'=>'Manage PerfilesUsuarios', 'url'=>array('admin')),
);
?>

<h1>Create PerfilesUsuarios</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>