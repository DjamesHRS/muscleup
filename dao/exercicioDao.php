<?php
include_once("../utilitarios/conexao.php");

class ExercicioDao {    

    function cadastrar($exercicio){
        $parametros = Array(
            ":nome" => $exercicio->nome,
            ":descricao" => $exercicio->descricao,
            ":instrucao" => $exercicio->instrucao,
            ":idGrupoMuscular" => $exercicio->idGrupoMuscular,
        );
        $query = "INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
                    VALUES (:nome, :descricao, :instrucao, :idGrupoMuscular);";

        Conexao::executarComParametros($query, $parametros);
    }

    function alterar($exercicio){
        $parametros = Array(
            ":idExercicio" => $exercicio->id,
            ":nome" => $exercicio->nome,
            ":descricao" => $exercicio->descricao,
            ":instrucao" => $exercicio->instrucao,
            ":idGrupoMuscular" => $exercicio->idGrupoMuscular,
        );
        $query = "UPDATE exercicio set nome = :nome, descricao = :descricao, instrucao = :instrucao, idGrupoMuscular = :idGrupoMuscular WHERE idExercicio = :idExercicio;";
        
        Conexao::executarComParametros($query, $parametros);
    }

    function excluir($exercicio){
        $parametros = Array(
            ":idExercicio" => $exercicio->id
        );
        $query = "DELETE from exercicio WHERE idExercicio = :idExercicio;";
        
        Conexao::executarComParametros($query, $parametros);
    }

    function pegarTodos() {
        try {
            $query = "SELECT e.idExercicio, e.nome AS nomeExercicio, e.descricao, e.instrucao, g.idGrupoMuscular, g.nome AS nomeGrupoMuscular FROM exercicio e JOIN grupomuscular g ON e.idGrupoMuscular = g.idGrupoMuscular ORDER BY nomeExercicio;";
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

    function pegarTodosFiltro($exercicio){
        $parametros = Array(
            ":idGrupoMuscular" => $exercicio->idGrupoMuscular
        );
        $query = "SELECT 
    exercicio.idExercicio AS idExercicio,
    exercicio.nome AS nomeExercicio, exercicio.descricao, exercicio.instrucao,
    grupomuscular.idGrupoMuscular AS idGrupoMuscular,
    grupomuscular.nome AS nomeGrupoMuscular
FROM 
    exercicio
JOIN 
    grupomuscular 
ON 
    exercicio.idGrupoMuscular = grupomuscular.idGrupoMuscular
WHERE 
    exercicio.idGrupoMuscular = :idGrupoMuscular;

";

        $stmt = Conexao::executarComParametros($query, $parametros);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function pegarPorId($exercicio){
        $parametros = Array(
            ":idExercicio" => $exercicio->idExercicio
        );
        $query = "SELECT * from exercicio where idExercicio = :idExercicio;";

        $stmt = Conexao::executarComParametros($query, $parametros);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
