<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $position
 * @property string $email
 * @property integer $locked
 * @property string $jabber
 * @property integer $changepass
 * @property string $number
 * @property integer $razr
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, name, position, email, jabber', 'required'),
			array('locked, changepass, razr', 'numerical', 'integerOnly'=>true),
			array('login', 'length', 'max'=>20),
			array('password', 'length', 'max'=>50),
			array('name', 'length', 'max'=>200),
			array('position, email, jabber', 'length', 'max'=>100),
			array('number', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, password, name, position, email, locked, jabber, changepass, number, razr', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'password' => 'Password',
			'name' => 'Name',
			'position' => 'Position',
			'email' => 'Email',
			'locked' => 'Locked',
			'jabber' => 'Jabber',
			'changepass' => 'Changepass',
			'number' => 'Number',
			'razr' => 'Razr',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('locked',$this->locked);
		$criteria->compare('jabber',$this->jabber,true);
		$criteria->compare('changepass',$this->changepass);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('razr',$this->razr);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}