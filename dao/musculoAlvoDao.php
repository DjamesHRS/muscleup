<?php
include_once("../utilitarios/conexao.php");

class MusculoAlvoDao {
    function cadastrar($musculoAlvo) {
        $parametros = array(
            ":nome" => $musculoAlvo->nome,
            ":idGrupoMuscular" => $musculoAlvo->idGrupoMuscular
        );

        $query = "INSERT INTO musculoalvo (nome, idGrupoMuscular) VALUES (:nome, :idGrupoMuscular)";
        Conexao::executarComParametros($query, $parametros);
    }

        function alterar($musculoAlvo) {
            $parametros = array(
                ":nome" => $musculoAlvo->nome,
                ":idMusculoAlvo" => $musculoAlvo->idMusculoAlvo
            );
    
            $query = "UPDATE musculoalvo SET nome = :nome WHERE idMusculoAlvo = :idMusculoAlvo;";
            Conexao::executarComParametros($query, $parametros);
        }

        function excluir($musculoAlvo) {
            $parametros = array(
                ":idGrupoMuscular" => $musculoAlvo->id
            );
    
            $query = "DELETE FROM musculoalvo where idGrupoMuscular = :idGrupoMuscular;";
            Conexao::executarComParametros($query, $parametros);
        }

    function pegarPorIdDoGrupo($musculoAlvo){
        $parametros = Array(
            ":idGrupoMuscular" => $musculoAlvo->idGrupoMuscular
        );

        $query = "SELECT * FROM musculoalvo where idGrupoMuscular = :idGrupoMuscular";
        $stmt = Conexao::executarcomParametros($query, $parametros);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}
?>
