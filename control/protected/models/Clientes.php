<?php

/**
 * This is the model class for table "clientes".
 *
 * The followings are the available columns in table 'clientes':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $rfc
 * @property string $razon_social
 * @property integer $id_tipo_cliente
 * @property integer $id_direcciones
 * @property string $telefono
 * @property string $celular
 * @property string $correo_electronico
 *
 * The followings are the available model relations:
 * @property Direcciones $idDirecciones
 * @property TipoCliente $idTipoCliente
 * @property Pedidos[] $pedidoses
 */
class Clientes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, apellido_paterno, id_tipo_cliente, id_direcciones, telefono', 'required'),
			array('id_tipo_cliente, id_direcciones', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido_paterno, apellido_materno', 'length', 'max'=>256),
			array('rfc', 'length', 'max'=>13),
			array('razon_social', 'length', 'max'=>512),
			array('telefono, celular', 'length', 'max'=>45),
			array('correo_electronico', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, apellido_paterno, apellido_materno, rfc, razon_social, id_tipo_cliente, id_direcciones, telefono, celular, correo_electronico', 'safe', 'on'=>'search'),
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
			'direccion' => array(self::BELONGS_TO, 'Direcciones', 'id_direcciones'),
			'tipoCliente' => array(self::BELONGS_TO, 'TipoCliente', 'id_tipo_cliente'),
			'pedidos' => array(self::HAS_MANY, 'Pedidos', 'id_clientes'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'apellido_paterno' => 'Apellido Paterno',
			'apellido_materno' => 'Apellido Materno',
			'rfc' => 'RFC',
			'razon_social' => 'Razon Social',
			'id_tipo_cliente' => 'Tipo de cliente',
			'id_direcciones' => 'Id Direcciones',
			'telefono' => 'Teléfono',
			'celular' => 'Celular',
			'correo_electronico' => 'Correo electrónico',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido_paterno',$this->apellido_paterno,true);
		$criteria->compare('apellido_materno',$this->apellido_materno,true);
		$criteria->compare('rfc',$this->rfc,true);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('id_tipo_cliente',$this->id_tipo_cliente);
		$criteria->compare('id_direcciones',$this->id_direcciones);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('correo_electronico',$this->correo_electronico,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerNombreCompleto()
	{
		return $this->nombre.' '.$this->apellido_paterno.' '.$this->apellido_materno;
	}

	public function obtenerClientes(){
		$clientes = Clientes::model()->findAll(array('order'=>'nombre'));
		$listData = array();
		foreach ($clientes as $cliente) {
			$listData[$cliente->id] = $cliente->obtenerNombreCompleto().'('.$cliente->direccion->ciudad.')';
		}
		return $listData;
	}
}
