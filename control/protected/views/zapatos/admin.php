<?php
/* @var $this ZapatosController */
/* @var $model Zapatos */

$this->breadcrumbs=array(
	'Zapatoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Zapatos', 'url'=>array('index')),
	array('label'=>'Create Zapatos', 'url'=>array('create')),
);
?>

<h1>Administración de precios</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Definir nuevo precio', array('zapatos/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'zapatos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
	        'name'=>'id_modelos',
	        'value'=>'$data->modeloColor->modelo->nombre',
    	),
    	array(
	        'name'=>'id_colores',
	        'value'=>'$data->modeloColor->color->color',
    	),
		array(
	        'name'=>'id_suelas',
	        'value'=>'$data->suela->nombre',
    	),
		'numero',
		array(
	        'name'=>'precio',
	        'value'=>'\'$\'.$data->precio',
    	),
		'codigo_barras',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
