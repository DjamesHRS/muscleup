<?php
include_once("../modelo/fichaDeTreino.php");
include_once("../dao/fichaDeTreinoDao.php");

class FichaDeTreinoControle {
    private $dao;

    function __construct() {
        $this->dao = new FichaDeTreinoDao();
    }
    
    function cadastrar(){
        $fichaDeTreino = new FichaDeTreino();
        $fichaDeTreino->objetivo = $_POST["objetivo"];
        $fichaDeTreino->nivel = $_POST["nivel"];
        $fichaDeTreino->dias = json_decode($_POST["dias"]);
        $fichaDeTreino->status = $_POST["status"];
        $fichaDeTreino->focoMuscular = $_POST["foco"];
        $fichaDeTreino->observacoes = $_POST["observacao"];
        $fichaDeTreino->idInstrutor = $_POST["instrutor"];
        $fichaDeTreino->idPraticante = $_POST["idPraticante"];

        $this->dao = new fichaDeTreinoDao();
        $this->dao->cadastrar($fichaDeTreino);
    }

    function pegarPorId(){
        $fichaDeTreino = new FichaDeTreino();
        
        // Verifica qual ID foi passado e preenche a ficha de treino com o ID apropriado
        if (isset($_POST["idPraticante"]) && !empty($_POST["idPraticante"])) {
            $fichaDeTreino->idPraticante = $_POST["idPraticante"];
        } elseif (isset($_POST["idInstrutor"]) && !empty($_POST["idInstrutor"])) {
            $fichaDeTreino->idInstrutor = $_POST["idInstrutor"];
        } elseif (isset($_POST["idFichaDeTreino"]) && !empty($_POST["idFichaDeTreino"])) {
            $fichaDeTreino->idFichaDeTreino = $_POST["idFichaDeTreino"];
        } else {
            echo json_encode(["erro" => "Nenhum identificador (idPraticante, idInstrutor ou idFichaDeTreino) foi fornecido."]);
            return;
        }
    
        // Chama o DAO para pegar os dados
        $this->dao = new FichaDeTreinoDao();    
        $retorno = $this->dao->pegarPorId($fichaDeTreino);
    
        // Retorna os dados no formato JSON
        echo json_encode($retorno);
    }

    function alterar(){
        $fichaDeTreino = new FichaDeTreino();
        $fichaDeTreino->idFichaDeTreino = $_POST["idFichaDeTreino"];
        $fichaDeTreino->nome = $_POST["nome"];
        $fichaDeTreino->dataDeCriacao = $_POST["dataCriacao"];
        $fichaDeTreino->descricao = $_POST["descricao"];

        $this->dao = new FichaDeTreinoDao();
        $this->dao->alterar($fichaDeTreino);
    }

    function alterarStatus(){
        $fichaDeTreino = new FichaDeTreino();
        $fichaDeTreino->idFichaDeTreino = $_POST["idFichaDeTreino"];
        $fichaDeTreino->status = $_POST["status"];

        $this->dao = new FichaDeTreinoDao();
        $this->dao->alterarStatus($fichaDeTreino);
    }

    function alterarNome(){
        $fichaDeTreino = new FichaDeTreino();
        $fichaDeTreino->idFichaDeTreino = $_POST["idFichaDeTreino"];
        $fichaDeTreino->nome = $_POST["nome"];

        $this->dao = new FichaDeTreinoDao();
        $this->dao->alterarNome($fichaDeTreino);
    }

    function alterarInstrutor(){
        $fichaDeTreino = new FichaDeTreino();
        $fichaDeTreino->idFichaDeTreino = $_POST["idFichaDeTreino"];
        $fichaDeTreino->nome = $_POST["nome"];
        $fichaDeTreino->descricao = $_POST["descricao"];

        $this->dao = new FichaDeTreinoDao();
        $this->dao->alterarInstrutor($fichaDeTreino);
    }

    function alterarAdm(){
        $fichaDeTreino = new FichaDeTreino();
        $fichaDeTreino->idFichaDeTreino = $_POST["idFichaDeTreino"];
        $fichaDeTreino->nome = $_POST["nome"];
        $fichaDeTreino->instrutor = $_POST["instrutor"];
        $fichaDeTreino->status = $_POST["status"];
        
        $this->dao = new FichaDeTreinoDao();
        $this->dao->alterarAdm($fichaDeTreino);
    }

    function excluir(){
        $fichaDeTreino = new FichaDeTreino();
        $fichaDeTreino->idFichaDeTreino = $_POST["idFichaDeTreino"];

        $this->dao = new FichaDeTreinoDao();
        $this->dao->excluir($fichaDeTreino);
    }
}

$controle = new FichaDeTreinoControle();
$acao = $_POST["acao"];

if ($acao == "cadastrar") {
    $controle->cadastrar();
}else if ($acao == "pegarPorId") {
    $controle->pegarPorId();
}else if ($acao == "alterar"){
    $controle->alterar();
}else if ($acao == "alterarStatus"){
    $controle->alterarStatus();
}else if ($acao == "alterarNome"){
    $controle->alterarNome();
}else if ($acao == "excluir"){
    $controle->excluir();
}else if ($acao == "alterarInstrutor"){
    $controle->alterarInstrutor();
}else if ($acao == "alterarAdm"){
    $controle->alterarAdm();
}
?>
