<?php
/* @var $this InventariosController */
/* @var $model Inventarios */
?>

<div class="row">
	<div class="col-md-4">
		<h1>Inventarios</h1>
	</div>
	<div class="col-md-8 text-right">
		<div class="inline-block">
			<h5>Agregar al inventario</h5>
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Suelas', array('suelas/agregarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Tacones', array('tacones/agregarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Agujetas y ojillos', array('agujetas/agregarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Materiales', array('inventarios/agregarMaterial'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-minus"></i> Descontar', array('#'), array('class'=>'btn btn-red-stripped remove-button')); ?>
		</div>
		<div class="inline-block remove-stock">
			<h5>Dar de baja del inventario</h5>
			<?php echo CHtml::link('<i class="fa fa-minus"></i> Suelas', array('suelas/descontarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-minus"></i> Tacones', array('tacones/descontarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-minus"></i> Agujetas y ojillos', array('agujetas/descontarInventario'), array('class'=>'btn btn-red-stripped')); ?>
			<?php echo CHtml::link('<i class="fa fa-minus"></i> Materiales', array('inventarios/descontarMaterial'), array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>
</div>
<br/>
<hr/>

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
	        'cssClassExpression'=> '(($data->cantidad_existente < ($data->cantidad_apartada + $data->stock_minimo)) ? "under-stock" : "")',
    	),
    	'cantidad_apartada',
    	'stock_minimo',
    	array(
	        'name'=>'var_compra_minima',
	        'value'=>'$data->cantidad_existente - $data->cantidad_apartada',
	        'cssClassExpression'=> '(($data->cantidad_existente - $data->cantidad_apartada<0) ? "under-stock" : "")',
    	),
    	array(
	        'name'=>'var_total',
	        'value'=>'$data->cantidad_existente - ($data->cantidad_apartada + $data->stock_minimo)',
	        'cssClassExpression'=> '(($data->cantidad_existente - ($data->cantidad_apartada + $data->stock_minimo)<0) ? "under-stock" : "")',
    	),
    	'unidad_medida',
    	'ultimo_precio',
		// array(
		// 	'class'=>'CButtonColumn',
		// ),
	),
)); ?>

<script type="text/javascript">
	$('.remove-button').click(function(){
		$('.remove-stock').toggle();
		return false;
	});
</script>
