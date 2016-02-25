<?php

class PedidosController extends Controller
{
	public $section = 'pedidos';
	public $subsection;

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('seguimientoPedidos', 'actualizarEstatusZapatos', 'seguimiento'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update', 'admin','delete', 'obtenerModelos', 'suelasPorModelo', 'coloresPorModelo', 'numerosPorModelo', 'agregarOrden', 'coloresPorSuela', 'revisarSiTieneAgujetas', 'coloresPorAgujeta', 'coloresPorOjillo', 'materialesPredeterminados', 'imprimirEtiquetasPedido', 'descuentoPorCliente', 'empezarpedido', 'entregarPedido'),
				'users'=>Usuarios::model()->obtenerPorPerfil('Administrador'),
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
		$estatusPedidoEnProceso = EstatusPedidos::model()->find('nombre=?', array('En proceso'));
		$model->id_estatus_pedidos = $estatusPedido->id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pedidos']))
		{
			// print_r($_POST);
			// return;
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Pedidos'];
				$prioridad = $_POST['Pedidos']['prioridad'];
				$formaDePagoSeleccionada = $model->id_formas_pago;
				$model->prioridad = 'NORMAL';
				if($prioridad == 1){
					$model->prioridad = 'ALTA';
					$model->id_estatus_pedidos = $estatusPedidoEnProceso->id;
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
				$cantidad_pares_pedido = 0;

				if($model->validate() && $model->save()){
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
									$estatusZapato = EstatusZapatos::model()->find('nombre=?', array('Pendiente'));
									$estatusZapatoCorte = EstatusZapatos::model()->find('nombre=?', array('En corte'));
									$cantidad_tipo_zapato = $cantidad;
									while ($cantidad_tipo_zapato > 5) {
										$pedidoZapato = new PedidosZapatos;
										$pedidoZapato->id_pedidos = $model->id;
										$pedidoZapato->id_zapatos = $zapato->id;
										$pedidoZapato->cantidad_total = 5;
										$pedidoZapato->id_estatus_zapatos = ($prioridad==1)?$estatusZapatoCorte->id:$estatusZapato->id;
										$pedidoZapato->completos = 0;
										$pedidoZapato->precio_unitario = $zapato->precio;
										if(isset($datosPedido['especiales'][$id])){
											$pedidoZapato->caracteristicas_especiales = $datosPedido['especiales'][$id];
										}
										$pedidoZapato->save();
										$cantidad_tipo_zapato -= 5;
									}

									$pedidoZapato = new PedidosZapatos;
									$pedidoZapato->id_pedidos = $model->id;
									$pedidoZapato->id_zapatos = $zapato->id;
									$pedidoZapato->cantidad_total = $cantidad_tipo_zapato;
									$pedidoZapato->id_estatus_zapatos = ($prioridad==1)?$estatusZapatoCorte->id:$estatusZapato->id;
									$pedidoZapato->completos = 0;
									$pedidoZapato->precio_unitario = $zapato->precio;
									if(isset($datosPedido['especiales'][$id])){
										$pedidoZapato->caracteristicas_especiales = $datosPedido['especiales'][$id];
									}
									$pedidoZapato->save();
									$total += $pedidoZapato->precio_unitario * $cantidad;
									$cantidad_pares_pedido += $cantidad;
								}
							}
						}
						if($total > 0){
							$model->descuento = 0;
							if ($cantidad_pares_pedido >= 6 && $cantidad_pares_pedido < 100) {
								$model->descuento = 6;
							}
							else if ($cantidad_pares_pedido >= 100 && $cantidad_pares_pedido < 200) {
								$model->descuento = 8;
							}
							else if ($cantidad_pares_pedido >= 200 && $cantidad_pares_pedido < 300) {
								$model->descuento = 10;
							}
							else if ($cantidad_pares_pedido >= 300) {
								$model->descuento = 12;
							}
							$descuento_cliente = 0;
							$descuento_pedido = 0;
							$gastos = 0;
							if (isset($_POST['Pedido']['descuento_cliente']) && $_POST['Pedido']['descuento_cliente'] > 0) {
								$descuento_cliente = $_POST['Pedido']['descuento_cliente'];
							}
							if(isset($model->descuento) && $model->descuento > 0){
								$descuento_pedido = $model->descuento;
							}
							if(isset($model->gastos_envio) && $model->gastos_envio > 0){
								$gastos = $model->gastos_envio;
							}
							$descuento_total = $descuento_cliente + $descuento_pedido - $gastos;
							$total = $total*(1-$descuento_total/100);
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
					$this->apartarMateriales($model->id);

					if($model->id_estatus_pedidos == $estatusPedidoEnProceso->id){
						$respuesta = $this->actualizarInventario($model->id);
						if ($respuesta !== 'true') {
							$model->id_estatus_pedidos = $estatusPedido->id;
							$model->save();
							$titulo = 'Aviso';
							$mensaje = $respuesta;
							$this->redirect(array('admin', 'mensaje'=>isset($mensaje)?$mensaje:"", 'titulo'=>isset($titulo)?$titulo:""));
						}
					}
					$this->redirect(array('view','id'=>$model->id));
				}
			}catch(Exception $ex){
				print_r($ex);
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
		$estatusPedido = EstatusPedidos::model()->find('nombre=?', array('Pendiente'));
		$estatusPedidoEnProceso = EstatusPedidos::model()->find('nombre=?', array('En proceso'));
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
				foreach ($model->materialesApartados as $materialApartado) {
					$materialApartado->delete();
				}

				$prioridad = $_POST['Pedidos']['prioridad'];
				$model->prioridad = 'NORMAL';
				if($prioridad == 1){
					$model->prioridad = 'ALTA';
					$model->id_estatus_pedidos = $estatusPedidoEnProceso->id;
				}
				$formaDePagoSeleccionada = $model->id_formas_pago;
				$date = str_replace('/', '-', $model->fecha_entrega);
				$newDate = date("Y-m-d", strtotime($date));
			
				$model->fecha_entrega = $newDate;
				$newDate = date("Y-m-d H:i:s", strtotime($model->fecha_pedido));
				$model->fecha_pedido = $newDate;
				$total = 0;
				$cantidad_pares_pedido = 0;
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
									$estatusZapato = EstatusZapatos::model()->find('nombre=?', array('Pendiente'));
									$estatusZapatoCorte = EstatusZapatos::model()->find('nombre=?', array('En corte'));
									$cantidad_tipo_zapato = $cantidad;
									while ($cantidad_tipo_zapato > 5) {
										$pedidoZapato = new PedidosZapatos;
										$pedidoZapato->id_pedidos = $model->id;
										$pedidoZapato->id_zapatos = $zapato->id;
										$pedidoZapato->cantidad_total = 5;
										$pedidoZapato->id_estatus_zapatos = ($prioridad==1)?$estatusZapatoCorte->id:$estatusZapato->id;
										$pedidoZapato->completos = 0;
										$pedidoZapato->precio_unitario = $zapato->precio;
										if(isset($datosPedido['especiales'][$id])){
											$pedidoZapato->caracteristicas_especiales = $datosPedido['especiales'][$id];
										}
										$pedidoZapato->save();
										$cantidad_tipo_zapato -= 5;
									}
									$pedidoZapato = new PedidosZapatos;
									$pedidoZapato->id_pedidos = $model->id;
									$pedidoZapato->id_zapatos = $zapato->id;
									$pedidoZapato->cantidad_total = $cantidad_tipo_zapato;
									$pedidoZapato->id_estatus_zapatos = ($prioridad==1)?$estatusZapatoCorte->id:$estatusZapato->id;
									$pedidoZapato->completos = 0;
									$pedidoZapato->precio_unitario = $zapato->precio;
									if(isset($datosPedido['especiales'][$id])){
										$pedidoZapato->caracteristicas_especiales = $datosPedido['especiales'][$id];
									}
									$pedidoZapato->save();
									$total += $pedidoZapato->precio_unitario * $cantidad;
									$cantidad_pares_pedido += $cantidad;
								}
							}
						}
						if($total > 0){
							$model->descuento = 0;
							if ($cantidad_pares_pedido >= 6 && $cantidad_pares_pedido < 100) {
								$model->descuento = 6;
							}
							else if ($cantidad_pares_pedido >= 100 && $cantidad_pares_pedido < 200) {
								$model->descuento = 8;
							}
							else if ($cantidad_pares_pedido >= 200 && $cantidad_pares_pedido < 300) {
								$model->descuento = 10;
							}
							else if ($cantidad_pares_pedido >= 300) {
								$model->descuento = 12;
							}
							$descuento_cliente = 0;
							$descuento_pedido = 0;
							$gastos = 0;
							if (isset($_POST['Pedido']['descuento_cliente']) && $_POST['Pedido']['descuento_cliente'] > 0) {
								$descuento_cliente = $_POST['Pedido']['descuento_cliente'];
							}
							if(isset($model->descuento) && $model->descuento > 0){
								$descuento_pedido = $model->descuento;
							}
							if(isset($model->gastos_envio) && $model->gastos_envio > 0){
								$gastos = $model->gastos_envio;
							}
							$descuento_total = $descuento_cliente + $descuento_pedido - $gastos;
							$total = $total*(1-$descuento_total/100);
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
					$this->apartarMateriales($model->id);
					if($model->id_estatus_pedidos == $estatusPedidoEnProceso->id){
						$respuesta = $this->actualizarInventario($model->id);
						if ($respuesta !== 'true') {
							$model->id_estatus_pedidos = $estatusPedido->id;
							$model->save();
							$titulo = 'Aviso';
							$mensaje = $respuesta;
							$this->redirect(array('admin', 'mensaje'=>isset($mensaje)?$mensaje:"", 'titulo'=>isset($titulo)?$titulo:""));
						}
					}
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
			if ($model->estatus->nombre == 'Pendiente') {
				foreach ($model->materialesApartados as $materialApartado) {
					$materialApartado->delete();
				}
				foreach ($model->pagos as $pago) {
					$pago->delete();
				}
				$model->delete();
			}
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
		$this->renderPartial('/layouts/_modal-alert', array('mensaje'=>isset($_GET['mensaje'])?$_GET['mensaje']:"", 'titulo'=>isset($_GET['titulo'])?$_GET['titulo']:""));
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

	/**
	 * Busca todas las suelas que puede llevar el modelo
	 * @param id_modelo, Requiere el id del modelo del que
	 * buscará las suelas, este se debe enviar por POST
	 * @return estructura del select (DropDown) que mostrará los resultados
	 */
	public function actionSuelasPorModelo()
	{
		$list = ModelosSuelas::model()->findAll("id_modelos=?",array($_POST["PedidosZapatos"]["id_modelos"]));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($list as $i => $data){
			echo "<option value=\"{$data->suela->id}\"".($i==0?'selected':'').">{$data->suela->nombre}</option>";
		}
	}

	/**
	 * Regresa todos los colores que puede llevar el modelo
	 * @param id_modelo, Requiere el id del modelo del que
	 * buscará los colores, este se debe enviar por POST
	 * @return estructura del select (DropDown) que mostrará los resultados
	 */
	public function actionColoresPorModelo()
	{
		$list = ModelosColores::model()->findAll("id_modelos=?",array($_POST["PedidosZapatos"]["id_modelos"]));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($list as $i => $data)
			echo "<option value=\"{$data->color->id}\"".($i==0?'selected':'').">{$data->color->color}</option>";
	}

	/**
	 * Regresa todos los numeros en que se puede hacer el modelo
	 * @param id_modelo, Requiere el id del modelo del que
	 * buscará los numeros, este se debe enviar por POST
	 * @return estructura del select (DropDown) que mostrará los resultados
	 */
	public function actionNumerosPorModelo()
	{
		$list = ModelosNumeros::model()->findAll("id_modelos=?",array($_POST["PedidosZapatos"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->id}\">{$data->numero}</option>";
	}

	/**
	 * Regresa todos los colores que hay para la suela especificada
	 * @param id_suelas, Requiere el id de la suela de la que
	 * buscará los colores, este se debe enviar por POST
	 * @return estructura del select (DropDown) que mostrará los resultados
	 */
	public function actionColoresPorSuela()
	{
		$list = SuelasColores::model()->findAll("id_suelas=?",array($_POST["PedidosZapatos"]["id_suelas"]));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($list as $i => $data)
			echo "<option value=\"{$data->color->id}\"".($i==0?'selected':'').">{$data->color->color}</option>";
	}

	/**
	 * Revisa si el modelo especificado debe llevar agujetas y ojillos o no,
	 * @param id_modelos, Requiere el id del modelo que se revisará
	 * este se debe enviar por POST
	 * @return true si lleva agujetas o false si no es así
	 */
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

	/**
	 * Busca todos los colores que hay para la agujeta especificada
	 * @param id_agujetas, Requiere el id de la agujeta de la que
	 * buscará los colores, este se debe enviar por POST
	 * @return estructura del select (DropDown) que mostrará los resultados
	 */
	public function actionColoresPorAgujeta()
	{
		$id_agujeta = $_POST['PedidosZapatos']['id_agujetas'];
		$agujetaColores = AgujetasColores::model()->findAll('id_agujetas=?', array($id_agujeta));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($agujetaColores as $i => $data)
			echo "<option value=\"{$data->color->id}\"".($i==0?'selected':'').">{$data->color->color}</option>";
	}

	/**
	 * Busca todos los colores que hay para los ojillos especificados
	 * @param id_ojillos, Requiere el id de los ojillos de los que
	 * buscará los colores, este se debe enviar por POST
	 * @return estructura del select (DropDown) que mostrará los resultados
	 */
	public function actionColoresPorOjillo()
	{
		$id_ojillo = $_POST['PedidosZapatos']['id_ojillos'];
		$ojillosColores = OjillosColores::model()->findAll('id_ojillos=?', array($id_ojillo));
		echo "<option value=\"0\">Seleccione una opción</option>";
		foreach($ojillosColores as $i => $data)
			echo "<option value=\"{$data->color->id}\"".($i==0?'selected':'').">{$data->color->color}</option>";
	}

	/**
	 * Generar el código necesario para agregar una nueva orden en el
	 * formulario de pedidos (Fila de la tabla de ordenes)
	 * @param id_modelos, id_colores, id_suelas, id_agujetas, id_color_agujetas,
	 * id_ojillos, id_color_ojillos. Todos los parametros se deben enviar por POST.
	 * @return codigo html para mostrar la nueva orden en el formulario
	 */
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
		<?php } ?>
	<?php	} 

	/**
	 * Consulta el descuento que se le aplica a cada cliente
	 * @param id_clientes, cliente del que se busca el descuento
	 * Los parametros son enviados por POST
	 * @return porcentaje de descuento que tiene el cliente
	 */
	public function actionDescuentoPorCliente()
	{
		$id_clientes = $_POST['Pedidos']['id_clientes'];
		$cliente = Clientes::model()->findByPk($id_clientes);
		echo $cliente->descuento;
	}

	/**
	 * Calcula el importe pendiente de pago de un pedido especifico
	 * Esta funcion se usa solo para el CGridView de la vista de admin
	 * para mostrar los datos en la tabla de administracion.
	 * @param $data, el modelo Pedido
	 * @param $row, no sé que es, no se usa pero debe estar 
	 * @return el monto que se adeuda para el pedido
	 */
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

	/**
	 * Apartar todos los materiales necesarios para completar el pedido
	 * @param $id_pedido, id del pedido a apartar
	 * @return nada, solo guarda en la base de datos la lista de materiales
	 * que se requieren para completar el pedido
	 */
	public function apartarMateriales($id_pedido)
	{
		$pedido = $this->loadModel($id_pedido);
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
				if(!$materialTieneColores && !isset($materialApartado)){
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

		// Apartar materiales en inventarios (acumular a lo apartado de los 
		// pedidos anteriores)
		foreach ($pedido->materialesApartados as $materialApartado) {
			$consulta = 'id_tipos_articulos_inventario=? AND id_articulo=?';
			$parametros = array($materialApartado->id_tipos_articulos_inventario, $materialApartado->id_articulo);
			if (isset($materialApartado->numero)) {
				$consulta .= ' AND numero=?';
				array_push($parametros, $materialApartado->numero);
			}
			if (isset($materialApartado->id_colores)) {
				$consulta .= ' AND id_colores=?';
				array_push($parametros, $materialApartado->id_colores);
			}

			$inventario = Inventarios::model()->find($consulta, $parametros);
			if (!isset($inventario)) {
				$inventario = new Inventarios;
				$inventario->id_tipos_articulos_inventario = $materialApartado->id_tipos_articulos_inventario;
				$inventario->id_articulo = $materialApartado->id_articulo;
				$inventario->id_colores = $materialApartado->id_colores;
				$inventario->numero = $materialApartado->numero;
				$inventario->cantidad_existente = 0;
				$inventario->cantidad_apartada = 0;

				$datosArticulo = $this->obtenerDatosArticulo($inventario->id_tipos_articulos_inventario, $inventario->id_articulo);
				$inventario->nombre_articulo = $datosArticulo['nombre'];
				$inventario->unidad_medida = $datosArticulo['unidad_medida'];
			}

			$inventario->cantidad_apartada += $materialApartado->cantidad_apartada;
			$inventario->save();
		}
	} // Fin metodo apartarMateriales

	/**
	 * Buscar los materiales basicos predeterminados para un modelo y color especificos
	 * @param id_modelos, id del modelo
	 * @param id_colores, id del color del modelo
	 * Los parametros se deben enviar por POST
	 * @return json con los datos de los materiales que lleva por defecto
	 * el modelo especificado, para el color especificado. Los datos que
	 * incluye el json son: id_modelo, id_color_modelo, id_suela, id_color_suela,
	 * [id_tacon, id_color_tacon], [id_agujetas, id_color_agujetas, id_ojillos, 
	 * id_color_ojillos].
	 */
	public function actionMaterialesPredeterminados()
	{
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

	/**
	 * Busca todos los pedidos que ya estan en proceso para mostrar los detalles
	 * de las tareas a realizar para finalizar el pedido
	 * @return muestra la vista de tareas que se estan haciendo y que quedan por hacer
	 */
	public function actionSeguimientoPedidos()
	{
		$this->subsection = 'seguimiento';
		$estatusPedidoEnProceso = EstatusPedidos::model()->find('nombre=?', array('En proceso'));
		$estatusPedidoTerminado = EstatusPedidos::model()->find('nombre=?', array('Terminado'));
		$pedidos = Pedidos::model()->findAll('id_estatus_pedidos=? OR id_estatus_pedidos=?', array($estatusPedidoEnProceso->id, $estatusPedidoTerminado->id));
		$perfil = Yii::app()->user->getState('perfil');
		switch ($perfil) {
			case 'Administrador':
				$this->render('seguimiento',array(
					'pedidos'=>$pedidos,
				));
				break;
			case 'Cortador':
				$this->render('seguimiento',array(
					'pedidos'=>$pedidos,
				));
				break;
			case 'Pespuntador':
				// Tarjetas de corte
				$estatusZapatoCorte = EstatusZapatos::model()->find('nombre=?', array('En corte'));
				$pedidosZapatosCorte = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
					array(
						'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
						'params' => array(
							':estatusPedido' => $estatusPedidoEnProceso->id,
							':estatusZapato' => $estatusZapatoCorte->id,
							),
						'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero',
						)
					);

				// Tarjetas de pespunte
				$estatusZapatoPespunte = EstatusZapatos::model()->find('nombre=?', array('En pespunte'));
				$pedidosZapatosPespunte = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
					array(
						'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
						'params' => array(
							':estatusPedido' => $estatusPedidoEnProceso->id,
							':estatusZapato' => $estatusZapatoPespunte->id,
							),
						'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero',
						)
					);

				// Tarjetas de ensuelado
				$estatusZapatoEnsuelado = EstatusZapatos::model()->find('nombre=?', array('En ensuelado'));
				$pedidosZapatosEnsuelado = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
					array(
						'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
						'params' => array(
							':estatusPedido' => $estatusPedidoEnProceso->id,
							':estatusZapato' => $estatusZapatoEnsuelado->id,
							),
						'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero, zapato.id_suelas_colores',
						)
					);
				$this->render('seguimiento',array(
					'pedidos'=>$pedidos,
					'tarjetasCorte'=>$pedidosZapatosCorte,
					'tarjetasPespunte'=>$pedidosZapatosPespunte,
					'tarjetasEnsuelado'=>$pedidosZapatosEnsuelado,
				));
				break;
			case 'Ensuelador':
				// Tarjetas de pespunte
				$estatusZapatoPespunte = EstatusZapatos::model()->find('nombre=?', array('En pespunte'));
				$pedidosZapatosPespunte = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
					array(
						'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
						'params' => array(
							':estatusPedido' => $estatusPedidoEnProceso->id,
							':estatusZapato' => $estatusZapatoPespunte->id,
							),
						'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero',
						)
					);

				// Tarjetas de ensuelado
				$estatusZapatoEnsuelado = EstatusZapatos::model()->find('nombre=?', array('En ensuelado'));
				$pedidosZapatosEnsuelado = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
					array(
						'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
						'params' => array(
							':estatusPedido' => $estatusPedidoEnProceso->id,
							':estatusZapato' => $estatusZapatoEnsuelado->id,
							),
						'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero, zapato.id_suelas_colores',
						)
					);
				
				// Tarjetas de Adornado
				$estatusZapatoAdornado = EstatusZapatos::model()->find('nombre=?', array('En adorno'));
				$pedidosZapatosAdornado = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
					array(
						'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
						'params' => array(
							':estatusPedido' => $estatusPedidoEnProceso->id,
							':estatusZapato' => $estatusZapatoAdornado->id,
							),
						'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero, zapato.id_suelas_colores',
						)
					);
				$this->render('seguimiento',array(
					'pedidos'=>$pedidos,
					'tarjetasPespunte'=>$pedidosZapatosPespunte,
					'tarjetasEnsuelado'=>$pedidosZapatosEnsuelado,
					'tarjetasAdornado'=>$pedidosZapatosAdornado,
				));
				break;
			case 'Adornador':
				// Tarjetas de Adornado
				$estatusZapatoAdornado = EstatusZapatos::model()->find('nombre=?', array('En adorno'));
				$pedidosZapatosAdornado = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
					array(
						'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
						'params' => array(
							':estatusPedido' => $estatusPedidoEnProceso->id,
							':estatusZapato' => $estatusZapatoAdornado->id,
							),
						'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero, zapato.id_suelas_colores',
						)
					);
				
				// Tarjetas de terminado
				$estatusZapatoTerminado = EstatusZapatos::model()->find('nombre=?', array('Terminado'));
				$pedidosZapatosTerminado = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
					array(
						'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
						'params' => array(
							':estatusPedido' => $estatusPedidoEnProceso->id,
							':estatusZapato' => $estatusZapatoTerminado->id,
							),
						'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero',
						)
					);
		
				$this->render('seguimiento',array(
					'pedidos'=>$pedidos,
					'tarjetasAdornado'=>$pedidosZapatosAdornado,
					'tarjetasTerminado'=>$pedidosZapatosTerminado,
				));
				break;
		}
		
	}

	/**
	 * Actualiza el estatus de los zapatos que corresponden a algún pedido,
	 * y que ha sido cambiado por el usuario en la vista de tareas.
	 * @param id, id del modelo PedidosZapatos que se va a actualizar
	 * @param estatus, nuevo estatus que se le pondrá al modelo
	 * Los parametros se deben enviar por POST
	 * @return nada, solo actualizar los modelos en la base de datos
	 */
	public function actionActualizarEstatusZapatos()
	{
		$pedidoZapato = PedidosZapatos::model()->findByPk($_POST['id']);
		$estatusZapato = EstatusZapatos::model()->find('nombre=?', array($_POST['estatus']));
		$pedido = $pedidoZapato->pedido;

		$pedidoZapato->id_estatus_zapatos = $estatusZapato->id;
		$pedidoZapato->save();

		if($_POST['estatus'] === 'Terminado'){
			//Imprimir la etiqueta o etiquetas

			$pedidoCompleto = true;
			foreach ($pedido->pedidosZapatos as $pZapato) {
				if ($pZapato->estatusZapato->nombre !== 'Terminado') {
					$pedidoCompleto = false;
					break;
				}
			}
			if ($pedidoCompleto) {
				$estatusPedidoTerminado = EstatusPedidos::model()->find('nombre=?', array('Terminado'));
				$pedido->id_estatus_pedidos = $estatusPedidoTerminado->id;
				$pedido->save();
			}
			$this->imprimirEtiquetasTarjeta($pedidoZapato->id);
		}
	}

	/**
	 * Generar e imprimir las etiquetas para un modelo de PedidosZapatos
	 * (tarjeta en seguimiento de pedidos). Se manda directo a la impresora
	 * @param $id, id del modelo(PedidosZapatos) a imprimir
	 */
	public function imprimirEtiquetasTarjeta($id)
	{
		$pedidoZapato = PedidosZapatos::model()->findByPk($id);
		$pdf_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'../../assets/pdfs/printCard.pdf';
		$etiquetas = array();
		$modelo = $pedidoZapato->zapato->modelo;
		$datos = array('modelo'=>$modelo->nombre, 'color'=>$pedidoZapato->zapato->color->color, 'numero'=>$pedidoZapato->zapato->numero, 'foto'=>$modelo->imagen, 'codigo'=>$pedidoZapato->zapato->codigo_barras);
		$altoPagina = 0;
		for($i=0; $i<$pedidoZapato->cantidad_total;$i++){
			array_push($etiquetas, $datos);
			$altoPagina += 5.3;
		}
		$altoPagina += 0.2;
		if(file_exists($pdf_path)) {
			unlink($pdf_path);
		}
		$orientacion = 'p';
		if ($altoPagina < 10) {
			$orientacion = 'l';
		}
		$pdf = new ImprimirEtiquetasTarjeta($orientacion,'cm',array(10, $altoPagina));
		$pdf->AddPage();
		$pdf->contenido($etiquetas);
		$pdf->Output($pdf_path, 'F');

		$this->printPdf('BrotherDCP7055', $pdf_path);
	}

	/**
	 * Manda a imprimir a la impresora especificada el archivo que se le envíe
	 * @param $nombre_impresora, nombre de la impresora (panel de control)
	 * @param $ruta_pdf, nombre del pdf a imprimir (incluir ruta)
	 */
	public function printPdf($nombre_impresora, $ruta_pdf) {
		$folder_path = dirname(__FILE__).DIRECTORY_SEPARATOR
		.'..'.DIRECTORY_SEPARATOR
		.'..'.DIRECTORY_SEPARATOR
		.'extensions'.DIRECTORY_SEPARATOR
		.'jars';

		$jar_directory = $folder_path.DIRECTORY_SEPARATOR.'*';
		$command = "java -classpath ".$jar_directory." org.apache.pdfbox.PrintPDF -silentPrint -printerName ".$nombre_impresora." ".$ruta_pdf;
		exec($command);
	}

	/**
	 * Genera un PDF con todas las etiquetas de los zapatos que incluye un pedido
	 * @param $id, id del pedido para el que se generan las etiquetas
	 * @return documento PDF con las etiquetas
	 */
	public function actionImprimirEtiquetasPedido($id)
	{
		$etiquetas = array();
		$pedido = $this->loadModel($id);
		foreach ($pedido->pedidosZapatos as $pedidoZapato) {
			$modelo = $pedidoZapato->zapato->modelo;
			$datos = array('modelo'=>$modelo->nombre, 'color'=>$pedidoZapato->zapato->color->color, 'numero'=>$pedidoZapato->zapato->numero, 'foto'=>$modelo->imagen, 'codigo'=>$pedidoZapato->zapato->codigo_barras);
			for($i=0; $i<$pedidoZapato->cantidad_total;$i++)
				array_push($etiquetas, $datos);
		}

		$pdf = new ImprimirEtiquetasPedido('P','cm','letter');
		$pdf->AddPage();
		$pdf->contenido($etiquetas);
		$pdf->Output();
	}

	/**
	 * Actualizar los inventarios para descontar los materiales que se 
	 * requieren para completar el pedido especificado
	 * @param $id_pedido, id del pedido a considerar
	 * @return true si es correcto, string de errores si no lo es
	 */
	public function actualizarInventario($id_pedido)
	{
		$pedido = $this->loadModel($id_pedido);
		$transaction = Yii::app()->db->beginTransaction();
		$errores = '';
		try{
			foreach ($pedido->materialesApartados as $materialApartado) {
				$consulta = 'id_tipos_articulos_inventario=? AND id_articulo=?';
				$parametros = array($materialApartado->id_tipos_articulos_inventario, $materialApartado->id_articulo);
				if (isset($materialApartado->numero)) {
					$consulta .= ' AND numero=?';
					array_push($parametros, $materialApartado->numero);
				}
				if (isset($materialApartado->id_colores)) {
					$consulta .= ' AND id_colores=?';
					array_push($parametros, $materialApartado->id_colores);
				}

				$inventario = Inventarios::model()->find($consulta, $parametros);
				if (!isset($inventario)) {
					$datosArticulo = $this->obtenerDatosArticulo($materialApartado->id_tipos_articulos_inventario, $materialApartado->id_articulo);
					$errores .= "No existe(n) ".$datosArticulo['nombre'];
					if (isset($materialApartado->color)) {
						$errores .= ", color: ".$materialApartado->color->color; 
					}
					if (isset($materialApartado->numero)) {
						$errores .= ", numero: ".$materialApartado->numero; 
					}
					$errores .= ' en el inventario|';
					continue;
				}

				if ($inventario->cantidad_existente >= $materialApartado->cantidad_apartada) {
					$inventario->cantidad_existente -= $materialApartado->cantidad_apartada;
					$inventario->cantidad_apartada -= $materialApartado->cantidad_apartada;
					$inventario->save(); 
				}else{
					$datosArticulo = $this->obtenerDatosArticulo($materialApartado->id_tipos_articulos_inventario, $materialApartado->id_articulo);
					$errores .= "No hay suficiente(s) ".$datosArticulo['nombre'];
					if (isset($materialApartado->color)) {
						$errores .= ", color: ".$materialApartado->color->color; 
					}
					if (isset($materialApartado->numero)) {
						$errores .= ", numero: ".$materialApartado->numero; 
					}
					$errores .= ' en el inventario|';
				}
			}
			if (strlen($errores) > 0) {
				$transaction->rollback();
				return $errores;
			}else{
				$transaction->commit();
				return 'true';
			}
		}catch(Exception $ex){
			$transaction->rollback();
		}
	}

	/**
	 * Obtener los datos necesasrios para dar de alta un modelo inventario si
	 * solo se conoce el tipo de articulo y el id del articulo.
	 * @param $id_tipo, id del tipo de articulo, modelo TiposArticulosInventario
	 * ('Suelas', 'Tacones', 'Materiales', etc.)
	 * @param $id_articulo, id del articulo que agrega al inventario 
	 * (sea id de suela, id de tacon, etc.)
	 * @return array('nombre'=>NOMBRE_DE_ARTICULO, 'unidad_medida'=>UNIDAD_MEDIDA)
	 */
	public function obtenerDatosArticulo($id_tipo, $id_articulo)
	{
		$tipo_articulo = TiposArticulosInventario::model()->findByPk($id_tipo);
		switch ($tipo_articulo->tipo) {
			case 'Suelas':
				$articulo = Suelas::model()->findByPk($id_articulo);
				return array('nombre'=>$articulo->nombre, 'unidad_medida'=>'Pares');
				break;
			case 'Tacones':
				$articulo = Tacones::model()->findByPk($id_articulo);
				return array('nombre'=>$articulo->nombre, 'unidad_medida'=>'Pares');
				break;
			case 'Agujetas':
				$articulo = Agujetas::model()->findByPk($id_articulo);
				return array('nombre'=>$articulo->nombre, 'unidad_medida'=>'Millares');
				break;
			case 'Ojillos':
				$articulo = Ojillos::model()->findByPk($id_articulo);
				return array('nombre'=>$articulo->nombre, 'unidad_medida'=>'Millares');
				break;
			case 'Materiales':
				$articulo = Materiales::model()->findByPk($id_articulo);
				return array('nombre'=>$articulo->nombre, 'unidad_medida'=>$articulo->unidad_medida);
				break;
		}
	}

	/**
	 * Muestra el avance en la fabricacion de los zapatos de todos los pedidos
	 * que se estan haciendo, los pedidos pendientes no se muestran en esta 
	 * seccion. 
	 */
	public function actionSeguimiento()
	{
		$this->subsection = 'seguimiento';
		$estatusPedidoEnProceso = EstatusPedidos::model()->find('nombre=?', array('En proceso'));
		$estatusPedidoTerminado = EstatusPedidos::model()->find('nombre=?', array('Terminado'));
		$pedidos = Pedidos::model()->findAll('id_estatus_pedidos=? OR id_estatus_pedidos=?', array($estatusPedidoEnProceso->id, $estatusPedidoTerminado->id));

		// Tarjetas de corte
		$estatusZapatoCorte = EstatusZapatos::model()->find('nombre=?', array('En corte'));
		$pedidosZapatosCorte = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
			array(
				'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
				'params' => array(
					':estatusPedido' => $estatusPedidoEnProceso->id,
					':estatusZapato' => $estatusZapatoCorte->id,
					),
				'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero',
				)
			);

		// Tarjetas de pespunte
		$estatusZapatoPespunte = EstatusZapatos::model()->find('nombre=?', array('En pespunte'));
		$pedidosZapatosPespunte = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
			array(
				'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
				'params' => array(
					':estatusPedido' => $estatusPedidoEnProceso->id,
					':estatusZapato' => $estatusZapatoPespunte->id,
					),
				'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero',
				)
			);

		// Tarjetas de ensuelado
		$estatusZapatoEnsuelado = EstatusZapatos::model()->find('nombre=?', array('En ensuelado'));
		$pedidosZapatosEnsuelado = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
			array(
				'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
				'params' => array(
					':estatusPedido' => $estatusPedidoEnProceso->id,
					':estatusZapato' => $estatusZapatoEnsuelado->id,
					),
				'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero, zapato.id_suelas_colores',
				)
			);
		
		// Tarjetas de Adornado
		$estatusZapatoAdornado = EstatusZapatos::model()->find('nombre=?', array('En adorno'));
		$pedidosZapatosAdornado = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
			array(
				'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
				'params' => array(
					':estatusPedido' => $estatusPedidoEnProceso->id,
					':estatusZapato' => $estatusZapatoAdornado->id,
					),
				'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero, zapato.id_suelas_colores',
				)
			);
		
		// Tarjetas de terminado
		$estatusZapatoTerminado = EstatusZapatos::model()->find('nombre=?', array('Terminado'));
		$pedidosZapatosTerminado = PedidosZapatos::model()->with('pedido', 'zapato')->findAll(
			array(
				'condition' => 'pedido.id_estatus_pedidos = :estatusPedido AND id_estatus_zapatos = :estatusZapato',
				'params' => array(
					':estatusPedido' => $estatusPedidoEnProceso->id,
					':estatusZapato' => $estatusZapatoTerminado->id,
					),
				'order' => 'zapato.id_modelos, zapato.id_colores, zapato.numero',
				)
			);
		
		$this->render('seguimiento',array(
			'pedidos'=>$pedidos,
			'tarjetasCorte'=>$pedidosZapatosCorte,
			'tarjetasPespunte'=>$pedidosZapatosPespunte,
			'tarjetasEnsuelado'=>$pedidosZapatosEnsuelado,
			'tarjetasAdornado'=>$pedidosZapatosAdornado,
			'tarjetasTerminado'=>$pedidosZapatosTerminado,
		));
	}

	/**
	 * Mandar a proceso un pedido y cambiar todos sus zapatos al
	 * departamento de corte, el pedido debe estar en estatus de
	 * pendiente para que la funcion actue.
	 * @param $id, id del pedido que se desea mandar a proceso.
	 */
	public function actionEmpezarPedido($id)
	{
		$pedido = $this->loadModel($id);
		if ($pedido->estatus->nombre === 'Pendiente') {
			$respuestaActualizarInventarios = $this->actualizarInventario($id);
			if ($respuestaActualizarInventarios !== 'true') {
				$titulo = 'Aviso';
				$mensaje = $respuestaActualizarInventarios;			
			}
			else{
				$estatusEnCurso = EstatusPedidos::model()->find('nombre=?', array('En proceso'));
				$estatusEnCorte = EstatusZapatos::model()->find('nombre=?', array('En corte'));
				foreach ($pedido->pedidosZapatos as $pedidoZapato) {
					$pedidoZapato->id_estatus_zapatos = $estatusEnCorte->id;
					$pedidoZapato->save();
				}
				$pedido->id_estatus_pedidos = $estatusEnCurso->id;
				$pedido->save();
			}
			$this->redirect(array('admin', 'mensaje'=>isset($mensaje)?$mensaje:"", 'titulo'=>isset($titulo)?$titulo:""));
		}
	}

	/**
	 * Entregar el pedido al cliente y quitar ya del seguimiento y tabla
	 * de administración de pedidos.
	 * @param $id, id del pedido que se entrega
	 */
	public function actionEntregarPedido($id)
	{
		$pedido = $this->loadModel($id);
		$estatusPedidoEntregado = EstatusPedidos::model()->find('nombre=?', array('Entregado'));
		$pedido->id_estatus_pedidos = $estatusPedidoEntregado->id;
		$pedido->save();
		$this->redirect(array('seguimiento'));
	}
}
