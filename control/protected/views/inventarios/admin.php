<?php
/* @var $this InventariosController */
/* @var $model Inventarios */
?>

<h1>Inventario</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo registro', array('inventarios/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'modelos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
    	array(
	        'name'=>'var_tipo_articulo',
	        'value'=>'$data->tipoArticulo->tipo',
    	),
    	'nombre_articulo',
		// array(
	 //        'name'=>'var_articulo',
	 //        'value'=>array($this, 'obtenerArticulo'),
  //   	),
    	'numero',
    	array(
	        'name'=>'var_color',
	        'value'=>'isset($data->color)?$data->color->color:\'N/A\'',
    	),
    	'cantidad_existente',
    	'cantidad_apartada',
    	'unidad_medida',
    	'ultimo_precio',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
