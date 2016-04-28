<?php
/* @var $this ProvedoresController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Provedores',
);

$this->menu=array(
	array('label'=>'Create Provedores', 'url'=>array('create')),
	array('label'=>'Manage Provedores', 'url'=>array('admin')),
);
?>

<h1>Provedores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
