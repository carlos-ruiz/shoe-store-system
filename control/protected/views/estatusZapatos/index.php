<?php
/* @var $this EstatusZapatosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Estatus Zapatoses',
);

$this->menu=array(
	array('label'=>'Create EstatusZapatos', 'url'=>array('create')),
	array('label'=>'Manage EstatusZapatos', 'url'=>array('admin')),
);
?>

<h1>Estatus Zapatoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
