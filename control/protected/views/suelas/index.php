<?php
/* @var $this SuelasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Suelases',
);

$this->menu=array(
	array('label'=>'Create Suelas', 'url'=>array('create')),
	array('label'=>'Manage Suelas', 'url'=>array('admin')),
);
?>

<h1>Suelases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
