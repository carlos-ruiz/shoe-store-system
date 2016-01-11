<?php
/* @var $this FormasPagoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Formas Pagos',
);

$this->menu=array(
	array('label'=>'Create FormasPago', 'url'=>array('create')),
	array('label'=>'Manage FormasPago', 'url'=>array('admin')),
);
?>

<h1>Formas Pagos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
