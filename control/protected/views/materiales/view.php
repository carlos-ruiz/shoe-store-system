<?php
/* @var $this MaterialesController */
/* @var $model Materiales */

$this->breadcrumbs=array(
	'Materiales'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Materiales', 'url'=>array('index')),
	array('label'=>'Create Materiales', 'url'=>array('create')),
	array('label'=>'Update Materiales', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Materiales', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Materiales', 'url'=>array('admin')),
);
?>

<h1>Material #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<div class="row">
	<div class="col-md-6">
	<h3>General</h3>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'nombre',
				'unidad_medida',
			),
		)); ?>
	</div>
	<div class="col-md-4">
		<h3>Colores</h3>
		<ul>
			<?php foreach ($model->colores as $materialColor) { ?>
				<li><?= $materialColor->color->color ?></li>
			<?php } ?>
		</ul>
	</div>
</div>

<?php if(!Yii::app()->user->isGuest) { ?>
	<div class="row">
		<div class="col-md-12 padding-top">
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar material', array('materiales/create'), array('class'=>'link-button')); ?>
		</div>
	</div>
<?php } ?>