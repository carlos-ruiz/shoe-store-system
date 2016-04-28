<?php
/* @var $this EstatusZapatosController */
/* @var $model EstatusZapatos */

$this->breadcrumbs=array(
	'Estatus Zapatoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EstatusZapatos', 'url'=>array('index')),
	array('label'=>'Create EstatusZapatos', 'url'=>array('create')),
	array('label'=>'Update EstatusZapatos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EstatusZapatos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EstatusZapatos', 'url'=>array('admin')),
);
?>

<h1>Estatus de zapatos #<?php echo $model->id.' - '.$model->nombre; ?></h1>

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
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar estatus', array('estatuszapatos/create'), array('class'=>'link-button')); ?>
		</div>
	</div>
<?php } ?>
