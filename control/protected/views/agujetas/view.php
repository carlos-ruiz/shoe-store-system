<?php
/* @var $this AgujetasController */
/* @var $model Agujetas */

$this->breadcrumbs=array(
	'Agujetases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Agujetas', 'url'=>array('index')),
	array('label'=>'Create Agujetas', 'url'=>array('create')),
	array('label'=>'Update Agujetas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Agujetas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Agujetas', 'url'=>array('admin')),
);
?>

<h1>Agujetas #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<div class="col-md-12">
	<div class="col-md-4">
		<h3>Colores disponibles</h3>
		<hr/>
		<ul>
		<?php foreach ($model->agujetasColores as $agujetaColor) { ?>
			<li><?= $agujetaColor->color->color ?></li>
		<?php } ?>
		</ul>
	</div>
	<div class="col-md-4"></div>
</div>

<?php if(!Yii::app()->user->isGuest) { ?>
	<div class="row">
		<div class="col-md-12 padding-top">
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar nueva', array('agujetas/create'), array('class'=>'link-button')); ?>
		</div>
	</div>
<?php } ?>

