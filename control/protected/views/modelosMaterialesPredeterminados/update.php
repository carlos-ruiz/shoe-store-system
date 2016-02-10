<?php
/* @var $this ModelosMaterialesPredeterminadosController */
/* @var $model ModelosMaterialesPredeterminados */

$this->breadcrumbs=array(
	'Modelos Materiales Predeterminadoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ModelosMaterialesPredeterminados', 'url'=>array('index')),
	array('label'=>'Create ModelosMaterialesPredeterminados', 'url'=>array('create')),
	array('label'=>'View ModelosMaterialesPredeterminados', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ModelosMaterialesPredeterminados', 'url'=>array('admin')),
);
?>

<h1>Actualizar materiales del modelo: <?php echo $model->modeloColor->modelo->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>