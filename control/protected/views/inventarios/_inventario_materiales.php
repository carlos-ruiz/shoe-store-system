<div class="text-right">
    <?php echo CHtml::link('<i class="fa fa-plus"></i> Agregar material', array('inventarios/agregarMaterial'), array('class'=>'btn btn-red-stripped')); ?>
</div>
<br/>
<div class="panel panel-red">
    <div class="panel-heading">Inventario de materiales</div>
    <div class="panel-body">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Color</th>
                    <th>Unidad de medida</th>
                    <th>Existencia</th>
                    <th>Apartada</th>
                    <th>Precio</th>
                    <th>Cantidad mínima en bodega</th>
                </tr>
            </thead>
            <tbody>
                <?php if (sizeof($inventarioMateriales) < 1) { ?>
                    <tr>
                        <td colspan="3">Sin datos que mostrar</td>
                    </tr>
                <?php } ?>
                <?php foreach ($inventarioMateriales as $inventarioMaterial) { ?>
                    <tr>
                        <td><?= $inventarioMaterial->material->nombre ?></td>
                        <td><?= isset($inventarioMaterial->color)?$inventarioMaterial->color->color:'N/A' ?></td>
                        <td><?= $inventarioMaterial->material->unidad_medida ?></td>
                        <td><?= $inventarioMaterial->existencia ?></td>
                        <td><?= isset($inventarioMaterial->cantidad_apartada)?$inventarioMaterial->cantidad_apartada:0 ?></td>
                        <td><?= isset($inventarioMaterial->ultimo_precio)?$inventarioMaterial->ultimo_precio:0 ?></td>
                        <td><?= isset($inventarioMaterial->stock_minimo)?$inventarioMaterial->stock_minimo:0 ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>