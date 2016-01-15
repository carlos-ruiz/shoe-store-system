<?php
/* @var $this ZapatoPreciosController */
/* @var $model ZapatoPrecios */

$this->breadcrumbs=array(
	'Zapato Precioses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ZapatoPrecios', 'url'=>array('index')),
	array('label'=>'Create ZapatoPrecios', 'url'=>array('create')),
	array('label'=>'View ZapatoPrecios', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ZapatoPrecios', 'url'=>array('admin')),
);
?>

<h1>Update ZapatoPrecios <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>