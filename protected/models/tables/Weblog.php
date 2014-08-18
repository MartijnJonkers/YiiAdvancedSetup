<?php

/**
 * This is the model class for table "weblog".
 *
 * The followings are the available columns in table 'weblog':
 * @property integer $ID
 * @property string $Title
 * @property integer $Author
 * @property string $CreatedUTC
 * @property string $UpdatedUTC
 * @property string $Content
 * @property string $ResourcePath
 */
class Weblog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'weblog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Title, Author, UpdatedUTC, Content, ResourcePath', 'required'),
			array('Author', 'numerical', 'integerOnly'=>true),
			array('Title, ResourcePath', 'length', 'max'=>300),
			array('CreatedUTC', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, Title, Author, CreatedUTC, UpdatedUTC, Content, ResourcePath', 'safe', 'on'=>'search'),
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
			'ID' => 'ID',
			'Title' => Language::t('Title'),
			'Author' => Language::t('Author'),
			'CreatedUTC' => Language::t('Created'),
			'UpdatedUTC' => Language::t('Updated'),
			'Content' => Language::t('Content'),
			'ResourcePath' => Language::t('Resource Path'),
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('Title',$this->Title,true);
		$criteria->compare('Author',$this->Author);
		$criteria->compare('CreatedUTC',$this->CreatedUTC,true);
		$criteria->compare('UpdatedUTC',$this->UpdatedUTC,true);
		$criteria->compare('Content',$this->Content,true);
		$criteria->compare('ResourcePath',$this->ResourcePath,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Weblog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
