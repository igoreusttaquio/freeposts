<?php
# Controllers
require_once 'vendor/autoload.php';
require_once 'App/Core/Core.php';
require_once 'App/Controller/HomeController.php';
require_once 'App/Controller/ErroController.php';
require_once 'App/Controller/PostController.php';
require_once 'App/Controller/AboutController.php';
require_once 'App/Controller/AdminController.php';

# Models
require_once 'App/Model/Post.php';
require_once 'App/Model/Comment.php';

# Infra
require_once 'App/Database/Connection.php';

$template = file_get_contents('App/Template/estrutura.html');

/*
    Verify the page who user need to acess
    wich query string.
*/
ob_start(); # obtains contend returned of function
    $core = new Core();
    $core->start($_GET);

    $returns = ob_get_contents(); # return a called function
ob_end_clean();

show($returns, $template);


function currentUrl(){
    $domain = $_SERVER['HTTP_HOST'];
    $url = "http://" . $domain. trim(' /freeposts/');
    return $url;
}

function show($returns, $template)
{
    $readyTemplate = str_replace('{{area_dinamica}}', $returns, $template);
    $readyTemplate = str_replace('{{home_link}}', currentUrl().'?page=home', $readyTemplate);
    $readyTemplate = str_replace('{{about_link}}', currentUrl().'?page=about', $readyTemplate);
    $readyTemplate = str_replace('{{admin_link}}', currentUrl().'?page=admin', $readyTemplate);

    $readyTemplate = str_replace('{{page_title}}', 'Free Posts', $readyTemplate);

    echo $readyTemplate;
}