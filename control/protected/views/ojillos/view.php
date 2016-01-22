<?php
/* @var $this OjillosController */
/* @var $model Ojillos */

$this->breadcrumbs=array(
	'Ojilloses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Ojillos', 'url'=>array('index')),
	array('label'=>'Create Ojillos', 'url'=>array('create')),
	array('label'=>'Update Ojillos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Ojillos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ojillos', 'url'=>array('admin')),
);
?>

<h1>Ojillo #<?php echo $model->id.' - '.$model->nombre; ?></h1>

<div class="col-md-12">
	<div class="col-md-4">
		<h3>Colores disponibles</h3>
		<hr/>
		<ul>
		<?php foreach ($model->ojillosColores as $ojilloColor) { ?>
			<li><?= $ojilloColor->color->color ?></li>
		<?php } ?>
		</ul>
	</div>
	<div class="col-md-4"></div>
</div>
