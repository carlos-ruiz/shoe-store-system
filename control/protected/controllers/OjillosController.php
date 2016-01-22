<?php

class OjillosController extends Controller
{
	public $section = 'ojillos';
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
		$model=new Ojillos;
		$colores = Colores::model()->findAll();
		$mensaje_error = null;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ojillos']))
		{
			$model->attributes=$_POST['Ojillos'];
			$coloresSeleccionados = array();
			if (isset($_POST['OjillosColores'])) {
				if(isset($_POST['OjillosColores']['id_colores'])){
					$coloresSeleccionados = $_POST['OjillosColores']['id_colores'];
				}
			}

			if (sizeof($coloresSeleccionados)>0) {
				if($model->save()){
					foreach ($coloresSeleccionados as $id_color => $value) {
						$ojilloColor = new OjillosColores;
						$ojilloColor->id_colores = $id_color;
						$ojilloColor->id_ojillos = $model->id;
						$ojilloColor->save();
					}
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			else{
				$mensaje_error = 'Debe seleccionar al menos un color';
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

		if(isset($_POST['Ojillos']))
		{
			$model->attributes=$_POST['Ojillos'];

			$coloresSeleccionados = array();
			if (isset($_POST['OjillosColores'])) {
				if(isset($_POST['OjillosColores']['id_colores'])){
					$coloresSeleccionados = $_POST['OjillosColores']['id_colores'];
				}
			}
			if (sizeof($coloresSeleccionados)>0) {
				$id_colores_seleccionados = array();
				foreach ($coloresSeleccionados as $id_color => $value) {
					array_push($id_colores_seleccionados, $id_color);
				}
				foreach ($model->ojillosColores as $ojilloColor) {
					if(!in_array($ojilloColor->color->id, $id_colores_seleccionados)){
						$ojilloColor->delete();
					}
					else{
						$id_colores_seleccionados = array_diff($id_colores_seleccionados, array($ojilloColor->color->id));
					}
				}
				if($model->save()){
					foreach ($id_colores_seleccionados as $id_color) {
						$ojilloColor = new OjillosColores;
						$ojilloColor->id_colores = $id_color;
						$ojilloColor->id_ojillos = $model->id;
						$ojilloColor->save();
					}
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			else{
				$mensaje_error = 'Debe seleccionar al menos un color';
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
		$dataProvider=new CActiveDataProvider('Ojillos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ojillos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ojillos']))
			$model->attributes=$_GET['Ojillos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ojillos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ojillos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ojillos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ojillos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
