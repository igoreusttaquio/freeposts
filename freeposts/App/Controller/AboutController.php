<?php
class AboutController
{
    public function index()
    {

            
        $loader = new \Twig\Loader\FilesystemLoader('App/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('about.html');
        
        $file = file_get_contents(currentUrl()."/Resources/about.txt");

        $viewParams['title_h1'] = "Sobre";
        $viewParams['about_title'] = "O que é Free Posts?";
        $viewParams['content'] = $file;
        
        echo $template->render($viewParams);


    }

    private static function currentUrl(){
        $domain = $_SERVER['HTTP_HOST'];
        $url = "http://" . $domain. trim(' /freeposts/');
        return $url;
    }
}