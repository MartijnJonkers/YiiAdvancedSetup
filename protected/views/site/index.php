<?php

if(Yii::app()->user->isGuest)
{
    echo "is guest";
}
else
{
    echo Yii::app()->user->getState('name')."<br>";
    echo Yii::app()->user->getState('username')."<br>";
    echo Yii::app()->user->getState('email')."<br>";
}
?>
