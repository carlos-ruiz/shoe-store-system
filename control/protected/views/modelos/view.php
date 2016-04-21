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

<div class="row">
	<div class="col-md-4">
		<h1>Modelo #<?php echo $model->id.' - '.$model->nombre; ?></h1>
	</div>
	<div class="col-md-6">
		<a href="<?= $model->imagen; ?>"><img class="col-md-3 imagen-modelo" src="<?php echo $model->imagen;?>" width="100" /></a>
	</div>
</div>
<div class="modelo-informacion row">
	<div class="col-md-3">
		<h3>Suelas</h3>
		<ul>
			<?php foreach ($model->modelosSuelas as $suela) { ?>
				<li><?= $suela->suela->nombre; ?></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-3">
		<h3>Colores</h3>
		<ul>
			<?php foreach ($model->modelosColores as $color) { ?>
				<li><?= $color->color->color; ?></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-3">
		<h3>Números</h3>
		<!-- <ul> -->
			<?php foreach ($model->modelosNumeros as $numero) { ?>
				<div class="col-md-4"><?= $numero->numero; ?></div>
			<?php } ?>
		<!-- </ul> -->
	</div>
	<div class="col-md-3">
		<h3>Materiales</h3>
		<ul>
			<?php foreach ($model->modelosMateriales as $material) { ?>
				<li><?= $material->material->nombre.' ('.$material->material->unidad_medida.')' ?>
					<ul>
						<li>Extrachico: <?= $material->cantidad_extrachico.' '.$material->unidad_medida ?></li>
						<li>Chico: <?= $material->cantidad_chico.' '.$material->unidad_medida ?></li>
						<li>Mediano: <?= $material->cantidad_mediano.' '.$material->unidad_medida ?></li>
						<li>Grande: <?= $material->cantidad_grande.' '.$material->unidad_medida ?></li>
					</ul>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>

<?php if(!Yii::app()->user->isGuest) { ?>
		<div class="row">
			<div class="col-md-12 padding-top">
				<?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar modelo', array('modelos/create'), array('class'=>'link-button')); ?>
			</div>
		</div>
<?php } ?>
