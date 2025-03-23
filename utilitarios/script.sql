SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema muscleup
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `muscleup` DEFAULT CHARACTER SET utf8 ;
USE `muscleup` ;

-- -----------------------------------------------------
-- Table `muscleup`.`praticante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`praticante` (
  `idPraticante` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` TEXT NOT NULL,
  `dataDeNascimento` DATE NOT NULL,
  `sexo` ENUM('masculino', 'feminino', 'outro') NOT NULL,
  `altura` DOUBLE NOT NULL,
  `peso` DOUBLE NOT NULL,
  PRIMARY KEY (`idPraticante`),
  UNIQUE INDEX `email_UNIQUE` (`email`(255) ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `muscleup`.`instrutor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`instrutor` (
  `idInstrutor` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` TEXT NOT NULL,
  `cref` VARCHAR(255) NOT NULL,
  `dataDeNascimento` DATE NOT NULL,
  `sexo` ENUM('masculino', 'feminino', 'outro') NOT NULL,
  `dataDeFormacao` DATE NOT NULL,
  `universidadeDeFormacao` TEXT NOT NULL,
  `descricao` TEXT NOT NULL,
  PRIMARY KEY (`idInstrutor`),
  UNIQUE INDEX `email_UNIQUE` (`email`(255) ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `muscleup`.`adm`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`adm` (
  `idAdm` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` TEXT NOT NULL,
  PRIMARY KEY (`idAdm`),
  UNIQUE INDEX `email_UNIQUE` (`email`(255) ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `muscleup`.`fichaDeTreino`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`fichadetreino` (
  `idFichaDeTreino` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NULL,
  `descricao` TEXT NULL,
  `status` ENUM('naoDesenvolvido', 'desenvolvido', 'desativado') NOT NULL,
  `dataDeCriacao` DATE NULL,
  `objetivo` ENUM('perderPeso', 'ganharMassa', 'manter') NOT NULL,
  `nivelDeTreino` ENUM('iniciante', 'intermediario', 'avançado') NOT NULL,
  `focoMuscular` TEXT NOT NULL,
  `diasDeTreino` TEXT NOT NULL, 
  `observacoes` VARCHAR(255) NULL,
  `idPraticante` INT NOT NULL,
  `idInstrutor` INT NOT NULL,
  PRIMARY KEY (`idFichaDeTreino`),
  INDEX `fk_ficha_de_treino_praticante1_idx` (`idPraticante` ASC),
  INDEX `fk_ficha_de_treino_instrutor1_idx` (`idInstrutor` ASC),
  CONSTRAINT `fk_ficha_de_treino_praticante1`
    FOREIGN KEY (`idPraticante`)
    REFERENCES `muscleup`.`praticante` (`idPraticante`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_ficha_de_treino_instrutor1`
    FOREIGN KEY (`idInstrutor`)
    REFERENCES `muscleup`.`instrutor` (`idInstrutor`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `muscleup`.`treino`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`treino` (
  `idTreino` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT NOT NULL,
  `diaDoTreino` ENUM('domingo', 'segundaFeira', 'tercaFeira', 'quartaFeira', 'quintaFeira', 'sextaFeira', 'sabado') NOT NULL,
  `tempoDeDuracao` INT NOT NULL,
  `IdFichaDeTreino` INT NOT NULL,
  PRIMARY KEY (`idTreino`),
  INDEX `fk_treino_fichaDeTreino1_idx` (`IdFichaDeTreino` ASC),
  CONSTRAINT `fk_treino_fichaDeTreino1`
    FOREIGN KEY (`IdFichaDeTreino`)
    REFERENCES `muscleup`.`fichaDeTreino` (`idFichaDeTreino`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `muscleup`.`grupoMuscular`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`grupomuscular` (
  `idGrupoMuscular` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idGrupoMuscular`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `muscleup`.`exercicio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`exercicio` (
  `idExercicio` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT NOT NULL,
  `instrucao` TEXT NOT NULL,
  `foto` INT NULL,
  `video` INT NULL,
  `IdGrupoMuscular` INT NOT NULL,
  PRIMARY KEY (`idExercicio`),
  INDEX `fk_exercicio_grupo_muscular1_idx` (`IdGrupoMuscular` ASC),
  CONSTRAINT `fk_exercicio_grupo_muscular1`
    FOREIGN KEY (`IdGrupoMuscular`)
    REFERENCES `muscleup`.`grupoMuscular` (`idGrupoMuscular`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `muscleup`.`musculoAlvo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`musculoalvo` (
  `idMusculoAlvo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `idGrupoMuscular` INT NOT NULL,
  PRIMARY KEY (`idMusculoAlvo`),
  INDEX `fk_musculo_alvo_grupo_muscular1_idx` (`idGrupoMuscular` ASC),
  CONSTRAINT `fk_musculo_alvo_grupo_muscular1`
    FOREIGN KEY (`idGrupoMuscular`)
    REFERENCES `muscleup`.`grupoMuscular` (`idGrupoMuscular`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `muscleup`.`exercicioDoTreino`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `muscleup`.`exerciciodotreino` (
  `idTreino` INT NOT NULL,
  `idExercicio` INT NOT NULL,
  `series` INT NOT NULL,
  `repeticoes` TEXT NOT NULL,
  `descanso` INT NOT NULL,
  PRIMARY KEY (`idTreino`, `idExercicio`),
  INDEX `fk_treino_has_exercicio_exercicio1_idx` (`idExercicio` ASC),
  INDEX `fk_treino_has_exercicio_treino1_idx` (`idTreino` ASC),
  CONSTRAINT `fk_treino_has_exercicio_treino1`
    FOREIGN KEY (`idTreino`)
    REFERENCES `muscleup`.`treino` (`idTreino`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_treino_has_exercicio_exercicio1`
    FOREIGN KEY (`idExercicio`)
    REFERENCES `muscleup`.`exercicio` (`idExercicio`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO adm (nome, email, senha)
VALUES ('Djames', 'djames.adm@gmail.com', MD5("adm"));

INSERT INTO praticante (nome, email, senha, dataDeNascimento, sexo, altura, peso)
VALUES 
('Ana Maria', 'ana.maria@gmail.com', MD5('123'), '1990-02-15', 'feminino', 1.65, 62.5),
('Lucas Pereira', 'lucas.pereira@gmail.com', MD5('123'), '1985-07-22', 'masculino', 1.80, 75.0),
('Maria Clara', 'maria.clara@gmail.com', MD5('123'), '1992-11-08', 'feminino', 1.60, 58.4),
('João Silva', 'joao.silva@gmail.com', MD5('123'), '1995-05-14', 'masculino', 1.75, 78.2),
('Gabriel Souza', 'gabriel.souza@gmail.com', MD5('123'), '2000-04-02', 'masculino', 1.90, 85.6),
('Fernanda Lima', 'fernanda.lima@gmail.com', MD5('123'), '1988-09-30', 'feminino', 1.70, 60.3),
('Pedro Henrique', 'pedro.henrique@gmail.com', MD5('123'), '1983-01-05', 'masculino', 1.82, 79.8),
('Camila Rocha', 'camila.rocha@gmail.com', MD5('123'), '1996-03-18', 'feminino', 1.58, 57.2),
('Felipe Carvalho', 'felipe.carvalho@gmail.com', MD5('123'), '1993-06-23', 'masculino', 1.85, 90.4),
('Juliana Alves', 'juliana.alves@gmail.com', MD5('123'), '1987-10-11', 'feminino', 1.63, 55.0),
('Marcos Vinicius', 'marcos.vinicius@gmail.com', MD5('123'), '1998-08-16', 'masculino', 1.77, 82.7),
('Carolina Borges', 'carolina.borges@gmail.com', MD5('123'), '1994-12-02', 'feminino',1.66, 63.1),
('Rodrigo Mendes', 'rodrigo.mendes@gmail.com', MD5('123'), '1989-04-21', 'masculino', 1.83, 81.5),
('Aline Costa', 'aline.costa@gmail.com', MD5('123'), '1991-11-30', 'feminino', 1.62, 59.0),
('Bruno Ferreira', 'bruno.ferreira@gmail.com', MD5('123'), '1984-03-10', 'masculino', 1.78, 83.4),
('Renata Oliveira', 'renata.oliveira@gmail.com', MD5('123'), '1997-06-05', 'feminino', 1.68, 61.9),
('Thiago Gomes', 'thiago.gomes@gmail.com', MD5('123'), '2001-09-19', 'masculino', 1.88, 87.3),
('Beatriz Santos', 'beatriz.santos@gmail.com', MD5('123'), '1999-02-28', 'feminino', 1.59, 54.6),
('Gustavo Lima', 'gustavo.lima@gmail.com', MD5('123'), '1986-05-07', 'masculino', 1.81, 77.5),
('Larissa Andrade', 'larissa.andrade@gmail.com', MD5('123'), '1990-07-14', 'feminino', 1.64, 56.8);

INSERT INTO instrutor (nome, email, senha, cref, dataDeNascimento, sexo, dataDeFormacao, universidadeDeFormacao, descricao)
VALUES
('Ana Rodrigues', 'ana.rodrigues@gmail.com', MD5('123'), '000123-G/PR', '1987-04-10', 'feminino', '2010-12-15', 'Universidade Federal do Paraná', 'Instrutora de musculação e personal trainer com 10 anos de experiência.'),
('Lucas Martins', 'lucas.martins@gmail.com', MD5('123'), '001456-G/PR', '1985-08-25', 'masculino', '2009-07-20', 'Universidade Estadual de Londrina', 'Especializado em treinamento funcional e crossfit.'),
('Mariana Silva', 'mariana.silva@gmail.com', MD5('123'), '002789-G/PR', '1990-02-11', 'feminino', '2013-11-05', 'Pontifícia Universidade Católica do Paraná', 'Fisiologista e especialista em reabilitação física.'),
('João Costa', 'joao.costa@gmail.com', MD5('123'), '003123-G/PR', '1989-06-19', 'masculino', '2012-04-22', 'Universidade Federal do Paraná', 'Treinador de alta performance focado em esportes de resistência.'),
('Gabriela Santos', 'gabriela.santos@gmail.com', MD5('123'), '004567-G/PR', '1992-12-04', 'feminino', '2015-06-28', 'Universidade Positivo', 'Instrutora de pilates e ioga, com foco em bem-estar físico e mental.'),
('Pedro Lima', 'pedro.lima@gmail.com', MD5('123'), '005678-G/PR', '1983-03-17', 'masculino', '2007-09-12', 'Universidade Estadual de Ponta Grossa', 'Personal trainer com foco em hipertrofia e emagrecimento.'),
('Camila Oliveira', 'camila.oliveira@gmail.com', MD5('123'), '006789-G/PR', '1991-09-27', 'feminino', '2014-03-03', 'Faculdade de Educação Física de Curitiba', 'Professora de ginástica aeróbica e musculação.'),
('Rafael Souza', 'rafael.souza@gmail.com', MD5('123'), '007890-G/PR', '1987-05-05', 'masculino', '2010-10-10', 'Universidade Tuiuti do Paraná', 'Treinador especializado em corrida de rua e maratonas.'),
('Larissa Mendes', 'larissa.mendes@gmail.com', MD5('123'), '008901-G/PR', '1993-01-30', 'feminino', '2016-12-18', 'Centro Universitário Curitiba', 'Personal trainer com foco em condicionamento físico feminino.'),
('Carlos Henrique', 'carlos.henrique@gmail.com', MD5('123'), '009012-G/PR', '1984-07-15', 'masculino', '2008-08-22', 'Universidade Estadual de Maringá', 'Especialista em musculação e treinamento funcional.'),
('Juliana Alves', 'juliana.alves@gmail.com', MD5('123'), '001234-G/PR', '1986-11-10', 'feminino', '2009-11-17', 'Universidade Estadual de Londrina', 'Instrutora de ioga com foco em flexibilidade e equilíbrio.'),
('Thiago Ribeiro', 'thiago.ribeiro@gmail.com', MD5('123'), '002345-G/PR', '1988-02-25', 'masculino', '2011-09-30', 'Pontifícia Universidade Católica do Paraná', 'Treinador de musculação com ênfase em reabilitação física.'),
('Fernanda Costa', 'fernanda.costa@gmail.com', MD5('123'), '003456-G/PR', '1990-05-12', 'feminino', '2013-07-25', 'Universidade Federal do Paraná', 'Instrutora de pilates e condicionamento físico para mulheres.'),
('Bruno Pereira', 'bruno.pereira@gmail.com', MD5('123'), '004567-G/PR', '1989-11-04', 'masculino', '2012-03-14', 'Universidade Estadual de Ponta Grossa', 'Especialista em hipertrofia e emagrecimento.'),
('Carolina Fernandes', 'carolina.fernandes@gmail.com', MD5('123'), '005678-G/PR', '1992-08-18', 'feminino', '2015-06-12', 'Universidade Tuiuti do Paraná', 'Treinadora com foco em treinamento funcional e reabilitação.'),
('Eduardo Araújo', 'eduardo.araujo@gmail.com', MD5('123'), '006789-G/PR', '1987-04-09', 'masculino', '2010-11-10', 'Faculdade de Educação Física de Curitiba', 'Especialista em condicionamento físico para esportes de alta performance.'),
('Paula Nogueira', 'paula.nogueira@gmail.com', MD5('123'), '007890-G/PR', '1991-10-01', 'feminino', '2014-05-20', 'Centro Universitário Curitiba', 'Personal trainer e instrutora de crossfit.'),
('Rodrigo Silva', 'rodrigo.silva@gmail.com', MD5('123'), '008901-G/PR', '1985-03-03', 'masculino', '2008-06-06', 'Universidade Estadual de Maringá', 'Profissional de musculação e emagrecimento com 15 anos de experiência.'),
('Beatriz Almeida', 'beatriz.almeida@gmail.com', MD5('123'), '009012-G/PR', '1993-09-25', 'feminino', '2016-08-22', 'Universidade Federal do Paraná', 'Instrutora de pilates e reabilitação física para idosos.'),
('Gustavo Ferreira', 'gustavo.ferreira@gmail.com', MD5('123'), '001111-G/PR', '1989-12-12', 'masculino', '2011-05-15', 'Universidade Estadual de Ponta Grossa', 'Especialista em crossfit e treinamento funcional.');


INSERT INTO grupomuscular (nome)
VALUES
('Peitoral'),
('Dorsal'),
('Trapézio'),
('Ombro'),
('Tríceps'),
('Bíceps'),
('Antebraço'),
('Abdômen'),
('Glúteo'),
('Quadríceps'),
('Posterior de Coxa'),
('Panturrilha');


-- Peitoral
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Peitoral Superior', 1),
('Peitoral Médio', 1),
('Peitoral Inferior', 1);

-- Dorsal
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Dorsal Superior', 2),
('Dorsal Médio', 2),
('Dorsal Inferior', 2);

-- Trapézio
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Trapézio Superior', 3),
('Trapézio Médio', 3),
('Trapézio Inferior', 3);

-- Ombro
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Ombro Anterior', 4),
('Ombro Lateral', 4),
('Ombro Posterior', 4);

-- Tríceps
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Cabeça Longa', 5),
('Cabeça Lateral', 5),
('Cabeça Medial', 5);

-- Bíceps
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Cabeça Longa', 6),
('Cabeça Curta', 6);

-- Antebraço
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Flexores do Antebraço', 7),
('Extensores do Antebraço', 7);

-- Abdômen
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Abdômen Superior', 8),
('Abdômen Inferior', 8),
('Oblíquos', 8);

-- Glúteo
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Glúteo Máximo', 9),
('Glúteo Médio', 9),
('Glúteo Mínimo', 9);

-- Quadríceps
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Reto Femoral', 10),
('Vasto Lateral', 10),
('Vasto Medial', 10),
('Vasto Intermédio', 10);

-- Posterior de Coxa
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Semitendinoso', 11),
('Semimembranoso', 11),
('Bíceps Femoral', 11);

-- Panturrilha
INSERT INTO musculoalvo (nome, idGrupoMuscular)
VALUES
('Gastrocnêmio', 12),
('Sóleo', 12);


-- Exercícios para Peitoral (idGrupoMuscular = 1)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Supino Reto', 'Exercício básico para o peitoral, realizado no banco reto com barra.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 1),
('Supino Inclinado', 'Variante do supino que foca na parte superior do peitoral.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 1),
('Crucifixo com Halteres', 'Exercício para abertura do peitoral com halteres no banco.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 1),
('Crossover', 'Exercício na polia alta, focado na parte média do peitoral.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 1),
('Peck Deck', 'Exercício na máquina para isolar o peitoral.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 1);

-- Exercícios para Dorsal (idGrupoMuscular = 2)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Puxada Frontal', 'Puxada no pulley alto com pegada aberta.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 2),
('Remada Curvada', 'Exercício de remada com barra, focado nas dorsais.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 2),
('Pulldown com Triângulo', 'Puxada no pulley com pegada fechada.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 2),
('Remada Cavalinho', 'Remada unilateral na máquina, focando as dorsais.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 2),
('Remada Serrote', 'Remada com halter, unilateral, focando no latíssimo.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 2);

-- Exercícios para Trapézio (idGrupoMuscular = 3)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Encolhimento com Barra', 'Exercício para a parte superior do trapézio.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 3),
('Encolhimento com Halteres', 'Exercício com halteres focando o trapézio.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 3),
('Levantamento Terra', 'Exercício composto que também trabalha o trapézio.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 3),
('Remada Alta', 'Remada com pegada alta para trapézio.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 3),
('Crucifixo Inverso', 'Exercício para a parte média do trapézio e posterior de ombro.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 3);

-- Exercícios para Ombro (idGrupoMuscular = 4)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Desenvolvimento com Barra', 'Exercício básico para o ombro, realizado com barra.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 4),
('Elevação Lateral', 'Elevação lateral com halteres para ombro lateral.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 4),
('Elevação Frontal', 'Elevação frontal com halteres ou barra para ombro anterior.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 4),
('Desenvolvimento com Halteres', 'Desenvolvimento de ombros com halteres.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 4),
('Arnold Press', 'Desenvolvimento com rotação, inventado por Arnold Schwarzenegger.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 4);

-- Exercícios para Tríceps (idGrupoMuscular = 5)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Tríceps Pulley', 'Exercício de tríceps realizado no pulley com corda.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 5),
('Tríceps Francês', 'Exercício de tríceps com halteres ou barra.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 5),
('Tríceps Testa', 'Exercício realizado com barra, focando no tríceps.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 5),
('Mergulho nas Paralelas', 'Exercício de peso corporal focado no tríceps.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 5),
('Kickback com Halteres', 'Extensão de tríceps com halteres, unilateral, focando no tríceps.', 'Realize de forma controlada, sem travar os cotovelos no topo.', 5);

-- Exercícios para Bíceps (idGrupoMuscular = 6)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Rosca Direta com Barra', 'Exercício básico de bíceps realizado com barra.', 'Realize de forma controlada, sem balançar o corpo.', 6),
('Rosca Alternada com Halteres', 'Exercício de bíceps realizado com halteres de forma alternada.', 'Realize de forma controlada, sem balançar o corpo.', 6),
('Rosca Concentrada', 'Exercício de concentração para o bíceps, realizado com halteres.', 'Realize de forma controlada, sem balançar o corpo.', 6),
('Rosca Martelo', 'Exercício de bíceps com pegada neutra, utilizando halteres.', 'Realize de forma controlada, sem balançar o corpo.', 6),
('Rosca Scott', 'Exercício de bíceps realizado na máquina ou com barra no banco Scott.', 'Realize de forma controlada, sem balançar o corpo.', 6);

-- Exercícios para Antebraço (idGrupoMuscular = 7)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Rosca Inversa com Barra', 'Exercício de antebraço com pegada invertida.', 'Realize de forma controlada, sem balançar o corpo.', 7),
('Flexão de Punho com Barra', 'Exercício para flexores do antebraço, realizado com barra.', 'Realize de forma controlada, sem balançar o corpo.', 7),
('Extensão de Punho com Barra', 'Exercício para extensores do antebraço, realizado com barra.', 'Realize de forma controlada, sem balançar o corpo.', 7),
('Rosca Martelo com Halteres', 'Exercício de antebraço com pegada neutra.', 'Realize de forma controlada, sem balançar o corpo.', 7),
('Rosca Inversa com Halteres', 'Exercício de antebraço realizado com halteres.', 'Realize de forma controlada, sem balançar o corpo.', 7);

-- Exercícios para Abdômen (idGrupoMuscular = 8)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Abdominal Reto', 'Exercício básico para abdômen reto.', 'Realize de forma controlada, sem forçar o pescoço.', 8),
('Abdominal Infra', 'Exercício para parte inferior do abdômen, realizado com pernas elevadas.', 'Realize de forma controlada, sem forçar o pescoço.', 8),
('Prancha', 'Exercício isométrico para fortalecer o core.', 'Realize de forma controlada, sem forçar o pescoço.', 8),
('Abdominal Oblíquo', 'Exercício para trabalhar a região lateral do abdômen.', 'Realize de forma controlada, sem forçar o pescoço.', 8),
('Elevação de Pernas', 'Exercício para abdômen infra, realizado com as pernas.', 'Realize de forma controlada, sem forçar o pescoço.', 8);

-- Exercícios para Glúteo (idGrupoMuscular = 9)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Agachamento Livre', 'Exercício composto que trabalha glúteos e pernas.', 'Realize de forma controlada, mantendo o tronco ereto.', 9),
('Elevação Pélvica', 'Exercício para glúteos, realizado no chão ou com barra.', 'Realize de forma controlada, sem forçar a lombar.', 9),
('Avanço', 'Exercício de passada, focado em glúteos e quadríceps.', 'Realize de forma controlada, mantendo o tronco ereto.', 9),
('Cadeira Abdutora', 'Exercício de glúteos realizado na cadeira abdutora.', 'Realize de forma controlada, sem balançar o corpo.', 9),
('Glúteo na Polia Baixa', 'Exercício realizado com polia, focado nos glúteos.', 'Realize de forma controlada, sem balançar o corpo.', 9);

-- Exercícios para Quadríceps (idGrupoMuscular = 10)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Agachamento Livre', 'Exercício composto que trabalha glúteos e quadríceps.', 'Realize de forma controlada, mantendo o tronco ereto.', 10),
('Leg Press', 'Exercício de pernas realizado na máquina de leg press.', 'Realize de forma controlada, sem estender completamente os joelhos.', 10),
('Extensão de Pernas', 'Exercício isolado para quadríceps, realizado na cadeira extensora.', 'Realize de forma controlada, sem travar os joelhos no topo.', 10),
('Agachamento Smith', 'Agachamento guiado realizado no Smith.', 'Realize de forma controlada, mantendo o tronco ereto.', 10),
('Passada com Barra', 'Exercício de passada, focado em quadríceps e glúteos.', 'Realize de forma controlada, mantendo o tronco ereto.', 10);

-- Exercícios para Posterior de Coxa (idGrupoMuscular = 11)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Flexão de Pernas', 'Exercício isolado para posterior de coxa, realizado na cadeira flexora.', 'Realize de forma controlada, sem estender completamente os joelhos.', 11),
('Stiff com Barra', 'Exercício composto que trabalha posterior de coxa e glúteos.', 'Realize de forma controlada, mantendo a coluna neutra.', 11),
('Levantamento Terra Romeno', 'Variante do levantamento terra focada no posterior de coxa.', 'Realize de forma controlada, mantendo a coluna neutra.', 11),
('Flexão Nórdica', 'Exercício avançado de peso corporal para posterior de coxa.', 'Realize de forma controlada, mantendo a coluna neutra.', 11),
('Cadeira Flexora', 'Exercício isolado para posterior de coxa, realizado na máquina.', 'Realize de forma controlada, sem estender completamente os joelhos.', 11);

-- Exercícios para Panturrilha (idGrupoMuscular = 12)
INSERT INTO exercicio (nome, descricao, instrucao, idGrupoMuscular)
VALUES
('Elevação de Gêmeos em Pé', 'Exercício para panturrilha, realizado em pé.', 'Realize de forma controlada, mantendo as pernas estendidas.', 12),
('Elevação de Gêmeos Sentado', 'Exercício para panturrilha, realizado sentado.', 'Realize de forma controlada, sem travar os joelhos.', 12),
('Panturrilha no Smith', 'Exercício de panturrilha realizado no Smith.', 'Realize de forma controlada, sem balançar o corpo.', 12),
('Panturrilha no Leg Press', 'Exercício de panturrilha realizado no leg press.', 'Realize de forma controlada, sem estender completamente os joelhos.', 12),
('Saltos com Barra', 'Exercício de panturrilha com leve salto, utilizando barra.', 'Realize de forma controlada, sem travar os joelhos.', 12);


/*
-- Inserir uma nova ficha de treino
INSERT INTO `muscleup`.`fichadetreino` 
  (nome, descricao, status, dataDeCriacao, objetivo, NivelDeTreino, FocoMuscular, quantidade_dias_de_treino, observacoes, idPraticante, idInstrutor) 
VALUES 
  ('Ficha de Treino A', 'Descrição da Ficha de Treino A', 1, CURDATE(), 1, 2, 1, 5, 'Observações da ficha', 1, 1);

-- Obter o id da ficha de treino inserida
SET @idFichaDeTreino = LAST_INSERT_ID();

-- Inserir os treinos associados à ficha de treino
INSERT INTO `muscleup`.`treino` 
  (nome, descricao, diaDoTreino, tempoDeDuracao, IdFichaDeTreino) 
VALUES 
  ('Treino A1', 'Treino focado em força', 1, 60, @idFichaDeTreino),
  ('Treino A2', 'Treino focado em resistência', 2, 45, @idFichaDeTreino),
  ('Treino A3', 'Treino focado em hipertrofia', 3, 75, @idFichaDeTreino),
  ('Treino A4', 'Treino de recuperação', 4, 30, @idFichaDeTreino);

-- Inserir os exercícios do treino
-- Treino A1
INSERT INTO `muscleup`.`exerciciodotreino` 
  (idTreino, idExercicio, quantidadeDeSeries, faixaDeRepeticoes, tempoDeDescanso) 
VALUES 
  (1, 1, 4, 12, 60),  -- Exercício 1
  (1, 2, 4, 12, 60),  -- Exercício 2
  (1, 3, 4, 12, 60),  -- Exercício 3
  (1, 4, 4, 12, 60);  -- Exercício 4

-- Treino A2
INSERT INTO `muscleup`.`exerciciodotreino` 
  (idTreino, idExercicio, quantidadeDeSeries, faixaDeRepeticoes, tempoDeDescanso) 
VALUES 
  (2, 5, 4, 12, 60),  -- Exercício 1
  (2, 6, 4, 12, 60),  -- Exercício 2
  (2, 7, 4, 12, 60),  -- Exercício 3
  (2, 8, 4, 12, 60);  -- Exercício 4

-- Treino A3
INSERT INTO `muscleup`.`exerciciodotreino` 
  (idTreino, idExercicio, quantidadeDeSeries, faixaDeRepeticoes, tempoDeDescanso) 
VALUES 
  (3, 9, 4, 12, 60),  -- Exercício 1
  (3, 10, 4, 12, 60), -- Exercício 2
  (3, 11, 4, 12, 60), -- Exercício 3
  (3, 12, 4, 12, 60); -- Exercício 4

-- Treino A4
INSERT INTO `muscleup`.`exerciciodotreino` 
  (idTreino, idExercicio, quantidadeDeSeries, faixaDeRepeticoes, tempoDeDescanso) 
VALUES 
  (4, 13, 4, 12, 60), -- Exercício 1
  (4, 14, 4, 12, 60), -- Exercício 2
  (4, 15, 4, 12, 60), -- Exercício 3
  (4, 16, 4, 12, 60); -- Exercício 4


SELECT 
    ft.idFichaDeTreino,
    ft.nome AS nomeFicha,
    ft.descricao AS descricaoFicha,
    ft.status,
    ft.dataDeCriacao,
    ft.objetivo,
    ft.NivelDeTreino,
    ft.FocoMuscular,
    ft.quantidade_dias_de_treino,
    ft.observacoes,
    p.nome AS nomePraticante,
    i.nome AS nomeInstrutor,
    t.idTreino,
    t.nome AS nomeTreino,
    t.descricao AS descricaoTreino,
    t.diaDoTreino,
    t.tempoDeDuracao,
    e.idExercicio,
    e.nome AS nomeExercicio,
    e.descricao AS descricaoExercicio,
    ed.quantidadeDeSeries,
    ed.faixaDeRepeticoes,
    ed.tempoDeDescanso
FROM 
    muscleup.fichadetreino ft
JOIN 
    muscleup.praticante p ON ft.idPraticante = p.idPraticante
JOIN 
    muscleup.instrutor i ON ft.idInstrutor = i.idInstrutor
JOIN 
    muscleup.treino t ON ft.idFichaDeTreino = t.IdFichaDeTreino
JOIN 
    muscleup.exerciciodotreino ed ON t.idTreino = ed.idTreino
JOIN 
    muscleup.exercicio e ON ed.idExercicio = e.idExercicio
WHERE 
    ft.idFichaDeTreino = @idFichaDeTreino; -- Substitua pelo ID da ficha de treino desejada
*/