<?php

/**
 * This is the model class for table "provedores".
 *
 * The followings are the available columns in table 'provedores':
 * @property integer $id
 * @property string $nombre
 * @property string $telefono
 * @property string $correo_electronico
 * @property integer $id_direcciones
 *
 * The followings are the available model relations:
 * @property Deudas[] $deudases
 * @property Direcciones $idDirecciones
 */
class Provedores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'provedores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, id_direcciones', 'required'),
			array('id_direcciones', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>512),
			array('telefono, correo_electronico', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, telefono, correo_electronico, id_direcciones', 'safe', 'on'=>'search'),
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
			'deudases' => array(self::HAS_MANY, 'Deudas', 'id_provedores'),
			'idDirecciones' => array(self::BELONGS_TO, 'Direcciones', 'id_direcciones'),
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
			'telefono' => 'Telefono',
			'correo_electronico' => 'Correo Electronico',
			'id_direcciones' => 'Id Direcciones',
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
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('correo_electronico',$this->correo_electronico,true);
		$criteria->compare('id_direcciones',$this->id_direcciones);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Provedores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
