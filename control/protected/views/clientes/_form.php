<?php
/* @var $this ClientesController */
/* @var $model Clientes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clientes-form',
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
			<div class="form-group col-md-4 <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'apellido_paterno')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'apellido_paterno', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'apellido_paterno',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'apellido_paterno', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'apellido_materno')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'apellido_materno', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'apellido_materno',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'apellido_materno', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>

		<div class="row">
			<!-- <div class="form-group col-md-4 <?php if($form->error($model,'id_tipo_cliente')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_tipo_cliente', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_tipo_cliente', TipoCliente::model()->obtenerTiposCliente(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
					<?php echo $form->error($model,'id_tipo_cliente', array('class'=>'help-block')); ?>
				</div>
			</div> -->
			
			<div class="form-group col-md-4 <?php if($form->error($model,'rfc')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'rfc', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'rfc',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'rfc', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'razon_social')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'razon_social', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'razon_social',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'razon_social', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'correo_electronico')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'correo_electronico', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'correo_electronico',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'correo_electronico', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-4 <?php if($form->error($model,'telefono')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'telefono', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'telefono',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'telefono', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'celular')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'celular', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'celular',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'celular', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>

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

		<div class="form-group">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->