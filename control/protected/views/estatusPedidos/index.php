<?php
/* @var $this EstatusPedidosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Estatus Pedidoses',
);

$this->menu=array(
	array('label'=>'Create EstatusPedidos', 'url'=>array('create')),
	array('label'=>'Manage EstatusPedidos', 'url'=>array('admin')),
);
?>

<h1>Estatus Pedidoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
