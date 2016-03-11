<?php

class ModelosSuelasNumerosController extends Controller
{
	public $section = 'extras';
	public $subsection = 'numeros_suelas_modelos';

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
				'actions'=>array('admin'),
				'users'=>Usuarios::model()->obtenerPorPerfil('Administrador'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAdmin()
	{
		$modelos = Modelos::model()->findAll();

		if (isset($_POST['Configuracion'])) {
			$datos = $_POST['Configuracion'];
			if (isset($datos['modelo'])) {
				$modelosSuelasNumerosTodos = ModelosSuelasNumeros::model()->findAll();
				foreach ($modelosSuelasNumerosTodos as $msn) {
					$msn->delete();
				}
				foreach ($datos['modelo'] as $clave => $id_modelo) {
					foreach ($datos['numeros'][$clave] as $numero_modelo => $id_suela_numero) {
						if (isset($id_suela_numero)) {
							$modeloNumero = ModelosNumeros::model()->find('id_modelos=? AND numero=?', array($id_modelo, $numero_modelo));
							$modeloSuelaNumero = new ModelosSuelasNumeros;
							$modeloSuelaNumero->id_modelos_numeros = $modeloNumero->id;
							$modeloSuelaNumero->id_suelas_numeros = $id_suela_numero;
							$modeloSuelaNumero->save();
						}
					}
				}
			}
		}
		$this->render('admin', array(
			'modelos' => $modelos,
		));
	}
}