<?php
/* @var $this SuelasController */
/* @var $model Suelas */

$this->breadcrumbs=array(
	'Suelases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Suelas', 'url'=>array('index')),
	array('label'=>'Create Suelas', 'url'=>array('create')),
	array('label'=>'Update Suelas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Suelas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Suelas', 'url'=>array('admin')),
);
?>

<h1>Suela #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>

<?php if(!Yii::app()->user->isGuest) { ?>
	<div class="row">
		<div class="col-md-12 padding-top">
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar suela', array('suelas/create'), array('class'=>'link-button')); ?>
		</div>
	</div>
<?php } ?>