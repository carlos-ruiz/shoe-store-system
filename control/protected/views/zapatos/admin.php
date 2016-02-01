<?php
/* @var $this ZapatosController */
/* @var $model Zapatos */

$this->breadcrumbs=array(
	'Zapatoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Zapatos', 'url'=>array('index')),
	array('label'=>'Create Zapatos', 'url'=>array('create')),
);
?>

<h1>Administración de precios</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Ver agrupados', array('zapatoprecios/admin'), array('class'=>'btn btn-red-stripped')); ?>
	<?php echo CHtml::link('<i class="fa fa-plus"></i> Definir nuevo precio', array('zapatos/create'), array('class'=>'btn btn-red-stripped')); ?>
</div>

<?php
$grid_id = 'zapatos-grid';
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>$grid_id,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
	        'name'=>'var_modelo',
	        'value'=>'$data->modelo->nombre',
    	),
    	array(
	        'name'=>'var_color',
	        'value'=>'$data->color->color',
    	),
		array(
	        'name'=>'var_suela',
	        'value'=>'$data->suelaColor->suela->nombre',
    	),
		array(
	        'name'=>'var_color_suela',
	        'value'=>'$data->suelaColor->color->color',
    	),
		'numero',
		array('name'=>'precio',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
            'action'=>array('/zapatos/actualizarPrecio'),
        ),
		// array(
	 //        'name'=>'precio',
	 //        'value'=>'\'$\'.$data->precio',
  //   	),
		'codigo_barras',
		array(
			'class'=>'CButtonColumn',
			'buttons'=>array(
				'view'=>array(
					'visible'=>'false',
				),
				'update'=>array(
					'visible'=>'false',
				)
			)
		),
	),
)); ?>
<script type="text/javascript">
$(document).on("blur",".edit-cell", function(){
	var field = $(this);
	id = $(this).parent().attr('editable_id');
	precio = parseFloat($(this).attr('value'));
	if(isNaN(precio)){
		alert('Debe escribir un valor numerico');
		return;
	}
	$.post(
		"<?php echo $this->createUrl('zapatos/actualizarPrecio/');?>",
		{
			id_zapato:id,
			precio:precio
		},
		function(data){
			field.val(data);
		}
	);
});
</script>