<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuarios-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<div class="form-body">
		<hr/>
		<div class="form-group <?php if($form->error($model,'usuario')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'usuario', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'usuario',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'usuario', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group <?php if($form->error($model,'contrasenia')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'contrasenia', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->passwordField($model,'contrasenia',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'contrasenia', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group <?php if($form->error($model,'confirmarContrasenia')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'confirmarContrasenia', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->passwordField($model,'confirmarContrasenia',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'confirmarContrasenia', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group <?php if($form->error($model,'id_perfiles_usuarios')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_perfiles_usuarios', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_perfiles_usuarios', PerfilesUsuarios::model()->obtenerPerfilesUsuarioDropDown(), array('class' => 'form-control',"empty"=>array(''=>"Seleccione una opci&oacute;n"))); ?>
					<?php echo $form->error($model,'id_perfiles_usuarios', array('class'=>'help-block')); ?>
				</div>
			</div>

		<div class="form-group">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->