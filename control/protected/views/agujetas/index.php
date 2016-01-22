<?php
/* @var $this AgujetasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Agujetases',
);

$this->menu=array(
	array('label'=>'Create Agujetas', 'url'=>array('create')),
	array('label'=>'Manage Agujetas', 'url'=>array('admin')),
);
?>

<h1>Agujetases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
