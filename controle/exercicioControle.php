<?php
include_once("../modelo/exercicio.php");
include_once("../dao/exercicioDao.php");

class ExercicioControle {
    private $dao;

    function __construct() {
        $this->dao = new ExercicioDao();
    }

    function cadastrar() {
        $exercicio = new Exercicio();
        $exercicio->idExercicio = $_POST["idExercicio"];
        $exercicio->nome = $_POST["nome"];
        $exercicio->descricao = $_POST["descricao"];
        $exercicio->instrucao = $_POST["instrucao"];
        $exercicio->idGrupoMuscular = $_POST["grupoMuscular"];
        
        $this->dao = new ExercicioDao();
        $this->dao->cadastrar($exercicio);
    }    

    function alterar() {
        $exercicio = new Exercicio();
        $exercicio->id = $_POST["idExercicio"];
        $exercicio->nome = $_POST["nome"];
        $exercicio->descricao = $_POST["descricao"];
        $exercicio->instrucao = $_POST["instrucao"];
        $exercicio->idGrupoMuscular = $_POST["grupoMuscular"];
        
        $this->dao = new ExercicioDao();
        $this->dao->alterar($exercicio);
    }   
    
    function pegarTodos(){
        $exercicio = new Exercicio();
        $this->dao = new ExercicioDao();
        $retorno = $this->dao->pegarTodos($exercicio);

        echo json_encode($retorno);
    }

    function pegarTodosFiltro(){
        $exercicio = new Exercicio();
        $exercicio->idGrupoMuscular = $_POST["idGrupoMuscular"];
        $this->dao = new ExercicioDao();
        $retorno = $this->dao->pegarTodosFiltro($exercicio);

        echo json_encode($retorno);
    }

    function pegarPorId(){
        $exercicio = new Exercicio();
        $exercicio->idExercicio = $_POST["idExercicio"];
        $this->dao = new ExercicioDao();
        $retorno = $this->dao->pegarPorId($exercicio);

        echo json_encode($retorno);
    }

    function excluir(){
        $exercicio = new Exercicio();
        $exercicio->id = $_POST["idExercicio"];
        $this->dao = new ExercicioDao();
        $this->dao->excluir($exercicio);
    }
}

$controle = new ExercicioControle();
$acao = $_POST["acao"];

if ($acao == "cadastrar") {
    $controle->cadastrar();
}else if ($acao == "pegarTodos") {
    $controle->pegarTodos();
}else if ($acao == "pegarPorId") {
    $controle->pegarPorId();
}else if ($acao == "alterar") {
    $controle->alterar();
}else if ($acao == "excluir") {
    $controle->excluir();
}else if ($acao == "pegarTodosFiltro") {
    $controle->pegarTodosFiltro();
}
?>
