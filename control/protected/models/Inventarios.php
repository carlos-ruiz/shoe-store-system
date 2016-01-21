<?php

/**
 * This is the model class for table "inventarios".
 *
 * The followings are the available columns in table 'inventarios':
 * @property integer $id
 * @property double $cantidad_existente
 * @property double $cantidad_apartada
 * @property string $unidad_medida
 * @property string $ultimo_precio
 * @property integer $id_tipos_articulos_inventario
 * @property integer $id_articulo
 *
 * The followings are the available model relations:
 * @property TiposArticulosInventario $idTiposArticulosInventario
 */
class Inventarios extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inventarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad_existente, unidad_medida, ultimo_precio, id_tipos_articulos_inventario, id_articulo', 'required'),
			array('id_tipos_articulos_inventario, id_articulo', 'numerical', 'integerOnly'=>true),
			array('cantidad_existente, cantidad_apartada', 'numerical'),
			array('unidad_medida', 'length', 'max'=>45),
			array('ultimo_precio', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cantidad_existente, cantidad_apartada, unidad_medida, ultimo_precio, id_tipos_articulos_inventario, id_articulo', 'safe', 'on'=>'search'),
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
			'idTiposArticulosInventario' => array(self::BELONGS_TO, 'TiposArticulosInventario', 'id_tipos_articulos_inventario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cantidad_existente' => 'Cantidad Existente',
			'cantidad_apartada' => 'Cantidad Apartada',
			'unidad_medida' => 'Unidad Medida',
			'ultimo_precio' => 'Ultimo Precio',
			'id_tipos_articulos_inventario' => 'Id Tipos Articulos Inventario',
			'id_articulo' => 'Id Articulo',
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
		$criteria->compare('cantidad_existente',$this->cantidad_existente);
		$criteria->compare('cantidad_apartada',$this->cantidad_apartada);
		$criteria->compare('unidad_medida',$this->unidad_medida,true);
		$criteria->compare('ultimo_precio',$this->ultimo_precio,true);
		$criteria->compare('id_tipos_articulos_inventario',$this->id_tipos_articulos_inventario);
		$criteria->compare('id_articulo',$this->id_articulo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inventarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
