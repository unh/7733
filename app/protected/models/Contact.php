<?php

/**
 * This is the model class for table "contacts".
 *
 * The followings are the available columns in table 'contacts':
 * @property integer $id
 * @property string $name
 * @property string $second_name
 * @property string $last_name
 * @property string $birthday
 * @property string $phone
 * @property integer $street_id
 */
class Contact extends CActiveRecord
{
    public $city_search, $street_search, $fio, $city_id_search;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contact the static model class
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
		return 'contacts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, second_name, last_name, birthday, street_id, phone', 'required'),
			array('street_id', 'numerical', 'integerOnly'=>true),
            array('birthday', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'dd.MM.yyyy'),
            array('phone', 'length', 'max'=>15),
			array('name, second_name, last_name', 'length', 'max'=>255),
            array('street_search, city_search, city_id_search, fio', 'safe', 'on' => 'search'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, second_name, last_name, birthday, street_id', 'safe', 'on'=>'search'),
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
            'street' => array(self::BELONGS_TO, 'Street', 'street_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'second_name' => 'Second Name',
			'last_name' => 'Last Name',
			'birthday' => 'Birthday',
			'street_id' => 'Street',
            'phone' => 'Phone',
            'city_id_search' => 'City',
            'city_search' => 'City',
            'street_search' => 'Street',
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
        $criteria->with = array('street', 'street.city');

        $criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('second_name',$this->second_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('street.name',$this->street_search, true);
        $criteria->compare('street.city.name',$this->city_search, true);
        $criteria->compare('phone',$this->phone, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'city_search'=>array(
                        'asc'=>'street.city.name',
                        'desc'=>'street.city.name DESC',
                    ),
                    'street_search'=>array(
                        'asc'=>'street.name',
                        'desc'=>'street.name DESC',
                    ),
                    '*',
                ),
            ),
		));
	}

    /**
     * Search by FIO
     * Generates all permutations of first three parts of input string/
     * @return CActiveDataProvider
     */
    public function searchFio()
    {
        if (strlen($this->fio) > 0) {
            $nameParts = explode(' ', $this->fio);
            $nameAttributes = array('t.name', 'second_name', 'last_name');
            sort($nameAttributes);
            $lastQ = false;
            $j = 0;
            do {
                $q = new CDbCriteria;

                foreach ($nameAttributes as $i => $attr) {
                    if ($i + 1 > count($nameParts))
                        continue;
                    $q->compare("$attr", $nameParts[$i], true);
                    //$q->addCondition("lower($attr) LIKE '%' + lower(:attr$j)+ '%' ");
                    //$q->params[":attr$j"] = $nameParts[$i];
                    //print_r($q->params);
                    $j++;
                }

                if ($lastQ) {
                    $q->mergeWith($lastQ, 'OR');
                }
                $lastQ = $q;
            } while ($this->__nextPermutation($nameAttributes, 2));
        }

        $criteria=new CDbCriteria;
        if (isset($q)) {
            $criteria->mergeWith($q);
        }
        $criteria->with = array('street', 'street.city');
        $criteria->compare('phone',$this->phone, true);
        $criteria->compare('street.city_id',$this->city_id_search, true);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'city_search'=>array(
                        'asc'=>'street.city.name',
                        'desc'=>'street.city.name DESC',
                    ),
                    'street_search'=>array(
                        'asc'=>'street.name',
                        'desc'=>'street.name DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }

    /**
     * Generate next permutation of array
     * @param $p array
     * @param $size
     * @return bool
     */
    private function __nextPermutation(&$p, $size) {
        // slide down the array looking for where we're smaller than the next guy
        for ($i = $size - 1; $p[$i] >= $p[$i+1]; --$i) { }

        // if this doesn't occur, we've finished our permutations
        // the array is reversed: (1, 2, 3, 4) => (4, 3, 2, 1)
        if ($i == -1) { return false; }

        // slide down the array looking for a bigger number than what we found before
        for ($j = $size; $p[$j] <= $p[$i]; --$j) { }

        // swap them
        $tmp = $p[$i]; $p[$i] = $p[$j]; $p[$j] = $tmp;

        // now reverse the elements in between by swapping the ends
        for (++$i, $j = $size; $i < $j; ++$i, --$j) {
            $tmp = $p[$i]; $p[$i] = $p[$j]; $p[$j] = $tmp;
        }

        return true;
    }
}