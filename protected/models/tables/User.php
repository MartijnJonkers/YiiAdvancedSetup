<?php

/**
 * This is the model class for table "Relaties".
 *
 * The followings are the available columns in table 'Relaties':
 * @property integer $ID
 * @property string $Name
 * @property string $LastName
 * @property string $UserName
 * @property string $Email
 * @property string $Password
 */
class User extends CActiveRecord
{
    const ROLE_ADMIN    = 'Admin';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'rights_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Name, LastName, UserName', 'length', 'max'=>50),
            array('Email', 'unique', 'allowEmpty'=>false),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID, Name, LastName, UserName, Email, Password', 'safe', 'on'=>'search'),
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
            'ID' => Yii::t(__CLASS__,'ID'),
            'Name' => Yii::t(__CLASS__,'Naam'),
            'LastName' => Yii::t(__CLASS__,'Achternaam'),
            'UserName' => Yii::t(__CLASS__,'Gebruikersnaam'),
            'Email' => Yii::t(__CLASS__,'Email'),
            'Password' => Yii::t(__CLASS__,'Wachtwoord'),
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

        $criteria->compare('ID',$this->ID);
        $criteria->compare('Name',$this->Name,true);
        $criteria->compare('LastName',$this->LastName,true);
        $criteria->compare('UserName',$this->UserName,true);
        $criteria->compare('Email',$this->Email,true);
        $criteria->compare('Password',$this->Password,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'LastName',
            ),
        ));
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword( $password )
    {
        if($this->Password == $password)
            return true;
        else
            return false;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Relatie the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}