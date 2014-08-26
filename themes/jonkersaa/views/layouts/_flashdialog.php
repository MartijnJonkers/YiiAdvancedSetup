<?php

if ( $flashes = Yii::app()->user->getFlashes() )
{
    if ( isset($flashes['success']) ||
         isset($flashes['warning'])   )
    {
        Yii::app()->clientScript->registerScript(
           'flashHideEffect',
           '$(".flash-holder > .info").animate({opacity: 1.0}, 6000).fadeOut("slow");',
           CClientScript::POS_READY
        );

        echo '<div class="flash-holder">';
        if ( isset($flashes['success']) )
            echo '<div class="info flash-success">' . $flashes['success']. '</div>';
        if ( isset($flashes['warning']) )
            echo '<div class="info flash-warning">' . $flashes['warning']. '</div>';
        echo '</div>';
    }
    if ( isset($flashes['error']) )
    {
        /* Show dialog */
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'error',
                    'options'=>array(
                        'show' => 'fade',
                        'hide' => 'fade',
                        'modal' => 'true',
                        'minWidth' => '400',
                        'position' => '{ my: "center top" }',
                        'title' => Yii::t('ct.mainmenu', 'Let op'),
                        'autoOpen'=>true,
                        'buttons' => array(
                                array('text'=>'Ok','click'=> 'js:function(){$(this).dialog("close");}'),
                            ),
                        ),
                    ));
        echo '<span class="dialog">'.$flashes['error'].'</span>';

        $this->endWidget('zii.widgets.jui.CJuiDialog');
    }
}
?>