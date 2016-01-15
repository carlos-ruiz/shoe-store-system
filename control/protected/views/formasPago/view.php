<?php
/* @var $this FormasPagoController */
/* @var $model FormasPago */

$this->breadcrumbs=array(
	'Formas Pagos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FormasPago', 'url'=>array('index')),
	array('label'=>'Create FormasPago', 'url'=>array('create')),
	array('label'=>'Update FormasPago', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FormasPago', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FormasPago', 'url'=>array('admin')),
);
?>

<h1>Forma de pago #<?php echo $model->id.' - '.$model->nombre; ?></h1>

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
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar forma de pago', array('formaspago/create'), array('class'=>'link-button')); ?>
		</div>
	</div>
<?php } ?>
