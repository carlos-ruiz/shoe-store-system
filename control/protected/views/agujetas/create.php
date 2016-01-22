<?php
/* @var $this AgujetasController */
/* @var $model Agujetas */

$this->breadcrumbs=array(
	'Agujetases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Agujetas', 'url'=>array('index')),
	array('label'=>'Manage Agujetas', 'url'=>array('admin')),
);
?>

<h1>Nuevas agujetas</h1>

<?php $this->renderPartial('_form', 
	array(
		'model'=>$model,
		'colores'=>$colores,
		'mensaje_error'=>$mensaje_error,
	)
); ?>