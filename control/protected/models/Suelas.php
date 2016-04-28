<?php

/**
 * This is the model class for table "suelas".
 *
 * The followings are the available columns in table 'suelas':
 * @property integer $id
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property ModelosSuelas[] $modelosSuelas
 * @property SuelasColores[] $suelasColores
 * @property SuelasNumeros[] $suelasNumeros
 * @property ZapatoPrecios[] $zapatoPrecios
 * @property Tacones[] $tacones
 */
class Suelas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suelas';
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
			'modeloSuela' => array(self::HAS_MANY, 'ModelosSuelas', 'id_suelas'),
			'suelasColores' => array(self::HAS_MANY, 'SuelasColores', 'id_suelas'),
			'suelaNumeros' => array(self::HAS_MANY, 'SuelasNumeros', 'id_suelas'),
			'zapatoPrecios' => array(self::HAS_MANY, 'ZapatoPrecios', 'id_suelas'),
			'tacones' => array(self::MANY_MANY, 'Tacones', 'suelas_tacones(id_suelas, id_tacones)'),
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
	 * @return Suelas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerColores($id_suelas){
		$suelaColores=SuelasColores::model()->findAll("id_suelas=?", array($id_suelas));
		$colores = array();
		foreach ($suelaColores as $suelaColor) {
			array_push($colores, $suelaColor->color);
		}
		return CHtml::listData($colores, 'id', 'color');
	}
}
