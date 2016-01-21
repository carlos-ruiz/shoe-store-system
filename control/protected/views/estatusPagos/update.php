<?php
/* @var $this EstatusPagosController */
/* @var $model EstatusPagos */

$this->breadcrumbs=array(
	'Estatus Pagoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EstatusPagos', 'url'=>array('index')),
	array('label'=>'Create EstatusPagos', 'url'=>array('create')),
	array('label'=>'View EstatusPagos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EstatusPagos', 'url'=>array('admin')),
);
?>

<h1>Update EstatusPagos <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>