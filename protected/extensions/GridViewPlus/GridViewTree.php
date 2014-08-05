<?php
Yii::import('ext.GridViewPlus.GridViewPlus');

/**
* @property string $expandAction The action to call when a tree item is selected
* @property integer $rootId The id of the root of the tree
* @property string $initFunctionName When set this will cause the js init data to be encapsuled in a fuction.
* @property string $afterClose Some javascript code that is called after closing branche
* @property bool $asyncInit When set to true the root data will be captured via the expandAction.
* @property string $loadingMessage The message to be displayed during data loading
* @property string $errorMessage The message to be displayed when an error occurred
* @property string $noDataMessage The message to be displayed when the branch has no data
*/
class GridViewTree extends CGridViewPlus
{
    /**
    * The action to call when a tree item is selected
    * It is passed through create absoluteUrl function.
    *
    * @var string
    */
    public $expandAction = null;

    /**
    * the initial id to render
    *
    * @var string
    */
    public $rootId = null;

    /**
    * When set this will cause the js init data to be encapsuled
    * in a fuction.
    * This makes it possible to do asynchronous grid initialization.
    *
    * @var string
    */
    public $initFunctionName = 'initTreeView';

    /**
    * Some javascript data that is called after closing branche
    * 'row' contains the selected row key
    *
    * @var string
    */
    public $afterClose = '';

    /**
    * Is the initial data a asynchronous ajax call?
    *
    * @var string
    */
    public $asyncInit = false;

    /**
    * The displayed messages
    *
    * @var string
    */
    public $loadingMessage = '';
    public $errorMessage = "Error!";
    public $noDataMessage = "No data found.";

    /**
    * init
    *
    */
    public function init()
    {
        parent::init();

        if( $this->loadingMessage == '' ){
            $this->loadingMessage = Yii::t(__CLASS__, "Loading..." );
        }
        if( $this->errorMessage == '' ){
            $this->errorMessage = Yii::t(__CLASS__, "Error!" );
        }
        if( $this->noDataMessage == '' ){
            $this->noDataMessage = Yii::t(__CLASS__, "No data found." );
        }

        if( $this->rootId == null )
        {
            $this->rootId = $this->dataProvider->rootId;
        }

        $this->selectionChanged = 'function (id)
        {
            function updateRowColors()
            {
                /* run through all rows and update odd even class */
                var i = 0;
                $("#'.$this->id.' table tbody").children().each(function(){
                    $(this).removeClass("odd even");
                    $(this).addClass( i ? "even" : "odd");
                    i = !i;
                });
            }

            /* get selected afdeling id */
            id=$.fn.yiiGridView.getSelection(id);

            /* remove selection */
            $("#'.$this->id.' #"+id).removeClass("selected");

            if(id > 0)
            {
                /* is valid afdeling */

                /* check for any busy */
                if( $("#'.$this->id.' .busy").length > 0 )
                    return;

                /* get level from class name */
                var level = $("#'.$this->id.' #"+id).prop("class").match(/grid-level-([0-9]+)/)[1];

                if($("#'.$this->id.' #"+id).hasClass("open") )
                {
                    /* is already open close it */

                    var keys = 0;
                    $(".keys").children().each( function ()
                    {
                        /* search for selected key in list */
                        if( $(this).html() == id )
                        {
                            /* found key */
                            keys = $(this);
                        }
                    });

                    $("#'.$this->id.' #"+id).nextAll().each( function ()
                    {
                        nextLevel = $(this).prop("class").match(/grid-level-([0-9]+)/)[1];
                        if( nextLevel > level )
                        {
                            $(this).remove();
                            keys.next().remove();
                        }
                        else
                            return false;
                    });

                    updateRowColors();

                    /* remove open state */
                    $("#'.$this->id.' #"+id).removeClass("open");

                    /* call user code after close */
                    TreeGridAfterClose(id);
                }
                else
                {
                    $("#'.$this->id.' #"+id).addClass("busy");

                    /* show loading text */
                    $("#'.$this->id.' #"+id).after( "<tr class=\"loading\"><td colspan=\"'.count($this->columns).'\"><div class=\"grid-view-loading\" style=\"padding-left: 2em\">'.$this->loadingMessage.'</div></td></tr>" );

                    /* update */
                    updateRowColors();

                    /* do ajax call for new data */
                    $.ajax({
                        url: "'.Yii::app()->createAbsoluteUrl($this->expandAction,array('id'=>'')).'" + id,
                        error: function (xhr, ajaxOptions, thrownError) {
                            /* error during data fetch */
                            $(".loading").remove();

                            /* show error */
                            $("#'.$this->id.' #"+id).after( "<tr id=\"message\" class=\"loading grid-level-"+(level+1)+"\"><td colspan=\"'.count($this->columns).'\"><div class=\"grid-view-error\" style=\"padding-left: 2em\">'.$this->errorMessage.'</div></td></tr>" );

                            updateRowColors();

                            /* remove error after timeout */
                            setTimeout(function() {
                                $("#'.$this->id.' #"+id).removeClass("busy");
                                $(".loading").remove();
                                updateRowColors();
                            }, 3000);
                        }
                    }).
                    done(function( data )
                    {
                        /* remove loading row */
                        $(".loading").remove();

                        /* find table content */
                        content = $("#'.$this->id.' table tbody", data);

                        /* added levels to rows, first is same level, the rest level+1 */
                        first = true;
                        content.children().each( function (){
                            $(this).addClass("grid-level-"+level);
                            if(first)
                            {
                                first = false;
                                level++;
                            }
                        });

                        /* replace selected row with new content */
                        $("#'.$this->id.' #"+id).replaceWith(content.html());

                        /* we are still busy, restore the class */
                        $("#'.$this->id.' #"+id).addClass("busy");

                        /* update key list with new keys */
                        keys = $(".keys", data).html();
                        $(".keys").children().each( function ()
                        {
                            /* search for selected key in list */
                            if( $(this).html() == id )
                            {
                                /* found key in existing list*/

                                /* add 1 extra dummy key for error message */
                                if( $(".keys span", data).length == 1)
                                {
                                    $( "<span>message</span>" ).insertAfter( $(this) );
                                }

                                /*replace it with the complete new list */
                                $(this).replaceWith(keys);

                                /* no need to search the remaining list items */
                                return false;
                            }
                        });

                        if( $(".keys span", data).length == 1)
                        {
                            /* no new data */

                            /* show message */
                            $("#'.$this->id.' #"+id).after( "<tr id=\"message\" class=\"grid-level-"+level+"\"><td colspan=\"'.count($this->columns).'\"><div class=\"grid-view-error\" style=\"padding-left: 2em\">'.$this->noDataMessage.'</div></td></tr>" );
                            updateRowColors();
                        }

                        /* set open */
                        $("#'.$this->id.' #"+id).removeClass("busy");
                        $("#'.$this->id.' #"+id).addClass("open");

                        updateRowColors();
                    });
                }
            }
        }';

        $this->rowHtmlOptionsExpression = 'array("id"=>$data["id"])';
    }

