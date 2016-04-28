<?php
/* @var $this PerfilesUsuariosController */
/* @var $model PerfilesUsuarios */

$this->breadcrumbs=array(
	'Perfiles Usuarioses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PerfilesUsuarios', 'url'=>array('index')),
	array('label'=>'Create PerfilesUsuarios', 'url'=>array('create')),
);
?>

<h1>Administración de perfiles de usuario</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('perfilesUsuarios/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'perfiles-usuarios-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
