<?php
/* @var $this ZapatosController */
/* @var $model Zapatos */

$this->breadcrumbs=array(
	'Zapatoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Zapatos', 'url'=>array('index')),
	array('label'=>'Create Zapatos', 'url'=>array('create')),
	array('label'=>'View Zapatos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Zapatos', 'url'=>array('admin')),
);
?>

<h1>Update Zapatos <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>