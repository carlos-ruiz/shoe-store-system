<?php

/**
 * This is the model class for table "materiales_colores_predeterminados".
 *
 * The followings are the available columns in table 'materiales_colores_predeterminados':
 * @property integer $id
 * @property integer $id_modelos_materiales_predeterminados
 * @property integer $id_materiales
 * @property integer $id_colores
 *
 * The followings are the available model relations:
 * @property MaterialesColores $idMateriales
 * @property MaterialesColores $idColores
 * @property ModelosMaterialesPredeterminados $idModelosMaterialesPredeterminados
 */
class MaterialesColoresPredeterminados extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'materiales_colores_predeterminados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_modelos_materiales_predeterminados, id_materiales, id_colores', 'required'),
			array('id_modelos_materiales_predeterminados, id_materiales, id_colores', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_modelos_materiales_predeterminados, id_materiales, id_colores', 'safe', 'on'=>'search'),
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
			'material' => array(self::BELONGS_TO, 'MaterialesColores', 'id_materiales'),
			'color' => array(self::BELONGS_TO, 'MaterialesColores', 'id_colores'),
			'modelosMaterialesPredeterminados' => array(self::BELONGS_TO, 'ModelosMaterialesPredeterminados', 'id_modelos_materiales_predeterminados'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_modelos_materiales_predeterminados' => 'Id Modelos Materiales Predeterminados',
			'id_materiales' => 'Id Materiales',
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
		$criteria->compare('id_modelos_materiales_predeterminados',$this->id_modelos_materiales_predeterminados);
		$criteria->compare('id_materiales',$this->id_materiales);
		$criteria->compare('id_colores',$this->id_colores);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MaterialesColoresPredeterminados the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
