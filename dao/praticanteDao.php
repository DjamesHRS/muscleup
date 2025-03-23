<?php
    include_once("../utilitarios/conexao.php");

    class PraticanteDao{
        function cadastrar($praticante){
            $parametros = Array(
                ":nome" => $praticante->nome,
                ":email" => $praticante->email,
                ":senha" => md5($praticante->senha),
                ":dataDeNascimento" => $praticante->dataDeNascimento,
                ":sexo" => $praticante->sexo,
                ":altura" => $praticante->altura,
                ":peso" => $praticante->peso
            );
            $query = "insert into praticante (nome, email, senha, dataDeNascimento, sexo, altura, peso)
            values (:nome, :email, :senha, :dataDeNascimento, :sexo, :altura, :peso)";
            Conexao::executarComParametros($query, $parametros);
        }

        function alterar($praticante){
            $parametros = Array(
                ":idPraticante" => $praticante->idPraticante,
                ":nome" => $praticante->nome,
                ":email" => $praticante->email,
                ":senha" => md5($praticante->senha),
                ":dataDeNascimento" => $praticante->dataDeNascimento,
                ":sexo" => $praticante->sexo,
                ":altura" => $praticante->altura,
                ":peso" => $praticante->peso
            );
            $query = "update praticante set nome = :nome, email = :email, senha = :senha, dataDeNascimento = :dataDeNascimento, sexo = :sexo, altura = :altura, peso = :peso where idPraticante = :idPraticante";
            Conexao::executarComParametros($query, $parametros);
        }

        function logar($praticante){
            $parametros = Array(
                ":email" => $praticante->email,
                ":senha" => md5($praticante->senha)
            );
            $query = "select idPraticante from praticante where email = :email and senha = :senha";
            $stmt = Conexao::executarComParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function pegarPorId($praticante){
            $parametros = Array(
                ":idPraticante" => $praticante->idPraticante,
            );
            $query = "select * from praticante where idPraticante = :idPraticante";
            $stmt = Conexao::executarcomParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function pegarTodos() {
            try {
                $query = "SELECT * FROM praticante ORDER BY nome";
                $stmt = Conexao::executar($query);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                return $result ?: [];
            } catch (PDOException $e) {
                // Registra o erro no log
                error_log("Erro ao pegar os praticantes: " . $e->getMessage());
                
                // Retorna um array vazio em caso de erro
                return [];
            }
        }

        function excluir($praticante){
            $parametros = Array(
                ":idPraticante" => $praticante->idPraticante,
            );
            $query = "delete from praticante where idPraticante = :idPraticante";
            Conexao::executarComParametros($query, $parametros);
        }

    }
?>