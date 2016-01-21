<?php

/**
 * This is the model class for table "ojillos_colores".
 *
 * The followings are the available columns in table 'ojillos_colores':
 * @property integer $id
 * @property integer $id_ojillos
 * @property integer $id_colores
 *
 * The followings are the available model relations:
 * @property Colores $idColores
 * @property Ojillos $idOjillos
 * @property Zapatos[] $zapatoses
 */
class OjillosColores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ojillos_colores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ojillos, id_colores', 'required'),
			array('id_ojillos, id_colores', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_ojillos, id_colores', 'safe', 'on'=>'search'),
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
			'idColores' => array(self::BELONGS_TO, 'Colores', 'id_colores'),
			'idOjillos' => array(self::BELONGS_TO, 'Ojillos', 'id_ojillos'),
			'zapatoses' => array(self::HAS_MANY, 'Zapatos', 'id_ojillos_colores'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_ojillos' => 'Id Ojillos',
			'id_colores' => 'Id Colores',
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
		$criteria->compare('id_ojillos',$this->id_ojillos);
		$criteria->compare('id_colores',$this->id_colores);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OjillosColores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
