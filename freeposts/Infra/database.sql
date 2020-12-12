CREATE TABLE postagem (
    id INT PRIMARY KEY NOT NULL, 
    titulo VARCHAR(200) NOT NULL,
    conteudo TEXT NOT NULL
); -- N* comentarios

CREATE TABLE comentario (
    id INT PRIMARY KEY NOT NULL,
    nome VARCHAR(150) NOT NULL,
    mensagem TEXT NOT NULL,
    id_postagem INT
); -- 1 postagem