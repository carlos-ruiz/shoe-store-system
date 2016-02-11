<?php

class PedidosController extends Controller
{
	public $section = 'pedidos';
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			// array('allow', // allow authenticated user to perform 'create' and 'update' actions
			// 	'actions'=>array('create','update'),
			// 	'users'=>array('@'),
			// ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update', 'admin','delete', 'obtenerModelos', 'suelasPorModelo', 'coloresPorModelo', 'numerosPorModelo', 'agregarOrden','descuentoPorCliente', 'coloresPorSuela', 'revisarSiTieneAgujetas', 'coloresPorAgujeta', 'coloresPorOjillo', 'materialesPredeterminados'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Pedidos;
		$model->fecha_pedido = date('d-m-Y H:i:s');
		$model->total = 0.0;
		$pedidoZapato = new PedidosZapatos;
		$estatusPedido = EstatusPedidos::model()->find('nombre=?', array('Pendiente'));
		$model->id_estatus_pedidos = $estatusPedido->id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pedidos']))
		{
			// print_r($_POST);
			// return;
			// $transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Pedidos'];
				$prioridad = $_POST['Pedidos']['prioridad'];
				$formaDePagoSeleccionada = $model->id_formas_pago;
				$model->prioridad = 'NORMAL';
				if($prioridad == 1){
					$model->prioridad = 'ALTA';
				}
				$date = str_replace('/', '-', $model->fecha_entrega);
				$newDate = date("Y-m-d", strtotime($date));
			
				$model->fecha_entrega = $newDate;
				$newDate = date("Y-m-d H:i:s", strtotime($model->fecha_pedido));
				$model->fecha_pedido = $newDate;
				$total = 0;
				$pagado = 0;
				if(isset($_POST['Pedidos']['pagado'])){
					$pagado = $_POST['Pedidos']['pagado'];
					if($pagado > 0 && $pagado < $_POST['Pedidos']['total']){
						$formaDePago = FormasPago::model()->find('nombre=? AND activo=1', array('Crédito'));
						if (isset($formaDePago)) {
							$model->id_formas_pago = $formaDePago->id;
						}
						$estatusDePago = EstatusPagos::model()->find('nombre=?', array('Pago parcial'));
					}
					else if ($pagado <= 0) {
						$estatusDePago = EstatusPagos::model()->find('nombre=?', array('Pendiente de pago'));	
					}
					else{
						$estatusDePago = EstatusPagos::model()->find('nombre=?', array('Pagado'));
					}
				}else{
					$estatusDePago = EstatusPagos::model()->find('nombre=?', array('Pendiente de pago'));
				}
				$model->estatus_pagos_id = $estatusDePago->id;
				if($model->save()){
					if (isset($_POST['Pedido'])) {
						$datosPedido = $_POST['Pedido'];
						foreach ($datosPedido['modelo'] as $id => $value) {
							foreach ($datosPedido['numeros'][$id] as $numero => $cantidad) {
								if (isset($cantidad) && $cantidad > 0) {
									$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($datosPedido['modelo'][$id], $datosPedido['color'][$id]));
									
									$zapato = Zapatos::model()->find('numero=? AND id_suelas_colores=? AND id_modelos=? AND id_colores=?', array($numero, $datosPedido['suelacolor'][$id], $modeloColor->id_modelos, $modeloColor->id_colores));
									$precioZapato = isset($zapato)?$zapato->precio:0;
									if (isset($datosPedido['agujetas'][$id])) {
										$zapatoConAgujeta = Zapatos::model()->find('numero=? AND id_suelas_colores=? AND id_modelos=? AND id_colores=? AND id_agujetas_colores=? AND id_ojillos_colores=?', array($numero, $datosPedido['suelacolor'][$id], $modeloColor->id_modelos, $modeloColor->id_colores, $datosPedido['agujetascolor'][$id], $datosPedido['colorojillos'][$id]));
										$zapato = $zapatoConAgujeta;
									}
	
									if (!isset($zapato)) {
										$zapato = new Zapatos;
										$zapato->numero = $numero;
										$zapato->precio = $precioZapato;
										$numeroCodigo = str_replace('.', '', $numero);
										$zapato->codigo_barras = sprintf('%03d',$modeloColor->id_modelos).sprintf('%03d', $datosPedido['suelacolor'][$id]).sprintf('%03d',$modeloColor->id_colores).sprintf('%03d', $numeroCodigo);
										$zapato->id_modelos = $modeloColor->id_modelos;
										$zapato->id_colores = $modeloColor->id_colores;
										$zapato->id_suelas_colores = $datosPedido['suelacolor'][$id];
										if (isset($datosPedido['agujetas'][$id])) {
											$zapato->id_agujetas_colores = $datosPedido['agujetascolor'][$id];
											$zapato->id_ojillos_colores = $datosPedido['colorojillos'][$id];
										}
										$zapato->save();
									}
									$pedidoZapato = new PedidosZapatos;
									$pedidoZapato->id_pedidos = $model->id;
									$pedidoZapato->id_zapatos = $zapato->id;
									$pedidoZapato->cantidad_total = $cantidad;
									$estatusZapato = EstatusZapatos::model()->find('nombre=?', array('Pendiente'));
									$pedidoZapato->id_estatus_zapatos = $estatusZapato->id;
									$pedidoZapato->completos = 0;
									$pedidoZapato->precio_unitario = $zapato->precio;
									if(isset($datosPedido['especiales'][$id])){
										$pedidoZapato->caracteristicas_especiales = $datosPedido['especiales'][$id];
									}
									$pedidoZapato->save();
									$total += $pedidoZapato->precio_unitario * $cantidad;
								}
							}
						}
						if($total > 0){
							if(isset($model->cliente->descuento) && $model->cliente->descuento > 0){
								$total = $total*(1-$model->cliente->descuento/100);
							}
							if(isset($model->descuento) && $model->descuento > 0){
								$total = $total*(1-$model->descuento/100);
							}
							$model->total = $total;
							if($pagado > 0){
								$pago = new Pagos;
								$pago->fecha = date('d-m-Y H:i:s');
								$pago->descripcion = 'Pago inicial';
								$pago->id_pedidos = $model->id;
								$pago->id_formas_pago = $formaDePagoSeleccionada;
								$pago->importe = $pagado;
								if ($pagado > $model->total) {
									$pago->importe = $model->total;
									$cambio = $pagado - $model->total;
									echo "<script>alert('$cambio');</script>";
								}
								$pago->save();
							}
							$model->save();
						}
					}
					$this->actualizarInventarios($model);
					// $transaction->commit();
					return;
					$this->redirect(array('view','id'=>$model->id));
				}
			}catch(Exception $ex){
				print_r($ex);
				// $transaction->rollback();
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'pedidoZapato'=>$pedidoZapato,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$pedidoZapato = new PedidosZapatos;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pedidos']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Pedidos'];

				foreach ($model->pedidosZapatos as $pedidoZapato) {
					$pedidoZapato->delete();
				}

				$prioridad = $_POST['Pedidos']['prioridad'];
				$model->prioridad = 'NORMAL';
				if($prioridad == 1){
					$model->prioridad = 'ALTA';
				}
				$formaDePagoSeleccionada = $model->id_formas_pago;
				$date = str_replace('/', '-', $model->fecha_entrega);
				$newDate = date("Y-m-d", strtotime($date));
			
				$model->fecha_entrega = $newDate;
				$newDate = date("Y-m-d H:i:s", strtotime($model->fecha_pedido));
				$model->fecha_pedido = $newDate;
				$total = 0;
				
				if($model->save()){
					if (isset($_POST['Pedido'])) {
						$datosPedido = $_POST['Pedido'];
						foreach ($datosPedido['modelo'] as $id => $value) {
							foreach ($datosPedido['numeros'][$id] as $numero => $cantidad) {
								if (isset($cantidad) && $cantidad > 0) {
									$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($datosPedido['modelo'][$id], $datosPedido['color'][$id]));
									
									$zapato = Zapatos::model()->find('numero=? AND id_suelas_colores=? AND id_modelos=? AND id_colores=?', array($numero, $datosPedido['suelacolor'][$id], $modeloColor->id_modelos, $modeloColor->id_colores));
	
									if (!isset($zapato)) {
										$zapato = new Zapatos;
										$zapato->numero = $numero;
										$zapato->precio = 0;
										$numeroCodigo = str_replace('.', '', $numero);
										$zapato->codigo_barras = sprintf('%03d',$modeloColor->id_modelos).sprintf('%03d', $datosPedido['suelacolor'][$id]).sprintf('%03d',$modeloColor->id_colores).sprintf('%03d', $numeroCodigo);
										$zapato->id_modelos = $modeloColor->id_modelos;
										$zapato->id_colores = $modeloColor->id_colores;
										$zapato->id_suelas_colores = $datosPedido['suelacolor'][$id];
										$zapato->save();
									}
									$pedidoZapato = new PedidosZapatos;
									$pedidoZapato->id_pedidos = $model->id;
									$pedidoZapato->id_zapatos = $zapato->id;
									$pedidoZapato->cantidad_total = $cantidad;
									$estatusZapato = EstatusZapatos::model()->find('nombre=?', array('Pendiente'));
									$pedidoZapato->id_estatus_zapatos = $estatusZapato->id;
									$pedidoZapato->completos = 0;
									$pedidoZapato->precio_unitario = $zapato->precio;
									if(isset($datosPedido['especiales'][$id])){
										$pedidoZapato->caracteristicas_especiales = $datosPedido['especiales'][$id];
									}
									$pedidoZapato->save();
									$total += $pedidoZapato->precio_unitario * $cantidad;
								}
							}
						}
						if($total > 0){
							if(isset($model->cliente->descuento) && $model->cliente->descuento > 0){
								$total = $total*(1-$model->cliente->descuento/100);
							}
							if(isset($model->descuento) && $model->descuento > 0){
								$total = $total*(1-$model->descuento/100);
							}
							$model->total = $total;
							$model->save();

							$pagado = 0;
							if (isset($_POST['Pedidos']['pagado'])) {
								$pagado = $_POST['Pedidos']['pagado'];
								if ($pagado > 0){
									if($pagado >= $model->obtenerAdeudo()) {
										$estatusDePago = EstatusPagos::model()->find('nombre=?', array('Pagado'));
									}
									else{
										$estatusDePago = EstatusPagos::model()->find('nombre=?', array('Pago parcial'));
										$formaDePago = FormasPago::model()->find('nombre=? AND activo=1', array('Crédito'));
										$model->id_formas_pago = $formaDePago->id;
									}
									$model->estatus_pagos_id = $estatusDePago->id;
									$model->save();
									$pago = new Pagos;
									$pago->fecha = date('d-m-Y H:i:s');
									$pago->descripcion = 'Pago adicional';
									$pago->id_pedidos = $model->id;
									$pago->id_formas_pago = $formaDePagoSeleccionada;
									$pago->importe = $pagado;
									if ($pagado > $model->total) {
										$pago->importe = $model->total;
										$cambio = $pagado - $model->total;
										echo "<script>alert('$cambio');</script>";
									}
									$pago->save();

								}
							}
							if($model->obtenerAdeudo() < 0){
								$pagoCambio = new Pagos;
								$pagoCambio->fecha = date('d-m-Y H:i:s');
								$pagoCambio->descripcion = 'Cambio';
								$pagoCambio->id_pedidos = $model->id;
								$pagoCambio->id_formas_pago = $formaDePagoSeleccionada;
								$pagoCambio->importe = $model->obtenerAdeudo();
								$pagoCambio->save();
								$estatusDePago = EstatusPagos::model()->find('nombre=?', array('Pagado'));
								$model->estatus_pagos_id = $estatusDePago->id;
								$model->save();
							}
						}
					}
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
			}catch(Exception $ex){
				$transaction->rollback();
				$mensaje = "Se ha producido un error inesperado.";
				$titulo = "Error";
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'pedidoZapato'=>$pedidoZapato,
		));
		$this->renderPartial('/layouts/_modal-alert', array('mensaje'=>isset($mensaje)?$mensaje:"", 'titulo'=>isset($titulo)?$titulo:""));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$transaction = Yii::app()->db->beginTransaction();
		try{
			foreach ($model->pedidosZapatos as $pedidoZapato) {
				$pedidoZapato->delete();
			}
			$model->delete();
			$transaction->commit();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])){
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}catch(Exception $ex){
			$transaction->rollback();
		}

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pedidos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pedidos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pedidos']))
			$model->attributes=$_GET['Pedidos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pedidos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pedidos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pedidos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pedidos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSuelasPorModelo()
	{
		$list = ModelosSuelas::model()->findAll("id_modelos=?",array($_POST["PedidosZapatos"]["id_modelos"]));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($list as $i => $data){
			echo "<option value=\"{$data->suela->id}\"".($i==0?'selected':'').">{$data->suela->nombre}</option>";
		}
	}

	public function actionColoresPorModelo()
	{
		$list = ModelosColores::model()->findAll("id_modelos=?",array($_POST["PedidosZapatos"]["id_modelos"]));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($list as $i => $data)
			echo "<option value=\"{$data->color->id}\"".($i==0?'selected':'').">{$data->color->color}</option>";
	}

	public function actionNumerosPorModelo()
	{
		$list = ModelosNumeros::model()->findAll("id_modelos=?",array($_POST["PedidosZapatos"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->id}\">{$data->numero}</option>";
	}

	public function actionColoresPorSuela()
	{
		$list = SuelasColores::model()->findAll("id_suelas=?",array($_POST["PedidosZapatos"]["id_suelas"]));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($list as $i => $data)
			echo "<option value=\"{$data->color->id}\"".($i==0?'selected':'').">{$data->color->color}</option>";
	}

	public function actionRevisarSiTieneAgujetas()
	{
		$id_modelo = $_POST['PedidosZapatos']['id_modelos'];
		$modelo = Modelos::model()->findByPk($id_modelo);
		$materialAgujeta = Materiales::model()->find('nombre=?', array('Agujetas'));
		$materialOjillos = Materiales::model()->find('nombre=?', array('Ojillos'));
		$modeloMaterial = ModelosMateriales::model()->find('id_modelos=? AND (id_materiales=? OR id_materiales=? )', array($modelo->id, $materialAgujeta->id, $materialOjillos->id));
		if (isset($modeloMaterial)) {
			echo 'true';
		}else{
			echo 'false';
		}
	}

	public function actionColoresPorAgujeta()
	{
		$id_agujeta = $_POST['PedidosZapatos']['id_agujetas'];
		$agujetaColores = AgujetasColores::model()->findAll('id_agujetas=?', array($id_agujeta));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($agujetaColores as $i => $data)
			echo "<option value=\"{$data->color->id}\"".($i==0?'selected':'').">{$data->color->color}</option>";
	}

	public function actionColoresPorOjillo()
	{
		$id_ojillo = $_POST['PedidosZapatos']['id_ojillos'];
		$ojillosColores = OjillosColores::model()->findAll('id_ojillos=?', array($id_ojillo));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($ojillosColores as $i => $data)
			echo "<option value=\"{$data->color->id}\"".($i==0?'selected':'').">{$data->color->color}</option>";
	}

	public function actionAgregarOrden()
	{
		if (isset($_POST)) {
			// print_r($_POST);
			// return;
			$modelo = Modelos::model()->findByPk($_POST['id_modelos']);
			$color = Colores::model()->findByPk($_POST['id_colores']);
			$suela = Suelas::model()->findByPk($_POST['id_suelas']);

			$rows = $_POST['row'];
			$rows++;
			$rowOdd = (($rows % 2)==0)?1:0;
			// echo $rows;
			// return;

			$tieneAgujetas = false;
			if(isset($_POST['id_agujetas'])){
				$tieneAgujetas = true;
				$agujetas = Agujetas::model()->findByPk($_POST['id_agujetas']);
				$agujetasColor = AgujetasColores::model()->find('id_agujetas=? AND id_colores=?', array($agujetas->id, $_POST['id_color_agujetas']));
				$ojillos = Ojillos::model()->findByPk($_POST['id_ojillos']);
				$ojillosColor = OjillosColores::model()->find('id_ojillos=? AND id_colores=?', array($ojillos->id, $_POST['id_color_ojillos']));
			}

			$suelaColor = SuelasColores::model()->find('id_suelas=? AND id_colores=?', array($suela->id, $_POST['id_color_suela']));
			$modeloNumeros = ModelosNumeros::model()->findAll('id_modelos=?', array($modelo->id));
			$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($modelo->id, $color->id));

			$numerosPosibles = array();
			foreach ($modeloNumeros as $modeloNumero) {
				array_push($numerosPosibles, $modeloNumero->numero);
			}
			$zapatosConPrecio = ZapatoPrecios::model()->findAll('id_modelos=? AND id_suelas=?', array($modelo->id, $suela->id));
			if (!isset($zapatosConPrecio) || sizeof($zapatosConPrecio)<1) {
				echo "<script>alert(\"No ha definido los precios del modelo $modelo->nombre con la suela $suela->nombre\");</script>";
				return;
			}
			
			$time = microtime();
			$time = str_replace(' ', '', $time);
			$time = str_replace('.', '', $time);
			?>
			<tr id="row_<?= $time ?>" class="<?= $rowOdd==1?'odd':'' ?>">
				<td class="modelo" data-id="<?= $modelo->id ?>"><?= $modelo->nombre; ?><input type="hidden" name="Pedido[modelo][<?= $time ?>]" value="<?= $modelo->id ?>"></td>
				<td class="color" data-id="<?= $color->id ?>"><?= $color->color; ?><input type="hidden" name="Pedido[color][<?= $time ?>]" value="<?= $color->id ?>"></td>
				<td class="suela" data-id="<?= $suela->id ?>"><?= $suela->nombre; ?><input type="hidden" name="Pedido[suela][<?= $time ?>]" value="<?= $suela->id ?>"></td>
				<td class="colorsuela" data-id="<?= $suelaColor->id ?>"><?= $suelaColor->color->color; ?><input type="hidden" name="Pedido[suelacolor][<?= $time ?>]" value="<?= $suelaColor->id ?>"></td>

				<?php if($tieneAgujetas){ ?>
				<td class="agujeta" data-id="<?= $agujetas->id ?>"><?= $agujetas->nombre; ?><input type="hidden" name="Pedido[agujetas][<?= $time ?>]" value="<?= $agujetas->id ?>"></td>
				<td class="coloragujetas" data-id="<?= $agujetasColor->id ?>"><?= $agujetasColor->color->color; ?><input type="hidden" name="Pedido[agujetascolor][<?= $time ?>]" value="<?= $agujetasColor->id ?>"></td>
				<td class="ojillos" data-id="<?= $ojillos->id ?>"><?= $ojillos->nombre; ?><input type="hidden" name="Pedido[ojillos][<?= $time ?>]" value="<?= $ojillos->id ?>"></td>
				<td class="colorojillos" data-id="<?= $ojillosColor->id ?>"><?= $ojillosColor->color->color; ?><input type="hidden" name="Pedido[colorojillos][<?= $time ?>]" value="<?= $ojillosColor->id ?>"></td>
				<?php } else{ ?>
				<td class="agujeta">N/A</td>
				<td class="coloragujetas">N/A</td>
				<td class="ojillos">N/A</td>
				<td class="colorojillos">N/A</td>
				<?php } ?>

			
			<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
				<td data-numero="<?= $i; ?>">
					<input class="input-cantidad" type="text" name="Pedido[numeros][<?= $time ?>][<?= $i; ?>]" maxlength="3" style="width:20px;" <?php if(!in_array($i, $numerosPosibles)) {echo "disabled value='X'";}else{echo "value=''";} ?>/>
				</td>
			<?php } ?>
				<td>
					<a data-row="<?= $time ?>" class="delete" title="Borrar" href="javascript:void(0);"><img src="/controlbom/control/images/icons/delete.png" alt="Borrar"></a>
				</td>
			</tr>

			<?php if (isset($_POST['especial']) && strlen($_POST['especial']) > 0) { ?>
				<tr class="row_<?= $time ?> especial <?= $rowOdd==1?'odd':'' ?>">
					<td  class="td-caracteristicas-especiales" colspan="46">
						<?= $_POST['especial'] ?>
						<input type="hidden" name="Pedido[especiales][<?= $time ?>]" value="<?= $_POST['especial'] ?>">
					</td>
					<td colspan="2">
						<a data-row="<?= $time ?>" class="quitar-especial" title="Quitar" href="javascript:void(0);"><img src="/controlbom/control/images/icons/delete.png" alt="Quitar">Quitar</a>
					</td>
				</tr>
			<?php } ?>
<?php		}
	}

	public function actionDescuentoPorCliente()
	{
		$id_clientes = $_POST['Pedidos']['id_clientes'];
		$cliente = Clientes::model()->findByPk($id_clientes);
		echo $cliente->descuento;
	}

	public function calcularAdeudo($data, $row)
	{
		$adeudo = $data->total;
		$pagos = Pagos::model()->findAll('id_pedidos=?', array($data->id));
		if (isset($pagos) && sizeof($pagos) > 0) {
			foreach ($pagos as $pago) {
				$adeudo = $adeudo - $pago->importe;
			}
		}
		return '$'.number_format($adeudo, 2, '.', '');
	}

	public function actualizarInventarios($pedido)
	{
		// Aqui se va a hacer todo el descuento de materiales, suelas, etc.
		foreach ($pedido->pedidosZapatos as $pedidoZapato) {
			$cantidad_pares = $pedidoZapato->cantidad_total;
			$numero_zapato = $pedidoZapato->zapato->numero;
			$modelo = Modelos::model()->findByPk($pedidoZapato->zapato->id_modelos);
			$cantidad_ojillos = 0;
			$cantidad_agujetas = 0;

			// Agregar a apartados los materiales
			foreach ($modelo->modelosMateriales as $modeloMaterial) {
				$cantidad_a_descontar = 0;
				unset($materialApartado);
				if ($numero_zapato >= 12 && $numero_zapato < 18) {
					$cantidad_a_descontar = $modeloMaterial->cantidad_extrachico;
				}
				elseif ($numero_zapato >= 18 && $numero_zapato < 22) {
					$cantidad_a_descontar = $modeloMaterial->cantidad_chico;
				}
				elseif ($numero_zapato >= 22 && $numero_zapato < 25) {
					$cantidad_a_descontar = $modeloMaterial->cantidad_mediano;
				}
				elseif ($numero_zapato >= 25 && $numero_zapato < 32) {
					$cantidad_a_descontar = $modeloMaterial->cantidad_grande;
				}
				$cantidad_a_descontar = $cantidad_a_descontar*$cantidad_pares;
				if ($modeloMaterial->material->nombre == 'Ojillos') {
					$cantidad_ojillos = $cantidad_a_descontar;
					continue;
				}
				else if ($modeloMaterial->material->nombre == 'Agujetas') {
					$cantidad_agujetas = $cantidad_a_descontar;
					continue;
				}

				$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?', array('Materiales'));
				$materialTieneColores = (MaterialesColores::model()->count('id_materiales=?', array($modeloMaterial->id_materiales)) > 0)?true:false;
				if($materialTieneColores){
					$materialApartado = MaterialesApartadosPedido::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_pedidos=? AND id_colores=?', array($tipoArticulo->id, $modeloMaterial->id_materiales, $pedido->id, $pedidoZapato->zapato->id_colores));
				}
				if(!isset($materialApartado)){
					$materialApartado = MaterialesApartadosPedido::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_pedidos=?', array($tipoArticulo->id, $modeloMaterial->id_materiales, $pedido->id));
				}
				if(!isset($materialApartado)){
					$materialApartado = new MaterialesApartadosPedido;
					$materialApartado->id_tipos_articulos_inventario = $tipoArticulo->id;
					$materialApartado->id_articulo = $modeloMaterial->id_materiales;
					if($materialTieneColores){
						$materialApartado->id_colores = $pedidoZapato->zapato->id_colores;
					}
					$materialApartado->id_pedidos = $pedido->id;
					$materialApartado->cantidad_apartada = 0;
				}
				$materialApartado->cantidad_apartada += $cantidad_a_descontar;
				$materialApartado->fecha_actualizacion = date('Y-m-d H:i:s');
				$materialApartado->save();
				$varImprimir = 'MaterialApartadoID: '.$materialApartado->id.' - cantidad_a_descontar = '.$cantidad_a_descontar.' - cantidad_apartada = '.$materialApartado->cantidad_apartada;
				echo "<script>console.log($varImprimir);</script>";
				echo $varImprimir;
			} // Fin foreach modelosMateriales

			// Agregar a apartados las suelas
			$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?', array('Suelas'));
			$modeloNumero = ModelosNumeros::model()->find('id_modelos=? AND numero=?', array($modelo->id, $numero_zapato));
			$modeloSuelaNumero = ModelosSuelasNumeros::model()->with(array('suelaNumero.suela'=>array('alias'=>'suela')))->find('id_modelos_numeros=? AND suela.id=?', array($modeloNumero->id, $pedidoZapato->zapato->suelaColor->id_suelas));
			$numero_suela = $modeloSuelaNumero->suelaNumero->numero;
			$suelasApartadas = MaterialesApartadosPedido::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_pedidos=? AND id_colores=? AND numero=?', array($tipoArticulo->id, $pedidoZapato->zapato->suelaColor->id_suelas, $pedido->id, $pedidoZapato->zapato->suelaColor->id_colores, $numero_suela));
			if (!isset($suelasApartadas)) {
				$suelasApartadas = new MaterialesApartadosPedido;
				$suelasApartadas->id_tipos_articulos_inventario = $tipoArticulo->id;
				$suelasApartadas->id_articulo = $pedidoZapato->zapato->suelaColor->id_suelas;
				$suelasApartadas->id_colores = $pedidoZapato->zapato->suelaColor->id_colores;
				$suelasApartadas->numero = $numero_suela;
				$suelasApartadas->id_pedidos = $pedido->id;
			}
			$suelasApartadas->cantidad_apartada += $cantidad_pares;
			$suelasApartadas->fecha_actualizacion = date('Y-m-d H:i:s');
			$suelasApartadas->save();

			// Apartar agujetas
			if (isset($pedidoZapato->zapato->agujetaColor)) {
				$agujetaColor = $pedidoZapato->zapato->agujetaColor;
				$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?', array('Agujetas'));
				$agujetasApartadas = MaterialesApartadosPedido::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_pedidos=? AND id_colores=?', array($tipoArticulo->id, $agujetaColor->id_agujetas, $pedido->id, $agujetaColor->id_colores));
				if (!isset($agujetasApartadas)) {
					$agujetasApartadas = new MaterialesApartadosPedido;
					$agujetasApartadas->id_tipos_articulos_inventario = $tipoArticulo->id;
					$agujetasApartadas->id_articulo = $agujetaColor->id_agujetas;
					$agujetasApartadas->id_colores = $agujetaColor->id_colores;
					$agujetasApartadas->id_pedidos = $pedido->id;
				}
				$agujetasApartadas->cantidad_apartada += $cantidad_agujetas;
				$agujetasApartadas->fecha_actualizacion = date('Y-m-d H:i:s');
				$agujetasApartadas->save();
			}

			// Apartar ojillos
			if (isset($pedidoZapato->zapato->ojilloColor)) {
				$materialOjillos = Materiales::model()->find('nombre=?', array('Ojillos'));
				$modeloMaterial = ModelosMateriales::model()->find('id_modelos=? AND id_materiales=?', array($modelo->id, $materialOjillos->id));
				if(isset($modeloMaterial)){
					$ojilloColor = $pedidoZapato->zapato->ojilloColor;
					$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?', array('Ojillos'));
					$ojillosApartados = MaterialesApartadosPedido::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_pedidos=? AND id_colores=?', array($tipoArticulo->id, $ojilloColor->id_ojillos, $pedido->id, $ojilloColor->id_colores));
					if (!isset($ojillosApartados)) {
						$ojillosApartados = new MaterialesApartadosPedido;
						$ojillosApartados->id_tipos_articulos_inventario = $tipoArticulo->id;
						$ojillosApartados->id_articulo = $ojilloColor->id_ojillos;
						$ojillosApartados->id_colores = $ojilloColor->id_colores;
						$ojillosApartados->id_pedidos = $pedido->id;
					}
					$ojillosApartados->cantidad_apartada += $cantidad_ojillos;
					$ojillosApartados->fecha_actualizacion = date('Y-m-d H:i:s');
					$ojillosApartados->save();
				}
			}

		} // Fin foreach pedidosZapatos
	} // Fin metodo actualizarInventarios

	public function actionMaterialesPredeterminados(){
		header('Content-Type: application/json');
		$respuesta = array();
		
		$id_modelo = $_POST['PedidosZapatos']['id_modelos'];
		$id_color_modelo = $_POST['PedidosZapatos']['id_colores'];
		$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($id_modelo, $id_color_modelo));
		if(isset($modeloColor)){
			$materialesPredeterminados = ModelosMaterialesPredeterminados::model()->findAll('id_modelos_colores=?', array($modeloColor->id));
			foreach ($materialesPredeterminados as $material) {
				$respuesta = array('id_modelo'=>$id_modelo, 'id_color_modelo'=>$id_color_modelo, 'id_suela'=>$material->suelaColor->id_suelas, 'id_color_suela'=>$material->suelaColor->id_colores, 'id_tacon'=>isset($material->taconColor)?$material->taconColor->id_tacones:0, 'id_color_tacon'=>isset($material->taconColor)?$material->taconColor->id_colores:0, 'id_agujetas'=>isset($material->agujetaColor)?$material->agujetaColor->id_agujetas:0, 'id_color_agujetas'=>isset($material->agujetaColor)?$material->agujetaColor->id_colores:0, 'id_ojillos'=>isset($material->ojillosColor)?$material->ojillosColor->id_ojillos:0, 'id_color_ojillos'=>isset($material->ojillosColor)?$material->ojillosColor->id_colores:0);
			}
		}
		echo json_encode($respuesta);
	}

}
