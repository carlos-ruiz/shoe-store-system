<?php

/**
 * This is the model class for table "pedidos_zapatos".
 *
 * The followings are the available columns in table 'pedidos_zapatos':
 * @property integer $id
 * @property integer $id_pedidos
 * @property integer $id_zapatos
 * @property integer $cantidad_total
 * @property integer $id_estatus_zapatos
 * @property integer $completos
 * @property string $caracteristicas_especiales
 * @property string $precio_unitario
 *
 * The followings are the available model relations:
 * @property Pedidos $idPedidos
 * @property Zapatos $idZapatos
 * @property EstatusZapatos $idEstatusZapatos
 */
class PedidosZapatos extends CActiveRecord
{
	public $id_modelos;
	public $id_colores;
	public $id_suelas;
	public $id_suelas_color;
	public $numero;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pedidos_zapatos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pedidos, id_zapatos, cantidad_total, id_estatus_zapatos, completos, precio_unitario', 'required'),
			array('id_pedidos, id_zapatos, cantidad_total, id_estatus_zapatos, completos', 'numerical', 'integerOnly'=>true),
			array('precio_unitario', 'length', 'max'=>7),
			array('caracteristicas_especiales', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_pedidos, id_zapatos, cantidad_total, id_estatus_zapatos, completos, caracteristicas_especiales, precio_unitario', 'safe', 'on'=>'search'),
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
			'zapato' => array(self::BELONGS_TO, 'Zapatos', 'id_zapatos'),
			'estatusZapato' => array(self::BELONGS_TO, 'EstatusZapatos', 'id_estatus_zapatos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_pedidos' => 'Id Pedidos',
			'id_zapatos' => 'Id Zapatos',
			'cantidad_total' => 'Cantidad Total',
			'id_estatus_zapatos' => 'Id Estatus Zapatos',
			'completos' => 'Completos',
			'id_modelos'=>'Modelo',
			'id_colores'=>'Color',
			'id_suelas'=>'Suela',
			'id_suelas_color'=>'Color de suela',
			'numero'=>'Número',
			'caracteristicas_especiales' => 'Características especiales',
			'precio_unitario' => 'Precio unitario',
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
		$criteria->compare('id_pedidos',$this->id_pedidos);
		$criteria->compare('id_zapatos',$this->id_zapatos);
		$criteria->compare('cantidad_total',$this->cantidad_total);
		$criteria->compare('id_estatus_zapatos',$this->id_estatus_zapatos);
		$criteria->compare('completos',$this->completos);
		$criteria->compare('caracteristicas_especiales',$this->caracteristicas_especiales,true);
		$criteria->compare('precio_unitario',$this->precio_unitario,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PedidosZapatos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
