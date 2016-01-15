<?php
/* @var $this ZapatoPreciosController */
/* @var $model ZapatoPrecios */

$this->breadcrumbs=array(
	'Zapato Precioses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ZapatoPrecios', 'url'=>array('index')),
	array('label'=>'Create ZapatoPrecios', 'url'=>array('create')),
);
?>

<h1>Administración de precios por modelo y suela</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'zapato-precios-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
	        'name'=>'var_modelo',
	        'value'=>'$data->modelo->nombre',
    	),
    	array(
	        'name'=>'var_suela',
	        'value'=>'$data->suela->nombre',
    	),
		array('name'=>'precio_extrachico',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
            'action'=>array('/zapatos/actualizarPrecio'),
        ),
		array('name'=>'precio_chico',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
            'action'=>array('/zapatos/actualizarPrecio'),
        ),
		array('name'=>'precio_mediano',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
            'action'=>array('/zapatos/actualizarPrecio'),
        ),
		array('name'=>'precio_grande',
            'class'=>'EEditableColumn', 'editable_type'=>'editbox',
            'action'=>array('/zapatos/actualizarPrecio'),
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
	precio = parseFloat($(this).attr('value'));
	if(isNaN(precio)){
		alert('Debe escribir un valor numerico');
		return;
	}
	tipo_precio = $(this).parent().attr('editable_name');
	$.post(
		"<?php echo $this->createUrl('zapatoprecios/actualizarPrecios/');?>",
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
