<?php
    include_once("../utilitarios/conexao.php");

    class ExercicioDoTreinoDao {
        function adicionarExercicios($exercicioDoTreino) {
            try {
                $parametros = Array(
                    ":idTreino" => $exercicioDoTreino->idTreino, 
                    ":idExercicio" => $exercicioDoTreino->idExercicio,
                    ":series" => $exercicioDoTreino->series,
                    ":repeticoes" => $exercicioDoTreino->repeticoes,
                    ":descanso" => $exercicioDoTreino->descanso
                );
        
                $query = "INSERT INTO exerciciodotreino (idTreino, idExercicio, series, repeticoes, descanso) 
                          VALUES (:idTreino, :idExercicio, :series, :repeticoes, :descanso)";
        
                Conexao::executarComParametros($query, $parametros);
                
                return true;
            } catch (PDOException $e) {
                error_log("Erro ao cadastrar exercício no treino: " . $e->getMessage());
                return false;
            }
        }

        function pegarPorId($exercicioDoTreino){
            $parametros = Array(
                ":idTreino" => $exercicioDoTreino->idTreino
            );

            $query = "SELECT 
                            exerciciodotreino.idExercicio AS idExercicio,
                            exercicio.nome,
                            exerciciodotreino.series,
                            exerciciodotreino.repeticoes,
                            exerciciodotreino.descanso
                        FROM 
                            exerciciodotreino
                        JOIN 
                            exercicio ON exerciciodotreino.idExercicio = exercicio.idExercicio
                        WHERE 
                            exerciciodotreino.idTreino = :idTreino;";
            $stmt = Conexao::executarcomParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
    }
        
?>