<?php
/* @var $this OjillosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ojilloses',
);

$this->menu=array(
	array('label'=>'Create Ojillos', 'url'=>array('create')),
	array('label'=>'Manage Ojillos', 'url'=>array('admin')),
);
?>

<h1>Ojilloses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
