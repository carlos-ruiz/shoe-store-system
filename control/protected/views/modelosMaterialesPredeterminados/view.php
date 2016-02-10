<?php
/* @var $this ModelosMaterialesPredeterminadosController */
/* @var $model ModelosMaterialesPredeterminados */

$this->breadcrumbs=array(
	'Modelos Materiales Predeterminadoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ModelosMaterialesPredeterminados', 'url'=>array('index')),
	array('label'=>'Create ModelosMaterialesPredeterminados', 'url'=>array('create')),
	array('label'=>'Update ModelosMaterialesPredeterminados', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ModelosMaterialesPredeterminados', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ModelosMaterialesPredeterminados', 'url'=>array('admin')),
);
?>

<h1>Materiales predeterminados para el modelo: <?php echo $model->modeloColor->modelo->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_modelos_colores',
		'id_suelas_colores',
		'id_tacones_colores',
		'id_ojillos_colores',
		'id_agujetas_colores',
	),
)); ?>
