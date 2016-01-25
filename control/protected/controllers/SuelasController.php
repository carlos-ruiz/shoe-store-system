<?php

class SuelasController extends Controller
{
	public $section = 'suelas';
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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new Suelas;
		$colores = Colores::model()->findAll();
		$mensaje_error = null;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Suelas']))
		{
			$model->attributes=$_POST['Suelas'];
			$todo_bien = true;
			if (!isset($_POST['SuelasColores']['id_colores'])) {
				$todo_bien = false;
				$mensaje_error = '<br/> - Debe elegir al menos un color de suela.';
			}
			if (!isset($_POST['SuelasNumeros']['numero'])) {
				$todo_bien = false;
				$mensaje_error .= '<br/> - Debe elegir al menos un número de suela.';
			}
			if($todo_bien && $model->save()){
				foreach ($_POST['SuelasColores']['id_colores'] as $id => $value) {
					$suelaColor = new SuelasColores;
					$suelaColor->id_suelas = $model->id;
					$suelaColor->id_colores = $id;
					$suelaColor->save();
				}
				foreach ($_POST['SuelasNumeros']['numero'] as $numero => $value) {
					$suelaNumero = new SuelasNumeros;
					$suelaNumero->numero = $numero;
					$suelaNumero->id_suelas = $model->id;
					$suelaNumero->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'colores'=>$colores,
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
		$mensaje_error = null;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Suelas']))
		{
			$todo_bien = true;
			$model->attributes=$_POST['Suelas'];
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$ids_colores_actuales = array();
				if (isset($_POST['SuelasColores']['id_colores'])) {
					foreach ($_POST['SuelasColores']['id_colores'] as $id => $value) {
						array_push($ids_colores_actuales, $id);
					}
				}
				if (sizeof($ids_colores_actuales)<1) {
					$todo_bien = false;
					$mensaje_error = '<br/> - Dede elegir al menos un color de suela.';
				}
				$numeros_actuales = array();
				if (isset($_POST['SuelasNumeros']['numero'])) {
					foreach ($_POST['SuelasNumeros']['numero'] as $numero => $value) {
						array_push($numeros_actuales, $numero);
					}
				}
				if (sizeof($numeros_actuales)<1) {
					$todo_bien = false;
					$mensaje_error .= '<br/> - Dede elegir al menos un número de suela.';
				}
				if($todo_bien){
					foreach ($model->suelasColores as $suelaColor) {
						if(!in_array($suelaColor->color->id, $ids_colores_actuales)){
							$suelaColor->delete();
						}else{
							$ids_colores_actuales = array_diff($ids_colores_actuales, array($suelaColor->color->id));
						}
					}
					foreach ($model->suelaNumeros as $suelaNumero) {
						if(!in_array($suelaNumero->numero, $numeros_actuales)){
							$suelaNumero->delete();
						}
						else{
							$numeros_actuales = array_diff($numeros_actuales, array($suelaNumero->numero));
						}
					}
					if($model->save()){
						foreach ($ids_colores_actuales as $id) {
							$suelaColor = new SuelasColores;
							$suelaColor->id_suelas = $model->id;
							$suelaColor->id_colores = $id;
							$suelaColor->save();
						}
						foreach ($numeros_actuales as $numero) {
							$suelaNumero = new SuelasNumeros;
							$suelaNumero->numero = $numero;
							$suelaNumero->id_suelas = $model->id;
							$suelaNumero->save();
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Suelas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Suelas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Suelas']))
			$model->attributes=$_GET['Suelas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Suelas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Suelas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Suelas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='suelas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
