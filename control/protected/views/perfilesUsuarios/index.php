<?php
/* @var $this PerfilesUsuariosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Perfiles Usuarioses',
);

$this->menu=array(
	array('label'=>'Create PerfilesUsuarios', 'url'=>array('create')),
	array('label'=>'Manage PerfilesUsuarios', 'url'=>array('admin')),
);
?>

<h1>Perfiles Usuarioses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
