<?php
/* @var $this ModelosMaterialesPredeterminadosController */
/* @var $model ModelosMaterialesPredeterminados */

$this->breadcrumbs=array(
	'Modelos Materiales Predeterminadoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ModelosMaterialesPredeterminados', 'url'=>array('index')),
	array('label'=>'Create ModelosMaterialesPredeterminados', 'url'=>array('create')),
);
?>

<h1>Materiales que lleva cada modelo normalmente</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('modelosmaterialespredeterminados/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'modelos-materiales-predeterminados-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
	        'name'=>'var_modelos',
	        'value'=>'$data->modeloColor->modelo->nombre',
    	),
		array(
	        'name'=>'var_color_modelo',
	        'value'=>'$data->modeloColor->color->color',
    	),
		array(
	        'name'=>'var_suelas',
	        'value'=>'$data->suelaColor->suela->nombre',
    	),
		array(
	        'name'=>'var_color_suela',
	        'value'=>'$data->suelaColor->color->color',
    	),
    	array(
	        'name'=>'var_tacones',
	        'value'=>'isset($data->taconColor)?$data->taconColor->tacon->nombre:\'N/A\'',
    	),
    	array(
	        'name'=>'var_color_tacon',
	        'value'=>'isset($data->taconColor)?$data->taconColor->color->color:\'N/A\'',
    	),
    	array(
	        'name'=>'var_agujetas',
	        'value'=>'isset($data->agujetaColor)?$data->agujetaColor->agujeta->nombre:\'N/A\'',
    	),
    	array(
	        'name'=>'var_color_agujetas',
	        'value'=>'isset($data->agujetaColor)?$data->agujetaColor->color->color:\'N/A\'',
    	),
    	array(
	        'name'=>'var_ojillos',
	        'value'=>'isset($data->ojillosColor)?$data->ojillosColor->ojillo->nombre:\'N/A\'',
    	),
    	array(
	        'name'=>'var_color_ojillos',
	        'value'=>'isset($data->ojillosColor)?$data->ojillosColor->color->color:\'N/A\'',
    	),
		array(
			'class'=>'CButtonColumn',
			'buttons'=>array(
				'view'=>array(
					'visible'=>'false',
				),
			)
		),
	),
)); ?>
