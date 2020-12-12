<?php
class Core
{
    public function start($urlRequestGET)
    {
        
        if(isset($urlRequestGET['action']))
        {
            $actionMethod = $urlRequestGET['action'];
        }
        else
        {
            $actionMethod = 'index';
        }

        if(isset($urlRequestGET['page']))
        {
            # page who user need to acess > mapping to controller
            $pageController = ucfirst($urlRequestGET['page']).'Controller';
        }
        else
        {
            $pageController = 'HomeController';
        }

        if(false == class_exists($pageController))
        {
            $pageController = 'ErroController';
        }

        call_user_func_array(array(new $pageController, $actionMethod), array($urlRequestGET));
    }
}