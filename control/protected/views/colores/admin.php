<?php
/* @var $this ColoresController */
/* @var $model Colores */

$this->breadcrumbs=array(
	'Colores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Colores', 'url'=>array('index')),
	array('label'=>'Create Colores', 'url'=>array('create')),
);
?>

<h1>Administración de colores</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo', array('colores/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'colores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'color',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}{update}{desactivar}',
			'buttons'=>array(
		        'activar' => array(
		            'label'=>'<span class="fa fa-check"></span>',
		            'imageUrl'=>false,
		            'options'=>array('title'=>'Activar'),
		            'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
		            'visible'=>'$data->activo == 0',
		        ),
		        'desactivar' => array(
		            'label'=>'<span class="fa fa-ban"></span>',
		            'imageUrl'=>false,
		            'options'=>array('title'=>'Desactivar'),
		            'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
		            'visible'=>'$data->activo == 1',
		        ),
			),
		),
	),
)); ?>
