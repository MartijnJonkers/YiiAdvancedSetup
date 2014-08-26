<?php

class ActiveRecord extends CActiveRecord
{
    public function load( $unsetAttributes = false, $source = null )
    {
        // unset attributes if needed
        if($unsetAttributes)
            $this->unsetAttributes();

        // default to _POST
        if($source == null)
            $source = &$_POST;

        // get the current model name
        $modelName = get_class($this);

        // is there a post?
        if(isset($source[$modelName])) {
            $this->attributes = $source[$modelName];
            return true;
        } else {
            return false;
        }
    }
}

?>
