<?php
    session_start();
    if (!isset($_SESSION["idPraticante"])) {
        header("location:../index.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../utilitarios/loadNavbar.js"></script>
    <script src="../../utilitarios/functionToggleNav.js"></script>
    <link rel="stylesheet" href="../../utilitarios/style.css">
    <title>Nova Ficha de Treino</title>
</head>
<body class="body-principal">
    <div id="navbar"></div>
    <div id="main">
        <h1>Nova Ficha de Treino</h1><br>
        <p>Na nossa plataforma, você tem a oportunidade de dar um passo ainda mais importante na sua jornada de bem-estar e evolução. Aqui, você pode solicitar uma nova ficha de treino totalmente individualizada, pensada especialmente para os seus objetivos, ritmo e necessidades. Seja para aprimorar seu desempenho, conquistar novos desafios ou simplesmente manter a motivação em alta, nossa equipe está pronta para criar um plano de treino exclusivo para você.
            Com apenas alguns cliques, você receberá um treino que se encaixa perfeitamente na sua rotina, com exercícios pensados para maximizar seus resultados de forma segura e eficaz. Nós sabemos que cada pessoa é única, e, por isso, seu treino também deve ser!
            Pronto para dar o próximo passo e alcançar suas metas com mais precisão e confiança? Peça sua nova ficha de treino agora mesmo e descubra como o cuidado personalizado pode transformar sua experiência. 💪</p>
        <button class="btn-positive" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Nova Ficha de Treino</button>
    </div>
    <div class="modal" id="myModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Nova Ficha de Treino</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    <label for="objetivo">Objetivo de Treino:</label>
                    <select name="objetivo" id="objetivo" class="form-control">
                        <option value="">Selecione</option>
                        <option value="perderPeso">Perder Peso</option>
                        <option value="ganharMassa">Ganhar Massa Muscular</option>
                        <option value="manter">Manter Peso</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nivel">Nível de Treino:</label>
                    <select name="nivel" id="nivel" class="form-control">
                        <option value="">Selecione</option>
                        <option value="iniciante">Iniciante</option>
                        <option value="intermediario">Intermediário</option>
                        <option value="avancado">Avançado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="foco">Foco no Grupo Muscular:</label>
                    <select name="foco" id="foco" class="form-control">
                        <option value="0">Selecione</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dias">Dias de Treino:</label>
                    <br>
                    <input type="checkbox" name="dias" value="segundaFeira"> Segunda-feira
                    <br>
                    <input type="checkbox" name="dias" value="tercaFeira"> Terça-feira
                    <br>
                    <input type="checkbox" name="dias" value="quartaFeira"> Quarta-feira
                    <br>
                    <input type="checkbox" name="dias" value="quintaFeira"> Quinta-feira
                    <br>
                    <input type="checkbox" name="dias" value="sextaFeira"> Sexta-feira
                    <br>
                    <input type="checkbox" name="dias" value="sabado"> Sábado
                    <br>
                    <input type="checkbox" name="dias" value="domingo"> Domingo
                </div>
                <div class="form-group">
                    <label for="observacao">Observações (Problemas físicos, etc.):</label>
                    <textarea name="observacao" id="observacao" class="form-control" placeholder="Informe suas observações" cols="10" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="instrutor">Instrutor:</label>
                    <select name="instrutor" id="instrutor" class="form-control">
                        <option value="0">Selecione</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn-positive" onclick="cadastrar()">Nova Ficha de Treino</button>
                    <button class="btn-negative" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
<script src="../../utilitarios/jquery-3.7.1.min.js"></script>
<script>
    var idPraticante;
    $(document).ready(function() {
        var idPraticante = <?php echo json_encode($_SESSION["idPraticante"]); ?>;
        pegarTodos();
        pegarPorId(idPraticante);
    });

    function pegarPorId(idPraticante) {
                $.ajax({
                    url: "../../controle/praticanteControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idPraticante: idPraticante
                    },
                    success: function(retorno) {
                        if (Array.isArray(retorno) && retorno.length > 0) {
                            var praticante = retorno[0];  // Pega o primeiro objeto
                            document.getElementById("nomeUsuario").innerText = praticante.nome;
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
                acao: "pegarTodos",
            },
            success: function(retorno) {
                result = JSON.parse(retorno);
                if (Array.isArray(result)) {
                    result.forEach(function(item) {
                        $("#foco").append(new Option(item.nomeGrupoMuscular, item.idGrupoMuscular));
                    });
                } else {
                    console.error("Resposta não é um array:", result);
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro ao buscar dados: ", error);
            }
        });

        $.ajax({
            url: "../../controle/instrutorControle.php",
            type: "POST",
            data: {
                acao: "pegarTodos",
            },
            success: function(retorno) {
                result = JSON.parse(retorno);
                if (Array.isArray(result)) {
                    result.forEach(function(item) {
                        $("#instrutor").append(new Option(item.nome, item.idInstrutor));
                    });
                } else {
                    console.error("Resposta não é um array:", result);
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro ao buscar dados: ", error);
            }
        });
    }

    function cadastrar() {
        var status;
        status = "naoDesenvolvido"
        var idPraticante = <?php echo json_encode($_SESSION["idPraticante"]); ?>;
        // Captura os dias selecionados
        var diasSelecionados = [];
        $("input[name='dias']:checked").each(function() {
            diasSelecionados.push($(this).val());
        });

        // Converte o array de dias para JSON
        var diasJson = JSON.stringify(diasSelecionados);
        // Envio dos dados via AJAX
        $.ajax({
            url: "../../controle/fichaDeTreinoControle.php",
            type: "POST",
            data: {
                acao: "cadastrar",
                idPraticante: idPraticante,
                status: status, 
                objetivo: $("#objetivo").val(),
                nivel: $("#nivel").val(),
                foco: $("#foco option:selected").text(),
                observacao: $("#observacao").val(),
                instrutor: $("#instrutor").val(),
                dias: diasJson // Enviando os dias em formato JSON
            },
            success: function(retorno) {
                alert("Pedido de Ficha de Treino Realizado com Sucesso");
                window.location.href = "fichaDeTreino.php";
            },
            error: function(xhr, status, error) {
                console.error("Erro ao cadastrar a ficha de treino: ", error);
            }
        });
    }
</script>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>