<?php
/* @var $this SuelasTaconesNumerosController */

$this->breadcrumbs=array(
	'Suelas Tacones Numeros'=>array('/suelasTaconesNumeros'),
	'Admin',
);
?>
<h1>Configurar número de tacones para cada número de suelas</h1>
<hr/>
<?php
$zapatosDiferentes = array();
$id_suela = 0;
$id_tacon = 0;
$contador = 0;
foreach ($suelas as $suela) {
	foreach ($suela->tacones as $tacon) {
		if(
			$suela->id != $id_suela ||
			$tacon->id != $id_tacon
		) {
			$contador++;
			$zapatosDiferentes[$contador]['id_suela'] = $suela->id;
			$zapatosDiferentes[$contador]['suela'] = $suela->nombre;
			$zapatosDiferentes[$contador]['id_tacon'] = $tacon->id;
			$zapatosDiferentes[$contador]['tacon'] = $tacon->nombre;
			$id_suela = $suela->id;
			$id_tacon = $tacon->id;
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
				<table class="table table-hover table-striped ordenes-pedido-table without-padding-table" id="table_configurar_numeros" summary="Tabla de configuracion de número de suela que lleva cada modelo.">
					<thead>
						<tr>
							<th>Suela</th>
							<th>Tacón</th>
							<?php for ($i=12; $i < 32 ; $i++) { ?>
							<th><?= $i ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody id="ordenes_table">
						<?php foreach ($zapatosDiferentes as $index => $row) { 
							$time = microtime();
							$time = str_replace(' ', '', $time);
							$time = str_replace('.', '', $time);
							$suelaNumeros = SuelasNumeros::model()->findAll('id_suelas=?', array($row['id_suela']));
							$numerosPosibles = array();
							foreach ($suelaNumeros as $suelaNumero) {
								array_push($numerosPosibles, $suelaNumero->numero);
							}
							?>
							<?php $rowOdd = (($index % 2)==0)?1:0; ?>
							<tr id="row_<?= $time ?>" class="<?= $rowOdd==1?'odd':'' ?>">
								<td class="suela" data-id="<?= $row['id_suela'] ?>">
									<?= $row['suela'] ?><input type="hidden" name="Configuracion[suela][<?= $time ?>]" value="<?= $row['id_suela'] ?>">
								</td>
								
								<td class="tacon" data-id="<?= $row['id_tacon'] ?>">
									<?= $row['tacon'] ?>
									<?php
										$taconNumeros = TaconesNumeros::model()->findAll('id_tacones=?', array($row['id_tacon']));
									?>
									
									<input type="hidden" name="Configuracion[tacon][<?= $time ?>]" value="<?= $row['id_tacon'] ?>">
								</td>
							
							<?php for ($i=12; $i < 32 ; $i++) { ?>
								<td data-numero="<?= $i; ?>">
								<?php if(in_array($i, $numerosPosibles)) { 
										$msn = SuelasTaconesNumeros::model()->with(
											array(
												'taconNumero.tacon'=>array(
													'alias'=>'tacon', 
													'condition'=>'tacon.id='.$row['id_tacon']
													),
												'suelaNumero'=>array(
													'alias'=>'suelaNumero',
													'condition'=>'suelaNumero.numero='.$i
													),
												'suelaNumero.suela'=>array(
													'alias'=>'suela',
													'condition'=>'suela.id='.$row['id_suela']
													),
												))->find();
									?>
									<select name="Configuracion[numeros][<?= $time ?>][<?= $i; ?>]">
										<?php foreach ($taconNumeros as $taconNumero) { ?>
											<option value="<?= $taconNumero->id ?>" <?php echo (isset($msn->taconNumero) && $msn->taconNumero->numero==$taconNumero->numero)?"selected":""; ?>><?= $taconNumero->numero ?></option>
										<?php } ?>
									</select>
								<?php }
								else { ?>
									<input class="input-cantidad" type="text" name="Configuracion[numeros][<?= $time ?>][<?= $i; ?>]" maxlength="3" style="width:20px;" disabled value='-' />
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