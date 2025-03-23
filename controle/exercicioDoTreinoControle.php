<?php
    include_once("../modelo/exercicioDoTreino.php");
    include_once("../dao/exercicioDoTreinoDao.php");

    class ExercicioDoTreinoControle {
        private $dao;
        
        function __construct() {
            $this->dao = new ExercicioDoTreinoDao();
        }

        function adicionarExercicios() {
            $exercicios = json_decode($_POST['exercicios'], true);
            //var_dump($exercicios);

            foreach ($exercicios as $exercicio) {
                $exercicioDoTreino = new ExercicioDoTreino();
                $exercicioDoTreino->idExercicio = $exercicio['idExercicio'];
                $exercicioDoTreino->series = $exercicio['quantidadeSeries'];
                $exercicioDoTreino->repeticoes = $exercicio['intervaloRepeticoes'];
                $exercicioDoTreino->descanso = $exercicio['tempoDescanso'];
                $exercicioDoTreino->idTreino = $exercicio['idTreino'];

                $this->dao = new ExercicioDoTreinoDao();
                $this->dao->adicionarExercicios($exercicioDoTreino);
            }
        }

        function pegarPorId(){
            $exercicioDoTreino = new ExercicioDoTreino();
            $exercicioDoTreino->idTreino = $_POST["idTreino"];

            $this->dao = new ExercicioDoTreinoDao();
            $retorno = $this->dao->pegarPorId($exercicioDoTreino);
            echo json_encode($retorno);
        }
    }        

    $controle = new ExercicioDoTreinoControle();
    $acao = $_POST["acao"];
    if($acao == "adicionarExercicios"){
        $controle->adicionarExercicios();
    } else if($acao == "pegarPorId"){
        $controle->pegarPorId();
    }

?>