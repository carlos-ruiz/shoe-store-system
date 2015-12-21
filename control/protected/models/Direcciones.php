<?php

/**
 * This is the model class for table "direcciones".
 *
 * The followings are the available columns in table 'direcciones':
 * @property integer $id
 * @property string $calle
 * @property string $numero_ext
 * @property string $numero_int
 * @property string $codigo_postal
 * @property string $colonia
 * @property string $ciudad
 * @property string $pais
 *
 * The followings are the available model relations:
 * @property Clientes[] $clientes
 * @property Provedores[] $provedores
 */
class Direcciones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'direcciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('calle, numero_ext, codigo_postal, colonia, ciudad, pais', 'required'),
			array('calle, numero_ext, numero_int, codigo_postal, colonia, ciudad, pais', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, calle, numero_ext, numero_int, codigo_postal, colonia, ciudad, pais', 'safe', 'on'=>'search'),
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
			'clientes' => array(self::HAS_MANY, 'Clientes', 'id_direcciones'),
			'provedores' => array(self::HAS_MANY, 'Provedores', 'id_direcciones'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'calle' => 'Calle',
			'numero_ext' => 'Numero Ext',
			'numero_int' => 'Numero Int',
			'codigo_postal' => 'Codigo Postal',
			'colonia' => 'Colonia',
			'ciudad' => 'Ciudad',
			'pais' => 'Pais',
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
		$criteria->compare('calle',$this->calle,true);
		$criteria->compare('numero_ext',$this->numero_ext,true);
		$criteria->compare('numero_int',$this->numero_int,true);
		$criteria->compare('codigo_postal',$this->codigo_postal,true);
		$criteria->compare('colonia',$this->colonia,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('pais',$this->pais,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Direcciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
