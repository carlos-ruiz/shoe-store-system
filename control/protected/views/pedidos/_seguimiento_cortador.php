<?php
	// consulta de agrupacion
	// SELECT z.id_modelos, z.id_colores, z.numero, sum(pz.cantidad_total) FROM pedidos_zapatos pz INNER JOIN zapatos z ON pz.id_zapatos=z.id group by z.id_modelos, z.id_colores, z.numero
	// $cortes = PedidosZapatos::model()->with(array(
	// 	'zapato'=>array(
	// 		'alias'=>'z',
	// 		)
	// 	))->findAll(array(
	// 	'select'=>'*, sum(cantidad_total) AS totalsumado',
	// 	'group'=>'z.id_modelos, z.id_colores, z.numero',
	// 	));

	$sql="SELECT z.id_modelos, z.id_colores, z.numero, sum(pz.cantidad_total) AS total, sum(completos) AS completos FROM pedidos_zapatos pz INNER JOIN zapatos z ON pz.id_zapatos=z.id group by z.id_modelos, z.id_colores, z.numero";
	$cortes=Yii::app()->db->createCommand($sql)->queryAll();

	$cortes_diferentes = array();

	$id_modelo = 0;
	$id_color = 0;
	$indice = 0;

	foreach ($cortes as $corte) {
		if($corte['id_modelos'] != $id_modelo || $corte['id_colores'] != $id_color){
			$indice++;
			$modelo = Modelos::model()->findByPk($corte['id_modelos']);
			$color = Colores::model()->findByPk($corte['id_colores']);
			$cortes_diferentes[$indice]['id_modelo'] = $corte['id_modelos']; 
			$cortes_diferentes[$indice]['modelo'] = $modelo->nombre;
			$cortes_diferentes[$indice]['id_color'] = $corte['id_colores'];
			$cortes_diferentes[$indice]['color'] = $color->color; 
			$id_modelo = $corte['id_modelos'];
			$id_color = $corte['id_colores'];
		}
		$cortes_diferentes[$indice][''.$corte['numero']] = $corte['total']-$corte['completos'];
	}
?>
<div class="panel panel-red">
    <div class="panel-heading">Tabla de Cortes</div>
    <div class="panel-body">
        <table class="table table-hover table-bordered tabla-seguimiento-pedido-cortador">
            <thead>
                <tr>
                    <th>Modelo</th>
                    <th>Color</th>
                    <?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
					<th><?php if(fmod($i ,1)==0){ echo $i;} else{echo "-";} ?></th>
					<?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cortes_diferentes as $i => $corte) { ?>
                	<tr>
                		<td><?= $corte['modelo'] ?></td>
                		<td><?= $corte['color'] ?></td>
                		<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
						<?php if(isset($corte[''.$i])){ ?>
							<td><button data-modelo="<?= $corte['id_modelo'] ?>" data-color="<?= $corte['id_color'] ?>" data-numero="<?= $i ?>"><?= $corte[''.$i] ?></button></td>
						<?php } else { ?>
							<td></td>
						<?php } ?>
					<?php } ?>
                	</tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
	$('button').click(function(){
		modelo = $(this).data('modelo');
		color = $(this).data('color');
		numero = $(this).data('numero');
		alert('modelo: '+modelo+'color: '+color+'numero: '+numero);
	});
</script>