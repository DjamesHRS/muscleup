<?php
    include_once("../modelo/praticante.php");
    include_once("../modelo/instrutor.php");
    include_once("../modelo/adm.php");
    include_once("../dao/praticanteDao.php");
    include_once("../dao/instrutorDao.php");
    include_once("../dao/admDao.php");

    class UsuarioControle{
        private $dao;

        function logar(){
            session_start();

            $praticante = new Praticante();
            $praticante->email = $_POST["email"];
            $praticante->senha = $_POST["senha"];

            $this->dao = new PraticanteDao();
            $retorno = $this->dao->logar($praticante);
            if( count($retorno) > 0 ){
                $_SESSION["idPraticante"] = $retorno[0]["idPraticante"];
                echo("1");
            }else{
                $instrutor = new Instrutor();
                $instrutor->email = $_POST["email"];
                $instrutor->senha = $_POST["senha"];
    
                $this->dao = new InstrutorDao();
                $retorno = $this->dao->logar($instrutor);
                if( count($retorno) > 0 ){
                    $_SESSION["idInstrutor"] = $retorno[0]["idInstrutor"];
                    echo("2");
                }else{
                    $adm = new Adm();
                    $adm->email = $_POST["email"];
                    $adm->senha = $_POST["senha"];
        
                    $this->dao = new AdmDao();
                    $retorno = $this->dao->logar($adm);
                    if( count($retorno) > 0 ){
                        $_SESSION["idAdm"] = $retorno[0]["idAdm"];
                        echo("3");
                    }else{
                        echo("3");
                    }
                }
            }
        }

        public function sair() {
            session_start();

            if (isset($_SESSION["idPraticante"]) || isset($_SESSION["idInstrutor"]) || isset($_SESSION["idAdm"])) {
                session_unset();   
                session_destroy(); 
    
                echo "1";
            } else {
                echo "0";
            }
        }
    }

    $controle = new UsuarioControle();
    $acao = $_POST["acao"];
    if($acao == "logar"){
        $controle->logar();
    }else if($acao == "sair"){
        $controle->sair();
    }
?>