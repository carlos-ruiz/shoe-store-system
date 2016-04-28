<?php

/**
 * This is the model class for table "colores".
 *
 * The followings are the available columns in table 'colores':
 * @property integer $id
 * @property string $color
 *
 * The followings are the available model relations:
 * @property AgujetasColores[] $agujetasColores
 * @property Materiales[] $materiales
 * @property ModelosColores[] $modelosColores
 * @property OjillosColores[] $ojillosColores
 * @property SuelasColores[] $suelasColores
 * @property TaconesColores[] $taconesColores
 * @property Zapatos[] $zapatoses
 */
class Colores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'colores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('color', 'required'),
			array('color', 'unique'),
			array('color', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, color', 'safe', 'on'=>'search'),
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
			'agujetasColores' => array(self::HAS_MANY, 'AgujetasColores', 'id_colores'),
			'materiales' => array(self::MANY_MANY, 'Materiales', 'materiales_colores(id_colores, id_materiales)'),
			'modelosColores' => array(self::HAS_MANY, 'ModelosColores', 'id_colores'),
			'ojillosColores' => array(self::HAS_MANY, 'OjillosColores', 'id_colores'),
			'suelasColores' => array(self::HAS_MANY, 'SuelasColores', 'id_colores'),
			'taconesColores' => array(self::HAS_MANY, 'TaconesColores', 'id_colores'),
			'zapatos' => array(self::HAS_MANY, 'Zapatos', 'id_colores'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'color' => 'Color',
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
		$criteria->compare('color',$this->color,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Colores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
