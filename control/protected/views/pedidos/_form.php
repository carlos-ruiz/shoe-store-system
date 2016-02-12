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
					<?php
						$htmlOptions = array(
							"ajax"=>array(
								"url"=>$this->createUrl("pedidos/descuentoPorCliente"),
								"type"=>"POST",
								//"update"=>"#Cliente_descuento",
								"success"=>"function(data)
                                {
                                	$('#Cliente_descuento').attr('value',data);
                                }"
							),
							"class" => "form-control",
							"empty"=>array('0'=>"Seleccione una opci&oacute;n"),
						);
					?>
					<?php echo $form->dropDownList($model,'id_clientes', Clientes::model()->obtenerClientes(), $htmlOptions); ?>
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
					<?php echo $form->dropDownList($model,'id_formas_pago', FormasPago::model()->obtenerFormasPago(), array('class' => 'form-control',"empty"=>array('0'=>"Seleccione una opci&oacute;n"))); ?>
					<?php echo $form->error($model,'id_formas_pago', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'id_estatus_pedidos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_estatus_pedidos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_estatus_pedidos', EstatusPedidos::model()->obtenerEstatusPedidos(), array('class' => 'form-control',"empty"=>array('0'=>"Seleccione una opci&oacute;n"))); ?>
					<?php echo $form->error($model,'id_estatus_pedidos', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'prioridad')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'prioridad', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->checkBox($model,'prioridad',  array('class'=>'form-control', 'style'=>'width:15px')); ?>
					<?php echo $form->error($model,'prioridad', array('class'=>'help-block')); ?>
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
							"empty"=>array('0'=>"Seleccione una opci&oacute;n"),
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
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_suelas')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_suelas', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptionsAjax = array(
									"ajax"=>array(
										"url"=>$this->createUrl("pedidos/coloresPorSuela"),
										"type"=>"POST",
										"update"=>"#PedidosZapatos_id_suelas_color"
									),
									"class" => "form-control input-medium select2me",
									"empty"=>array('0'=>"Seleccione una opci&oacute;n"),
								);
					?>
					<?php echo $form->dropDownList($pedidoZapato,'id_suelas',Modelos::model()->obtenerSuelas(isset($pedidoZapato->id_modelos)?$pedidoZapato->id_modelos:0), $htmlOptionsAjax); ?>
					<?php echo $form->error($pedidoZapato,'id_suelas', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_suelas_color')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_suelas_color', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($pedidoZapato,'id_suelas_color',SuelasColores::model()->obtenerColoresPorSuela(isset($pedidoZapato->id_suelas)?$pedidoZapato->id_suelas:0), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'id_suelas_color', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row" id="agujetas_ojillos_panel">
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_agujetas')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_agujetas', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						// $htmlOptionsAjax = array(
						// 			"ajax"=>array(
						// 				"url"=>$this->createUrl("pedidos/coloresPorAgujeta"),
						// 				"type"=>"POST",
						// 				"update"=>"#PedidosZapatos_id_agujetas_color"
						// 			),
						// 			"class" => "form-control input-medium select2me",
						// 			"empty"=>array('0'=>"Seleccione una opci&oacute;n"),
						// 		);
					?>
					<?php echo $form->dropDownList($pedidoZapato,'id_agujetas',CHtml::listData(Agujetas::model()->findAll(), 'id', 'nombre'), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'id_agujetas', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_agujetas_color')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_agujetas_color', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($pedidoZapato,'id_agujetas_color',AgujetasColores::model()->obtenerColoresPorAgujeta(isset($pedidoZapato->id_agujetas)?$pedidoZapato->id_agujetas:0), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'id_agujetas_color', array('class'=>'help-block')); ?>
				</div>
			</div>
			
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_ojillos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_ojillos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						// $htmlOptionsAjax = array(
						// 			"ajax"=>array(
						// 				"url"=>$this->createUrl("pedidos/coloresPorOjillo"),
						// 				"type"=>"POST",
						// 				"update"=>"#PedidosZapatos_id_ojillos_color"
						// 			),
						// 			"class" => "form-control input-medium select2me",
						// 			"empty"=>array('0'=>"Seleccione una opci&oacute;n"),
						// 		);
					?>
					<?php echo $form->dropDownList($pedidoZapato,'id_ojillos',CHtml::listData(Ojillos::model()->findAll(), 'id', 'nombre'), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'id_ojillos', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($pedidoZapato,'id_ojillos_color')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($pedidoZapato,'id_ojillos_color', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($pedidoZapato,'id_ojillos_color',AgujetasColores::model()->obtenerColoresPorAgujeta(isset($pedidoZapato->id_agujetas)?$pedidoZapato->id_agujetas:0), $htmlOptions); ?>
					<?php echo $form->error($pedidoZapato,'id_ojillos_color', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3 ">
				<label class="control-label" for="Pedidos_es_especial">¿Es especial?</label>
				<div class="input-group">
					<input class="form-control" style="width:15px" name="Pedidos[es_especial]" id="Pedidos_es_especial" value="1" type="checkbox">
				</div>
			</div>
			<div class="form-group col-md-9 <?php if($form->error($pedidoZapato,'caracteristicas_especiales')!=''){ echo 'has-error'; }?>" id="especial_input">
				<?php echo $form->labelEx($pedidoZapato,'caracteristicas_especiales', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textArea($pedidoZapato,'caracteristicas_especiales',array('rows'=>5, 'cols'=>150, 'class'=>'form-control')); ?>
					<?php echo $form->error($pedidoZapato,'caracteristicas_especiales', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				<div class="btn btn-red-stripped" id="boton_agregar_orden">Agregar</div>
			</div>
		</div>
		<?php
		$zapatosDiferentes = array();
		$id_modelo = 0;
		$id_color = 0;
		$id_suela = 0;
		$id_color_suela = 0;
		$id_agujeta = 0;
		$id_color_agujeta = 0;
		$id_ojillo = 0;
		$id_color_ojillo = 0;
		$contador = 0;
		$caracteristicas_especiales = '';
		foreach ($model->pedidosZapatos as $pedidoZapato) { 
			if(
				$pedidoZapato->zapato->modelo->id != $id_modelo ||
				$pedidoZapato->zapato->color->id != $id_color ||
				$pedidoZapato->zapato->suelaColor->suela->id != $id_suela || 
				$pedidoZapato->zapato->suelaColor->color->id != $id_color_suela ||
				$pedidoZapato->caracteristicas_especiales != $caracteristicas_especiales
			) {
				if (isset($pedidoZapato->zapato->agujetaColor)) {
					if (
						$pedidoZapato->zapato->agujetaColor->agujeta->id != $id_agujeta || 
						$pedidoZapato->zapato->agujetaColor->color->id != $id_color_agujeta || 
						$pedidoZapato->zapato->ojilloColor->ojillo->id != $id_ojillo || 
						$pedidoZapato->zapato->ojilloColor->color->id != $id_color_ojillo) {
						$contador++;
						
						$zapatosDiferentes[$contador]['id_agujeta'] = $pedidoZapato->zapato->agujetaColor->id_agujetas;
						$zapatosDiferentes[$contador]['agujeta'] = $pedidoZapato->zapato->agujetaColor->agujeta->nombre;
						$zapatosDiferentes[$contador]['id_agujetacolor'] = $pedidoZapato->zapato->agujetaColor->id;
						$zapatosDiferentes[$contador]['coloragujeta'] = $pedidoZapato->zapato->agujetaColor->color->color;
						$zapatosDiferentes[$contador]['id_ojillo'] = $pedidoZapato->zapato->ojilloColor->id_ojillos;
						$zapatosDiferentes[$contador]['ojillo'] = $pedidoZapato->zapato->ojilloColor->ojillo->nombre;
						$zapatosDiferentes[$contador]['id_ojillocolor'] = $pedidoZapato->zapato->ojilloColor->id;
						$zapatosDiferentes[$contador]['colorojillo'] = $pedidoZapato->zapato->ojilloColor->color->color;		
					}
				}
				else{
					$contador++;
					$zapatosDiferentes[$contador]['id_agujeta'] = 'N/A';
					$zapatosDiferentes[$contador]['agujeta'] = 'N/A';
					$zapatosDiferentes[$contador]['id_agujetacolor'] = 'N/A';
					$zapatosDiferentes[$contador]['coloragujeta'] = 'N/A';
					$zapatosDiferentes[$contador]['id_ojillo'] = 'N/A';
					$zapatosDiferentes[$contador]['ojillo'] = 'N/A';
					$zapatosDiferentes[$contador]['id_ojillocolor'] = 'N/A';
					$zapatosDiferentes[$contador]['colorojillo'] = 'N/A';
				}
				$zapatosDiferentes[$contador]['id_modelo'] = $pedidoZapato->zapato->modelo->id;
				$zapatosDiferentes[$contador]['modelo'] = $pedidoZapato->zapato->modelo->nombre;
				$zapatosDiferentes[$contador]['id_color'] = $pedidoZapato->zapato->color->id;
				$zapatosDiferentes[$contador]['color'] = $pedidoZapato->zapato->color->color;
				$zapatosDiferentes[$contador]['id_suela'] = $pedidoZapato->zapato->suelaColor->id_suelas;
				$zapatosDiferentes[$contador]['suela'] = $pedidoZapato->zapato->suelaColor->suela->nombre;
				$zapatosDiferentes[$contador]['id_suelacolor'] = $pedidoZapato->zapato->suelaColor->id;
				$zapatosDiferentes[$contador]['colorsuela'] = $pedidoZapato->zapato->suelaColor->color->color;

				$zapatosDiferentes[$contador]['especial'] = $pedidoZapato->caracteristicas_especiales;
				$id_modelo = $pedidoZapato->zapato->modelo->id;
				$id_suela = $pedidoZapato->zapato->suelaColor->id_suelas;
				$id_color_suela = $pedidoZapato->zapato->suelaColor->id_colores;
				$id_color = $pedidoZapato->zapato->color->id;
				$caracteristicas_especiales = $pedidoZapato->caracteristicas_especiales;
			}
			
			$zapatosDiferentes[$contador][''.$pedidoZapato->zapato->numero] = $pedidoZapato->cantidad_total;
		}
		?>
		<div class="row">
			<div class="panel panel-red panel-ordenes">
				<div class="panel-heading">Ordenes</div>
				<div class="panel-body">
					<table class="table table-hover table-striped ordenes-pedido-table">
						<thead>
							<tr>
								<th>Modelo</th>
								<th>Color</th>
								<th>Suela</th>
								<th>Color Suela</th>
								<th>Agujetas</th>
								<th>Color Agujetas</th>
								<th>Ojillos</th>
								<th>Color Ojillos</th>
								<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
								<th><?php if(fmod($i ,1)==0){ echo $i;} else{echo "-";} ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tbody id="ordenes_table">
							<?php foreach ($zapatosDiferentes as $index => $row) { 
								$time = microtime();
								$time = str_replace(' ', '', $time);
								$time = str_replace('.', '', $time);
								$modeloNumeros = ModelosNumeros::model()->findAll('id_modelos=?', array($row['id_modelo']));
								$numerosPosibles = array();
								foreach ($modeloNumeros as $modeloNumero) {
									array_push($numerosPosibles, $modeloNumero->numero);
								}
								?>
								<?php $rowOdd = (($index % 2)==0)?1:0; ?>
								<tr id="row_<?= $time ?>" class="<?= $rowOdd==1?'odd':'' ?>">
									<td class="modelo" data-id="<?= $row['id_modelo'] ?>">
										<?= $row['modelo'] ?><input type="hidden" name="Pedido[modelo][<?= $time ?>]" value="<?= $row['id_modelo'] ?>">
									</td>
									<td class="color" data-id="<?= $row['id_color'] ?>">
										<?= $row['color'] ?><input type="hidden" name="Pedido[color][<?= $time ?>]" value="<?= $row['id_color'] ?>">
									</td>
									<td class="suela" data-id="<?= $row['id_suela'] ?>">
										<?= $row['suela'] ?><input type="hidden" name="Pedido[suela][<?= $time ?>]" value="<?= $row['id_suela'] ?>">
									</td>
									<td class="colorsuela" data-id="<?= $row['id_suelacolor'] ?>">
										<?= $row['colorsuela'] ?><input type="hidden" name="Pedido[suelacolor][<?= $time ?>]" value="<?= $row['id_suelacolor'] ?>">
									</td>

									<td class="agujeta" data-id="<?= $row['id_agujeta'] ?>">
										<?= $row['agujeta'] ?><input type="hidden" name="Pedido[agujeta][<?= $time ?>]" value="<?= $row['id_agujeta'] ?>">
									</td>
									<td class="coloragujeta" data-id="<?= $row['id_agujetacolor'] ?>">
										<?= $row['coloragujeta'] ?><input type="hidden" name="Pedido[agujetacolor][<?= $time ?>]" value="<?= $row['id_agujetacolor'] ?>">
									</td>

									<td class="ojillo" data-id="<?= $row['id_ojillo'] ?>">
										<?= $row['ojillo'] ?><input type="hidden" name="Pedido[ojillo][<?= $time ?>]" value="<?= $row['id_ojillo'] ?>">
									</td>
									<td class="colorojillo" data-id="<?= $row['id_ojillocolor'] ?>">
										<?= $row['colorojillo'] ?><input type="hidden" name="Pedido[ojillocolor][<?= $time ?>]" value="<?= $row['id_ojillocolor'] ?>">
									</td>
								
								<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
									<td data-numero="<?= $i; ?>">
										<input class="input-cantidad" type="text" name="Pedido[numeros][<?= $time ?>][<?= $i; ?>]" maxlength="3" style="width:20px;" <?php if(!in_array($i, $numerosPosibles)) {echo "disabled value='X'";}else{echo "value='";if(isset($row[''.$i])){echo $row[''.$i];}echo "'";} ?>/>
									</td>
								<?php } ?>
									<td>
										<a data-row="<?= $time ?>" class="delete" title="Borrar" href="javascript:void(0);"><img src="/controlbom/control/images/icons/delete.png" alt="Borrar"></a>
									</td>
								</tr>
								<?php if(isset($row['especial'])) { ?>
									<tr class="row_<?= $time ?> <?= $rowOdd==1?'odd':'' ?>">
										<td class="td-caracteristicas-especiales" colspan="46">
											<?= $row['especial'] ?><input type="hidden" name="Pedido[especiales][<?= $time ?>]" value="<?= $row['especial'] ?>">
										</td>
										<td colspan="2">
											<a data-row="<?= $time ?>" class="quitar-especial" title="Quitar" href="javascript:void(0);"><img src="/controlbom/control/images/icons/delete.png" alt="Quitar">Quitar</a>
										</td>
									</tr>
								<?php } ?>
							<?php }	?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<hr/>
		<div class="row">
			<div class="col-md-8"></div>
			<div class="form-group col-md-4">
				<label class="control-label required" for="Pedidos_total">Subtotal ($)</label>
				<div class="input-group">
					<input size="60" maxlength="128" class="form-control" disabled="disabled" name="Aux[subtotal]" id="Pedidos_subtotal" type="text" value="0">
				</div>
			</div>
		</div>
		<div class="row">
			<?php
			$descuentoCliente = 0;  
			if(isset($model->cliente->descuento) && $model->cliente->descuento > 0) { $descuentoCliente = $model->cliente->descuento; }?>
			<div class="col-md-8"></div>
			<div class="form-group col-md-4">
				<label class="control-label required" for="Pedidos_total">Descuento al cliente (%)</label>
				<div class="input-group">
					<input size="60" maxlength="128" class="form-control" disabled="disabled" name="Aux[descuento]" id="Cliente_descuento" type="text" value="<?= $descuentoCliente ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8"></div>
			<div class="form-group col-md-4 <?php if($form->error($model,'descuento')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'descuento', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'descuento',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'descuento', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8"></div>
			<div class="form-group col-md-4 <?php if($form->error($model,'total')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'total', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'total',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'readonly'=>'readonly')); ?>
					<?php echo $form->error($model,'total', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<?php if (!$model->isNewRecord) { ?>
		<div class="row">
			<div class="col-md-8"></div>
			<div class="form-group col-md-4 ">
				<label class="control-label" for="PedidosTemp_pago_anterior">Monto pagado ($)</label>
				<div class="input-group">
					<input size="60" maxlength="128" class="form-control" readonly="readonly" name="PedidosTemp[pago_anterior]" id="PedidosTemp_pago_anterior" type="text" value="<?= number_format($model->obtenerMontoPagado(), 2, '.', '') ?>">
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="row">
			<div class="col-md-8"></div>
			<div class="form-group col-md-4 <?php if($form->error($model,'pagado')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'pagado', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'pagado',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'pagado', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8"></div>
			<div class="form-group col-md-4 ">
				<label class="control-label" for="PedidosTemp_pago_pendiente">Monto pendiente ($)</label>
				<div class="input-group">
					<input size="60" maxlength="128" class="form-control" readonly="readonly" name="PedidosTemp[pago_pendiente]" id="PedidosTemp_pago_pendiente" type="text" value="<?= number_format(($model->total - $model->obtenerMontoPagado()), 2, '.', '') ?>">
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
	var tieneAgujetas = false;

	$(document).ready(function(){
		total = parseFloat($('#Pedidos_total').val());
		descuentoCliente = parseFloat($('#Cliente_descuento').val());
		descuentoPedido = parseFloat($('#Pedidos_descuento').val());
		subtotal = total;
		if(total > 0){
			if(descuentoPedido > 0){
				subtotal = subtotal/((100-descuentoPedido)/100);
			}
			if(descuentoCliente > 0){
				subtotal = subtotal/((100-descuentoCliente)/100);
			}
		}
		$('#Pedidos_subtotal').val(subtotal.toFixed(2));

		checked = $('#Pedidos_es_especial').is(":checked");
		if(!checked){
			$('#especial_input').hide();
		}
	});

	$('#Pedidos_es_especial').change(function(){
		$('#especial_input').toggle(500);
	});

	jQuery(function($) {
		jQuery('body').on('change','#PedidosZapatos_id_modelos',function(){
			jQuery.ajax({'url':'/controlbom/control/pedidos/coloresPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){
					jQuery("#PedidosZapatos_id_colores").html(html);
					jQuery.ajax({'url':'/controlbom/control/pedidos/materialesPredeterminados','type':'POST','dataType':'json','cache':false,'data':jQuery('#PedidosZapatos_id_modelos').parents("form").serialize(),'success':function(json_response){
							establecerMaterialesPredeterminados(json_response);
						}
					});
				}
			});
			jQuery.ajax({'url':'/controlbom/control/pedidos/suelasPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){
					jQuery("#PedidosZapatos_id_suelas").html(html);
					actualizarColoresSuelas();
				}
			});
			jQuery.ajax({'url':'/controlbom/control/pedidos/revisarSiTieneAgujetas','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){
					if (html == 'true') {
						$('#agujetas_ojillos_panel').show(500);
						tieneAgujetas = true;
					}
					else{
						$('#agujetas_ojillos_panel').hide(500);
						tieneAgujetas = false;
					}
				}
			});
			return false;
		});

		jQuery('body').on('change','#PedidosZapatos_id_colores',function(){
			jQuery.ajax({'url':'/controlbom/control/pedidos/materialesPredeterminados','type':'POST','dataType':'json','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(json_response){
					establecerMaterialesPredeterminados(json_response);
				}
			});
			return false;
		});

		jQuery('body').on('change','#PedidosZapatos_id_agujetas',function(){
			actualizarColoresDeAgujetas();
			return false;
		});
		jQuery('body').on('change','#PedidosZapatos_id_ojillos',function(){
			actualizarColoresDeOjillos();
			return false;
		});
	});
	function actualizarColoresDeAgujetas(){
		jQuery.ajax({'url':'/controlbom/control/pedidos/coloresPorAgujeta','type':'POST','cache':false,'data':jQuery('#PedidosZapatos_id_modelos').parents("form").serialize(),'success':function(html){
				jQuery("#PedidosZapatos_id_agujetas_color").html(html);
			}
		});
	}

	function actualizarColoresDeOjillos(){
		jQuery.ajax({'url':'/controlbom/control/pedidos/coloresPorOjillo','type':'POST','cache':false,'data':jQuery('#PedidosZapatos_id_modelos').parents("form").serialize(),'success':function(html){
				jQuery("#PedidosZapatos_id_ojillos_color").html(html);
			}
		});
	}

	function actualizarColoresSuelas(){
		jQuery.ajax({'url':'/controlbom/control/pedidos/coloresPorSuela','type':'POST','cache':false,'data':jQuery('#PedidosZapatos_id_modelos').parents("form").serialize(),'success':function(html){jQuery("#PedidosZapatos_id_suelas_color").html(html);}});
	}

	$('#boton_agregar_orden').click(function(){
		id_modelos = $('#PedidosZapatos_id_modelos').val();
		id_colores = $('#PedidosZapatos_id_colores').val();
		id_suelas = $('#PedidosZapatos_id_suelas').val();
		id_color_suela = $('#PedidosZapatos_id_suelas_color').val();
		id_agujetas = $('#PedidosZapatos_id_agujetas').val();
		id_color_agujetas = $('#PedidosZapatos_id_agujetas_color').val();
		id_ojillos = $('#PedidosZapatos_id_ojillos').val();
		id_color_ojillos = $('#PedidosZapatos_id_ojillos_color').val();
		rows = $('#ordenes_table tr').length;
		rows_especiales = $('#ordenes_table tr.especial').length;
		rows = rows-rows_especiales;
		caracteristicas_especiales = $('#PedidosZapatos_caracteristicas_especiales').val();

		if (id_modelos>0 && id_colores>0 && id_suelas>0 && id_color_suela>0) {
			var datos = {};
			datos.id_modelos = id_modelos;
			datos.id_colores = id_colores;
			datos.id_suelas = id_suelas;
			datos.id_color_suela = id_color_suela;
			datos.row = rows;
			datos.especial = caracteristicas_especiales;
			if(tieneAgujetas){
				if (id_agujetas>0 && id_color_agujetas>0 && id_ojillos>0 && id_color_ojillos>0) {
					datos.id_agujetas = id_agujetas;
					datos.id_color_agujetas = id_color_agujetas;
					datos.id_ojillos = id_ojillos;
					datos.id_color_ojillos = id_color_ojillos;
				}else{
					alerta('Debe seleccionar tambien los datos de agujetas y ojillos', "Error");
					return;
				}
			}
			$.post(
				"<?php echo $this->createUrl('pedidos/agregarOrden/');?>",
				datos,
				function(data){
					$("#ordenes_table").append(data);
					limpiarCamposOrden();
					calcularTotal();
					calcularMontoPendiente();
				}
			);
		}else{
			alerta('Debe seleccionar los datos de modelo y suela, así como sus respectivos colores', 'Error');
		}
		
	});
	var valorAnterior;
	$(document).on("focus",".input-cantidad", function(){
		valorAnterior = $(this).val();
	});
	$(document).on("change",".input-cantidad", function(){
		id_modelos = $(this).parent().parent().find('.modelo').data('id');
		id_suelas = $(this).parent().parent().find('.suela').data('id');
		numero = $(this).parent().data('numero');
		total = parseFloat($('#Pedidos_subtotal').val());
		cantidad = $(this).val();
		if(!/^([0-9])*$/.test(cantidad)){
			alerta('Debe especificar la cantidad de pares, debe ser un número');
			cantidad = 0;
			$(this).val(cantidad);
		}
		if($(this).val()===''){
			$(this).val(0);
		}
		input = $(this);
		$(".panel-ordenes").block({message:'Espere...'});
		$.post(
			"<?php echo $this->createUrl('zapatoprecios/consultarprecio/');?>",
			{
				id_modelos:id_modelos,
				numero:numero,
				id_suelas:id_suelas
			},
			function(data){
				if(data.search("error")>=0){
					input.val(0);
					mensaje = data.split('#');
					alerta(mensaje[1], 'Error');
					$(".panel-ordenes").unblock();
					return;
				}
				precio = parseFloat(data);
				total += (precio*cantidad);
				if(/^([0-9])*$/.test(valorAnterior)){
					total -= (valorAnterior*precio);
				}
				$('#Pedidos_subtotal').val(''+total.toFixed(2));
				calcularTotal();
				calcularMontoPendiente();
				$(".panel-ordenes").unblock();
			}
		);
	});

	$(document).on("change","#Pedidos_pagado", function(){
		calcularMontoPendiente();
	});
	$(document).on("change","#Pedidos_descuento", function(){
		if($(this).val() < 0 || $(this).val() > 100){
			alerta('El descuento debe ser un número entre 0 y 100');
			$(this).val('0');
		}
		calcularTotal();
		calcularMontoPendiente();
	});

	$(document).on("click","a.delete", function(){
		id_modelos = $(this).parent().parent().find('.modelo').data('id');
		id_suelas = $(this).parent().parent().find('.suela').data('id');
		total = parseFloat($('#Pedidos_subtotal').val());
		row = $(this).data('row');
		jQuery.ajax({
			'url':'/controlbom/control/zapatoprecios/totalRow',
			'type':'POST',
			'cache':false,
			'data':$('#ordenes_table #row_'+row+' :input').serialize(),
			'success':function(html){
				reduccion = parseFloat(html);
				total -= reduccion;
				$('#Pedidos_subtotal').val(''+total.toFixed(2));
				calcularTotal();
				calcularMontoPendiente();
			}
		});
		idTrEspecial = $(this).parent().parent().attr('id');
		$('.'+idTrEspecial).remove();
		$(this).parent().parent().remove();
	});

	$(document).on("click","a.quitar-especial", function(){
		$(this).parent().parent().remove();
	});

	function limpiarCamposOrden(){
		$('#PedidosZapatos_id_modelos').val(0);
		$('#PedidosZapatos_id_colores').html('<option value="">Seleccione una opción</option>');
		$('#PedidosZapatos_id_suelas').html('<option value="">Seleccione una opción</option>');
		$('#PedidosZapatos_id_suelas_color').html('<option value="">Seleccione una opción</option>');
		$('#PedidosZapatos_id_agujetas').val(0);
		$('#PedidosZapatos_id_agujetas_color').html('<option value="">Seleccione una opción</option>');
		$('#PedidosZapatos_id_ojillos').val(0);
		$('#PedidosZapatos_id_ojillos_color').html('<option value="">Seleccione una opción</option>');
		$('#Pedidos_es_especial').attr('checked', false);
		$('#PedidosZapatos_caracteristicas_especiales').val(0);
		$('#especial_input').hide(500);
	}

	function calcularTotal(){
		subtotal = $('#Pedidos_subtotal').val();
		granTotal = subtotal;
		descuentoCliente = $('#Cliente_descuento').val();
		descuentoPedido = parseFloat($('#Pedidos_descuento').val());
		if(isNaN(descuentoPedido)){
			descuentoPedido=0;
			$('#Pedidos_descuento').val('0');
		}
		granTotal = granTotal * ((100-descuentoCliente)/100);
		granTotal = granTotal * ((100-descuentoPedido)/100);
		$('#Pedidos_total').attr("value", granTotal.toFixed(2));
	}

	function calcularMontoPendiente(){
		total = parseFloat($('#Pedidos_total').val());
		if(isNaN(total)){
			total = 0;
		}
		pagado = parseFloat($('#PedidosTemp_pago_anterior').val());
		if(isNaN(pagado)){
			pagado = 0;
		}
		pagoActual = parseFloat($('#Pedidos_pagado').val());
		if(isNaN(pagoActual)){
			pagoActual = 0;
		}
		pendiente = total-pagado-pagoActual;
		$('#PedidosTemp_pago_pendiente').val(pendiente.toFixed(2));
	}

	function establecerMaterialesPredeterminados(datos_json){
		id_modelo = datos_json.id_modelo;
		id_color_modelo = datos_json.id_color_modelo;
		id_suela = datos_json.id_suela;
		id_color_suela = datos_json.id_color_suela;
		id_tacon = datos_json.id_tacon;
		id_color_tacon = datos_json.id_color_tacon;
		id_agujetas = datos_json.id_agujetas;
		id_color_agujetas = datos_json.id_color_agujetas;
		id_ojillos = datos_json.id_ojillos;
		id_color_ojillos = datos_json.id_color_ojillos;
		$('#PedidosZapatos_id_suelas').val(id_suela);
		jQuery.ajax({'url':'/controlbom/control/pedidos/coloresPorSuela','type':'POST','cache':false,'data':jQuery('#PedidosZapatos_id_modelos').parents("form").serialize(),'success':function(html){
				jQuery("#PedidosZapatos_id_suelas_color").html(html);
				$('#PedidosZapatos_id_suelas_color').val(id_color_suela);
				$('#PedidosZapatos_id_agujetas').val(id_agujetas);
				jQuery.ajax({'url':'/controlbom/control/pedidos/coloresPorAgujeta','type':'POST','cache':false,'data':jQuery('#PedidosZapatos_id_modelos').parents("form").serialize(),'success':function(html){
						jQuery("#PedidosZapatos_id_agujetas_color").html(html);
						$("select#PedidosZapatos_id_agujetas option").each(function(){
							$(this).removeAttr('selected');
						});
						$("select#PedidosZapatos_id_agujetas option[value='"+id_agujetas+"']").attr("selected","selected");
						$("select#PedidosZapatos_id_agujetas_color option").each(function(){
							$(this).removeAttr('selected');
						});
						$("select#PedidosZapatos_id_agujetas_color option[value='"+id_color_agujetas+"']").attr("selected","selected");
						$('#PedidosZapatos_id_agujetas_color').val(id_color_agujetas);
					}
				});
				$('#PedidosZapatos_id_ojillos').val(id_ojillos);
				jQuery.ajax({'url':'/controlbom/control/pedidos/coloresPorOjillo','type':'POST','cache':false,'data':jQuery('#PedidosZapatos_id_modelos').parents("form").serialize(),'success':function(html){
						jQuery("#PedidosZapatos_id_ojillos_color").html(html);
						$("select#PedidosZapatos_id_ojillos option").each(function(){
							$(this).removeAttr('selected');
						});
						$("select#PedidosZapatos_id_ojillos option[value='"+id_ojillos+"']").attr("selected","selected");
						$("select#PedidosZapatos_id_ojillos_color option").each(function(){
							$(this).removeAttr('selected');
						});
						$("select#PedidosZapatos_id_ojillos_color option[value='"+id_color_ojillos+"']").attr("selected","selected");
						$('#PedidosZapatos_id_ojillos_color').val(id_color_ojillos);
					}
				});
			}
		});
	}
</script>
