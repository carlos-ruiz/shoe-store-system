<div class="text-right">
    <?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar insumo', array('inventarios/agregarInsumo'), array('class'=>'btn btn-red-stripped')); ?>
</div>
<br/>
<div class="panel panel-red">
<div class="panel-heading">Inventario de insumos</div>
    <div class="panel-body">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Insumo</th>
                    <th>Unidad de medida</th>
                    <th>Existencia</th>
                </tr>
            </thead>
            <tbody>
            	<?php if (sizeof($inventarioInsumos) < 1) { ?>
            		<tr>
            			<td colspan="3">Sin datos que mostrar</td>
            		</tr>
	            <?php } ?>
                <?php foreach ($inventarioInsumos as $inventarioInsumo) { ?>
                    <tr>
                        <td><?= $inventarioInsumo->insumo->nombre ?></td>
                        <td><?= $inventarioInsumo->insumo->unidad_medida ?></td>
                        <td><?= $inventarioInsumo->existencia ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>