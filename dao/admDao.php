<?php
    include_once("../utilitarios/conexao.php");

    class AdmDao{
        function logar($adm){
            $parametros = Array(
                ":email" => $adm->email,
                ":senha" => md5($adm->senha)
            );
            $query = "select idAdm from adm where email = :email and senha = :senha";
            $stmt = Conexao::executarComParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function pegarPorId($adm){
            $parametros = Array(
                ":idAdm" => $adm->idAdm,
            );
            $query = "select * from adm where idAdm = :idAdm";
            $stmt = Conexao::executarcomParametros($query, $parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>