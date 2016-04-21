<?php
/* @var $this ProvedoresController */
/* @var $model Provedores */

$this->breadcrumbs=array(
	'Provedores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Provedores', 'url'=>array('index')),
	array('label'=>'Create Provedores', 'url'=>array('create')),
	array('label'=>'Update Provedores', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Provedores', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Provedores', 'url'=>array('admin')),
);
?>

<h1>Proveedor #<?php echo $model->id.': '.$model->nombre; ?></h1>
<hr/>

<section class="proveedor-informacion">
	<div class="row col-md-12">
		<h4>Información general</h4>
		<hr/>
	</div>
	<div class="row">
		<div class="col-md-4">
			<p>Nombre: <?= $model->nombre ?></p>
		</div>
		<div class="col-md-4">
			<p>Teléfono: <?= $model->telefono ?></p>
		</div>
		<div class="col-md-4">
			<p>Correo electrónico: <?= $model->correo_electronico ?></p>
		</div>
	</div>
</section>

<section class="proveedor-direccion-view">
	<div class="row col-md-12">
		<h4>Dirección</h4>
		<hr/>
	</div>
	<div class="row">
		<div class="col-md-4">
			<p>Calle: <?= $model->direccion->calle ?></p>
		</div>
		<div class="col-md-4">
			<p>Número: <?= $model->direccion->numero_ext.($model->direccion->numero_int != null ? ' INT '.$model->direccion->numero_int : '') ?></p>
		</div>
		<div class="col-md-4">
			<p>Colonia: <?= $model->direccion->colonia ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<p>Ciudad: <?= $model->direccion->ciudad ?></p>
		</div>
		<div class="col-md-4">
			<p>Código postal: <?= $model->direccion->codigo_postal ?></p>
		</div>
		<div class="col-md-4">
			<p>País: <?= $model->direccion->pais ?></p>
		</div>
	</div>
</section>

<section class="proveedor-materiales">
	<div class="row col-md-12">
		<h4>Materiales que provee</h4>
		<hr/>
	</div>
	
	<div class="col-md-4">
		<h5>Suelas</h5>
		<hr/>
		<?php foreach ($suelas as $suela) { ?>
		<div class="form-group col-md-6">
			<p><?= $suela->nombre ?></p><br/>
		</div>
		<?php } ?>
	</div>
	<div class="col-md-4">
		<h5>Tacones</h5>
		<hr/>
		<?php foreach ($tacones as $tacon) { ?>
			<div class="form-group col-md-6">
				<p><?= $tacon->nombre ?></p><br/>
			</div>
		<?php } ?>
	</div>
	<div class="col-md-4">
		<h5>Materiales</h5>
		<hr/>
		<?php foreach ($materiales as $material) { ?>
			<div class="form-group col-md-6">
				<p><?= $material->nombre ?></p><br/>
			</div>
		<?php } ?>
	</div>
</section>