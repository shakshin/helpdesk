<?php

/**
 * This is the model class for table "v_group".
 *
 * The followings are the available columns in table 'v_group':
 * @property string $gid
 * @property string $gname
 * @property string $uid
 * @property string $uname
 * @property string $ingroup
 */
class VGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VGroup the static model class
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
		return 'v_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gname, uname', 'required'),
			array('gid, uid', 'length', 'max'=>10),
			array('gname', 'length', 'max'=>64),
			array('uname', 'length', 'max'=>200),
			array('ingroup', 'length', 'max'=>21),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gid, gname, uid, uname, ingroup', 'safe', 'on'=>'search'),
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
			'gid' => 'Gid',
			'gname' => 'Gname',
			'uid' => 'Uid',
			'uname' => 'Uname',
			'ingroup' => 'Ingroup',
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

		$criteria->compare('gid',$this->gid,true);
		$criteria->compare('gname',$this->gname,true);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('uname',$this->uname,true);
		$criteria->compare('ingroup',$this->ingroup,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}