<?php
/* @var $this ZapatosController */
/* @var $model Zapatos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'zapatos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<hr/>
		<div class="row">
			<div class="form-group col-md-4 <?php if($form->error($model,'id_modelos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_modelos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptions = array(
							"class" => "form-control",
							"empty"=>"Seleccione una opci&oacute;n",
						);
					?>
					<?php echo $form->dropDownList($model,'id_modelos',Modelos::model()->obtenerModelos(), $htmlOptions); ?>
					<?php echo $form->error($model,'id_modelos', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'id_colores')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_colores', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_colores',Modelos::model()->obtenerColores(isset($model->id_modelos)?$model->id_modelos:0), $htmlOptions); ?>
					<?php echo $form->error($model,'id_colores', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'numero')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'numero', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'numero',Modelos::model()->obtenerNumeros(isset($model->id_modelos)?$model->id_modelos:0), $htmlOptions); ?>
					<?php echo $form->error($model,'numero', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4 <?php if($form->error($model,'id_suelas')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_suelas', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_suelas',Modelos::model()->obtenerSuelas(isset($model->id_modelos)?$model->id_modelos:0), $htmlOptions); ?>
					<?php echo $form->error($model,'id_suelas', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'precio')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'precio', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'precio',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'precio', array('class'=>'help-block')); ?>
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
		jQuery('body').on('change','#Zapatos_id_modelos',function(){
			jQuery.ajax({'url':'/controlbom/control/zapatos/coloresPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#Zapatos_id_colores").html(html)}});
			jQuery.ajax({'url':'/controlbom/control/zapatos/suelasPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#Zapatos_id_suelas").html(html)}});
			jQuery.ajax({'url':'/controlbom/control/zapatos/numerosPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#Zapatos_numero").html(html)}});
			return false;
		});
	});
</script>