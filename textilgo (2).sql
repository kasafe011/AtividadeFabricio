-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/09/2024 às 22:35
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `textilgo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `quantidade_estoque` int(11) NOT NULL,
  `tecido_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`id_estoque`, `quantidade_estoque`, `tecido_id`) VALUES
(1, 100, 1),
(2, 200, 2),
(3, 0, 6),
(4, 0, 7),
(5, 0, 8),
(6, 0, 9),
(7, 0, 10),
(8, 0, 11),
(9, 0, 12),
(10, 0, 13),
(11, 0, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `precos`
--

CREATE TABLE `precos` (
  `id_preco` int(11) NOT NULL,
  `tecido_id` int(11) NOT NULL,
  `quantidade_estoque` int(11) NOT NULL,
  `metro_preco` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tecidos`
--

CREATE TABLE `tecidos` (
  `id_tecido` int(11) NOT NULL,
  `nome_tecido` varchar(50) NOT NULL,
  `descricao_tecido` varchar(200) NOT NULL,
  `comprimento_tecido` int(11) NOT NULL,
  `cor_tecido` varchar(50) NOT NULL,
  `preco_tecido` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tecidos`
--

INSERT INTO `tecidos` (`id_tecido`, `nome_tecido`, `descricao_tecido`, `comprimento_tecido`, `cor_tecido`, `preco_tecido`) VALUES
(1, 'Algodão', 'Suave', 2, 'Azul', NULL),
(2, 'Lã', 'Quente', 2, 'Verde', NULL),
(6, 'cetim', 'liso', 2, 'azul vermelho', NULL),
(7, 'lã', 'felpuda', 45, 'preta', NULL),
(8, 'oxford', 'poliester', 10, 'marrom meio azulado', NULL),
(9, 'oxford', 'poliester', 10, 'vermelho', 12.30),
(10, 'couro', 'sedoso', 50, 'marrom', 10.00),
(11, 'Viscose', 'lisa', 100, 'malhado ', 7.00),
(12, 'asdasd', 'dadsad', 12, 'dede', 12.00),
(13, 'Pinto azul', 'ele é um pinto azul', 10, 'preta', 12.00),
(14, 'Linho', 'Linho pai', 22, 'azul', 20.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `id_venda` int(11) NOT NULL,
  `preco_id` int(11) NOT NULL,
  `tecido_id` int(11) NOT NULL,
  `estoque_id` int(11) NOT NULL,
  `metros_comprados` int(11) NOT NULL,
  `valor_total` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`),
  ADD KEY `estoque_tecido_fk` (`tecido_id`);

--
-- Índices de tabela `precos`
--
ALTER TABLE `precos`
  ADD PRIMARY KEY (`id_preco`),
  ADD KEY `preco_tecido_fk` (`tecido_id`),
  ADD KEY `preco_estoque_fk` (`quantidade_estoque`);

--
-- Índices de tabela `tecidos`
--
ALTER TABLE `tecidos`
  ADD PRIMARY KEY (`id_tecido`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `venda_preco_fk` (`preco_id`),
  ADD KEY `venda_tecido_fk` (`tecido_id`),
  ADD KEY `venda_estoque_fk` (`estoque_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `precos`
--
ALTER TABLE `precos`
  MODIFY `id_preco` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tecidos`
--
ALTER TABLE `tecidos`
  MODIFY `id_tecido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_tecido_fk` FOREIGN KEY (`tecido_id`) REFERENCES `tecidos` (`id_tecido`);

--
-- Restrições para tabelas `precos`
--
ALTER TABLE `precos`
  ADD CONSTRAINT `preco_estoque_fk` FOREIGN KEY (`quantidade_estoque`) REFERENCES `estoque` (`id_estoque`),
  ADD CONSTRAINT `preco_tecido_fk` FOREIGN KEY (`tecido_id`) REFERENCES `tecidos` (`id_tecido`);

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_estoque_fk` FOREIGN KEY (`estoque_id`) REFERENCES `estoque` (`id_estoque`),
  ADD CONSTRAINT `venda_preco_fk` FOREIGN KEY (`preco_id`) REFERENCES `precos` (`id_preco`),
  ADD CONSTRAINT `venda_tecido_fk` FOREIGN KEY (`tecido_id`) REFERENCES `tecidos` (`id_tecido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
