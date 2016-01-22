<?php

/**
 * This is the model class for table "zapatos".
 *
 * The followings are the available columns in table 'zapatos':
 * @property integer $id
 * @property double $numero
 * @property string $precio
 * @property string $codigo_barras
 * @property integer $id_modelos
 * @property integer $id_colores
 * @property integer $id_suelas_colores
 * @property integer $id_agujetas_colores
 * @property integer $id_ojillos_colores
 *
 * The followings are the available model relations:
 * @property InventarioZapatosTerminados[] $inventarioZapatosTerminadoses
 * @property PedidosZapatos[] $pedidosZapatoses
 * @property ModelosColores $idModelosColoresAgujetasColores $idAgujetasColores
 * @property Suelas $idSuelasColores $idColores
 * @property Modelos $idModelos
 * @property OjillosColores $idOjillosColores
 * @property SuelasColores $idSuelasColores
 */
class Zapatos extends CActiveRecord
{
	public $var_suela;
	public $var_modelo;
	public $var_color;
	public $id_suelas;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zapatos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numero, precio, codigo_barras, id_modelos, id_colores, id_suelas_colores', 'required'),
			array('id_modelos', 'required', 'on'=>'catalog'),
			array('id_modelos, id_colores, id_suelas_colores, id_agujetas_colores, id_ojillos_colores, id_suelas', 'numerical', 'integerOnly'=>true),
			array('numero, precio', 'numerical'),
			array('precio', 'length', 'max'=>7),
			array('codigo_barras', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, numero, precio, codigo_barras, var_suela, var_modelo, var_color', 'safe', 'on'=>'search'),
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
			'inventarioZapatosTerminados' => array(self::HAS_MANY, 'InventarioZapatosTerminados', 'id_zapatos'),
			'pedidosZapatos' => array(self::HAS_MANY, 'PedidosZapatos', 'id_zapatos'),
			'modelo' => array(self::BELONGS_TO, 'Modelos', 'id_modelos'),
			'color' => array(self::BELONGS_TO, 'Colores', 'id_colores'),
			'suelaColor' => array(self::BELONGS_TO, 'SuelasColores', 'id_suelas_colores'),
			'agujetaColor' => array(self::BELONGS_TO, 'AgujetasColores', 'id_agujetas_colores'),
			'ojilloColor' => array(self::BELONGS_TO, 'OjillosColores', 'id_ojillos_colores'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'numero' => 'Número',
			'precio' => 'Precio',
			'codigo_barras' => 'Código de barras',
			'id_suelas' => 'Suela',
			'id_colores' => 'Color',
			'id_modelos' => 'Modelo',
			'var_suela' => 'Suela',
			'var_modelo' => 'Modelo',
			'var_color' => 'Color',
			'id_agujetas_colores' => 'Agujetas',
			'id_ojillos_colores' => 'Ojillos',
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('precio',$this->precio, true);
		$criteria->compare('codigo_barras',$this->codigo_barras,true);
		$criteria->compare('id_suelas_colores',$this->id_suelas_colores);
		$criteria->compare('id_ojillos_colores',$this->id_ojillos_colores);
		$criteria->compare('id_agujetas_colores',$this->id_agujetas_colores);
		$criteria->with = array('modelo', 'color');
		// $criteria->compare('suela.nombre', $this->var_suela, true);
		$criteria->compare('modelo.nombre', $this->var_modelo, true);
		$criteria->compare('color.color', $this->var_color, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Zapatos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
