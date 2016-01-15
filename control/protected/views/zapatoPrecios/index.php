<?php
/* @var $this ZapatoPreciosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Zapato Precioses',
);

$this->menu=array(
	array('label'=>'Create ZapatoPrecios', 'url'=>array('create')),
	array('label'=>'Manage ZapatoPrecios', 'url'=>array('admin')),
);
?>

<h1>Zapato Precioses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
