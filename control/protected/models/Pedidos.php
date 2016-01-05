<?php

/**
 * This is the model class for table "pedidos".
 *
 * The followings are the available columns in table 'pedidos':
 * @property integer $id
 * @property integer $id_clientes
 * @property string $fecha_pedido
 * @property string $fecha_entrega
 * @property integer $id_formas_pago
 * @property double $total
 * @property integer $id_estatus_pedidos
 *
 * The followings are the available model relations:
 * @property Pagos[] $pagoses
 * @property Clientes $idClientes
 * @property EstatusPedidos $idEstatusPedidos
 * @property FormasPago $idFormasPago
 * @property PedidosZapatos[] $pedidosZapatoses
 */
class Pedidos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pedidos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_clientes, fecha_pedido, id_formas_pago, total, id_estatus_pedidos', 'required'),
			array('id_clientes, id_formas_pago, id_estatus_pedidos', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			array('fecha_entrega', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_clientes, fecha_pedido, fecha_entrega, id_formas_pago, total, id_estatus_pedidos', 'safe', 'on'=>'search'),
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
			'pagos' => array(self::HAS_MANY, 'Pagos', 'id_pedidos'),
			'cliente' => array(self::BELONGS_TO, 'Clientes', 'id_clientes'),
			'estatisPedido' => array(self::BELONGS_TO, 'EstatusPedidos', 'id_estatus_pedidos'),
			'formaPago' => array(self::BELONGS_TO, 'FormasPago', 'id_formas_pago'),
			'pedidoZapatos' => array(self::HAS_MANY, 'PedidosZapatos', 'id_pedidos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_clientes' => 'Id Clientes',
			'fecha_pedido' => 'Fecha Pedido',
			'fecha_entrega' => 'Fecha Entrega',
			'id_formas_pago' => 'Id Formas Pago',
			'total' => 'Total',
			'id_estatus_pedidos' => 'Id Estatus Pedidos',
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
		$criteria->compare('id_clientes',$this->id_clientes);
		$criteria->compare('fecha_pedido',$this->fecha_pedido,true);
		$criteria->compare('fecha_entrega',$this->fecha_entrega,true);
		$criteria->compare('id_formas_pago',$this->id_formas_pago);
		$criteria->compare('total',$this->total);
		$criteria->compare('id_estatus_pedidos',$this->id_estatus_pedidos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pedidos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
