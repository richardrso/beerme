-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Nov-2023 às 18:08
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `beerme`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacaousuario`
--

CREATE TABLE `avaliacaousuario` (
  `ID` int(11) NOT NULL,
  `ROTULO` varchar(50) NOT NULL,
  `TIPO` varchar(50) NOT NULL,
  `NOTA` int(11) NOT NULL,
  `COMENTARIO` text NOT NULL,
  `FAMILIA` varchar(50) NOT NULL,
  `ABV` decimal(16,2) NOT NULL,
  `IBU` int(11) NOT NULL,
  `COR` varchar(50) NOT NULL,
  `CORPO` varchar(50) NOT NULL,
  `DATA` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `avaliacaousuario`
--

INSERT INTO `avaliacaousuario` (`ID`, `ROTULO`, `TIPO`, `NOTA`, `COMENTARIO`, `FAMILIA`, `ABV`, `IBU`, `COR`, `CORPO`, `DATA`) VALUES
(10, 'Heineken', 'Premium', 5, 'Melhor cerveja que já tomei na minha vida!', 'Lager', '10.00', 6, 'Verde', 'Leve', '3222-02-11'),
(11, 'Roleta Russa', 'Ipa', 4, 'Me lembra dos bons tempos que passei com meus avós em Goiás.', 'Ale', '12.00', 5, 'Marrom', 'Medio', '2002-03-12'),
(14, 'Bhrama', 'American', 4, 'Boa pra tomar no barzinho.', 'Lager', '10.00', 6, 'Verde', 'Leve', '2023-03-15'),
(15, 'Cacildis', 'Pale Ale', 5, 'Antigona!', 'Ale', '12.00', 8, 'Amarelo', 'Medio', '2023-02-20'),
(16, 'Heineken', 'Premium', 2, 'Boazinha', 'Lager', '10.00', 6, 'Verde', 'Leve', '1111-11-11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cervejaria`
--

CREATE TABLE `cervejaria` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(100) NOT NULL,
  `ENDERECOCERVEJARIAID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cervejaria`
--

INSERT INTO `cervejaria` (`ID`, `NOME`, `ENDERECOCERVEJARIAID`) VALUES
(1, 'Cervejaria Beerme', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `corpo`
--

CREATE TABLE `corpo` (
  `ID` int(11) NOT NULL,
  `DESCRICAO` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `corpo`
--

INSERT INTO `corpo` (`ID`, `DESCRICAO`) VALUES
(1, 'Leve'),
(2, 'Medio'),
(3, 'Denso');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecocervejaria`
--

CREATE TABLE `enderecocervejaria` (
  `ID` int(11) NOT NULL,
  `PAIS` varchar(30) NOT NULL,
  `CIDADE` varchar(50) NOT NULL,
  `ENDERECO` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `enderecocervejaria`
--

INSERT INTO `enderecocervejaria` (`ID`, `PAIS`, `CIDADE`, `ENDERECO`) VALUES
(1, 'Brasil', 'São Paulo', 'Rua Teste Beerme');

-- --------------------------------------------------------

--
-- Estrutura da tabela `familiacerveja`
--

CREATE TABLE `familiacerveja` (
  `ID` int(11) NOT NULL,
  `DESCRICAO` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `familiacerveja`
--

INSERT INTO `familiacerveja` (`ID`, `DESCRICAO`) VALUES
(1, 'Lager'),
(2, 'Ale');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotulo`
--

CREATE TABLE `rotulo` (
  `ID` int(11) NOT NULL,
  `DESCRICAO` varchar(50) DEFAULT NULL,
  `IMAGEM` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `rotulo`
--

INSERT INTO `rotulo` (`ID`, `DESCRICAO`, `IMAGEM`) VALUES
(1, 'Heineken', '/img/heineken.jpg'),
(2, 'Bhrama', '/img/brahma.jpg'),
(3, 'Roleta Russa', '/img/roletaRussa--beer.jpg'),
(4, 'Cacildis', '/img/cacildis.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocerveja`
--

CREATE TABLE `tipocerveja` (
  `ID` int(11) NOT NULL,
  `DESCRICAO` varchar(50) DEFAULT NULL,
  `ROTULOID` int(11) NOT NULL,
  `CORPOID` int(11) NOT NULL,
  `FAMILIACERVEJAID` int(11) NOT NULL,
  `NIVELAMARGOR` decimal(10,2) NOT NULL,
  `TEORALCOOLICO` decimal(10,2) DEFAULT NULL,
  `COR` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipocerveja`
--

INSERT INTO `tipocerveja` (`ID`, `DESCRICAO`, `ROTULOID`, `CORPOID`, `FAMILIACERVEJAID`, `NIVELAMARGOR`, `TEORALCOOLICO`, `COR`) VALUES
(1, 'Premium', 1, 1, 1, '5.60', '10.00', 'Verde'),
(2, 'American', 2, 1, 1, '4.40', '7.00', 'Amarelo'),
(3, 'Ipa', 3, 2, 2, '7.60', '12.00', 'Marrom'),
(4, 'Pale Ale', 4, 2, 2, '5.00', '18.00', 'Amarelo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(100) NOT NULL,
  `EMAIL` varchar(150) NOT NULL,
  `STATUS` decimal(1,0) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`ID`, `NOME`, `EMAIL`, `STATUS`) VALUES
(1, 'master', 'usermaster@master.com', '1');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacaousuario`
--
ALTER TABLE `avaliacaousuario`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `cervejaria`
--
ALTER TABLE `cervejaria`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `corpo`
--
ALTER TABLE `corpo`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `enderecocervejaria`
--
ALTER TABLE `enderecocervejaria`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `familiacerveja`
--
ALTER TABLE `familiacerveja`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `rotulo`
--
ALTER TABLE `rotulo`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `tipocerveja`
--
ALTER TABLE `tipocerveja`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacaousuario`
--
ALTER TABLE `avaliacaousuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `cervejaria`
--
ALTER TABLE `cervejaria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `corpo`
--
ALTER TABLE `corpo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `enderecocervejaria`
--
ALTER TABLE `enderecocervejaria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `familiacerveja`
--
ALTER TABLE `familiacerveja`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `rotulo`
--
ALTER TABLE `rotulo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tipocerveja`
--
ALTER TABLE `tipocerveja`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
