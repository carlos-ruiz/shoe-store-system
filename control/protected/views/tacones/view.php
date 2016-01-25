<?php
/* @var $this TaconesController */
/* @var $model Tacones */

$this->breadcrumbs=array(
	'Tacones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Tacones', 'url'=>array('index')),
	array('label'=>'Create Tacones', 'url'=>array('create')),
	array('label'=>'Update Tacones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tacones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tacones', 'url'=>array('admin')),
);
?>

<h1>Tacón #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<div class="row">
	<div class="col-md-4">
		<h3>Colores</h3>
		<ul>
			<?php foreach ($model->taconesColores as $taconColor) { ?>
				<li><?= $taconColor->color->color ?></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-4">
		<h3>Números</h3>
		<ul>
			<?php foreach ($model->taconesNumeros as $taconNumero) { ?>
				<li><?= $taconNumero->numero ?></li>
			<?php } ?>
		</ul>
	</div>
</div>

<?php if(!Yii::app()->user->isGuest) { ?>
	<div class="row">
		<div class="col-md-12 padding-top">
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar tacón', array('tacones/create'), array('class'=>'link-button')); ?>
		</div>
	</div>
<?php } ?>
