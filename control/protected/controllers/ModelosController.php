<?php

class ModelosController extends Controller
{
	public $section = 'modelos';
	public $subsection = '';
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
				'actions'=>array('create','update', 'delete', 'generarEtiqueta', 'coloresPorModelo', 'numerosPorModelo'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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

		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Modelos;
		$colores = Colores::model()->findAll();
		$suelas = Suelas::model()->findAll();
		$materiales = Materiales::model()->findAll();
		$mensaje_error = null;
		$folderImagesPath = Yii::getPathOfAlias('webroot').'/images/modelos/';
		if(!is_dir($folderImagesPath)) {
			mkdir($folderImagesPath);
			chmod($folderImagesPath, 0755);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Modelos']))
		{
			// print_r($_POST);
			// return;
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Modelos'];

				//Guardando la imagen seleccionada
				$uploadedFile = CUploadedFile::getInstance($model,'imagen');
				if(isset($uploadedFile)){
					$tempNameArray = explode('.',$uploadedFile->name);
					$ext = ".".$tempNameArray[sizeof($tempNameArray)-1];
		            $fileName = time().rand(1, 999).$ext;
					$uploadedFile->saveAs($folderImagesPath.$fileName);
					$model->imagen = Yii::app()->request->baseUrl."/images/modelos/".$fileName;
				}
				if($model->save()){
					$todo_bien = true;
					$error_suelas = true;
					if(isset($_POST['ModelosSuelas'])){
						foreach ($_POST['ModelosSuelas']['id_suelas'] as $id => $value) {
							$modeloSuela = new ModelosSuelas;
							$modeloSuela->id_modelos = $model->id;
							$modeloSuela->id_suelas = $id;
							$modeloSuela->save();
							$error_suelas = false;
						}
					}
					if($error_suelas){
						$mensaje_error = '<br/> - Debe elegir al menos un tipo de suela.';
						$todo_bien = false;
					}

					$error_colores = true;
					if(isset($_POST['ModelosColores'])){
						foreach ($_POST['ModelosColores']['id_colores'] as $id => $value) {
							$modeloColor = new ModelosColores;
							$modeloColor->id_modelos = $model->id;
							$modeloColor->id_colores = $id;
							$modeloColor->save();
							$error_colores = false;
						}
					}
					if ($error_colores) {
						$mensaje_error .= '<br/> - Debe elegir al menos un color.';
						$todo_bien = false;
					}

					$error_numeros = true;
					if(isset($_POST['ModelosNumeros'])){
						foreach ($_POST['ModelosNumeros']['numero'] as $numero => $value) {
							$modeloNumero = new ModelosNumeros;
							$modeloNumero->id_modelos = $model->id;
							$modeloNumero->numero = $numero;
							$modeloNumero->save();
							$error_numeros = false;
						}
					}
					if ($error_numeros) {
						$mensaje_error .= '<br/> - Debe elegir al menos un número.';
						$todo_bien = false;
					}

					if (isset($_POST['ModelosMateriales'])) {
						if (isset($_POST['ModelosMateriales']['id_materiales'])) {
							foreach ($_POST['ModelosMateriales']['id_materiales'] as $id => $value) {
								$material = Materiales::model()->findByPk($id);
								$modeloMaterial = new ModelosMateriales;
								$modeloMaterial->id_modelos = $model->id;
								$modeloMaterial->id_materiales = $id;
								$modeloMaterial->cantidad_extrachico = $_POST['ModelosMateriales']['cantidades'][$id]['cantidad_extrachico'];
								$modeloMaterial->cantidad_chico = $_POST['ModelosMateriales']['cantidades'][$id]['cantidad_chico'];
								$modeloMaterial->cantidad_mediano = $_POST['ModelosMateriales']['cantidades'][$id]['cantidad_mediano'];
								$modeloMaterial->cantidad_grande = $_POST['ModelosMateriales']['cantidades'][$id]['cantidad_grande'];
								$modeloMaterial->unidad_medida = $material->unidad_medida;
								$modeloMaterial->save();
							}
						}	
					}

					if ($todo_bien) {
						$transaction->commit();
						$this->redirect(array('view','id'=>$model->id));
					}
				}
			}catch(Exception $ex){
				$transaction->rollback();
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'colores'=>$colores, 
			'suelas'=>$suelas,
			'materiales'=>$materiales,
			'mensaje_error'=>$mensaje_error,
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
		$colores = Colores::model()->findAll();
		$suelas = Suelas::model()->findAll();
		$materiales = Materiales::model()->findAll();
		$mensaje_error = null;
		$folderImagesPath = Yii::getPathOfAlias('webroot').'/images/modelos/';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Modelos']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$todo_bien = true;
				$ids_suelas_actuales = array();
				if(isset($_POST['ModelosSuelas'])){
					foreach ($_POST['ModelosSuelas']['id_suelas'] as $id_suela => $value){
						array_push($ids_suelas_actuales, $id_suela);
					}
				}
				if (sizeof($ids_suelas_actuales) < 1) {
					$mensaje_error = '<br/> - Debe elegir al menos un tipo de suela.';
					$todo_bien = false;
				}
				foreach ($model->modelosSuelas as $modeloSuela) {
					if (!in_array($modeloSuela->suela->id, $ids_suelas_actuales)) {
						$modeloSuela->delete();
					}else{
						$ids_suelas_actuales = array_diff($ids_suelas_actuales, array($modeloSuela->suela->id));
					}
				}

				$ids_colores_actuales = array();
				if(isset($_POST['ModelosColores'])){
					foreach ($_POST['ModelosColores']['id_colores'] as $id_color => $value){
						array_push($ids_colores_actuales, $id_color);
					}
				}
				if (sizeof($ids_colores_actuales) < 1) {
					$mensaje_error = '<br/> - Debe elegir al menos un color.';
					$todo_bien = false;
				}
				foreach ($model->modelosColores as $modeloColor) {
					if (!in_array($modeloColor->color->id, $ids_colores_actuales)) {
						$modeloColor->delete();
					}else{
						$ids_colores_actuales = array_diff($ids_colores_actuales, array($modeloColor->color->id));
					}
				}

				$numeros_actuales = array();
				if(isset($_POST['ModelosNumeros'])){
					foreach ($_POST['ModelosNumeros']['numero'] as $numero => $value){
						array_push($numeros_actuales, $numero);
					}
				}
				if (sizeof($numeros_actuales) < 1) {
					$mensaje_error = '<br/> - Debe elegir al menos un número.';
					$todo_bien = false;
				}
				foreach ($model->modelosNumeros as $modeloNumero) {
					if (!in_array($modeloNumero->numero, $numeros_actuales)) {
						$modeloNumero->delete();
					}else{
						$numeros_actuales = array_diff($numeros_actuales, array($modeloNumero->numero));
					}
				}
				foreach ($model->modelosMateriales as $modeloMaterial) {
					$modeloMaterial->delete();
				}

				$model->attributes=$_POST['Modelos'];

				//Guardando la imagen seleccionada
				$uploadedFile = CUploadedFile::getInstance($model,'imagen');
				if (isset($uploadedFile)) {
					$tempNameArray = explode('.',$uploadedFile->name);
					$ext = ".".$tempNameArray[sizeof($tempNameArray)-1];
		            $fileName = time().rand(1, 999).$ext;
					$uploadedFile->saveAs($folderImagesPath.$fileName);
					$model->imagen = Yii::app()->request->baseUrl."/images/modelos/".$fileName;
				}
				if($todo_bien){
					if($model->save()){
						foreach ($ids_suelas_actuales as $id) {
							$modeloSuela = new ModelosSuelas;
							$modeloSuela->id_modelos = $model->id;
							$modeloSuela->id_suelas = $id;
							$modeloSuela->save();
						}

						foreach ($ids_colores_actuales as $id) {
							$modeloColor = new ModelosColores;
							$modeloColor->id_modelos = $model->id;
							$modeloColor->id_colores = $id;
							$modeloColor->save();
						}

						foreach ($numeros_actuales as $numero) {
							$modeloNumero = new ModelosNumeros;
							$modeloNumero->id_modelos = $model->id;
							$modeloNumero->numero = $numero;
							$modeloNumero->save();
						}

						if (isset($_POST['ModelosMateriales'])) {
							if (isset($_POST['ModelosMateriales']['id_materiales'])) {
								foreach ($_POST['ModelosMateriales']['id_materiales'] as $id => $value) {
									$modeloMaterial = new ModelosMateriales;
									$modeloMaterial->id_modelos = $model->id;
									$modeloMaterial->id_materiales = $id;
									$modeloMaterial->cantidad_extrachico = $_POST['ModelosMateriales']['cantidades'][$id]['cantidad_extrachico'];
									$modeloMaterial->cantidad_chico = $_POST['ModelosMateriales']['cantidades'][$id]['cantidad_chico'];
									$modeloMaterial->cantidad_mediano = $_POST['ModelosMateriales']['cantidades'][$id]['cantidad_mediano'];
									$modeloMaterial->cantidad_grande = $_POST['ModelosMateriales']['cantidades'][$id]['cantidad_grande'];
									$modeloMaterial->save();
								}
							}
						}

						$transaction->commit();
						$this->redirect(array('view','id'=>$model->id));
					}
				}
			}catch(Exception $ex){
				$transaction->rollback();
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'colores'=>$colores, 
			'suelas'=>$suelas,
			'materiales'=>$materiales,
			'mensaje_error'=>$mensaje_error,
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
			foreach ($model->modelosSuelas as $modeloSuela) {
				$modeloSuela->delete();
			}
			foreach ($model->modelosColores as $modeloColor) {
				$modeloColor->delete();
			}
			foreach ($model->modelosMateriales as $modeloMaterial) {
				$modeloMaterial->delete();
			}
			foreach ($model->modelosNumeros as $modeloNumero) {
				$modeloNumero->delete();
			}
			$model->delete();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Modelos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Modelos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Modelos']))
			$model->attributes=$_GET['Modelos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Modelos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Modelos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Modelos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='modelos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGenerarEtiqueta()
	{
		$this->section = 'extras';
		$this->subsection = 'etiquetas';
		$model = new Modelos('generarEtiqueta');
		$model->nombre = 'nada';
		if(isset($_POST['Modelos'])){
			$model->attributes = $_POST['Modelos'];
			if($model->validate()){
				$modelo = $this->loadModel($_POST['Modelos']['id']);
				$color = Colores::model()->findByPk($_POST['Modelos']['id_colores']);
				$numero = ModelosNumeros::model()->findByPk($_POST['Modelos']['numero']);
				$datos = array('modelo'=>$modelo->nombre, 'color'=>$color->color, 'numero'=>$numero->numero, 'foto'=>$modelo->imagen);
				$this->imprimirEtiqueta($datos);
			}
		}
		$this->render('generarEtiqueta', array(
			'model'=>$model,
		));
	}

	public function imprimirEtiqueta($datos)
	{
		$pdf = new ImprimirEtiqueta('P','cm','letter');
		$pdf->AddPage();
		$pdf->contenido($datos);
		$pdf->Output();
	}

	public function actionColoresPorModelo()
	{
		$list = ModelosColores::model()->findAll("id_modelos=?",array($_POST["Modelos"]["id"]));
		foreach($list as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionNumerosPorModelo()
	{
		$list = ModelosNumeros::model()->findAll("id_modelos=?",array($_POST["Modelos"]["id"]));
		foreach($list as $data)
			echo "<option value=\"{$data->id}\">{$data->numero}</option>";
	}
}
