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
					<?php echo $form->textField($model,'fecha_entrega',array('size'=>60,'maxlength'=>128, 'class'=>'form-control date-picker', 'data-date-format'=>'yyyy-mm-dd','data-date-language'=>'es')); ?>
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