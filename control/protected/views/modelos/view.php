<?php
/* @var $this ModelosController */
/* @var $model Modelos */

$this->breadcrumbs=array(
	'Modeloses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Modelos', 'url'=>array('index')),
	array('label'=>'Create Modelos', 'url'=>array('create')),
	array('label'=>'Update Modelos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Modelos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Modelos', 'url'=>array('admin')),
);
?>

<h1>Modelo #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<div class="modelo-informacion row">
	<div class="col-md-3">
		<h3>Suelas</h3>
		<ul>
			<?php foreach ($suelas as $suela) { ?>
				<li><?= $suela->suela->nombre; ?></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-3">
		<h3>Colores</h3>
		<ul>
			<?php foreach ($colores as $color) { ?>
				<li><?= $color->color->color; ?></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-3">
		<h3>Números</h3>
		<ul>
			<?php foreach ($numeros as $numero) { ?>
				<li><?= $numero->numero; ?></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-3">
		<h3>Materiales</h3>
		<ul>
			<?php foreach ($materiales as $material) { ?>
				<li><?= $material->material->nombre.': '.$material->cantidad.' '.$material->unidad_medida; ?></li>
			<?php } ?>
		</ul>
	</div>
</div>
<div class="row">
	<a href="<?= $model->imagen; ?>"><img class="col-md-4 imagen-modelo" src="<?php echo $model->imagen;?>" /></a>
</div>
