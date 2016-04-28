<?php
/* @var $this InsumosController */
/* @var $model Insumos */

$this->breadcrumbs=array(
	'Insumoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Insumos', 'url'=>array('index')),
	array('label'=>'Create Insumos', 'url'=>array('create')),
	array('label'=>'View Insumos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Insumos', 'url'=>array('admin')),
);
?>

<h1>Actualizar insumo: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>