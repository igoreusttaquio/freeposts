<?php
class AdminController
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('admin.html');
        
        $posts = Post::selectAllPosts();

        $viewParams['title_h1'] = "Gerenciador de conteúdo";
        $viewParams['posts'] = $posts;
        
        echo $template->render($viewParams);


    }

    public function createPost()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('admin_create.html');
        $viewParams['title_h1'] = "Criando post";

        echo $template->render($viewParams);
    }

    public function insertPost()
    {
        try
        {
            Post::insertPost($_POST);
            $this->index();
        }
        catch(Exception $e)
        {
            echo "<h1>{$e->getMessage()}</h1>";
        }
    }

    public function changePost($requestGET)
    {
        $id = $requestGET['id'];
        $post = Post::selectPostById($id);

        $titulo = $post->titulo;
        $conteudo = $post->conteudo;

        $loader = new \Twig\Loader\FilesystemLoader('App/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('admin_update.html');

        $viewParams['title_h1'] = "Alterando post {$id}";
        $viewParams['id'] = $id;
        $viewParams['titulo'] = $titulo;
        $viewParams['conteudo'] = $conteudo;

        echo $template->render($viewParams);
    }

    public function updatePost()
    {
        try
        {
            Post::updatePost($_POST);
            $this->index();

            # redirect the user
        }
        catch(Exception $e)
        {
            echo "<h1>{$e->getMessage()}</h1>";

            # redirect the user
        }
    }

    public function deletePost($requestGET)
    {
        $id = $requestGET['id'];
        Post::deletePost($id);

        $this->index();
    }


    private static function currentUrl(){
        $domain = $_SERVER['HTTP_HOST'];
        $url = "http://" . $domain. trim(' /freeposts/');
        return $url;
    }
}