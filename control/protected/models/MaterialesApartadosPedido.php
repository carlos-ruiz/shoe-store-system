<?php

/**
 * This is the model class for table "materiales_apartados_pedido".
 *
 * The followings are the available columns in table 'materiales_apartados_pedido':
 * @property integer $id
 * @property integer $id_tipos_articulos_inventario
 * @property integer $id_articulo
 * @property integer $id_colores
 * @property integer $numero
 * @property integer $id_pedidos
 * @property double $cantidad_apartada
 * @property string $fecha_actualizacion
 *
 * The followings are the available model relations:
 * @property Pedidos $idPedidos
 */
class MaterialesApartadosPedido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'materiales_apartados_pedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipos_articulos_inventario, id_articulo, id_pedidos, cantidad_apartada', 'required'),
			array('id_tipos_articulos_inventario, id_articulo, id_colores, id_pedidos', 'numerical', 'integerOnly'=>true),
			array('cantidad_apartada, numero', 'numerical'),
			array('fecha_actualizacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_tipos_articulos_inventario, id_articulo, id_colores, id_pedidos, cantidad_apartada, fecha_actualizacion', 'safe', 'on'=>'search'),
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
			'pedido' => array(self::BELONGS_TO, 'Pedidos', 'id_pedidos'),
			'color' => array(self::BELONGS_TO, 'Colores', 'id_colores'),
			'tipoMaterial' => array(self::BELONGS_TO, 'TiposArticulosInventario', 'id_tipos_articulos_inventario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_tipos_articulos_inventario' => 'Tipo de artículo',
			'id_articulo' => 'Artículo',
			'id_colores' => 'Color',
			'numero' => 'Número',
			'id_pedidos' => 'Pedido',
			'cantidad_apartada' => 'Cantidad apartada',
			'fecha_actualizacion' => 'Fecha de actualización',
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
		$criteria->compare('id_tipos_articulos_inventario',$this->id_tipos_articulos_inventario);
		$criteria->compare('id_articulo',$this->id_articulo);
		$criteria->compare('id_colores',$this->id_colores);
		$criteria->compare('id_pedidos',$this->id_pedidos);
		$criteria->compare('cantidad_apartada',$this->cantidad_apartada);
		$criteria->compare('fecha_actualizacion',$this->fecha_actualizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MaterialesApartadosPedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
