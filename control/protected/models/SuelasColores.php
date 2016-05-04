<?php

/**
 * This is the model class for table "suelas_colores".
 *
 * The followings are the available columns in table 'suelas_colores':
 * @property integer $id
 * @property integer $id_suelas
 * @property integer $id_colores
 *
 * The followings are the available model relations:
 * @property Colores $idColores
 * @property Suelas $idSuelas
 */
class SuelasColores extends CActiveRecord
{
	public $var_color;
	public $var_suela;
	public $precio_extrachico;
	public $precio_chico;
	public $precio_mediano;
	public $precio_grande;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suelas_colores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_suelas, id_colores', 'required'),
			array('id_suelas, id_colores', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_suelas, id_colores, var_color, var_suela', 'safe', 'on'=>'search'),
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
			'color' => array(self::BELONGS_TO, 'Colores', 'id_colores'),
			'suela' => array(self::BELONGS_TO, 'Suelas', 'id_suelas'),
			'materialesPredeterminados' => array(self::HAS_MANY, 'ModelosMaterialesPredeterminados', 'id_suelas_colores'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_suelas' => 'Id Suelas',
			'id_colores' => 'Id Colores',
			'var_suela' => 'Suela',
			'var_color' => 'Color',
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
		$criteria->compare('id_suelas',$this->id_suelas);
		$criteria->compare('id_colores',$this->id_colores);
		$criteria->with = array('suela', 'color');
		$criteria->compare('suela.nombre', $this->var_suela, true);
		$criteria->compare('color.color', $this->var_color, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuelasColores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerColoresPorSuela($id_suela){
		$suelaColores=SuelasColores::model()->findAll("id_suelas=?", array($id_suela));
		$colores = array();
		foreach ($suelaColores as $suelaColor) {
			array_push($colores, $suelaColor->color);
		}
		return CHtml::listData($colores, 'id', 'nombre');
	}
}
