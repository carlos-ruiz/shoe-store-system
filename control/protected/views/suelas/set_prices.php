<?php
/* @var $this TaconesController */
/* @var $model Tacones */
?>

<h1>Administración de precios de suelas</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'suelas-precios-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
	        'name'=>'var_suela',
	        'value'=>'$data->suela->nombre',
    	),
    	array(
	        'name'=>'var_color',
	        'value'=>'$data->color->color',
    	),
		array('name'=>'precio_extrachico',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
        ),
		array('name'=>'precio_chico',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
        ),
		array('name'=>'precio_mediano',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
        ),
		array('name'=>'precio_grande',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
        ),
		array(
			'class'=>'CButtonColumn',
			'buttons'=>array(
			   'view'=>array(
			        'visible'=>'false'
				),
			   'update'=>array(
			        'visible'=>'false'
				)
			)
		),
	),
)); ?>

<script type="text/javascript">
$(document).on("blur",".edit-cell", function(){
	var field = $(this);
	id = $(this).parent().attr('editable_id');
	precio = $(this).attr('value');
	if(!/^([0-9]*(\.[0-9]+)?)$/.test(precio)){
		alert('Debe escribir un valor numerico');
		return;
	}
	precio = parseFloat(precio);
	if (isNaN(precio) || precio <= 0) {
		return;
	}
	
	tipo_precio = $(this).parent().attr('editable_name');
	$.post(
		"<?php echo $this->createUrl('suelas/actualizarPrecios/');?>",
		{
			id:id,
			precio:precio,
			tipo_precio:tipo_precio
		},
		function(data){
			field.val(data);
		}
	);
});
</script>
