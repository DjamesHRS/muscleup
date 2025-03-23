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
    <title>Página Inicial</title>
</head>
<body class="body-principal">
<div id="navbar"></div>
    <!-- Conteúdo Principal -->
    <div id="main">

                <!-- Cards com funcionalidades -->
            <div class="container mt-4">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Fichas de Treino</h5>
                            <img class="imgHome" src="../../img/gym.png" alt="">
                            <p class="card-footer">Gerencie todas as fichas de treino do sistema, seja o responsável pelo resultado positivo de todos os usuários do sistema!</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Exercícios</h5>
                            <img class="imgHome" src="../../img/workout.png" alt="">
                            <p class="card-footer">Gerencie todos os exercícios do sistema, crie, acesse, altere e exclua!</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Grupos Musculares</h5>
                            <img class="imgHome" src="../../img/muscle.png" alt="">
                            <p class="card-footer">Tenha acesso a todos oe instrutores do sistema e decida qual combina melhor com suas expectativas, preferências e necessidades!</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Instrutores</h5>
                            <img class="imgHome" src="../../img/coaches.png" alt="">
                            <p class="card-footer">Tenha acesso a todos oe instrutores do sistema e decida qual combina melhor com suas expectativas, preferências e necessidades!</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Praticantes</h5>
                            <img class="imgHome" src="../../img/people.png" alt="">
                            <p class="card-footer">Tenha acesso a todos oe instrutores do sistema e decida qual combina melhor com suas expectativas, preferências e necessidades!</p>
                        </div>
                </div>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sobre o Muscle Up</h5>
                        <p class="card-text">Nosso sistema tem em seu cerne o comprometimento com o esporte e performance. Decida todos os requisitos das suas fichas de treino de acordo com o que melhor combina com você e sua rotina!</p>
                        <img class="logoHome" src="../../img/logoEscura.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../utilitarios/jquery-3.7.1.min.js"></script>
    <script>
        var idAdm;
        $(document).ready(function() {
            var idAdm = <?php echo json_encode($_SESSION["idAdm"]); ?>;
            pegarPorId(idAdm);
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
                            var adm = retorno[0];  // Pega o primeiro objeto
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
</script>
</body>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>