<?php 
$pendiente = true;
if(isset($mensaje) && !empty($mensaje) && isset($destino) && !empty($destino)){ 
	$pendiente = false;
	?>
	<script>
		alerta("<?php echo $mensaje ?>","<?php echo $titulo ?>","<?php echo $destino ?>");
	</script>
<?php } ?>
<?php if(isset($mensaje) && !empty($mensaje) && $pendiente) { ?>
	<script>
		alerta("<?php echo $mensaje ?>","<?php echo $titulo ?>");
	</script>
<?php } ?>