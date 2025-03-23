<?php
include_once("../modelo/musculoAlvo.php");
include_once("../dao/musculoAlvoDao.php");

class MusculoAlvoControle {
    private $dao;

    function __construct() {
        $this->dao = new MusculoAlvoDao();
    }

    function cadastrar(){
        $musculoAlvo = new MusculoAlvo();
        $nomes = $_POST['nomes'];
        $idGrupoMuscular = $_POST["idGrupoMuscular"];
       
        foreach ($nomes as $nome) {
            $musculoAlvo = new MusculoAlvo();
            $musculoAlvo->nome = $nome;
            $musculoAlvo->idGrupoMuscular = $idGrupoMuscular;
            
            $this->dao->cadastrar($musculoAlvo);
        }
    }   

    function alterar(){
        $musculoAlvo = new MusculoAlvo();
        $musculoAlvo->nome =$_POST["nome"];
        $musculoAlvo->idMusculoAlvo = $_POST["idMusculoAlvo"];

        $this->dao = new MusculoAlvoDao();
        $this->dao->alterar($musculoAlvo);
    }

    function excluir(){
        $musculoAlvo = new MusculoAlvo();
        $musculoAlvo->idGrupoMuscular = $_POST["idGrupoMuscular"];

        $this->dao = new MusculoAlvoDao();
        $this->dao->excluir($musculoAlvo);
    }

    function pegarPorIdDoGrupo(){
        $musculoAlvo = new MusculoAlvo();
        $musculoAlvo->idGrupoMuscular = $_POST["idGrupoMuscular"];
        $this->dao = new MusculoAlvoDao();
        $retorno = $this->dao->pegarPorIdDoGrupo($musculoAlvo);
        echo json_encode($retorno);
    }
}

$controle = new MusculoAlvoControle();
$acao = $_POST["acao"];

if ($acao == "cadastrar") {
    $controle->cadastrar();
}else if ($acao == "excluir") {
    $controle->excluir();
}else if ($acao == "pegarPorIdDoGrupo") {
    $controle->pegarPorIdDoGrupo();
}else if ($acao == "alterar") {
    $controle->alterar();
}
?>
