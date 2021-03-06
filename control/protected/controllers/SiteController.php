<?php

class SiteController extends Controller
{
	public $section;
	public $subSection;
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->section = 'index';
		$this->subSection = 'index';

		
		$this->init();

		if(Yii::app()->user->isGuest){
			$this->layout='//layouts/loginForm';
		}

		if (!Yii::app()->user->isGuest && Yii::app()->user->getState('perfil') != 'Administrador') {
			$this->redirect(array('pedidos/seguimiento'));
		}

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index',array('model'=>$model));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->redirect(array('index'));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function init()
	{
		$this->crearPerfilesUsuario();
		$this->crearEstatusDePedido();
		$this->crearEstatusDePagos();
		$this->crearEstatusDeZapatos();
		$this->crearFormasDePago();
		$this->inicializarTiposDeInventarios();
		$this->inicializarMaterialesNecesarios();
		if(Usuarios::model()->find('usuario=?', array('admin')) == null){
			$perfilAdministrador = PerfilesUsuarios::model()->find('nombre=?', array('Administrador'));
			$usuario = new Usuarios;
			$usuario->usuario = 'admin';
			$usuario->contrasenia = base64_encode('admin');
			$usuario->id_perfiles_usuarios = $perfilAdministrador->id;
			$usuario->creacion = date('Y-m-d H:i:s');
			$usuario->ultima_modificacion = '2000-01-01 00:00:00';
			$usuario->save();
		}
	}

	public function crearPerfilesUsuario()
	{
		if(PerfilesUsuarios::model()->count()==0){
			$perfil = new PerfilesUsuarios;
			$perfil->nombre="Administrador";
			$perfil->save();
			$perfil = new PerfilesUsuarios;
			$perfil->nombre="Cortador";
			$perfil->save();
			$perfil = new PerfilesUsuarios;
			$perfil->nombre="Pespuntador";
			$perfil->save();
			$perfil = new PerfilesUsuarios;
			$perfil->nombre="Ensuelador";
			$perfil->save();
		}
	}

	public function crearEstatusDePedido()
	{
		if(EstatusPedidos::model()->count()==0){
			$estatus = new EstatusPedidos;
			$estatus->nombre="Pendiente";
			$estatus->save();
			$estatus = new EstatusPedidos;
			$estatus->nombre="En proceso";
			$estatus->save();
			$estatus = new EstatusPedidos;
			$estatus->nombre="Terminado";
			$estatus->save();
			$estatus = new EstatusPedidos;
			$estatus->nombre="Entregado";
			$estatus->save();
		}
	}

	public function crearEstatusDePagos()
	{
		if(EstatusPagos::model()->count()==0){
			$estatus = new EstatusPagos;
			$estatus->nombre="Pendiente de pago";
			$estatus->save();
			$estatus = new EstatusPagos;
			$estatus->nombre="Pago parcial";
			$estatus->save();
			$estatus = new EstatusPagos;
			$estatus->nombre="Pagado";
			$estatus->save();
		}
	}

	public function crearEstatusDeZapatos()
	{
		if(EstatusZapatos::model()->count()==0){
			$estatus = new EstatusZapatos;
			$estatus->nombre="Pendiente";
			$estatus->save();
			$estatus = new EstatusZapatos;
			$estatus->nombre="En corte";
			$estatus->save();
			$estatus = new EstatusZapatos;
			$estatus->nombre="En pespunte";
			$estatus->save();
			$estatus = new EstatusZapatos;
			$estatus->nombre="En ensuelado";
			$estatus->save();
			$estatus = new EstatusZapatos;
			$estatus->nombre="En adorno";
			$estatus->save();
			$estatus = new EstatusZapatos;
			$estatus->nombre="Terminado";
			$estatus->save();
		}
	}

	public function crearFormasDePago()
	{
		if (FormasPago::model()->count()==0) {
			$formaDePago = new FormasPago;
			$formaDePago->nombre = 'Efectivo';
			$formaDePago->save();
			$formaDePago = new FormasPago;
			$formaDePago->nombre = 'Cr??dito';
			$formaDePago->save();
			$formaDePago = new FormasPago;
			$formaDePago->nombre = 'Cheque';
			$formaDePago->save();
			$formaDePago = new FormasPago;
			$formaDePago->nombre = 'Tarjeta de cr??dito';
			$formaDePago->save();
			$formaDePago = new FormasPago;
			$formaDePago->nombre = 'Tarjeta de d??bito';
			$formaDePago->save();
			$formaDePago = new FormasPago;
			$formaDePago->nombre = 'Transferencia';
			$formaDePago->save();
		}
	}

	public function inicializarTiposDeInventarios()
	{
		if(TiposArticulosInventario::model()->count()==0){
			$tipoInventario = new TiposArticulosInventario;
			$tipoInventario->tipo = 'Suelas';
			$tipoInventario->save();
			$tipoInventario = new TiposArticulosInventario;
			$tipoInventario->tipo = 'Tacones';
			$tipoInventario->save();
			$tipoInventario = new TiposArticulosInventario;
			$tipoInventario->tipo = 'Agujetas';
			$tipoInventario->save();
			$tipoInventario = new TiposArticulosInventario;
			$tipoInventario->tipo = 'Ojillos';
			$tipoInventario->save();
			$tipoInventario = new TiposArticulosInventario;
			$tipoInventario->tipo = 'Materiales';
			$tipoInventario->save();
		}
	}

	public function inicializarMaterialesNecesarios()
	{
		if (Materiales::model()->count()==0) {
			$material = new Materiales;
			$material->nombre = 'Agujetas';
			$material->unidad_medida = 'Millares';
			$material->activo = 1;
			$material->save();
			$material = new Materiales;
			$material->nombre = 'Ojillos';
			$material->unidad_medida = 'Millares';
			$material->activo = 1;
			$material->save();
			$material = new Materiales;
			$material->nombre = 'Transfer';
			$material->unidad_medida = 'Pares';
			$material->activo = 1;
			$material->save();
		}
	}
}