<?php
/* @var $this ColoresController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Colores',
);

$this->menu=array(
	array('label'=>'Create Colores', 'url'=>array('create')),
	array('label'=>'Manage Colores', 'url'=>array('admin')),
);
?>

<h1>Colores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
