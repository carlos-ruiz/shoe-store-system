<?php
/* @var $this TipoClienteController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tipo Clientes',
);

$this->menu=array(
	array('label'=>'Create TipoCliente', 'url'=>array('create')),
	array('label'=>'Manage TipoCliente', 'url'=>array('admin')),
);
?>

<h1>Tipo Clientes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
