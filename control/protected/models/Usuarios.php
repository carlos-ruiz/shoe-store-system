<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id
 * @property string $usuario
 * @property string $contrasenia
 * @property string $creacion
 * @property string $ultima_modificacion
 * @property integer $id_perfiles_usuarios
 *
 * The followings are the available model relations:
 * @property PerdidasMateriales[] $perdidasMateriales
 * @property PerfilesUsuarios $idPerfilesUsuarios
 * @property ZapatoCortador[] $zapatoCortadors
 */
class Usuarios extends CActiveRecord
{
	public $var_perfil;
	public $confirmarContrasenia;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, contrasenia, creacion, ultima_modificacion, id_perfiles_usuarios', 'required'),
			array('confirmarContrasenia', 'required', 'on'=>'createForm'),
			array('contrasenia', 'compare', 'compareAttribute' => 'confirmarContrasenia', 'on' => 'createForm'),
			array('id_perfiles_usuarios', 'numerical', 'integerOnly'=>true),
			array('usuario', 'length', 'max'=>45),
			array('contrasenia, confirmarContrasenia', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, contrasenia, creacion, ultima_modificacion, id_perfiles_usuarios, var_perfil', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'perdidasMateriales' => array(self::HAS_MANY, 'PerdidasMateriales', 'id_usuarios'),
			'perfil' => array(self::BELONGS_TO, 'PerfilesUsuarios', 'id_perfiles_usuarios'),
			'zapatoCortador' => array(self::HAS_MANY, 'ZapatoCortador', 'id_usuarios'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'contrasenia' => 'Contrase??a',
			'confirmarContrasenia' => 'Confirmar contrase??a',
			'creacion' => 'Creaci??n',
			'ultima_modificacion' => '??ltima modificaci??n',
			'id_perfiles_usuarios' => 'Perfil de usuario',
			'var_perfil' => 'Perfil de usuario',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('contrasenia',$this->contrasenia,true);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('ultima_modificacion',$this->ultima_modificacion,true);
		$criteria->compare('id_perfiles_usuarios',$this->id_perfiles_usuarios);
		$criteria->with = array('perfil');
		$criteria->compare('perfil.nombre',$this->var_perfil,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'var_perfil'=>array(
						'asc'=>'perfil.nombre ASC',
						'desc'=>'perfil.nombre DESC',
					),
					'*',
				),
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerPorPerfil($perfil) {
		$perfil = PerfilesUsuarios::model()->find('nombre=?', array($perfil));
		$usuarios = $this->model()->findAll("id_perfiles_usuarios=?", array($perfil->id));
		$nombresDeUsuario = array();
		foreach ($usuarios as $usuario) {
			array_push($nombresDeUsuario, $usuario->usuario);
		}
		return $nombresDeUsuario;
	}
}
