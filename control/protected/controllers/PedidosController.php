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
				'actions'=>array('create','update', 'admin','delete', 'obtenerModelos', 'suelasPorModelo', 'coloresPorModelo', 'numerosPorModelo', 'agregarOrden','descuentoPorCliente', 'coloresPorSuela', 'actualizarInventarios', 'revisarSiTieneAgujetas', 'coloresPorAgujeta', 'coloresPorOjillo'),
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
			print_r($_POST);
			return;
			$transaction = Yii::app()->db->beginTransaction();
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
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
			}catch(Exception $ex){
				$transaction->rollback();
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
				print_r($ex);
				return;
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'pedidoZapato'=>$pedidoZapato,
		));
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
		foreach($list as $i => $data){
			if ($i==0) {
				echo "<option value=\"{$data->suela->id}\" selected>{$data->suela->nombre}</option>";
			}
			else{
				echo "<option value=\"{$data->suela->id}\">{$data->suela->nombre}</option>";
			}
		}
	}

	public function actionColoresPorModelo()
	{
		$list = ModelosColores::model()->findAll("id_modelos=?",array($_POST["PedidosZapatos"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
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
		foreach($list as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
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
		foreach($agujetaColores as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionColoresPorOjillo()
	{
		$id_ojillo = $_POST['PedidosZapatos']['id_ojillos'];
		$ojillosColores = OjillosColores::model()->findAll('id_ojillos=?', array($id_ojillo));
		foreach($ojillosColores as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionAgregarOrden()
	{
		if (isset($_POST)) {
			print_r($_POST);
			return;
			$modelo = Modelos::model()->findByPk($_POST['id_modelos']);
			$color = Colores::model()->findByPk($_POST['id_colores']);
			$suela = Suelas::model()->findByPk($_POST['id_suelas']);
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
			<tr id="row_<?= $time ?>">
				<td class="modelo" data-id="<?= $modelo->id ?>"><?= $modelo->nombre; ?><input type="hidden" name="Pedido[modelo][<?= $time ?>]" value="<?= $modelo->id ?>"></td>
				<td class="color" data-id="<?= $color->id ?>"><?= $color->color; ?><input type="hidden" name="Pedido[color][<?= $time ?>]" value="<?= $color->id ?>"></td>
				<td class="suela" data-id="<?= $suela->id ?>"><?= $suela->nombre; ?><input type="hidden" name="Pedido[suela][<?= $time ?>]" value="<?= $suela->id ?>"></td>
				<td class="colorsuela" data-id="<?= $suelaColor->id ?>"><?= $suelaColor->color->color; ?><input type="hidden" name="Pedido[suelacolor][<?= $time ?>]" value="<?= $suelaColor->id ?>"></td>
			
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
				<tr>
					<td>
						<?= $_POST['especial'] ?>
						<input type="hidden" name="Pedido[especiales][<?= $time ?>]" value="<?= $_POST['especial'] ?>">
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

	public function actionActualizarInventarios($id_pedidos)
	{
		$pedido = $this->loadModel($id_pedidos);
		// Aqui se va a hacer todo el descuento de materiales, suelas, etc.
	}

}
