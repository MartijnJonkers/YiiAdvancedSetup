<?php

Yii::import('ext.Emenu.EMenu');

class MainMenu extends EMenu
{
    protected $_id = '_Mainmenu';
    public $items = array();

    public function __construct()
    {
        /**
        * Make sure the parent class is properly present
        */
        parent::__construct();

        $user = Yii::app()->user;

        if ( Yii::app()->user->checkAccess('Site.index') )
            $this->items = array_merge( $this->items, array( $this->menuSub( Yii::t(__class__, 'Home'), 'site' )));

        $addSubs = array();
        if ( Yii::app()->user->checkAccess('User.index') )
            $addSubs[] = $this->menuSub( Yii::t(__class__, 'Gebruikers beheer'), 'user' );
        if ( Yii::app()->user->checkAccess('Translation.*') )
            $addSubs[] = $this->menuSub( Yii::t(__class__, 'Vertalingen'), 'translation' );
        if ( Yii::app()->user->isAdmin() ) {
            $addSubs[] = $this->menuSub( Yii::t(__class__, 'Rechten beheer'), 'rights/authItem/permissions', 'rights/*' );
            //$addSubs[] = $this->menuSub( Yii::t(__class__, 'Yii logging'), 'backendView/yiilog' );
        }

        if( count($addSubs) )
        {
            $this->items = array_merge( $this->items, array(
                    $this->menuSub( Yii::t(__class__, 'Technisch beheer'), '', '', $addSubs),
                ));
        }

        /* login */
        if( !$user->isGuest )
        {
            $this->items = array_merge( $this->items, array(
                $this->menuSub( Yii::t(__class__, 'logout'), 'user/logout' )
            ));
        }
        else
        {
            $this->items = array_merge( $this->items, array(
                $this->menuSub( Yii::t(__class__, 'login'), 'user/login' )
            ));
        }
    }

    /**
    * Create a menu item
    *
    * @param mixed $name - text to show for the menu item
    * @param mixed $link - link to the controller/action
    * @param mixed $view - additional view parameters
    * @param mixed $sub  - optional submenu aray
    */
    private function menuSub($name='Name', $link='controller/action', $active=null, $sub=null)
    {
        if ( strpos($link, '.php') !== false )
        {
            /* Legacy link */
            $item = array(
                'name' => $name,
                'link' => Yii::app()->baseUrl.$link,
                'active' => (strpos($link, '/') === 0 ? substr($link, 1) : $link),
                'sub' => $sub,
            );
        }
        else
        {
            /* Yii link, routing to controller/view */
            $item = array (
                'name' => $name,
                'link' => Yii::app()->createUrl( $link ),
                'active' => (null==$active ? $link : $active),
                'sub' => $sub,
            );
        }
        return $item;
    }
}

?>
