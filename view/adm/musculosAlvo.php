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
                    <h2>Adicionar Músculos Alvo</h2>
                </div>
                <div class="form-group" id="musculoInputs">
                    <label for="nomeModal">Nome do Músculo Alvo:</label>
                    <input name="nomeModal[]" class="form-control" placeholder="Informe o nome do Músculo Alvo" type="text">
                </div>
                <button class="btn-neutral" onclick="adicionarOutroInput()">Adicionar Outro Músculo Alvo</button>
                <div class="modal-footer">
                    <button class="btn-positive" onclick="cadastrar()">Finalizar</button>
                    <button type="button" class="btn-negative" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../../utilitarios/jquery-3.7.1.min.js"></script>
    <script>
        var idGrupoMuscularSelecionado;
        var idAdm;
        $(document).ready(function() {
            var idAdm = <?php echo json_encode($_SESSION["idAdm"]); ?>;
            pegarPorId(idAdm);
            pegarTodos();
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

            function pegarTodos() {
                $.ajax({
                    url: "../../controle/grupoMuscularControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarTodosSemMusculoAlvo",
                    },
                    success: function(retorno) {
                        result = JSON.parse(retorno);
                        if (Array.isArray(result) && result.length > 0) {
                        result.forEach(function(item) {
                            var cardHtml = `
                                <div onclick="openModal(${item.idGrupoMuscular})" class="card" data-bs-toggle="modal" data-bs-target="#myModal">
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
                        console.error("Erro ao buscar dados: ", error);
                    }
                });
            }

            function openModal(idGrupoMuscular) {
                idGrupoMuscularSelecionado = idGrupoMuscular;
            }

            function adicionarOutroInput() {
                // Cria um novo input para o músculo alvo
                const novoInput = document.createElement("input");
                novoInput.setAttribute("name", "nomeModal[]");
                novoInput.setAttribute("class", "form-control mt-2");
                novoInput.setAttribute("placeholder", "Informe o nome do Músculo Alvo");
                novoInput.setAttribute("type", "text");
                
                // Adiciona o novo input ao contêiner
                document.getElementById("musculoInputs").appendChild(novoInput);
            }

            function cadastrar() {
                // Coletar todos os valores dos inputs
                const inputs = document.querySelectorAll("input[name='nomeModal[]']");
                const nomes = Array.from(inputs).map(input => input.value.trim()).filter(nome => nome !== "");

                if (nomes.length === 0) {
                    alert("Por favor, preencha pelo menos um nome de músculo alvo.");
                    return;
                }
                console.log(nomes);

                // Enviar o array para o backend
                $.ajax({
                    url: "../../controle/musculoAlvoControle.php",
                    type: "POST",
                    data: {
                        acao: "cadastrar",
                        idGrupoMuscular: idGrupoMuscularSelecionado,
                        nomes: nomes
                    },
                    success: function(retorno) {
                        alert("Músculos cadastrados com sucesso!");
                        window.location.href = "musculosAlvo.php";
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