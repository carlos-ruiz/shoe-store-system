<?php
/* @var $this ModelosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Modeloses',
);

$this->menu=array(
	array('label'=>'Create Modelos', 'url'=>array('create')),
	array('label'=>'Manage Modelos', 'url'=>array('admin')),
);
?>

<h1>Modeloses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
