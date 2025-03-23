<?php
include_once("../modelo/grupoMuscular.php");
include_once("../dao/grupoMuscularDao.php");

class GrupoMuscularControle {
    private $dao;

    function __construct() {
        $this->dao = new GrupoMuscularDao();
    }

    function cadastrar(){
        $grupoMuscular = new GrupoMuscular();
        $grupoMuscular->nome = $_POST["nome"];
        $this->dao = new GrupoMuscularDao();
        $this->dao->cadastrar($grupoMuscular);
    }   

    function alterar(){
        $grupoMuscular = new GrupoMuscular();
        $grupoMuscular->nome = $_POST["nome"];
        $grupoMuscular->id = $_POST["idGrupoMuscular"];
        $this->dao = new GrupoMuscularDao();
        $this->dao->alterar($grupoMuscular);
    } 

    function excluir(){
        $grupoMuscular = new GrupoMuscular();
        $grupoMuscular->id = $_POST["idGrupoMuscular"];
        $this->dao = new GrupoMuscularDao();
        $this->dao->excluir($grupoMuscular);
    } 
    
    function pegarTodos(){
        $grupoMuscular = new GrupoMuscular();
        $this->dao = new GrupoMuscularDao();
        $retorno = $this->dao->pegarTodos($grupoMuscular);
        echo json_encode($retorno);
    }

    function pegarTodosSemMusculoAlvo(){
        $grupoMuscular = new GrupoMuscular();
        $this->dao = new GrupoMuscularDao();
        $retorno = $this->dao->pegarTodosSemMusculoAlvo($grupoMuscular);
        echo json_encode($retorno);
    }
}

$controle = new GrupoMuscularControle();
$acao = $_POST["acao"];

if ($acao == "cadastrar") {
    $controle->cadastrar();
}else if ($acao == "pegarTodos") {
    $controle->pegarTodos();
}else if ($acao == "pegarTodosSemMusculoAlvo") {
    $controle->pegarTodosSemMusculoAlvo();
}else if ($acao == "alterar"){
    $controle->alterar();
}else if ($acao == "excluir"){
    $controle->excluir();
}
?>
