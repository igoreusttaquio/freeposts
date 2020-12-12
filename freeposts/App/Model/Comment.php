<?php
class Comment
{
    const TABLENAME = 'comentario';

    public static function selectAllComments($id)
    {
        # this methos is user on model Post
        $con = Connection::getConnection();

        $sql = "SELECT * FROM ".self::TABLENAME." WHERE id_postagem=:id";
        $sql = $con->prepare($sql);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->execute();

        $comments = array();

        while($row = $sql->fetchObject('Comment'))
        {
            $comments[] = $row;
        }

        if(sizeof($comments) == 0)
        {
            $std = new Comment;
            $std->nome = "System bot";
            $std->mensagem = "Não existe comentarios para essa postagem.";
            
            $comments[] = $std; 
        }
        return $comments;
    }


    public static function insertComment($arrayPOST)
    {
        $con = Connection::getConnection();
        $name = $arrayPOST['nome'].' - '.date('Y-m-d');
        $message = $arrayPOST['mensagem'];
        $id_post = $arrayPOST['id_post'];
        $id = self::getLastId();

        $sql = "INSERT INTO ".self::TABLENAME." (id, nome, mensagem, id_postagem)".
        " VALUES (:id, :nome, :mensagem, :id_post)";
        
        $sql = $con->prepare($sql);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->bindValue(":nome", $name, PDO::PARAM_STR);
        $sql->bindValue(":mensagem", $message, PDO::PARAM_STR);
        $sql->bindValue(":id_post", $id_post, PDO::PARAM_INT);

        $sql->execute();

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
        return $post;
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