<?php
    include_once("../utilitarios/conexao.php");

    class TreinoDao {

        function cadastrar($treino) {
            $parametros = Array(
                ":nome" => $treino->nome,
                ":descricao" => $treino->descricao,
                ":diaDoTreino" => $treino->diaDoTreino,
                ":tempoDeDuracao" => $treino->tempoDeDuracao,
                ":idFichaDeTreino" => $treino->idFichaDeTreino,
            );
        
            $query = "INSERT INTO treino (nome, descricao, diaDoTreino, tempoDeDuracao, idFichaDeTreino)
                      VALUES (:nome, :descricao, :diaDoTreino, :tempoDeDuracao, :idFichaDeTreino)";
            
            Conexao::executarComParametros($query, $parametros);
        }

        function alterar($treino){
            $parametros = Array(
                ":idTreino" => $treino->idTreino,
                ":nome" => $treino->nome,
                ":descricao" => $treino->descricao,
                ":diaDoTreino" => $treino->diaDoTreino,
                ":tempoDeDuracao" => $treino->tempoDeDuracao,
            );
            $query = "update treino set nome = :nome, descricao = :descricao, diaDoTreino = :diaDoTreino, tempoDeDuracao = :tempoDeDuracao where idTreino = :idTreino";
            Conexao::executarComParametros($query, $parametros);
        }

        function pegarPorIdDaFicha($treino){
            $parametros = Array(
                ":idFichaDeTreino" => $treino->idFichaDeTreino,
            );
            $query = "select * from treino where idFichaDeTreino = :idFichaDeTreino";
            $stmt = Conexao::executarcomParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function pegarPorId($treino){
            $parametros = Array(
                ":idTreino" => $treino->idTreino,
            );
            $query = "select * from treino where idTreino = :idTreino";
            $stmt = Conexao::executarcomParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }
        
?>