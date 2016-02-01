<?php

class ZapatosController extends Controller
{
	public $section = 'extras';
	public $subsection = 'zapatos';
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
			// 'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('admin','delete', 'suelasPorModelo', 'coloresPorModelo', 'numerosPorModelo','actualizarPrecio'),
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
		$model=new Zapatos('catalog');
		$zapatoPrecios=new ZapatoPrecios;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ZapatoPrecios']))
		{
			// $model->attributes=$_POST['Zapatos'];
			$zapatoPrecios->attributes=$_POST['ZapatoPrecios'];

			if($zapatoPrecios->validate()){
				$modeloColores = ModelosColores::model()->findAll('id_modelos=?', array($zapatoPrecios->id_modelos));

				foreach ($modeloColores as $modeloColor) {
					$zapatosExistentes = Zapatos::model()->with(array('suelaColor.suela'=>array('alias'=>'suela')))->findAll('t.id_modelos=? AND t.id_colores=? AND suela.id=?', array($modeloColor->id_modelos, $modeloColor->id_colores, $zapatoPrecios->id_suelas));
					if (isset($zapatosExistentes)) {
						foreach ($zapatosExistentes as $zapatoExistente) {
							if($zapatoExistente->numero >= 12 && $zapatoExistente->numero < 18){
								$zapatoExistente->precio = $zapatoPrecios->precio_extrachico;
							}
							else if($zapatoExistente->numero >= 18 && $zapatoExistente->numero < 22){
								$zapatoExistente->precio = $zapatoPrecios->precio_chico;
							}
							else if($zapatoExistente->numero >= 22 && $zapatoExistente->numero < 25){
								$zapatoExistente->precio = $zapatoPrecios->precio_mediano;
							}
							else if($zapatoExistente->numero >= 25 && $zapatoExistente->numero < 32){
								$zapatoExistente->precio = $zapatoPrecios->precio_grande;
							}
							$zapatoExistente->save();
						}
					}

					$modeloNumeros = ModelosNumeros::model()->findAll('id_modelos=?', array($zapatoPrecios->id_modelos));
					foreach ($modeloNumeros as $modeloNumero) {
						$numero = $modeloNumero->numero;
						$zapatoExiste = Zapatos::model()->with(array('suelaColor.suela'=>array('alias'=>'suela')))->find('t.id_modelos=? AND t.id_colores=? AND suela.id=? AND numero=?', array($modeloColor->id_modelos, $modeloColor->id_colores, $zapatoPrecios->id_suelas, $numero));
						if (!isset($zapatoExiste)) {
							$suelaColores = SuelasColores::model()->findAll('id_suelas=?', array($zapatoPrecios->id_suelas));
							foreach ($suelaColores as $suelaColor) {
								$nuevoZapato = new Zapatos;
								$nuevoZapato->id_modelos = $modeloColor->id_modelos;
								$nuevoZapato->id_colores = $modeloColor->id_colores;
								$nuevoZapato->id_suelas_colores = $suelaColor->id;
								$nuevoZapato->numero = $numero;
								$numeroCodigo = str_replace('.', '', $numero);
								$nuevoZapato->codigo_barras = sprintf('%03d',$zapatoPrecios->id_modelos).sprintf('%03d', $suelaColor->id).sprintf('%03d',$modeloColor->id_colores).sprintf('%03d', $numeroCodigo);
								if($numero >= 12 && $numero < 18){
									$nuevoZapato->precio = $zapatoPrecios->precio_extrachico;
								}
								else if($numero >= 18 && $numero < 22){
									$nuevoZapato->precio = $zapatoPrecios->precio_chico;
								}
								else if($numero >= 22 && $numero < 25){
									$nuevoZapato->precio = $zapatoPrecios->precio_mediano;
								}
								else if($numero >= 25 && $numero < 32){
									$nuevoZapato->precio = $zapatoPrecios->precio_grande;
								}
								if ($nuevoZapato->validate()) {
									$nuevoZapato->save();
								}
							}
						}
					}
				}
				$zapatoPreciosExistente = ZapatoPrecios::model()->find('id_modelos=? AND id_suelas=?', array($zapatoPrecios->id_modelos, $zapatoPrecios->id_suelas));
				if (isset($zapatoPreciosExistente)) {
					$zapatoPreciosExistente->precio_extrachico = $zapatoPrecios->precio_extrachico;
					$zapatoPreciosExistente->precio_chico = $zapatoPrecios->precio_chico;
					$zapatoPreciosExistente->precio_mediano = $zapatoPrecios->precio_mediano;
					$zapatoPreciosExistente->precio_grande = $zapatoPrecios->precio_grande;
					$zapatoPreciosExistente->save();
				}
				else{
					$zapatoPrecios->save();
				}
				
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'zapatoPrecios'=>$zapatoPrecios,
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
		$model->id_modelos = $model->modeloColor->modelo->id;
		$model->id_colores = $model->modeloColor->color->id;
		$modeloNumero = ModelosNumeros::model()->find('id_modelos=? AND numero=?', array($model->id_modelos, $model->numero));
		$model->numero = $modeloNumero->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Zapatos']))
		{
			$model->attributes=$_POST['Zapatos'];
			$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($model->id_modelos, $model->id_colores));
			$model->id_modelos_colores = $modeloColor->id;
			$modeloNumero = ModelosNumeros::model()->findByPk($model->numero);
			$model->numero = $modeloNumero->numero;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('Zapatos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Zapatos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Zapatos'])){
			echo "hola";
			$model->attributes=$_GET['Zapatos'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Zapatos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Zapatos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Zapatos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='zapatos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSuelasPorModelo()
	{
		$list = ModelosSuelas::model()->findAll("id_modelos=?",array($_POST["ZapatoPrecios"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->suela->id}\">{$data->suela->nombre}</option>";
	}

	public function actionColoresPorModelo()
	{
		$list = ModelosColores::model()->findAll("id_modelos=?",array($_POST["ZapatoPrecios"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionNumerosPorModelo()
	{
		$list = ModelosNumeros::model()->findAll("id_modelos=?",array($_POST["ZapatoPrecios"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->id}\">{$data->numero}</option>";
	}

	public function actionActualizarPrecio()
	{
		$id = $_POST["id_zapato"];
        $precio = $_POST["precio"];

        $zapato = Zapatos::model()->findByPk($id);
        $zapato->precio = $precio;
        $zapato->save();
        echo $precio;
	}
}
