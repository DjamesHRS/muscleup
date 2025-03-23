<?php
    include_once("../modelo/praticante.php");
    include_once("../dao/praticanteDao.php");

    class PraticanteControle{
        private $dao; 

        function __construct(){
            $this->dao = new PraticanteDao();
        }

        function cadastrar(){
            $praticante = new Praticante();
            $praticante->nome = $_POST["nome"];
            $praticante->email = $_POST["email"];
            $praticante->senha = $_POST["senha"];
            $praticante->dataDeNascimento = $_POST["dataDeNascimento"];
            $praticante->sexo = $_POST["sexo"];
            $praticante->altura = $_POST["altura"];
            $praticante->peso = $_POST["peso"];

            $this->dao = new PraticanteDao();
            $this->dao->cadastrar($praticante);
        }

        function pegarPorId(){
            session_start();

            // Desativa a exibição de erros
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(E_ALL);
        
            // Defina o cabeçalho para retornar JSON
            header('Content-Type: application/json');
        
            if (!isset($_POST["idPraticante"])) {
                echo json_encode(["error" => "ID do praticante não foi enviado."]);
                exit;
            }
            try {
                $praticante = new Praticante();
                $praticante->idPraticante = $_POST["idPraticante"];
                $this->dao = new PraticanteDao();
                $retorno = $this->dao->pegarPorId($praticante);
            
                echo json_encode($retorno);
            } catch (Exception $e) {
                // Captura a exceção e retorna como JSON
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage()
                ]);
            }            
        }

        function pegarTodos(){
            $praticante = new Praticante();
            $this->dao = new PraticanteDao();
            $retorno = $this->dao->pegarTodos($praticante);
            echo json_encode($retorno);
        }

        function alterar(){
            $praticante = new Praticante();
            $praticante->idPraticante = $_POST["idPraticante"];
            $praticante->nome = $_POST["nome"];
            $praticante->email = $_POST["email"];
            $praticante->senha = $_POST["senha"];
            $praticante->dataDeNascimento = $_POST["dataDeNascimento"];
            $praticante->sexo = $_POST["sexo"];
            $praticante->altura = $_POST["altura"];
            $praticante->peso = $_POST["peso"];

            $this->dao = new PraticanteDao();
            $this->dao->alterar($praticante);
        }

        function excluir(){
            $praticante = new Praticante();
            $praticante->idPraticante = $_POST["idPraticante"];

            $this->dao = new PraticanteDao();
            $this->dao->excluir($praticante);
        }

    }

    $controle = new PraticanteControle();
    $acao = $_POST["acao"];
    if($acao == "cadastrar"){
        $controle->cadastrar();
    }else if($acao == "pegarPorId"){
        $controle->pegarPorId();
    }else if ($acao == "alterar"){
        $controle->alterar();
    }else if($acao == "excluir"){
        $controle->excluir();
    }else if($acao == "pegarTodos"){
        $controle->pegarTodos();
    }else if($acao == "excluir"){
        $controle->excluir();
    }
?>