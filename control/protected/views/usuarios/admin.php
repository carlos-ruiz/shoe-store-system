<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */

$this->breadcrumbs=array(
	'Usuarioses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Usuarios', 'url'=>array('index')),
	array('label'=>'Create Usuarios', 'url'=>array('create')),
);
?>

<h1>Administración de usuarios</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('usuarios/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usuarios-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'usuario',
		array(
			'name'=>'contrasenia',
			'value'=>'base64_decode($data->contrasenia)',
			),
		'creacion',
		'ultima_modificacion',
		array(
			'name' => 'var_perfil',
			'value'=> '$data->perfil->nombre',
			),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
