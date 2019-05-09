<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/9/19
 * Time: 2:45 PM
 */

class MessageController
{

    public function showHomePage()
    {
        RenderView::render_php('home.php',array());
    }
}