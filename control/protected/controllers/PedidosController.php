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
				'actions'=>array('admin','delete', 'obtenerModelos', 'suelasPorModelo', 'coloresPorModelo', 'numerosPorModelo', 'agregarOrden'),
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
		$pedidoZapato = new PedidosZapatos;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pedidos']))
		{
			$model->attributes=$_POST['Pedidos'];
			if($model->save()){
				if (isset($_POST['pedidoZapato'])) {
					foreach ($_POST['pedidoZapato'] as $idZapato => $cantidad) {
						$pedidoZapato = new PedidosZapatos;
						$pedidoZapato->id_pedidos = $model->id;
						$pedidoZapato->id_zapatos = $idZapato;
						$pedidoZapato->cantidad_total = $cantidad;
						$statusZapatoCreado = EstatusZapatos::model()->find('nombre=?', 'Creado');
						$pedidoZapato->id_estatus_zapatos = $statusZapatoCreado->id;
						$pedidoZapato->completos = 0;
						$pedidoZapato->save();
					}
				}
				if (isset($_POST['PedidosZapatosNuevo'])) {
					foreach ($_POST['PedidosZapatosNuevo']['modelo'] as $i => $value) {
						$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($_POST['PedidosZapatosNuevo']['modelo'][$i], $_POST['PedidosZapatosNuevo']['color'][$i]));
						$zapato = new Zapatos;
						$zapato->id_modelos_colores = $modeloColor->id;
					}
				}
				$this->redirect(array('view','id'=>$model->id));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pedidos']))
		{
			$model->attributes=$_POST['Pedidos'];
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
		foreach($list as $data)
			echo "<option value=\"{$data->suela->id}\">{$data->suela->nombre}</option>";
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

	public function actionAgregarOrden(){
		if (isset($_POST)) {
			$modelo = Modelos::model()->findByPk($_POST['id_modelos']);
			$color = Colores::model()->findByPk($_POST['id_colores']);
			$suela = Suelas::model()->findByPk($_POST['id_suelas']);
			$modeloNumero = ModelosNumeros::model()->findByPk($_POST['numero']);
			$cantidad = $_POST['cantidad'];
			$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($modelo->id, $color->id));
			$zapato = Zapatos::model()->find('id_suelas=? AND id_modelos_colores=? AND numero=?', array($suela->id, $modeloColor->id, $modeloNumero->numero));
			if (isset($zapato)) {
				echo "
				<tr>
					<td>".$modelo->nombre."</td>
					<td>".$color->color."</td>
					<td>".$suela->nombre."</td>
					<td>".$modeloNumero->numero."</td>
					<td>".$zapato->precio."</td>
					<td>".$cantidad."</td>
					<td class='importe_total'>".($cantidad*$zapato->precio)."</td>
					<input type='hidden' name='pedidoZapato[$zapato->id]' value='$cantidad'/>
				</tr>";
			}
			else{
				echo "
				<tr>
					<td>".$modelo->nombre."</td>
					<input type='hidden' name='PedidosZapatosNuevo[modelo][".$_POST['row']."]' value='$modelo->id'/>
					<td>".$color->color."</td>
					<input type='hidden' name='PedidosZapatosNuevo[color][".$_POST['row']."]' value='$color->id'/>
					<td>".$suela->nombre."</td>
					<input type='hidden' name='PedidosZapatosNuevo[suela][".$_POST['row']."]' value='$suela->id'/>
					<td>".$modeloNumero->numero."</td>
					<input type='hidden' name='PedidosZapatosNuevo[numero][".$_POST['row']."]' value='$modeloNumero->numero'/>
					<td class='precio_column_".$_POST['row']."'><input type='text' name='PedidosZapatosNuevo[precio][".$_POST['row']."]' /><div class='agregar_precio btn btn-red-stripped btn-tin' data-id='".$_POST['row']."'>Agregar</div></td>
					<td class='cantidad_column_".$_POST['row']."'>".$cantidad."</td>
					<input type='hidden' name='PedidosZapatosNuevo[cantidad][".$_POST['row']."]' value='$cantidad'/>
					<td class='importe_total total_column_".$_POST['row']."'></td>
				</tr>";
			}
		}

	}
}
