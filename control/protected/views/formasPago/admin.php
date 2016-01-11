<?php
/* @var $this FormasPagoController */
/* @var $model FormasPago */

$this->breadcrumbs=array(
	'Formas Pagos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FormasPago', 'url'=>array('index')),
	array('label'=>'Create FormasPago', 'url'=>array('create')),
);
?>

<h1>Administración de formas de pago</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nueva', array('formasPago/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'formas-pago-grid',
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
