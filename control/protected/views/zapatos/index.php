<?php
/* @var $this ZapatosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Zapatoses',
);

$this->menu=array(
	array('label'=>'Create Zapatos', 'url'=>array('create')),
	array('label'=>'Manage Zapatos', 'url'=>array('admin')),
);
?>

<h1>Zapatoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
