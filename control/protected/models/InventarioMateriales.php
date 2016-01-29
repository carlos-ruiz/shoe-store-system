<?php

/**
 * This is the model class for table "inventario_materiales".
 *
 * The followings are the available columns in table 'inventario_materiales':
 * @property integer $id
 * @property double $existencia
 * @property double $cantidad_apartada
 * @property integer $id_materiales
 * @property integer $id_colores
 * @property double $stock_minimo
 * @property string $ultimo_precio
 *
 * The followings are the available model relations:
 * @property Materiales $idMateriales
 */
class InventarioMateriales extends CActiveRecord
{
	public $cantidad;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inventario_materiales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('existencia, id_materiales, stock_minimo', 'required'),
			array('id_materiales, id_colores', 'numerical', 'integerOnly'=>true),
			array('existencia, cantidad_apartada, cantidad, ultimo_precio, stock_minimo', 'numerical'),
			array('cantidad, stock_minimo', 'required', 'on'=>'agregarMaterial'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, existencia, cantidad_apartada, id_materiales, id_colores, stock_minimo, ultimo_precio', 'safe', 'on'=>'search'),
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
			'material' => array(self::BELONGS_TO, 'Materiales', 'id_materiales'),
			'color' => array(self::BELONGS_TO, 'Colores', 'id_colores'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'existencia' => 'Existencia',
			'cantidad_apartada' => 'Cantidad apartada',
			'id_materiales' => 'Material',
			'id_colores' => 'Color',
			'cantidad' => 'Cantidad',
			'ultimo_precio' => 'Último precio',
			'stock_minimo' => 'Cantidad mínima en bodega',
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
		$criteria->compare('existencia',$this->existencia);
		$criteria->compare('cantidad_apartada',$this->cantidad_apartada);
		$criteria->compare('id_materiales',$this->id_materiales);
		$criteria->compare('id_colores',$this->id_colores);
		$criteria->compare('ultimo_precio',$this->ultimo_precio);
		$criteria->compare('stock_minimo',$this->stock_minimo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InventarioMateriales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerMateriales(){
		return CHtml::listData(Materiales::model()->findAll(array('order'=>'nombre')), 'id', 'nombre');
	}
}
