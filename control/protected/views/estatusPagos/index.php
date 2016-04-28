<?php
/* @var $this EstatusPagosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Estatus Pagoses',
);

$this->menu=array(
	array('label'=>'Create EstatusPagos', 'url'=>array('create')),
	array('label'=>'Manage EstatusPagos', 'url'=>array('admin')),
);
?>

<h1>Estatus Pagoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
