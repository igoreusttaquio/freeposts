<?php
class Post
{
    const TABLENAME = 'postagem';

    public static function selectAllPosts()
    {
        $con = Connection::getConnection();

        $sql = "SELECT * FROM ".self::TABLENAME." ORDER BY id DESC";
        $sql = $con->prepare($sql);
        $sql->execute();

        $posts = array();

        while($row = $sql->fetchObject('Post'))
        {
            $posts[] = $row;
        }

        if(sizeof($posts) == 0)
        {
            throw new PDOException("Nenhum post encontrado!");
        }
        return $posts;
    }

    public static function selectPostById($id)
    {
        $con = Connection::getConnection();

        $sql = "SELECT * FROM ".self::TABLENAME." WHERE id=:id";
        $sql = $con->prepare($sql);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->execute();

        $post = $sql->fetchObject('Post');
        if(!$post)
        {
            throw new PDOException("Nenhum post encontrado com este id.");
        }
        else
        {
            $comments = Comment::selectAllComments($id);
            $post->comments = $comments;
            
    
        }
        return $post;
    }

    public static function insertPost($arrayPOST)
    {
        $title = $arrayPOST['titulo'];
        $content = $arrayPOST['conteudo'];

        if(empty($title) || empty($content))
        {
            throw new Exception("Prencha todos os campos.");
        }

        $id = self::getLastId();
            
        $con = Connection::getConnection();
            
        $sql = "INSERT INTO ".self::TABLENAME." (id, titulo, conteudo) VALUES (:id, :tit, :cont)";
        $sql = $con->prepare($sql);
         
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->bindValue(":tit", $title, PDO::PARAM_STR);
        $sql->bindValue(":cont", $content, PDO::PARAM_STR);
            
        if($sql->execute())
        {
           return true;
        }
        else
        {
            var_dump($sql);
            throw new PDOException("Falha ao inserir postagem");
        }

    }

    public static function updatePost($arrayPOST)
    {
        # var_dump($arrayPOST);
        $id = $arrayPOST['id'];
        $title = $arrayPOST['titulo'];
        $content = $arrayPOST['conteudo'];

        $con = Connection::getConnection();
        $sql = "UPDATE ".self::TABLENAME." SET titulo = :tit, conteudo = :cont WHERE id = :id";
        $sql = $con->prepare($sql);

        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->bindValue(":tit", $title, PDO::PARAM_STR);
        $sql->bindValue(":cont", $content, PDO::PARAM_STR);

        if($sql->execute())
        {
            return true;
        }
        else
        {
            throw new PDOException("Falha ao alterar postage.");
            
        }
    }

    public static function deletePost($id)
    {
        $table = self::TABLENAME;

        $con = Connection::getConnection();
        
        $sql = "DELETE FROM {$table} WHERE id=:id";
        $sql = $con->prepare($sql);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        
        $sql->execute();

    
    }

    private static function getLastId()
    {
        $table = self::TABLENAME;
        $con = Connection::getConnection();
        $sql = "SELECT MAX(id) AS maxID FROM {$table}";
        $sql = $con->prepare($sql);
        $sql->execute();

        $stdObject = $sql->fetchObject();
        return $stdObject->maxID +1;
    }
}