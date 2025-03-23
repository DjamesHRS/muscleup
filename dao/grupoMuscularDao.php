<?php
include_once("../utilitarios/conexao.php");

class GrupoMuscularDao {
    function cadastrar($grupoMuscular) {
        $parametros = array(
            ":nome" => $grupoMuscular->nome
        );

        $query = "INSERT INTO grupomuscular (nome) VALUES (:nome)";
        Conexao::executarComParametros($query, $parametros);
    }
    
    function pegarTodos() {
        try {
            $query = "SELECT gm.idGrupoMuscular, gm.nome AS nomeGrupoMuscular, GROUP_CONCAT(m.nome ORDER BY m.nome ASC) AS musculosAlvo FROM grupoMuscular gm LEFT JOIN musculoalvo m ON gm.idGrupoMuscular = m.idGrupoMuscular GROUP BY gm.idGrupoMuscular ORDER BY nomeGrupoMuscular;";
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

    function pegarTodosSemMusculoAlvo() {
        try {
            $query = "SELECT * FROM grupomuscular gm WHERE NOT EXISTS (SELECT 1 FROM musculoalvo ma WHERE ma.idGrupoMuscular = gm.idGrupoMuscular);";
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

    function alterar($grupoMuscular) {
        $parametros = array(
            ":nome" => $grupoMuscular->nome,
            ":idGrupoMuscular" => $grupoMuscular->id
        );

        $query = "UPDATE grupomuscular SET nome = :nome where idGrupoMuscular = :idGrupoMuscular;";
        Conexao::executarComParametros($query, $parametros);
    }

    function excluir($grupoMuscular) {
        $parametros = array(
            ":idGrupoMuscular" => $grupoMuscular->id
        );

        $query = "DELETE FROM grupomuscular where idGrupoMuscular = :idGrupoMuscular;";
        Conexao::executarComParametros($query, $parametros);
    }
                 
}
?>
