<?php
/**
 * Wrapper for the PHPExcel library. https://github.com/marcovtwout/yii-phpexcel
 * @see README.md
 */
class YiiPHPExcel extends CComponent
{
    public $PHPExcelPath = '';

    private static $_isInitialized = false;

    /**
     * Register autoloader.
     */
    public function init()
    {
        if (!self::$_isInitialized)
        {
            if($this->PHPExcelPath == '')
                $this->PHPExcelPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'PHPExcel.php';

            spl_autoload_unregister(array('YiiBase', 'autoload'));
            require($this->PHPExcelPath);
            spl_autoload_register(array('YiiBase', 'autoload'));

            self::$_isInitialized = true;
        }
    }

    /**
     * Returns new PHPExcel object. Automatically registers autoloader.
     * @return PHPExcel
     */
    public function create()
    {
        self::init();
        return new PHPExcel;
    }

    /**
    * Increment an Excel column like 'A' to 'B' (and 'Z' to 'AA' etc)
    *
    * @param string $abc
    * @return string next column
    */
    public static function incrementCol($abc)
    {
        $value = 0;
        $mul = 1;
        for($i = strlen($abc); $i > 0; $i--)
        {
            $value += ((ord($abc)-0x40) * $mul);
            $mul *= 26;
        }
        for($ret = ""; $value >= 0; $value = intval($value/26)-1)
        {
            $ret = chr($value%26 + 0x41) . $ret;
        }
        return $ret;
    }

    /**
    * convert a number to a column letter A-Z,AA-AZ,etc
    *
    * @param integer $colNumber
    * @return string
    */
    public static function numToCol($colNumber)
    {
        for($r = ""; $colNumber >= 0; $colNumber = intval($colNumber / 26) - 1)
            $r = chr($colNumber%26 + 0x41) . $r;
        return $r;
    }
}