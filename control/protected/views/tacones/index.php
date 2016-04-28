<?php
/* @var $this TaconesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tacones',
);

$this->menu=array(
	array('label'=>'Create Tacones', 'url'=>array('create')),
	array('label'=>'Manage Tacones', 'url'=>array('admin')),
);
?>

<h1>Tacones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
