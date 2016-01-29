<?php
/* @var $this InventariosController */
/* @var $model Inventarios */
?>

<h1>Inventario</h1>

<!-- <div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Nuevo registro', array('inventarios/create'), array('class'=>'btn btn-red-stripped')); ?>
</div> -->

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
    	'numero',
    	array(
	        'name'=>'var_color',
	        'value'=>'isset($data->color)?$data->color->color:\'N/A\'',
    	),
    	array(
	        'name'=>'cantidad_existente',
	        'cssClassExpression'=> '(($data->cantidad_existente < $data->stock_minimo) ? "red" : "green")',
    	),
    	'cantidad_apartada',
    	'stock_minimo',
    	'unidad_medida',
    	'ultimo_precio',
		// array(
		// 	'class'=>'CButtonColumn',
		// ),
	),
)); ?>
