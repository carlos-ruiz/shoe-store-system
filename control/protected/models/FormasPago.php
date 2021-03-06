<?php

/**
 * This is the model class for table "formas_pago".
 *
 * The followings are the available columns in table 'formas_pago':
 * @property integer $id
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Abonos[] $abonoses
 * @property Pagos[] $pagoses
 * @property Pedidos[] $pedidoses
 */
class FormasPago extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'formas_pago';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('nombre', 'unique'),
			array('nombre', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre', 'safe', 'on'=>'search'),
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
			'abonoses' => array(self::HAS_MANY, 'Abonos', 'id_formas_pago'),
			'pagoses' => array(self::HAS_MANY, 'Pagos', 'id_formas_pago'),
			'pedidoses' => array(self::HAS_MANY, 'Pedidos', 'id_formas_pago'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FormasPago the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerFormasPago(){
		return CHtml::listData(FormasPago::model()->findAll(array('order'=>'nombre')), 'id', 'nombre');
	}
}
