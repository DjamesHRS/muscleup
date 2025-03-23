<?php
   session_start();
    if( !isset($_SESSION["idAdm"])){
        header("location:../index.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../utilitarios/loadNavbarAdm.js"></script>
    <script src="../../utilitarios/functionToggleNav.js"></script>
    <link rel="stylesheet" href="../../utilitarios/style.css">
    <title>Músculos Alvo</title>
</head>
<body class="body-principal">
<div id="navbar"></div>
    <!-- Conteúdo Principal -->
    <div id="main">
        <div class="card-columns mt-4" id="cards"></div>
        <a href="gruposMusculares.php"><button class="btn-neutral">Voltar</button></a>
    </div>
    
    <div class="modal" id="myModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Alterar Músculos Alvo</h2>
                </div>
                <div class="form-group" id="musculoInputs">
                    <label for="nomeModal">Nome do Músculo Alvo:</label>
                    <input id="nomeModal" name="nomeModal" class="form-control" placeholder="Informe o nome do Músculo Alvo" type="text">
                </div>
                <div class="modal-footer">
                    <button class="btn-positive" onclick="alterar()">Salvar</button>
                    <button type="button" class="btn-negative" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../../utilitarios/jquery-3.7.1.min.js"></script>
    <script>
        function getQueryParam(param) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
        var idAdm;
        $(document).ready(function() {
            var idMusculoAlvoSelecionado;
            var idAdm = <?php echo json_encode($_SESSION["idAdm"]); ?>;
            pegarPorId(idAdm);

            var idGrupoMuscular = getQueryParam('idGrupoMuscular');
            if (idGrupoMuscular) {
                pegarPorIdDoGrupo(idGrupoMuscular);
            } else {
                console.error("idGrupoMuscular não encontrado na URL.");
            }
        });


        function pegarPorId(idAdm) {
                $.ajax({
                    url: "../../controle/admControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idAdm: idAdm
                    },
                    success: function(retorno) {
                        if (Array.isArray(retorno) && retorno.length > 0) {
                            var adm = retorno[0];
                            document.getElementById("nomeUsuario").innerText = adm.nome;
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados do praticante:', error);
                    }
                });
            }

            function pegarPorIdDoGrupo(idGrupoMuscular) {
                $.ajax({
                    url: "../../controle/musculoAlvoControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorIdDoGrupo",
                        idGrupoMuscular: idGrupoMuscular
                    },
                    success: function(retorno) {
                        result = JSON.parse(retorno);
                        if (Array.isArray(result) && result.length > 0) {
                        result.forEach(function(item) {
                            var cardHtml = `
                                <div onclick="openModal(${item.idMusculoAlvo}, '${item.nome}')" class="card" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <div class="card-body">
                                        <h5 class="card-title">${item.nome}</h5>
                                    </div>
                                </div>
                            `;
                            $('#cards').append(cardHtml);
                        })
                    } else {
                        console.error('Nenhum dado foi retornado.');
                    }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao carregar o grupo muscular:", error);
                    }
                });
            }

            function openModal(idMusculoAlvo, nomeMusculo) {
                idMusculoAlvoSelecionado = idMusculoAlvo;
                document.querySelector("input[name='nomeModal']").value = nomeMusculo;
            }

            function alterar() {
                $.ajax({
                    url: "../../controle/musculoAlvoControle.php",
                    type: "POST",
                    data: {
                        acao: "alterar",
                        idMusculoAlvo: idMusculoAlvoSelecionado,
                        nome: $("#nomeModal").val(),
                    },
                    success: function(retorno) {
                        alert("Músculo alterado com sucesso!");

                        // Redireciona para a mesma página, mantendo o idGrupoMuscular na URL
                        var idGrupoMuscular = getQueryParam('idGrupoMuscular');
                        if (idGrupoMuscular) {
                            // Redireciona para a página atual, mantendo o idGrupoMuscular na URL
                            window.location.href = window.location.pathname + "?idGrupoMuscular=" + idGrupoMuscular;
                        } else {
                            console.error("idGrupoMuscular não encontrado na URL.");
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao cadastrar músculos:", error);
                    }
                });
            }

</script>
</body>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>