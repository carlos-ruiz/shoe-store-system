<?php
/* @var $this EstatusPagosController */
/* @var $model EstatusPagos */

$this->breadcrumbs=array(
	'Estatus Pagoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EstatusPagos', 'url'=>array('index')),
	array('label'=>'Create EstatusPagos', 'url'=>array('create')),
	array('label'=>'Update EstatusPagos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EstatusPagos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EstatusPagos', 'url'=>array('admin')),
);
?>

<h1>Estatus de pago #<?php echo $model->id.' - '.$model->nombre; ?></h1>

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
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar estatus', array('estatuspagos/create'), array('class'=>'link-button')); ?>
		</div>
	</div>
<?php } ?>
