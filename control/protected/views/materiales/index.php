<?php
/* @var $this MaterialesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Materiales',
);

$this->menu=array(
	array('label'=>'Create Materiales', 'url'=>array('create')),
	array('label'=>'Manage Materiales', 'url'=>array('admin')),
);
?>

<h1>Materiales</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
