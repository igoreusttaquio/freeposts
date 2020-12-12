<?php
class PostController
{
    public function index($urlRequestGET)
    {
        try
        {
            $id = $urlRequestGET['id'];
            $post = Post::selectPostById($id);
            
            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('post.html');
            
            $viewParams['title_h1'] = "Post {$post->id}";
            $viewParams['post_id'] = $post->id;
            $viewParams['post'] = $post;
            $viewParams['comments_title'] = "Comentários";
            echo $template->render($viewParams);


        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function addComment()
    {
        Comment::insertComment($_POST);
        header("Location: ".self::currentUrl()."?page=post&id=".$_POST['id_post']);
    }

    private static function currentUrl(){
        $domain = $_SERVER['HTTP_HOST'];
        $url = "http://" . $domain. trim(' /freeposts/');
        return $url;
    }
}