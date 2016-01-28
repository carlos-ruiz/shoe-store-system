<?php

class TaconesController extends Controller
{
	public $section = 'materiaPrima';
	public $subsection = 'tacones';
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
		$model=new Tacones;
		$colores = Colores::model()->findAll();
		$suelas = Suelas::model()->findAll();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tacones']))
		{
			$model->attributes=$_POST['Tacones'];
			if($model->save()){
				foreach ($_POST['TaconesColores']['id_colores'] as $id => $value) {
					$suelaColor = new TaconesColores;
					$suelaColor->id_tacones = $model->id;
					$suelaColor->id_colores = $id;
					$suelaColor->save();
				}
				foreach ($_POST['TaconesNumeros']['numero'] as $numero => $value) {
					$suelaNumero = new TaconesNumeros;
					$suelaNumero->numero = $numero;
					$suelaNumero->id_tacones = $model->id;
					$suelaNumero->save();
				}
				foreach ($_POST['TaconesSuelas']['id_suelas'] as $id_suela => $value) {
					$suelaTacon = new SuelasTacones;
					$suelaTacon->id_suelas = $id_suela;
					$suelaTacon->id_tacones = $model->id;
					$suelaTacon->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'colores'=>$colores,
			'suelas'=>$suelas,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tacones']))
		{
			$model->attributes=$_POST['Tacones'];
			$transaction = Yii::app()->db->beginTransaction();
			try{
				if($model->save()){
					$ids_colores_seleccionados = array();
					if (isset($_POST['TaconesColores']['id_colores'])) {
						foreach ($_POST['TaconesColores']['id_colores'] as $id => $value) {
							array_push($ids_colores_seleccionados, $id);
						}
					}
					foreach ($model->taconesColores as $taconColor) {
						if(!in_array($taconColor->id_colores, $ids_colores_seleccionados)){
							$taconColor->delete();
						}else{
							$ids_colores_seleccionados = array_diff($ids_colores_seleccionados, array($taconColor->id_colores));
						}
					}

					$ids_numeros_seleccionados = array();
					if (isset($_POST['TaconesNumeros']['numero'])) {
						foreach ($_POST['TaconesNumeros']['numero'] as $numero => $value) {
							array_push($ids_numeros_seleccionados, $numero);
						}
					}
					foreach ($model->taconesNumeros as $taconNumero) {
						if(!in_array($taconNumero->numero, $ids_numeros_seleccionados)){
							foreach ($taconNumero->suelasTaconesNumeros as $suelaTaconNumero) {
								$suelaTaconNumero->delete();
							}
							$taconNumero->delete();
						}else{
							$ids_numeros_seleccionados = array_diff($ids_numeros_seleccionados, array($taconNumero->numero));
						}
					}

					$ids_suelas_seleccioandas = array();
					if (isset($_POST['TaconesSuelas']['id_suelas'])) {
						foreach ($_POST['TaconesSuelas']['id_suelas'] as $id => $value) {
							array_push($ids_suelas_seleccioandas, $id);
						}
					}
					foreach ($model->taconesSuelas as $taconSuela) {
						if(!in_array($taconSuela->id_suelas, $ids_suelas_seleccioandas)){
							$taconSuela->delete();
						}
						else{
							$ids_suelas_seleccioandas = array_diff($ids_suelas_seleccioandas, array($taconSuela->id_suelas));
						}
					}
					foreach ($ids_colores_seleccionados as $id) {
						$suelaColor = new TaconesColores;
						$suelaColor->id_tacones = $model->id;
						$suelaColor->id_colores = $id;
						$suelaColor->save();
					}
					foreach ($ids_numeros_seleccionados as $numero) {
						$suelaNumero = new TaconesNumeros;
						$suelaNumero->numero = $numero;
						$suelaNumero->id_tacones = $model->id;
						$suelaNumero->save();
					}
					foreach ($ids_suelas_seleccioandas as $id_suela) {
						$suelaTacon = new SuelasTacones;
						$suelaTacon->id_suelas = $id_suela;
						$suelaTacon->id_tacones = $model->id;
						$suelaTacon->save();
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
			'colores'=>$colores,
			'suelas'=>$suelas,
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
		$dataProvider=new CActiveDataProvider('Tacones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tacones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tacones']))
			$model->attributes=$_GET['Tacones'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tacones the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tacones::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tacones $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tacones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
