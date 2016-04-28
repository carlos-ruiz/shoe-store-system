<?php
/* @var $this SuelasController */
/* @var $model Suelas */

$this->breadcrumbs=array(
	'Suelases'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Suelas', 'url'=>array('index')),
	array('label'=>'Create Suelas', 'url'=>array('create')),
);
?>

<h1>Administración de suelas</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-usd"></i> Definir precios', array('suelas/definirPrecios'), array('class'=>'btn btn-red-stripped')); ?>
	<?php echo CHtml::link('<i class="fa fa-cubes"></i> Agregar a inventario', array('suelas/agregarInventario'), array('class'=>'btn btn-red-stripped')); ?>
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nueva', array('suelas/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'suelas-grid',
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
