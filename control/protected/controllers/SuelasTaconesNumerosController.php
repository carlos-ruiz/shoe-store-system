<?php

class SuelasTaconesNumerosController extends Controller
{
	public $section = 'extras';
	public $subsection = 'numeros_suelas_tacones';

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
		$suelas = Suelas::model()->findAll('activo=1');
		if (isset($_POST['Configuracion'])) {
			$datos = $_POST['Configuracion'];
			$transaction = Yii::app()->db->beginTransaction();
			try{
				if (isset($datos['suela'])) {
					$suelasTaconesnumeros = SuelasTaconesNumeros::model()->findAll();
					foreach ($suelasTaconesnumeros as $stn) {
						$stn->delete();
					}
					foreach ($datos['suela'] as $clave => $id_suela) {
						foreach ($datos['numeros'][$clave] as $numero_suela => $id_tacon_numero) {
							if (isset($id_tacon_numero)) {
								$suelaNumero = SuelasNumeros::model()->find('id_suelas=? AND numero=?', array($id_suela, $numero_suela));
								$suelaTaconNumero = new SuelasTaconesNumeros;
								$suelaTaconNumero->id_suelas_numeros = $suelaNumero->id;
								$suelaTaconNumero->id_tacones_numeros = $id_tacon_numero;
								$suelaTaconNumero->save();
							}
						}
					}
				}
				$transaction->commit();
			}catch(Exception $ex){
				print_r($ex);
				$transaction->rollback();
			}
		}
		$this->render('admin', array(
			'suelas' => $suelas,
		));
	}

}
