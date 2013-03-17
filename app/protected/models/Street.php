<?php

/**
 * This is the model class for table "streets".
 *
 * The followings are the available columns in table 'streets':
 * @property integer $id
 * @property integer $city_id
 * @property string $name
 */
class Street extends CActiveRecord
{
    public $city_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Street the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'streets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, name', 'required'),
			array('city_id', 'numerical', 'integerOnly' => true),
            array('city_search', 'safe', 'on' => 'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('city_id, name', 'safe', 'on'=>'search'),
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
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'city_id' => 'City',
			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->with = array('city');
		$criteria->compare('id', $this->id);
		$criteria->compare('city_id', $this->city_id);
		$criteria->compare('t.name', $this->name, true);
        $criteria->compare('city.name', $this->city_search, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'city_search'=>array(
                        'asc'=>'city.name',
                        'desc'=>'city.name DESC',
                    ),
                    '*',
                ),
            ),
		));
	}
}