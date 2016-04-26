<?php
/* @var $this ModelosMaterialesPredeterminadosController */
/* @var $model ModelosMaterialesPredeterminados */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'modelos-materiales-predeterminados-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<hr/>
		
		<div class="row">
			<div class="form-group col-md-3 <?php if($form->error($model,'id_modelos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_modelos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptions = array(
							"class" => "form-control",
							"empty"=>array(''=>"Seleccione una opci&oacute;n"),
						);
					?>
					<?php echo $form->dropDownList($model,'id_modelos',Modelos::model()->obtenerModelos(), $htmlOptions); ?>
					<?php echo $form->error($model,'id_modelos', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($model,'id_color_modelo')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_color_modelo', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_color_modelo',Modelos::model()->obtenerColores(isset($model->id_modelos)?$model->id_modelos:0), $htmlOptions); ?>
					<?php echo $form->error($model,'id_color_modelo', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($model,'id_suelas')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_suelas', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptionsAjax = array(
									"ajax"=>array(
										"url"=>$this->createUrl("modelosmaterialespredeterminados/coloresPorSuela"),
										"type"=>"POST",
										"update"=>"#ModelosMaterialesPredeterminados_id_color_suela"
									),
									"class" => "form-control input-medium select2me",
									"empty"=>array(''=>"Seleccione una opci&oacute;n"),
								);
					?>
					<?php echo $form->dropDownList($model,'id_suelas', Modelos::model()->obtenerSuelas(isset($model->id_modelos)?$model->id_modelos:0), $htmlOptionsAjax); ?>
					<?php echo $form->error($model,'id_suelas', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($model,'id_color_suela')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_color_suela', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_color_suela', Suelas::model()->obtenerColores(isset($model->id_suelas)?$model->id_suelas:0), $htmlOptions); ?>
					<?php echo $form->error($model,'id_color_suela', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>


		<div class="row" id="agujetas_ojillos_panel">
			<div class="form-group col-md-3 <?php if($form->error($model,'id_agujetas')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_agujetas', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptionsAjax = array(
									"ajax"=>array(
										"url"=>$this->createUrl("modelosmaterialespredeterminados/coloresPorAgujeta"),
										"type"=>"POST",
										"update"=>"#ModelosMaterialesPredeterminados_id_color_agujetas"
									),
									"class" => "form-control input-medium select2me",
									"empty"=>array(''=>"Seleccione una opci&oacute;n"),
								);
					?>
					<?php echo $form->dropDownList($model,'id_agujetas',CHtml::listData(Agujetas::model()->findAll(), 'id', 'nombre'), $htmlOptionsAjax); ?>
					<?php echo $form->error($model,'id_agujetas', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($model,'id_color_agujetas')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_color_agujetas', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_color_agujetas', Agujetas::model()->obtenerColores(isset($model->id_agujetas)?$model->id_agujetas:0), $htmlOptions); ?>
					<?php echo $form->error($model,'id_color_agujetas', array('class'=>'help-block')); ?>
				</div>
			</div>
			
			<div class="form-group col-md-3 <?php if($form->error($model,'id_ojillos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_ojillos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptionsAjax = array(
									"ajax"=>array(
										"url"=>$this->createUrl("modelosmaterialespredeterminados/coloresPorOjillo"),
										"type"=>"POST",
										"update"=>"#ModelosMaterialesPredeterminados_id_color_ojillos"
									),
									"class" => "form-control input-medium select2me",
									"empty"=>array(''=>"Seleccione una opci&oacute;n"),
								);
					?>
					<?php echo $form->dropDownList($model,'id_ojillos',CHtml::listData(Ojillos::model()->findAll(), 'id', 'nombre'), $htmlOptionsAjax); ?>
					<?php echo $form->error($model,'id_ojillos', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($model,'id_color_ojillos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_color_ojillos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_color_ojillos', Ojillos::model()->obtenerColores(isset($model->id_ojillos)?$model->id_ojillos:0), $htmlOptions); ?>
					<?php echo $form->error($model,'id_color_ojillos', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>

		<div class="row" id="tacones_panel">
			<div class="form-group col-md-3 <?php if($form->error($model,'id_tacones')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_tacones', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptionsAjax = array(
									"ajax"=>array(
										"url"=>$this->createUrl("modelosmaterialespredeterminados/coloresPorTacon"),
										"type"=>"POST",
										"update"=>"#ModelosMaterialesPredeterminados_id_color_tacon"
									),
									"class" => "form-control input-medium select2me",
									"empty"=>array(''=>"Seleccione una opci&oacute;n"),
								);
					?>
					<?php echo $form->dropDownList($model,'id_tacones', SuelasTacones::model()->obtenerTaconesPorSuela(isset($model->id_suelas)?$model->id_suelas:0), $htmlOptionsAjax); ?>
					<?php echo $form->error($model,'id_tacones', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($model,'id_color_tacon')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_color_tacon', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_color_tacon', Tacones::model()->obtenerColores(isset($model->id_tacones)?$model->id_tacones:0), $htmlOptions); ?>
					<?php echo $form->error($model,'id_color_tacon', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>

		<div class="row col-md-12">
			<h4>Materiales de colores</h4>
			<hr/>
		</div>
		<div class="row" id="materiales_con_color">
			<?php if(isset($model->materialesColoresPredeterminados) && sizeof($model->materialesColoresPredeterminados)){ ?>
				<?php foreach ($model->materialesColoresPredeterminados as $mcp) { ?>
					<div class="form-group col-md-3 ">
						<label class="control-label required" for="material_<?= $mcp->id_materiales ?>" ><?= $mcp->material->material->nombre ?><span class="required">*</span></label>
						<div class="input-group">
							<select class="form-control" name="ModelosMaterialesPredeterminados[MaterialesColores][<?= $mcp->id_materiales ?>]" id="material_<?= $mcp->id_materiales ?>" required>
								<option value="">Seleccione una opción</option>
								<?php foreach ($mcp->material->material->colores as $materialColor) { ?>
									<option value="<?= $materialColor->id_colores ?>" <?= ($materialColor->id_colores==$mcp->id_colores)?'selected':'' ?>><?= $materialColor->color->color ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>

		<div class="row">
			<div class="form-group col-md-12">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-red-stripped')); ?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	var modeloTieneAgujetas = false;
	var suelaTieneTacon = false;


	$(document).ready(function(){
		id_modelo = $('#ModelosMaterialesPredeterminados_id_modelos').val();
		if (id_modelo > 0) {
			jQuery.ajax({
				'url':'/controlbom/control/modelosmaterialespredeterminados/revisarSiTieneAgujetas',
				'type':'POST',
				'cache':false,
				'data':jQuery("#modelos-materiales-predeterminados-form").serialize(),
				'success':function(html){
						if (html == 'true') {
							$('#agujetas_ojillos_panel').show(500);
							modeloTieneAgujetas = true;
						}
					}
				});
		}
		id_suela = $('#ModelosMaterialesPredeterminados_id_suelas').val();
		if (id_suela > 0) {
			jQuery.ajax({'url':'/controlbom/control/modelosmaterialespredeterminados/revisarSiSuelaTieneTacon','type':'POST','cache':false,'data':jQuery('#ModelosMaterialesPredeterminados_id_modelos').parents("form").serialize(),'success':function(html){
					if (html == 'true') {
						$('#tacones_panel').show(500);
						suelaTieneTacon = true;
					}
				}
			});
		}
		// id_agujeta = $('#ModelosMaterialesPredeterminados_id_agujetas').val();
		// id_color_agujeta = $('#ModelosMaterialesPredeterminados_id_color_agujetas').val();
		// id_ojillo = $('#ModelosMaterialesPredeterminados_id_ojillos').val();
		// id_color_ojillo = $('#ModelosMaterialesPredeterminados_id_color_ojillos').val();
		// id_tacon = $('#ModelosMaterialesPredeterminados_id_tacones').val();
		// id_color_tacon = $('#ModelosMaterialesPredeterminados_id_color_tacon').val();
		// if (id_agujeta>0 && id_color_agujeta>0 && id_ojillo>0 && id_color_ojillo>0) {
		// 	$('#agujetas_ojillos_panel').css('display', 'block');
		// }
		// if (id_tacon>0 && id_color_tacon>0) {
		// 	$('#tacones_panel').css('display', 'block');
		// }
	});

	jQuery(function($) {
		jQuery('body').on('change','#ModelosMaterialesPredeterminados_id_modelos',function(){
			id_modelo = $(this).val();
			if (id_modelo > 0) {
				jQuery.ajax({'url':'/controlbom/control/modelosmaterialespredeterminados/coloresPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),
					'success':function(html){
						jQuery("#ModelosMaterialesPredeterminados_id_color_modelo").html(html);
						actualizarMaterialesDeColores(id_modelo);
					}
				});
				jQuery.ajax({'url':'/controlbom/control/modelosmaterialespredeterminados/suelasPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){
						jQuery("#ModelosMaterialesPredeterminados_id_suelas").html(html);
						actualizarDatosDependientesDeSuela();
					}
				});
				jQuery.ajax({'url':'/controlbom/control/modelosmaterialespredeterminados/revisarSiTieneAgujetas','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){
						if (html == 'true') {
							$('#agujetas_ojillos_panel').show(500);
							modeloTieneAgujetas = true;
						}
						else{
							$('#agujetas_ojillos_panel').hide(500);
							$('#ModelosMaterialesPredeterminados_id_agujetas').val(0);
							$('#ModelosMaterialesPredeterminados_id_color_agujetas').val(0);
							$('#ModelosMaterialesPredeterminados_id_ojillos').val(0);
							$('#ModelosMaterialesPredeterminados_id_color_ojillos').val(0);
							modeloTieneAgujetas = false;
						}
					}
				});
			}
			else{
				restablecerSelectsPrincipales();
			}
			return false;
		});

		jQuery('body').on('change','#ModelosMaterialesPredeterminados_id_suelas',function(){
			actualizarDatosDependientesDeSuela();
		});
	});

	function actualizarDatosDependientesDeSuela(){
		//Actualizando los colores disponibles de la suela
		jQuery.ajax({'url':'/controlbom/control/modelosmaterialespredeterminados/coloresPorSuela','type':'POST','cache':false,'data':jQuery('#ModelosMaterialesPredeterminados_id_modelos').parents("form").serialize(),'success':function(html){jQuery("#ModelosMaterialesPredeterminados_id_color_suela").html(html);}});

		//Revisando si la suela lleva tacon
		jQuery.ajax({'url':'/controlbom/control/modelosmaterialespredeterminados/revisarSiSuelaTieneTacon','type':'POST','cache':false,'data':jQuery('#ModelosMaterialesPredeterminados_id_modelos').parents("form").serialize(),'success':function(html){
				if (html == 'true') {
					$('#tacones_panel').show(500);
					suelaTieneTacon = true;
				}
				else{
					$('#tacones_panel').hide(500);
					suelaTieneTacon = false;
					$('#ModelosMaterialesPredeterminados_id_tacones').val(0);
					$('#ModelosMaterialesPredeterminados_id_color_tacon').val(0);
				}
				actualizarTaconesPorSuela();
			}
		});
	}

	function actualizarTaconesPorSuela(){
		if (suelaTieneTacon) {
			//Actualizando los tacones que puede tener la suela (Si es que tiene)
			jQuery.ajax({'url':'/controlbom/control/modelosmaterialespredeterminados/taconesPorSuela','type':'POST','cache':false,'data':jQuery('#ModelosMaterialesPredeterminados_id_modelos').parents("form").serialize(),'success':function(html){
					jQuery("#ModelosMaterialesPredeterminados_id_tacones").html(html);
					actualizarDatosDependientesDeTacon();
				}
			});
		}
	}

	function actualizarDatosDependientesDeTacon(){
		//Actualizando los colores disponibles del tacón
		jQuery.ajax({'url':'/controlbom/control/modelosmaterialespredeterminados/coloresPorTacon','type':'POST','cache':false,'data':jQuery('#ModelosMaterialesPredeterminados_id_modelos').parents("form").serialize(),'success':function(html){jQuery("#ModelosMaterialesPredeterminados_id_color_tacon").html(html);}});
	}

	function actualizarMaterialesDeColores(id_modelo){
		jQuery.ajax({
			'url':'/controlbom/control/modelosmaterialespredeterminados/materialesDeColores',
			'type':'POST',
			'cache':false,
			'data':{'id_modelo':id_modelo},
			'success':function(response){
				jQuery("#materiales_con_color").html(response);
			}
		});
	}

	function restablecerSelectsPrincipales(){
		$('#ModelosMaterialesPredeterminados_id_color_modelo').html('<option value>Seleccione una opción</option>');
		$('#ModelosMaterialesPredeterminados_id_suelas').html('<option value>Seleccione una opción</option>');
		$('#ModelosMaterialesPredeterminados_id_color_suela').html('<option value>Seleccione una opción</option>');
		$('#agujetas_ojillos_panel').hide(500);
		$('#tacones_panel').hide(500);
		$('#materiales_con_color').html('');
		$('#materiales_con_color').hide(500);
	}
</script>
