<?php

class MaterialesController extends Controller
{
	public $section = 'materiales';

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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','create','update','admin','delete'),
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
		$model=new Materiales;
		$colores = Colores::model()->findAll();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Materiales']))
		{
			$model->attributes=$_POST['Materiales'];
			if($model->save()){
				if (isset($_POST['MaterialesColores'])) {
					foreach ($_POST['MaterialesColores']['id_colores'] as $idColor => $value) {
						$materialColor = new MaterialesColores;
						$materialColor->id_colores = $idColor;
						$materialColor->id_materiales = $model->id;
						$materialColor->save();
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'colores'=>$colores,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Materiales']))
		{
			$model->attributes=$_POST['Materiales'];
			$ids_colores_actuales = array();
			if (isset($_POST['MaterialesColores'])) {
				foreach ($_POST['MaterialesColores']['id_colores'] as $id_color => $value) {
					array_push($ids_colores_actuales, $id_color);
				}
			}
			foreach ($model->colores as $modeloColor) {
				if (!in_array($modeloColor->color->id, $ids_colores_actuales)) {
					$modeloColor->delete();
				}else{
					$ids_colores_actuales = array_diff($ids_colores_actuales, array($modeloColor->color->id));
				}
			}
			if($model->save()){
				foreach ($ids_colores_actuales as $id_color) {
					$materialColor = new MaterialesColores;
					$materialColor->id_colores = $id_color;
					$materialColor->id_materiales = $model->id;
					$materialColor->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'colores'=>$colores,
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
		$dataProvider=new CActiveDataProvider('Materiales');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Materiales('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Materiales']))
			$model->attributes=$_GET['Materiales'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Materiales the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Materiales::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Materiales $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='materiales-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
