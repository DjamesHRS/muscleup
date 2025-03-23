<?php
    include_once("../utilitarios/conexao.php");

    class FichaDeTreinoDao{
        function cadastrar($fichaDeTreino){
            $parametros = Array(
                ":objetivo" => $fichaDeTreino->objetivo,
                ":nivel" => $fichaDeTreino->nivel,
                ":dias" => json_encode($fichaDeTreino->dias),
                ":status" => $fichaDeTreino->status,
                ":focoMuscular" => $fichaDeTreino->focoMuscular,
                ":observacoes" => $fichaDeTreino->observacoes,
                ":idInstrutor" => $fichaDeTreino->idInstrutor,
                ":idPraticante" => $fichaDeTreino->idPraticante
            );
            $query = "insert into fichadetreino (objetivo, nivelDeTreino, diasDeTreino, status, focoMuscular, observacoes, idInstrutor, idPraticante)
            values (:objetivo, :nivel, :dias, :status, :focoMuscular, :observacoes, :idInstrutor, :idPraticante)";
            Conexao::executarComParametros($query, $parametros);
        }

        function pegarPorId($fichaDeTreino){
            $parametros = Array();
        
            // Monta os parâmetros de acordo com o que foi passado
            if (isset($fichaDeTreino->idPraticante)) {
                $parametros[":idPraticante"] = $fichaDeTreino->idPraticante;
            }
            if (isset($fichaDeTreino->idInstrutor)) {
                $parametros[":idInstrutor"] = $fichaDeTreino->idInstrutor;
            }
            if (isset($fichaDeTreino->idFichaDeTreino)) {
                $parametros[":idFichaDeTreino"] = $fichaDeTreino->idFichaDeTreino;
            }
        
            // Condicional para ajustar a consulta conforme o parâmetro passado
            $query = "SELECT f.*, i.idInstrutor as idInstrutor, i.nome AS nome_instrutor FROM fichadetreino f JOIN instrutor i ON f.idInstrutor = i.idInstrutor WHERE ";
            $conditions = [];
        
            // Condições baseadas nos parâmetros fornecidos
            if (isset($parametros[":idPraticante"])) {
                $conditions[] = "idPraticante = :idPraticante";
            }
            if (isset($parametros[":idInstrutor"])) {
                $conditions[] = "i.idInstrutor = :idInstrutor";
            }
            if (isset($parametros[":idFichaDeTreino"])) {
                $conditions[] = "idFichaDeTreino = :idFichaDeTreino";
            }
        
            // Junte as condições para formar a consulta
            $query .= implode(" OR ", $conditions);
        
            // Execute a consulta
            $stmt = Conexao::executarComParametros($query, $parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: [];
        }

        function alterar($fichaDeTreino){
            $parametros = Array(
                ":idFichaDeTreino" => $fichaDeTreino->idFichaDeTreino,
                ":nome" => $fichaDeTreino->nome,
                ":dataDeCriacao" => $fichaDeTreino->dataDeCriacao,
                ":descricao" => $fichaDeTreino->descricao,
            );
            $query = "update fichadetreino set nome = :nome, dataDeCriacao = :dataDeCriacao, descricao = :descricao where idFichaDeTreino = :idFichaDeTreino";
            Conexao::executarComParametros($query, $parametros);
        }

        function alterarStatus($fichaDeTreino){
            $parametros = Array(
                ":idFichaDeTreino" => $fichaDeTreino->idFichaDeTreino,
                ":status" => $fichaDeTreino->status,
            );
            $query = "update fichadetreino set status = :status where idFichaDeTreino = :idFichaDeTreino";
            Conexao::executarComParametros($query, $parametros);
        }

        function alterarNome($fichaDeTreino){
            $parametros = Array(
                ":idFichaDeTreino" => $fichaDeTreino->idFichaDeTreino,
                ":nome" => $fichaDeTreino->nome,
            );
            $query = "update fichadetreino set nome = :nome where idFichaDeTreino = :idFichaDeTreino";
            Conexao::executarComParametros($query, $parametros);
        }

        function alterarInstrutor($fichaDeTreino){
            $parametros = Array(
                ":idFichaDeTreino" => $fichaDeTreino->idFichaDeTreino,
                ":nome" => $fichaDeTreino->nome,
                ":descricao" => $fichaDeTreino->descricao,
            );
            $query = "update fichadetreino set nome = :nome, descricao = :descricao where idFichaDeTreino = :idFichaDeTreino";
            Conexao::executarComParametros($query, $parametros);
        }

        function alterarAdm($fichaDeTreino){
            $parametros = Array(
                ":idFichaDeTreino" => $fichaDeTreino->idFichaDeTreino,
                ":nome" => $fichaDeTreino->nome,
                ":instrutor" => $fichaDeTreino->instrutor,
                ":status" => $fichaDeTreino->status,
            );
            $query = "update fichadetreino set nome = :nome, idInstrutor = :instrutor, status = :status where idFichaDeTreino = :idFichaDeTreino";
            Conexao::executarComParametros($query, $parametros);
        }

        function excluir($fichaDeTreino){
            $parametros = Array(
                ":idFichaDeTreino" => $fichaDeTreino->idFichaDeTreino,
            );
            $query = "delete from fichadetreino where idFichaDeTreino = :idFichaDeTreino";
            Conexao::executarComParametros($query, $parametros);
        }
        
    }
?>