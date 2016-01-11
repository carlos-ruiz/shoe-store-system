<?php
/* @var $this EstatusPedidosController */
/* @var $model EstatusPedidos */

$this->breadcrumbs=array(
	'Estatus Pedidoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EstatusPedidos', 'url'=>array('index')),
	array('label'=>'Create EstatusPedidos', 'url'=>array('create')),
	array('label'=>'Update EstatusPedidos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EstatusPedidos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EstatusPedidos', 'url'=>array('admin')),
);
?>

<h1>Estatus de pedido #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
