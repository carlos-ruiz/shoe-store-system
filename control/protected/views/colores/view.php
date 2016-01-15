<?php
/* @var $this ColoresController */
/* @var $model Colores */

$this->breadcrumbs=array(
	'Colores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Colores', 'url'=>array('index')),
	array('label'=>'Create Colores', 'url'=>array('create')),
	array('label'=>'Update Colores', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Colores', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Colores', 'url'=>array('admin')),
);
?>

<h1>Color #<?php echo $model->id.' - '.$model->color; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'color',
	),
)); ?>

<?php if(!Yii::app()->user->isGuest) { ?>
		<div class="row">
			<div class="col-md-12 padding-top">
				<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar color', array('colores/create'), array('class'=>'link-button')); ?>
			</div>
		</div>
<?php } ?>