    /**
    * Registers necessary client scripts.
    */
    public function registerClientScript()
    {
        /** register parent scripts */
        parent::registerClientScript();

        /**
        * add level classes to init data
        */
        Yii::app()->clientScript->registerScript('init',"function ".$this->initFunctionName.'(){
            /* find table content */
            content = $("#'.$this->id.' table tbody");

            /* set tree level per row */
            first = true;
            content.children().each( function (){
                if(first)
                {
                    $(this).addClass("grid-level-0");
                    first = false;
                }
                else
                    $(this).addClass("grid-level-1");
            });

            /* replace table content new content */
            $("#'.$this->id.' table tbody").html(content.html());

            /* update key list with new keys */
            keys = $(".keys").html();
            $(".keys").html(keys);

            /* first item is opened */
            $("#'.$this->id.' #"+'.$this->rootId.').addClass("open");
        }',CClientScript::POS_HEAD);

        /**
        * do we need to init async?
        */
        if($this->asyncInit)
        {
            /* load initial data */
            Yii::app()->clientScript->registerScript('init','

                    /* do ajax call for new data */
                    $.ajax({
                        url: "'.Yii::app()->createAbsoluteUrl($this->expandAction,array('id'=>$this->rootId)).'",
                        error: function (xhr, ajaxOptions, thrownError) {
                            /* show error */
                            $("#'.$this->id.' table tbody").html( "<tr class=\"loading\"><td colspan=\"'.count($this->columns).'\"><div class=\"grid-view-error\" style=\"padding-left: 2em\">'.Yii::t(__CLASS__,"Fout tijdens laden van gegevens").'</div></td></tr>" );

                            /* remove error after timeout */
                            setTimeout(function() {
                                $("#'.$this->id.' table tbody").html("");
                            }, 3000);
                        }
                    }).
                    done(function( data )
                    {
                        '.$this->initFunctionName.'();
                    });
            ', null
            );
        }

        Yii::app()->clientScript->registerScript('close',"
            function TreeGridAfterClose(row){"
                .$this->afterClose.
            "}
        ",CClientScript::POS_HEAD);
    }

}
?>
