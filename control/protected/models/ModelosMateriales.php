<?php

/**
 * This is the model class for table "modelos_materiales".
 *
 * The followings are the available columns in table 'modelos_materiales':
 * @property integer $id
 * @property integer $id_modelos
 * @property integer $id_materiales
 * @property double $cantidad
 * @property string $unidad_medida
 *
 * The followings are the available model relations:
 * @property Materiales $idMateriales
 * @property Modelos $idModelos
 */
class ModelosMateriales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modelos_materiales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_modelos, id_materiales, cantidad', 'required'),
			array('id_modelos, id_materiales', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical'),
			array('unidad_medida', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_modelos, id_materiales, cantidad, unidad_medida', 'safe', 'on'=>'search'),
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
			'idMateriales' => array(self::BELONGS_TO, 'Materiales', 'id_materiales'),
			'idModelos' => array(self::BELONGS_TO, 'Modelos', 'id_modelos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_modelos' => 'Id Modelos',
			'id_materiales' => 'Id Materiales',
			'cantidad' => 'Cantidad',
			'unidad_medida' => 'Unidad Medida',
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
		$criteria->compare('id_modelos',$this->id_modelos);
		$criteria->compare('id_materiales',$this->id_materiales);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('unidad_medida',$this->unidad_medida,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelosMateriales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
