<?php
/* @var $this PedidosController */
/* @var $model Pedidos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pedidos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<hr/>
		
		<div class="row">
			<div class="form-group col-md-4 <?php if($form->error($model,'id_clientes')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_clientes', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_clientes', Clientes::model()->obtenerClientes(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
					<?php echo $form->error($model,'id_clientes', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'fecha_pedido')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'fecha_pedido', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'fecha_pedido',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'fecha_pedido', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'fecha_entrega')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'fecha_entrega', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'fecha_entrega',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'data-provide'=>'datepicker')); ?>
					<?php echo $form->error($model,'fecha_entrega', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-4 <?php if($form->error($model,'id_formas_pago')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_formas_pago', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_formas_pago', FormasPago::model()->obtenerFormasPago(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
					<?php echo $form->error($model,'id_formas_pago', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'id_estatus_pedidos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_estatus_pedidos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_estatus_pedidos', EstatusPedidos::model()->obtenerEstatusPedidos(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
					<?php echo $form->error($model,'id_estatus_pedidos', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<hr/>
		<h3>Descripción de pedido</h3>
		<div class="row">
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_modelos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_modelos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptions = array(
							"class" => "form-control",
							"empty"=>"Seleccione una opci&oacute;n",
						);
					?>
					<?php echo $form->dropDownList($pedidoZapato,'id_modelos',Modelos::model()->obtenerModelos(), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'id_modelos', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_colores')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_colores', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($pedidoZapato,'id_colores',Modelos::model()->obtenerColores(isset($pedidoZapato->id_modelos)?$pedidoZapato->id_modelos:0), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'id_colores', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'numero')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'numero', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($pedidoZapato,'numero',Modelos::model()->obtenerNumeros(isset($pedidoZapato->id_modelos)?$pedidoZapato->id_modelos:0), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'numero', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_suelas')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_suelas', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($pedidoZapato,'id_suelas',Modelos::model()->obtenerSuelas(isset($pedidoZapato->id_modelos)?$pedidoZapato->id_modelos:0), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'id_suelas', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'cantidad_total')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'cantidad_total', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($pedidoZapato,'cantidad_total',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
					<?php echo $form->error($pedidoZapato,'cantidad_total', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				<div class="btn btn-red-stripped" id="boton_agregar_orden">Agregar</div>
			</div>
		</div>
		<div class="row">
				<div class="panel panel-red panel-ordenes">
				    <div class="panel-heading">Ordenes</div>
				    <div class="panel-body">
				        <table class="table table-hover table-striped">
				            <thead>
				                <tr>
				                    <th>Modelo</th>
				                    <th>Color</th>
				                    <th>Suela</th>
				                   <!--  <?php for ($i=15; $i < 32 ; $i = $i + 0.5) { ?>
				                    <th><?php if(fmod($i ,1)==0){ echo $i;} else{echo "-";} ?></th>
				                    <?php } ?> -->
				                    <th>Número</th>
				                    <th>Precio unitario</th>
				                    <th>Cantidad</th>
				                    <th>Importe</th>
				                </tr>
				            </thead>
				            <tbody id="ordenes_table">
				                
				            </tbody>
				        </table>
				    </div>

			</div>
		</div>

		<hr/>
		<div class="row">
			<div class="col-md-8"></div>
			<div class="form-group col-md-4 <?php if($form->error($model,'total')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'total', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'total',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'total', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>	

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	jQuery(function($) {
		jQuery('body').on('change','#PedidosZapatos_id_modelos',function(){
			jQuery.ajax({'url':'/controlbom/control/pedidos/coloresPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#PedidosZapatos_id_colores").html(html)}});
			jQuery.ajax({'url':'/controlbom/control/pedidos/suelasPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#PedidosZapatos_id_suelas").html(html)}});
			jQuery.ajax({'url':'/controlbom/control/pedidos/numerosPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#PedidosZapatos_numero").html(html)}});
			return false;
		});
	});
	$('#boton_agregar_orden').click(function(){
		id_modelos = $('#PedidosZapatos_id_modelos').val();
		id_colores = $('#PedidosZapatos_id_colores').val();
		id_suelas = $('#PedidosZapatos_id_suelas').val();
		numero = $('#PedidosZapatos_numero').val();
		cantidad = $('#PedidosZapatos_cantidad_total').val();
		rows = $('#ordenes_table tr').length;

		if (id_modelos>0 && id_colores>0 && id_suelas>0 && numero>0 && cantidad>0) {
			$.post(
				"<?php echo $this->createUrl('pedidos/agregarOrden/');?>",
				{
					id_modelos:id_modelos,
					id_colores:id_colores,
					id_suelas:id_suelas,
					numero:numero,
					cantidad:cantidad,
					row:rows
				},
				function(data){
					$("#ordenes_table").append(data);
					limpiarCamposOrden();
					activarBotones();
					calcularTotal();
				}
			);
		}else{
			alert('Esta mal');
		}
		
	});

	function limpiarCamposOrden(){
		$('#PedidosZapatos_id_modelos').val('');
		$('#PedidosZapatos_id_colores').html('Seleccione una opción');
		$('#PedidosZapatos_id_suelas').html('Seleccione una opción');
		$('#PedidosZapatos_numero').html('Seleccione una opción');
		$('#PedidosZapatos_cantidad_total').val('');
	}

	function activarBotones(){
		$('.agregar_precio').click(function(){
			id = $(this).data('id');
			valor = $('.precio_column_'+id+' input[type=text]').val();
			if (/^\d+(\.\d{1,2})?$/.test(valor)){
				$('.total_column_'+id).text($('.cantidad_column_'+id).text()*valor);
				calcularTotal();
				// $('.precio_column_'+id).text(valor);
			}
			else{
				// alert('El precio debe ser un número con máximo dos decimales');
			}
		});
	}

	function calcularTotal(){
		granTotal = 0;
		$('.importe_total').each(function(){
			granTotal += parseFloat($(this).text());
		});
		if(isNaN(granTotal))
			granTotal=0;
		$('#Pedidos_total').val(granTotal);
	}
</script>