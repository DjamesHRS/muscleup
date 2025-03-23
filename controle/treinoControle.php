<?php
    include_once("../modelo/treino.php");
    include_once("../dao/treinoDao.php");

    class TreinoControle {
        private $dao;
        
        function __construct() {
            $this->dao = new TreinoDao();
        }

        function cadastrar() {
            $treinos = json_decode($_POST["treinos"]);

            foreach ($treinos as $treinoData) {
                $treino = new Treino();
                $treino->nome = $treinoData->nome;
                $treino->descricao = $treinoData->descricao;
                $treino->diaDoTreino = $treinoData->dia;
                $treino->tempoDeDuracao = $treinoData->duracao;
                $treino->idFichaDeTreino = $treinoData->idFichaDeTreino;
                
                $this->dao = new TreinoDao();
                $this->dao->cadastrar($treino);
            }
        
            echo json_encode([
                'status' => 'success',
                'message' => 'Treinos e exercícios cadastrados com sucesso',
            ]);
        } 
        
        function alterar(){
            $treino = new Treino();
            $treino->idTreino = $_POST["idTreino"];
            $treino->nome = $_POST["nome"];
            $treino->descricao = $_POST["descricao"];
            $treino->diaDoTreino = $_POST["diaDoTreino"];
            $treino->tempoDeDuracao = $_POST["tempoDeDuracao"];

            $this->dao = new TreinoDao();
            $this->dao->alterar($treino);
        }

        function pegarPorIdDaFicha(){
            $treino = new Treino();
            $treino->idFichaDeTreino = $_POST["idFichaDeTreino"];
            $this->dao = new TreinoDao();
            $retorno = $this->dao->pegarPorIdDaFicha($treino);

            echo json_encode($retorno);
        }

        function pegarPorId(){
            $treino = new Treino();
            $treino->idTreino = $_POST["idTreino"];
            $this->dao = new TreinoDao();
            $retorno = $this->dao->pegarPorId($treino);

            echo json_encode($retorno);
        }
    
    }

    $controle = new TreinoControle();
    $acao = $_POST["acao"];
    if($acao == "cadastrar"){
        $controle->cadastrar();
    }else if($acao == "pegarPorIdDaFicha"){
        $controle->pegarPorIdDaFicha();
    }else if ($acao == "pegarPorId"){
        $controle->pegarPorId();
    }else if ($acao == "alterar"){
        $controle->alterar();
    }

?>