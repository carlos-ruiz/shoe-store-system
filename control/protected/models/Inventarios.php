<?php

/**
 * This is the model class for table "inventarios".
 *
 * The followings are the available columns in table 'inventarios':
 * @property integer $id
 * @property integer $id_tipos_articulos_inventario
 * @property integer $id_articulo
 * @property string $nombre_articulo
 * @property double $numero
 * @property integer $id_colores
 * @property double $cantidad_existente
 * @property double $cantidad_apartada
 * @property string $unidad_medida
 * @property string $ultimo_precio
 * @property double $stock_minimo
 *
 * The followings are the available model relations:
 * @property TiposArticulosInventario $idTiposArticulosInventario
 */
class Inventarios extends CActiveRecord
{
	public $var_tipo_articulo;
	public $var_color;
	public $var_total;

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
			array('id_tipos_articulos_inventario, id_articulo, cantidad_existente, unidad_medida, ultimo_precio', 'required'),
			array('id_tipos_articulos_inventario, id_articulo, id_colores', 'numerical', 'integerOnly'=>true),
			array('numero, cantidad_existente, cantidad_apartada, stock_minimo', 'numerical'),
			array('unidad_medida', 'length', 'max'=>45),
			array('ultimo_precio', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_tipos_articulos_inventario, id_articulo, nombre_articulo, numero, id_colores, cantidad_existente, cantidad_apartada, unidad_medida, ultimo_precio, stock_minimo, var_tipo_articulo, var_color, var_total', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		// $relations = array();
		// $relations['tipoArticulo'] = array(self::BELONGS_TO, 'TiposArticulosInventario', 'id_tipos_articulos_inventario');
		// $relations['color'] = array(self::BELONGS_TO, 'Colores', 'id_colores');

		// return $relations;
		return array(
			'tipoArticulo' => array(self::BELONGS_TO, 'TiposArticulosInventario', 'id_tipos_articulos_inventario'),
			'color' => array(self::BELONGS_TO, 'Colores', 'id_colores'),
			'suela' => array(self::BELONGS_TO, 'Suelas', 'id_articulo'),
			'material' => array(self::BELONGS_TO, 'Materiales', 'id_articulo'),
			'agujeta' => array(self::BELONGS_TO, 'Agujetas', 'id_articulo'),
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
			'numero' => 'Número',
			'id_colores' => 'Color',
			'cantidad_existente' => 'Cantidad existente',
			'cantidad_apartada' => 'Cantidad apartada',
			'unidad_medida' => 'Unidad de medida',
			'ultimo_precio' => 'Último precio',
			'var_tipo_articulo' => 'Tipo de artículo',
			'var_color' => 'Color',
			'nombre_articulo' => 'Artículo',
			'stock_minimo' => 'Cantidad mínima',
			'var_total' => 'Total',
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
		$criteria->compare('id_tipos_articulos_inventario',$this->id_tipos_articulos_inventario);
		$criteria->compare('id_articulo',$this->id_articulo);
		$criteria->compare('nombre_articulo',$this->nombre_articulo,true);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('id_colores',$this->id_colores);
		$criteria->compare('cantidad_existente',$this->cantidad_existente);
		$criteria->compare('cantidad_apartada',$this->cantidad_apartada);
		$criteria->compare('t.stock_minimo',$this->stock_minimo);
		$criteria->compare('unidad_medida',$this->unidad_medida,true);
		$criteria->compare('ultimo_precio',$this->ultimo_precio,true);
		$criteria->with = array('tipoArticulo', 'color');
		$criteria->compare('tipoArticulo.tipo', $this->var_tipo_articulo, true);
		$criteria->compare('color.color', $this->var_color, true);
		$criteria->compare('cantidad_existente - (cantidad_apartada + t.stock_minimo)', $this->var_total);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'Pagination' => array(
                'PageSize' => 20,
            ),
            'sort'=>array(
		        'attributes'=>array(
		        	'var_tipo_articulo'=>array(
		                'asc'=>'tipoArticulo.tipo',
		                'desc'=>'tipoArticulo.tipo DESC',
		            ),
		            'var_total'=>array(
		            	'asc'=>'cantidad_existente - (cantidad_apartada + t.stock_minimo)',
		            	'desc'=>'cantidad_existente - (cantidad_apartada + t.stock_minimo) DESC',
		            ),
		            'nombre_articulo',
		            'numero',
		            'cantidad_existente',
		            'cantidad_apartada',
		            'stock_minimo',
		            'unidad_medida',
		            'ultimo_precio',
		        ),
		    ),
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
