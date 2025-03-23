<?php
    include_once("../utilitarios/conexao.php");

    class InstrutorDao{
        function cadastrar($instrutor){
            $parametros = Array(
                ":nome" => $instrutor->nome,
                ":email" => $instrutor->email,
                ":senha" => md5($instrutor->senha),
                ":cref" => $instrutor->cref,
                ":dataDeNascimento" => $instrutor->dataDeNascimento,
                ":sexo" => $instrutor->sexo,
                ":dataDeFormacao" => $instrutor->dataDeFormacao,
                ":universidadeDeFormacao" => $instrutor->universidadeDeFormacao,
                ":descricao" => $instrutor->descricao
            );
            $query = "insert into instrutor (nome, email, senha, cref, dataDeNascimento, sexo, dataDeFormacao, universidadeDeFormacao, descricao)
            values (:nome, :email, :senha, :cref, :dataDeNascimento, :sexo, :dataDeFormacao, :universidadeDeFormacao, :descricao)";
            Conexao::executarComParametros($query, $parametros);
        }

        function alterar($instrutor){
            $parametros = Array(
                ":idInstrutor" => $instrutor->idInstrutor,
                ":nome" => $instrutor->nome,
                ":email" => $instrutor->email,
                ":senha" => md5($instrutor->senha),
                ":cref" => $instrutor->cref,
                ":dataDeNascimento" => $instrutor->dataDeNascimento,
                ":sexo" => $instrutor->sexo,
                ":dataDeFormacao" => $instrutor->dataDeFormacao,
                ":universidadeDeFormacao" => $instrutor->universidadeDeFormacao,
                ":descricao" => $instrutor->descricao
            );
            $query = "update instrutor set nome = :nome, email = :email, senha = :senha, cref = :cref, dataDeNascimento = :dataDeNascimento, sexo = :sexo, dataDeFormacao = :dataDeFormacao, universidadeDeFormacao = :universidadeDeFormacao, descricao = :descricao where idInstrutor = :idInstrutor";
            Conexao::executarComParametros($query, $parametros);
        }

        function pegarPorId($instrutor){
            $parametros = Array(
                ":idInstrutor" => $instrutor->idInstrutor,
            );
            $query = "select nome, email, cref, dataDeNascimento, sexo, dataDeFormacao, universidadeDeFormacao, descricao from instrutor where idInstrutor = :idInstrutor";
            $stmt = Conexao::executarcomParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function pegarTodos() {
            try {
                $query = "SELECT * FROM instrutor ORDER BY nome";
                $stmt = Conexao::executar($query);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                return $result ?: [];
            } catch (PDOException $e) {
                // Registra o erro no log
                error_log("Erro ao pegar todos os grupos musculares: " . $e->getMessage());
                
                // Retorna um array vazio em caso de erro
                return [];
            }
        }

        function logar($instrutor){
            $parametros = Array(
                ":email" => $instrutor->email,
                ":senha" => md5($instrutor->senha)
            );
            $query = "select idInstrutor from instrutor where email = :email and senha = :senha";
            $stmt = Conexao::executarComParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function excluir($instrutor){
            $parametros = Array(
                ":idInstrutor" => $instrutor->idInstrutor,
            );
            $query = "delete from instrutor where idInstrutor = :idInstrutor";
            Conexao::executarComParametros($query, $parametros);
        }
    }
?>