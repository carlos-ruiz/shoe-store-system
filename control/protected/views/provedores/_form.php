<?php
/* @var $this ProvedoresController */
/* @var $model Provedores */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'provedores-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<!-- <h4>Datos generales</h4> -->
		<hr/>
		<div class="row">
			<div class="form-group col-md-12 <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 <?php if($form->error($model,'telefono')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'telefono', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'telefono',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'telefono', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-6 <?php if($form->error($model,'correo_electronico')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'correo_electronico', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'correo_electronico',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'correo_electronico', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="agregar_direccion"><?= $model->isNewRecord ? 'Agregar dirección' : 'Actualizar dirección' ?></label>
				<div class="input-group inline-block">
					<input size="45" maxlength="45" name="Agregar_direccion" id="agregar_direccion" value="1" type="checkbox">
				</div>
			</div>
		</div>
		<section class="proveedor-direccion">
			<div class="row col-md-12">
				<h4>Dirección</h4>
				<hr/>
			</div>

			<div class="row">
				<div class="form-group col-md-4 <?php if($form->error($direccion,'calle')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'calle', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($direccion,'calle',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
						<?php echo $form->error($direccion,'calle', array('class'=>'help-block')); ?>
					</div>
				</div>
				<div class="form-group col-md-4 <?php if($form->error($direccion,'numero_ext')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'numero_ext', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($direccion,'numero_ext',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
						<?php echo $form->error($direccion,'numero_ext', array('class'=>'help-block')); ?>
					</div>
				</div>
				<div class="form-group col-md-4 <?php if($form->error($direccion,'numero_int')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'numero_int', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($direccion,'numero_int',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
						<?php echo $form->error($direccion,'numero_int', array('class'=>'help-block')); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4 <?php if($form->error($direccion,'codigo_postal')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'codigo_postal', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($direccion,'codigo_postal',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
						<?php echo $form->error($direccion,'codigo_postal', array('class'=>'help-block')); ?>
					</div>
				</div>
				<div class="form-group col-md-4 <?php if($form->error($direccion,'colonia')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'colonia', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($direccion,'colonia',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
						<?php echo $form->error($direccion,'colonia', array('class'=>'help-block')); ?>
					</div>
				</div>
				<div class="form-group col-md-4 <?php if($form->error($direccion,'ciudad')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'ciudad', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($direccion,'ciudad',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
						<?php echo $form->error($direccion,'ciudad', array('class'=>'help-block')); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4 <?php if($form->error($direccion,'pais')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'pais', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($direccion,'pais',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
						<?php echo $form->error($direccion,'pais', array('class'=>'help-block')); ?>
					</div>
				</div>
			</div>
		</section>

		<section class="proveedor-materiales">
			<div class="row col-md-12">
				<h4>Materiales que provee</h4>
				<hr/>
			</div>
			<?php
				$tipoSuela = TiposArticulosInventario::model()->find('tipo=?', array('Suelas'));
				$tipoTacon = TiposArticulosInventario::model()->find('tipo=?', array('Tacones'));
				$tipoMateriales = TiposArticulosInventario::model()->find('tipo=?', array('Materiales'));

				$suelasSeleccionadas = array();
				$taconesSeleccionados = array();
				$materialesSeleccionados = array();
				foreach ($model->proveedorMateriales as $pMaterial) {

					if($pMaterial->id_tipos_articulos_inventario == $tipoSuela->id){
				 		array_push($suelasSeleccionadas, $pMaterial->id_articulo);
					}
					else if($pMaterial->id_tipos_articulos_inventario == $tipoTacon->id){
				 		array_push($taconesSeleccionados, $pMaterial->id_articulo);
					}
					else if($pMaterial->id_tipos_articulos_inventario == $tipoMateriales->id){
				 		array_push($materialesSeleccionados, $pMaterial->id_articulo);
					}
				}
			?>
			<div class="col-md-4">
				<h5>Suelas</h5>
				<hr/>
				<?php foreach ($suelas as $suela) { ?>
				<div class="form-group col-md-6">
					<label for="proveedor_suela_<?= $suela->id ?>"><?= $suela->nombre; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="Proveedor_suela[id_suela][<?= $suela->id; ?>]" id="proveedor_suela_<?= $suela->id ?>" value="1" type="checkbox" <?php if(in_array($suela->id, $suelasSeleccionadas)){echo "checked";} ?>>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-4">
				<h5>Tacones</h5>
				<hr/>
				<?php foreach ($tacones as $tacon) { ?>
				<div class="form-group col-md-6">
					<label for="proveedor_tacon_<?= $tacon->id ?>"><?= $tacon->nombre; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="Proveedor_tacon[id_tacon][<?= $tacon->id; ?>]" id="proveedor_tacon_<?= $tacon->id ?>" value="1" type="checkbox" <?php if(in_array($tacon->id, $taconesSeleccionados)){echo "checked";} ?>>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-4">
				<h5>Materiales</h5>
				<hr/>
				<?php foreach ($materiales as $material) { ?>
				<div class="form-group col-md-6">
					<label for="proveedor_material_<?= $material->id ?>"><?= $material->nombre; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="Proveedor_material[id_material][<?= $material->id; ?>]" id="proveedor_material_<?= $material->id ?>" value="1" type="checkbox" <?php if(in_array($material->id, $materialesSeleccionados)){echo "checked";} ?>>
					</div>
				</div>
				<?php } ?>
			</div>
		</section>

		<div class="form-group">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	$('#agregar_direccion').change(function(){
		if($(this).is(":checked")) {
            $('.proveedor-direccion').show(500);
        }
        else{
        	$('.proveedor-direccion').hide(500);
        }
	});
</script>