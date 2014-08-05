<?php

Yii::import('ext.GridViewPlus.GridViewGroup');

class GridViewPlus extends GridViewGroup {

    public $customHeaders = array();

    public function renderTableHeader()
    {

        if (!empty($this->customHeaders) && (!$this->hideHeader))
        {
            /* hide default headers */
            $this->hideHeader = true;

            /* render custom header */
            $this->multiRowHeader();
        }

        /* render default headers filters when enable */
        parent::renderTableHeader();
    }

    protected function multiRowHeader()
    {
        echo CHtml::openTag('thead') . "\n";
        foreach ($this->customHeaders as $row)
        {
            $this->addHeaderRow($row);
        }
        echo CHtml::closeTag('thead') . "\n";
    }

    // each cell value expects array(array($text,$colspan,$options), array(...))
    protected function addHeaderRow($row)
    {
        // add a single header row
        echo CHtml::openTag('tr') . "\n";

        // inherits header options from first column
        $options = $this->columns[array_keys($this->columns)[0]]->headerHtmlOptions;

        foreach ($row as $header)
        {
            $options['colspan'] = isset($header['colspan']) ? $header['colspan'] : 1;
            $options['rowspan'] = isset($header['rowspan']) ? $header['rowspan'] : 1;
            $cellOptions = isset($header['htmlOptions']) ? ($header['htmlOptions'] + $options) : $options;
            echo CHtml::openTag('th', $cellOptions);
            if(isset($header['text']))
                echo $header['text'];
            echo CHtml::closeTag('th');
        }
        echo CHtml::closeTag('tr') . "\n";
    }

}
?>
