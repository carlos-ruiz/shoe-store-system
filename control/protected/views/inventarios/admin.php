<?php
/* @var $this InventariosController */
/* @var $model Inventarios */
?>

<div class="row">
	<div class="col-md-6">
		<h1>Inventarios</h1>
	</div>
	<div class="col-md-6 text-right">
		<div class="inline-block">
			<h5>Agregar al inventario</h5>
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Suelas', array('suelas/agregarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Tacones', array('tacones/agregarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agujetas y ojillos', array('agujetas/agregarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Materiales', array('inventarios/agregarMaterial'), array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>
</div>
<br/>
<hr/>

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
	        'cssClassExpression'=> '(($data->cantidad_existente < $data->stock_minimo) ? "under-stock" : "")',
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
