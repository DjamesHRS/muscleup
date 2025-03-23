<?php
    include_once("../modelo/adm.php");
    include_once("../dao/admDao.php");

    class AdmControle{
        private $dao;

        function __construct(){
            $this->dao = new AdmDao();
        }

        function pegarPorId(){
            session_start();

            // Desativa a exibição de erros
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(E_ALL);
       
            // Defina o cabeçalho para retornar JSON
            header('Content-Type: application/json');
       
            if (!isset($_POST["idAdm"])) {
                echo json_encode(["error" => "ID do Adm não foi enviado."]);
                exit;
            }
            try {
                $adm = new Adm();
                $adm->idAdm = $_POST["idAdm"];
                $this->dao = new AdmDao();
                $retorno = $this->dao->pegarPorId($adm);
           
                echo json_encode($retorno);
            } catch (Exception $e) {
                // Captura a exceção e retorna como JSON
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage()
                ]);
            }            
        }
    }

    $controle = new AdmControle();
    $acao = $_POST["acao"];
    if($acao == "pegarPorId"){
        $controle->pegarPorId();
    }
?>