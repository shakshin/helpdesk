<?php

/**
 * This is the model class for table "worker_request".
 *
 * The followings are the available columns in table 'worker_request':
 * @property string $request_id
 * @property string $user_id
 * @property string $date_begin
 * @property string $date_end
 * @property string $comment
 */
class Worker extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Worker the static model class
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
		return 'worker_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id, user_id', 'required'),
			array('request_id', 'length', 'max'=>20),
			array('user_id', 'length', 'max'=>10),
			array('date_begin, date_end, comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('request_id, user_id, date_begin, date_end, comment', 'safe', 'on'=>'search'),
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
			'request_id' => 'Request',
			'user_id' => 'User',
			'date_begin' => 'Date Begin',
			'date_end' => 'Date End',
			'comment' => 'Comment',
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

		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}