<?php

class ProvedoresController extends Controller
{
	public $section = 'provedores';
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','create','update','admin','delete', 'verAdeudos'),
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
		$model = $this->loadModel($id);
		$ids_suelas = array();
		$ids_tacones = array();
		$ids_materiales = array();

		$tipoSuela = TiposArticulosInventario::model()->find('tipo=?', array('Suelas'));
		$tipoTacon = TiposArticulosInventario::model()->find('tipo=?', array('Tacones'));
		$tipoMateriales = TiposArticulosInventario::model()->find('tipo=?', array('Materiales'));

		foreach ($model->proveedorMateriales as $pMaterial) {
			if ($pMaterial->id_tipos_articulos_inventario == $tipoSuela->id) {
				array_push($ids_suelas, $pMaterial->id_articulo);
			}
			else if ($pMaterial->id_tipos_articulos_inventario == $tipoTacon->id) {
				array_push($ids_tacones, $pMaterial->id_articulo);
			}
			else if ($pMaterial->id_tipos_articulos_inventario == $tipoMateriales->id) {
				array_push($ids_materiales, $pMaterial->id_articulo);
			}
		}

		if (empty($ids_suelas)) {
			array_push($ids_suelas, 0);
		}
		if (empty($ids_tacones)) {
			array_push($ids_tacones, 0);
		}
		if (empty($ids_materiales)) {
			array_push($ids_materiales, 0);
		}
		$suelas = Suelas::model()->findAll(array(
						'condition'=>'id IN('.implode(',',$ids_suelas).')'
					)
			);
		$tacones = Tacones::model()->findAll(array(
						'condition'=>'id IN('.implode(',',$ids_tacones).')'
					)
			);
		$materiales = Materiales::model()->findAll(array(
						'condition'=>'id IN('.implode(',',$ids_materiales).')'
					)
			);
		$this->render('view',array(
			'model'=>$model,
			'suelas'=>$suelas,
			'tacones'=>$tacones,
			'materiales'=>$materiales,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Provedores;
		$direccion = new Direcciones;

		//Determinar materiales a seleccionar
		$materialesOcupados = ProveedoresMateriales::model()->with(array('tiposArticulosInventario'=>array('alias'=>'tipoArticulo')))->findAll(array('select'=>'id_articulo', 'condition'=>'tipoArticulo.tipo=:tipo', 'params'=>array('tipo'=>'Materiales')));
		$idsMaterialesOcupados = array();
		foreach ($materialesOcupados as $mo) {
			array_push($idsMaterialesOcupados, $mo->id_articulo);
		}
		if (empty($idsMaterialesOcupados)) {
			$materialesDisponibles = Materiales::model()->findAll();
		}
		else {
			$materialesDisponibles = Materiales::model()->findAll(array(
						'condition'=>'id NOT IN('.implode(',',$idsMaterialesOcupados).')'
					)
			);
		}

		//Determinar tacones a seleccionar
		$taconesOcupados = ProveedoresMateriales::model()->with(array('tiposArticulosInventario'=>array('alias'=>'tipoArticulo')))->findAll(array('select'=>'id_articulo', 'condition'=>'tipoArticulo.tipo=:tipo', 'params'=>array('tipo'=>'Tacones')));
		$idsTaconesOcupados = array();
		foreach ($taconesOcupados as $to) {
			array_push($idsTaconesOcupados, $to->id_articulo);
		}
		if (empty($idsTaconesOcupados)) {
			$taconesDisponibles = Tacones::model()->findAll();
		}
		else {
			$taconesDisponibles = Tacones::model()->findAll(array(
						'condition'=>'id NOT IN('.implode(',',$idsTaconesOcupados).')'
					)
			);
		}

		//Determinar suelas a seleccionar
		$suelasOcupados = ProveedoresMateriales::model()->with(array('tiposArticulosInventario'=>array('alias'=>'tipoArticulo')))->findAll(array('select'=>'id_articulo', 'condition'=>'tipoArticulo.tipo=:tipo', 'params'=>array('tipo'=>'Suelas')));
		$idsSuelasOcupados = array();
		foreach ($suelasOcupados as $to) {
			array_push($idsSuelasOcupados, $to->id_articulo);
		}
		if (empty($idsSuelasOcupados)) {
			$suelasDisponibles = Suelas::model()->findAll();
		}
		else {
			$suelasDisponibles = Suelas::model()->findAll(array(
						'condition'=>'id NOT IN('.implode(',',$idsSuelasOcupados).')'
					)
			);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Provedores']))
		{
			// print_r($_POST);
			// return;
			$transaction = Yii::app()->db->beginTransaction();
			$model->attributes=$_POST['Provedores'];
			$model->validate();

			if (isset($_POST['Agregar_direccion'])) {
				$direccion->attributes = $_POST['Direcciones'];
			}
			else {
				$direccion->calle = 'No especificado';
				$direccion->numero_ext = 'S/N';
				$direccion->codigo_postal = 'No especificado';
				$direccion->colonia = 'No especificado';
				$direccion->ciudad = 'No especificado';
				$direccion->pais = 'No especificado';
			}
			if($direccion->save()){
				$model->id_direcciones = $direccion->id;
				if($model->save()){
					$tipoSuela = TiposArticulosInventario::model()->find('tipo=?', array('Suelas'));
					$tipoTacon = TiposArticulosInventario::model()->find('tipo=?', array('Tacones'));
					$tipoMateriales = TiposArticulosInventario::model()->find('tipo=?', array('Materiales'));

					if (isset($_POST['Proveedor_suela'])) {
						foreach ($_POST['Proveedor_suela']['id_suela'] as $id_suela => $value) {
							$proveedorMateriales = new ProveedoresMateriales;
							$proveedorMateriales->id_provedores = $model->id;
							$proveedorMateriales->id_tipos_articulos_inventario = $tipoSuela->id;
							$proveedorMateriales->id_articulo = $id_suela;
							$proveedorMateriales->save();
						}
					}

					if (isset($_POST['Proveedor_tacon'])) {
						foreach ($_POST['Proveedor_tacon']['id_tacon'] as $id_tacon => $value) {
							$proveedorMateriales = new ProveedoresMateriales;
							$proveedorMateriales->id_provedores = $model->id;
							$proveedorMateriales->id_tipos_articulos_inventario = $tipoTacon->id;
							$proveedorMateriales->id_articulo = $id_tacon;
							$proveedorMateriales->save();
						}
					}

					if (isset($_POST['Proveedor_material'])) {
						foreach ($_POST['Proveedor_material']['id_material'] as $id_material => $value) {
							$proveedorMateriales = new ProveedoresMateriales;
							$proveedorMateriales->id_provedores = $model->id;
							$proveedorMateriales->id_tipos_articulos_inventario = $tipoMateriales->id;
							$proveedorMateriales->id_articulo = $id_material;
							$proveedorMateriales->save();
						}
					}

					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'direccion'=>$direccion,
			'materiales'=>$materialesDisponibles,
			'tacones'=>$taconesDisponibles,
			'suelas'=>$suelasDisponibles,
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
		$direccion = $model->direccion;
		//Determinar materiales a seleccionar
		$materialesOcupados = ProveedoresMateriales::model()->with(array('tiposArticulosInventario'=>array('alias'=>'tipoArticulo')))->findAll(array('select'=>'id_articulo', 'condition'=>'tipoArticulo.tipo=:tipo AND id_provedores!=:id_provedor', 'params'=>array('tipo'=>'Materiales', 'id_provedor'=>$id)));
		$idsMaterialesOcupados = array();
		foreach ($materialesOcupados as $mo) {
			array_push($idsMaterialesOcupados, $mo->id_articulo);
		}
		if (empty($idsMaterialesOcupados)) {
			$materialesDisponibles = Materiales::model()->findAll();
		}
		else {
			$materialesDisponibles = Materiales::model()->findAll(array(
						'condition'=>'id NOT IN('.implode(',',$idsMaterialesOcupados).')'
					)
			);
		}

		//Determinar tacones a seleccionar
		$taconesOcupados = ProveedoresMateriales::model()->with(array('tiposArticulosInventario'=>array('alias'=>'tipoArticulo')))->findAll(array('select'=>'id_articulo', 'condition'=>'tipoArticulo.tipo=:tipo AND id_provedores!=:provedor', 'params'=>array('tipo'=>'Tacones', 'provedor'=>$id)));
		$idsTaconesOcupados = array();
		foreach ($taconesOcupados as $to) {
			array_push($idsTaconesOcupados, $to->id_articulo);
		}
		if (empty($idsTaconesOcupados)) {
			$taconesDisponibles = Tacones::model()->findAll();
		}
		else {
			$taconesDisponibles = Tacones::model()->findAll(array(
						'condition'=>'id NOT IN('.implode(',',$idsTaconesOcupados).')'
					)
			);
		}

		//Determinar suelas a seleccionar
		$suelasOcupados = ProveedoresMateriales::model()->with(array('tiposArticulosInventario'=>array('alias'=>'tipoArticulo')))->findAll(array('select'=>'id_articulo', 'condition'=>'tipoArticulo.tipo=:tipo AND id_provedores!=:provedor', 'params'=>array('tipo'=>'Suelas', 'provedor'=>$id)));
		$idsSuelasOcupados = array();
		foreach ($suelasOcupados as $to) {
			array_push($idsSuelasOcupados, $to->id_articulo);
		}
		if (empty($idsSuelasOcupados)) {
			$suelasDisponibles = Suelas::model()->findAll();
		}
		else {
			$suelasDisponibles = Suelas::model()->findAll(array(
						'condition'=>'id NOT IN('.implode(',',$idsSuelasOcupados).')'
					)
			);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Provedores']))
		{
			// print_r($_POST);
			// return;
			$transaction = Yii::app()->db->beginTransaction();
			foreach ($model->proveedorMateriales as $pMaterial) {
				$pMaterial->delete();
			}
			$model->attributes=$_POST['Provedores'];
			$model->validate();

			if (isset($_POST['Agregar_direccion'])) {
				$direccion->attributes = $_POST['Direcciones'];
			}
			else {
				$direccion->calle = 'No especificado';
				$direccion->numero_ext = 'S/N';
				$direccion->codigo_postal = 'No especificado';
				$direccion->colonia = 'No especificado';
				$direccion->ciudad = 'No especificado';
				$direccion->pais = 'No especificado';
			}
			if($direccion->save()){
				$model->id_direcciones = $direccion->id;
				if($model->save()){
					$tipoSuela = TiposArticulosInventario::model()->find('tipo=?', array('Suelas'));
					$tipoTacon = TiposArticulosInventario::model()->find('tipo=?', array('Tacones'));
					$tipoMateriales = TiposArticulosInventario::model()->find('tipo=?', array('Materiales'));

					if (isset($_POST['Proveedor_suela'])) {
						foreach ($_POST['Proveedor_suela']['id_suela'] as $id_suela => $value) {
							$proveedorMateriales = new ProveedoresMateriales;
							$proveedorMateriales->id_provedores = $model->id;
							$proveedorMateriales->id_tipos_articulos_inventario = $tipoSuela->id;
							$proveedorMateriales->id_articulo = $id_suela;
							$proveedorMateriales->save();
						}
					}

					if (isset($_POST['Proveedor_tacon'])) {
						foreach ($_POST['Proveedor_tacon']['id_tacon'] as $id_tacon => $value) {
							$proveedorMateriales = new ProveedoresMateriales;
							$proveedorMateriales->id_provedores = $model->id;
							$proveedorMateriales->id_tipos_articulos_inventario = $tipoTacon->id;
							$proveedorMateriales->id_articulo = $id_tacon;
							$proveedorMateriales->save();
						}
					}

					if (isset($_POST['Proveedor_material'])) {
						foreach ($_POST['Proveedor_material']['id_material'] as $id_material => $value) {
							$proveedorMateriales = new ProveedoresMateriales;
							$proveedorMateriales->id_provedores = $model->id;
							$proveedorMateriales->id_tipos_articulos_inventario = $tipoMateriales->id;
							$proveedorMateriales->id_articulo = $id_material;
							$proveedorMateriales->save();
						}
					}

					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'direccion'=>$direccion,
			'materiales'=>$materialesDisponibles,
			'tacones'=>$taconesDisponibles,
			'suelas'=>$suelasDisponibles,
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

		foreach ($model->proveedorMateriales as $material) {
			$material->delete();
		}
		$direccion = $model->direccion;
		$model->delete();
		$direccion->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Provedores');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Provedores('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Provedores']))
			$model->attributes=$_GET['Provedores'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Provedores the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Provedores::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Provedores $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='provedores-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionVerAdeudos()
	{
		$deudas = DeudasPedidosProveedores::model()->findAll(array('order'=>'t.id_provedores'));
		$deudasPorProveedor = array();
		foreach ($deudas as $deudaProveedor) {
			if (!isset($deudasPorProveedor[$deudaProveedor->proveedor->nombre])) {
				$deudasPorProveedor[$deudaProveedor->proveedor->nombre] = 0;
			}
			$deudasPorProveedor[$deudaProveedor->proveedor->nombre] += $deudaProveedor->cantidad;
		}
		$this->render('adeudos', array('deudasPorProveedor'=>$deudasPorProveedor));
	}
}
