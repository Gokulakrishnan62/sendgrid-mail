<?php

namespace SGM\app;

class Route
{
    function hook()
    {
    
        $menu_action = new \SGM\app\Controllers\Menu();
        add_action('admin_menu', [$menu_action, 'showing_menu']);

        add_action('admin_head', [$menu_action,'sendgrid_mail']);
       
    }

}



?>
