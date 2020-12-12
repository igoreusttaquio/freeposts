<?php
class HomeController
{
    public function index()
    {
        try
        {
            $posts = Post::selectAllPosts();
            
            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('home.html');
            
            $viewParams['title_h1'] = "Posts";
            $viewParams['posts'] = $posts;
            $viewParams['link_postagem'] = currentUrl();

            echo $template->render($viewParams);


        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    private static function currentUrl(){
        $domain = $_SERVER['HTTP_HOST'];
        $url = "http://" . $domain. trim(' /freeposts/');
        return $url;
    }

    private static function shortText($text)
    {
        return substr($text, 0, 25); 
    }
}