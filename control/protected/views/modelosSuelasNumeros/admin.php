<?php
/* @var $this ModelosSuelasNumerosController */

$this->breadcrumbs=array(
	'Modelos Suelas Numeros'=>array('/modelosSuelasNumeros'),
	'Admin',
);
?>
<h1>Configurar número de suelas para cada número de modelo</h1>
<hr/>
<?php
$zapatosDiferentes = array();
$id_modelo = 0;
$id_suela = 0;
$contador = 0;
foreach ($modelos as $modelo) {
	foreach ($modelo->modelosSuelas as $modeloSuela) {
		if(
			$modelo->id != $id_modelo ||
			$modeloSuela->suela->id != $id_suela
		) {
			$contador++;
			$zapatosDiferentes[$contador]['id_modelo'] = $modelo->id;
			$zapatosDiferentes[$contador]['modelo'] = $modelo->nombre;
			$zapatosDiferentes[$contador]['id_suela'] = $modeloSuela->suela->id;
			$zapatosDiferentes[$contador]['suela'] = $modeloSuela->suela->nombre;
			$id_modelo = $modelo->id;
			$id_suela = $modeloSuela->suela->id;
		}
	}	
}
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'configurar-numeros-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<div class="row">
		<div class="panel panel-red panel-ordenes">
			<div class="panel-heading">Configurar números</div>
			<div class="panel-body">
				<table class="table table-hover table-striped ordenes-pedido-table without-padding-table table-bordered-tds" id="table_configurar_numeros" summary="Tabla de configuracion de número de suela que lleva cada modelo.">
					<thead>
						<tr>
							<th>Modelo</th>
							<th>Suela</th>
							<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
							<th><?php if(fmod($i ,1)==0){ echo $i;} else{echo "-";} ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody id="ordenes_table">
						<?php 
						$indice_valor = 0;
						foreach ($zapatosDiferentes as $index => $row) { 
							$time = $indice_valor++;
							$modeloNumeros = ModelosNumeros::model()->findAll('id_modelos=?', array($row['id_modelo']));
							$numerosPosibles = array();
							foreach ($modeloNumeros as $modeloNumero) {
								array_push($numerosPosibles, $modeloNumero->numero);
							}
							?>
							<?php $rowOdd = (($index % 2)==0)?1:0; ?>
							<tr id="row_<?= $time ?>" class="<?= $rowOdd==1?'odd':'' ?>">
								<td class="modelo" data-id="<?= $row['id_modelo'] ?>">
									<?= $row['modelo'] ?><input type="hidden" name="Configuracion[modelo][<?= $time ?>]" value="<?= $row['id_modelo'] ?>">
								</td>
								
								<td class="suela" data-id="<?= $row['id_suela'] ?>">
									<?= $row['suela'] ?>
									<?php
										$suelaNumeros = SuelasNumeros::model()->findAll('id_suelas=?', array($row['id_suela']));
									?>
									
									<input type="hidden" name="Configuracion[suela][<?= $time ?>]" value="<?= $row['id_suela'] ?>">
								</td>
							
							<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
								<td data-numero="<?= $i; ?>">
								<?php if(in_array($i, $numerosPosibles)) { 
										$msn = ModelosSuelasNumeros::model()->with(
											array(
												'suelaNumero.suela'=>array(
													'alias'=>'suela', 
													'condition'=>'suela.id='.$row['id_suela']
													),
												'modeloNumero'=>array(
													'alias'=>'modeloNumero',
													'condition'=>'modeloNumero.numero='.$i
													),
												'modeloNumero.modelo'=>array(
													'alias'=>'modelo',
													'condition'=>'modelo.id='.$row['id_modelo']
													),
												))->find();
									?>
									<select name="Configuracion[numeros][<?= $time ?>][<?= $i; ?>]">
										<?php foreach ($suelaNumeros as $suelaNumero) { ?>
											<option value="<?= $suelaNumero->id ?>" <?php echo (isset($msn->suelaNumero) && $msn->suelaNumero->numero==$suelaNumero->numero)?"selected":""; ?>><?= $suelaNumero->numero ?></option>
										<?php } ?>
									</select>
								<?php }
								else { ?>
									--
								<?php } ?>
								</td>
							<?php } ?>
							</tr>
						<?php }	?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group">
			<?php echo CHtml::submitButton('Guardar cambios', array('class'=>'btn btn-red-stripped', 'onclick'=>'mostrarCargando();')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<div class="loading-panel">
	<div class="loading-gif">
		<img src="<?= Yii::app()->request->baseUrl ?>/images/icons/loading_red.gif">
		<h4>Cargando, por favor espere...</h4>
	</div>
</div>

<script type="text/javascript">
	function mostrarCargando() {
		width = $('.loading-gif').outerWidth();
		height = $('.loading-gif').outerHeight();
		windowHeight = $( window ).height();
		alto = (windowHeight-height)/2;
		left = ($('#wrapper').width()-width)/2;
		
		$('.loading-gif').css('top',alto);
		$('.loading-gif').css('left',left);
		$('.loading-panel').show(500);
	}
</script>