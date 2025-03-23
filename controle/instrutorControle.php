<?php
    include_once("../modelo/instrutor.php");
    include_once("../dao/instrutorDao.php");

    class InstrutorControle{
        private $dao;

        function __construct(){
            $this->dao = new InstrutorDao();
        }

        function cadastrar(){
            $instrutor = new Instrutor();
            $instrutor->nome = $_POST["nome"];
            $instrutor->email = $_POST["email"];
            $instrutor->senha = $_POST["senha"];
            $instrutor->cref = $_POST["cref"];
            $instrutor->dataDeNascimento = $_POST["dataDeNascimento"];
            $instrutor->sexo = $_POST["sexo"];
            $instrutor->dataDeFormacao = $_POST["dataDeFormacao"];
            $instrutor->universidadeDeFormacao = $_POST["universidadeDeFormacao"];
            $instrutor->descricao = $_POST["descricao"];

            $this->dao = new InstrutorDao();
            $this->dao->cadastrar($instrutor);
        }

        function pegarPorId(){
            session_start();

            // Desativa a exibição de erros
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(E_ALL);
       
            // Defina o cabeçalho para retornar JSON
            header('Content-Type: application/json');
       
            if (!isset($_POST["idInstrutor"])) {
                echo json_encode(["error" => "ID do instrutor não foi enviado."]);
                exit;
            }
            try {
                $instrutor = new Instrutor();
                $instrutor->idInstrutor = $_POST["idInstrutor"];
                $this->dao = new InstrutorDao();
                $retorno = $this->dao->pegarPorId($instrutor);
           
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
            $instrutor = new Instrutor();
            $this->dao = new InstrutorDao();
            $retorno = $this->dao->pegarTodos($instrutor);
            echo json_encode($retorno);
        }

        function alterar(){
            $instrutor = new Instrutor();
            $instrutor->idInstrutor = $_POST["idInstrutor"];
            $instrutor->nome = $_POST["nome"];
            $instrutor->email = $_POST["email"];
            $instrutor->senha = $_POST["senha"];
            $instrutor->cref = $_POST["cref"];
            $instrutor->dataDeNascimento = $_POST["dataDeNascimento"];
            $instrutor->sexo = $_POST["sexo"];
            $instrutor->dataDeFormacao = $_POST["dataDeFormacao"];
            $instrutor->universidadeDeFormacao = $_POST["universidadeDeFormacao"];
            $instrutor->descricao = $_POST["descricao"];

            $this->dao = new InstrutorDao();
            $this->dao->alterar($instrutor);
        }

        function excluir(){
            $instrutor = new Instrutor();
            $instrutor->idInstrutor = $_POST["idInstrutor"];

            $this->dao = new InstrutorDao();
            $this->dao->excluir($instrutor);
        }
    }

    $controle = new InstrutorControle();
    $acao = $_POST["acao"];
    if($acao == "cadastrar"){
        $controle->cadastrar();
    }else if($acao == "pegarPorId"){
        $controle->pegarPorId();
    }else if ($acao == "alterar"){
        $controle->alterar();
    }else if ($acao == "pegarTodos"){
        $controle->pegarTodos();
    }else if($acao == "excluir"){
        $controle->excluir();
    }
?>