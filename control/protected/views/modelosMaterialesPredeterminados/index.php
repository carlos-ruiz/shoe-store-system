<?php
/* @var $this ModelosMaterialesPredeterminadosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Modelos Materiales Predeterminadoses',
);

$this->menu=array(
	array('label'=>'Create ModelosMaterialesPredeterminados', 'url'=>array('create')),
	array('label'=>'Manage ModelosMaterialesPredeterminados', 'url'=>array('admin')),
);
?>

<h1>Modelos Materiales Predeterminadoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
