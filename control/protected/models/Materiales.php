<?php

/**
 * This is the model class for table "materiales".
 *
 * The followings are the available columns in table 'materiales':
 * @property integer $id
 * @property string $nombre
 * @property string $unidad_medida
 *
 * The followings are the available model relations:
 * @property ComprasMateriales[] $comprasMateriales
 * @property InventarioMateriales[] $inventarioMateriales
 * @property Colores[] $colores
 * @property ModelosMateriales[] $modelosMateriales
 * @property PerdidasMateriales[] $perdidasMateriales
 */
class Materiales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'materiales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, unidad_medida', 'required'),
			array('nombre', 'length', 'max'=>128),
			array('unidad_medida', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, unidad_medida', 'safe', 'on'=>'search'),
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
			'comprasMateriales' => array(self::HAS_MANY, 'ComprasMateriales', 'id_materiales'),
			'inventarioMateriales' => array(self::HAS_MANY, 'InventarioMateriales', 'id_materiales'),
			'colores' => array(self::HAS_MANY, 'MaterialesColores', 'id_materiales'),
			'modelosMateriales' => array(self::HAS_MANY, 'ModelosMateriales', 'id_materiales'),
			'perdidasMateriales' => array(self::HAS_MANY, 'PerdidasMateriales', 'id_materiales'),
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
			'unidad_medida' => 'Unidad de medida',
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
		$criteria->compare('unidad_medida',$this->unidad_medida,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Materiales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
