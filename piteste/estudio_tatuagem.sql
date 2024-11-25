-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/11/2024 às 00:36
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
-- Banco de dados: `estudio_tatuagem`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_tatuador` int(11) NOT NULL,
  `data_agendamento` datetime NOT NULL,
  `especialidades` text NOT NULL,
  `status` enum('pendente','confirmado','concluído') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `id_cliente`, `id_tatuador`, `data_agendamento`, `especialidades`, `status`) VALUES
(1, 2, 4, '2024-11-22 19:00:00', 'Realismo', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `estilos_preferidos` text DEFAULT NULL,
  `tatuador_preferido` varchar(100) DEFAULT NULL,
  `perfil_completo` tinyint(1) DEFAULT 0,
  `tipo_usuario` enum('cliente','tatuador') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `senha`, `telefone`, `data_nascimento`, `foto`, `estilos_preferidos`, `tatuador_preferido`, `perfil_completo`, `tipo_usuario`, `created_at`) VALUES
(2, 'teste01', 'teste01@teste01.com.br', '$2y$10$3h7/zh91olE0iTpeLd0elOd5g.k7NHaZxL6mrtwZkjHNnEv4LgLJi', '(48) 98840-8811', '1998-06-10', 'foto_2.jpg', NULL, NULL, 0, 'cliente', '2024-11-10 02:58:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `especialidades`
--

INSERT INTO `especialidades` (`id`, `nome`) VALUES
(1, 'Old School'),
(2, 'New School'),
(3, 'Realismo'),
(4, 'Aquarela'),
(5, 'Geométrica'),
(6, 'Tribal'),
(7, 'Dotwork'),
(8, 'Neotradicional'),
(9, 'Minimalista'),
(10, 'Blackwork'),
(11, 'Surrealismo'),
(12, 'Sketch'),
(13, 'Retrato'),
(14, '3D'),
(15, 'Fine Line'),
(16, 'Trash Polka'),
(17, 'Hiper-realismo'),
(18, 'Biomecânica'),
(19, 'Lettering'),
(20, 'Neo Traditional'),
(21, 'Watercolor'),
(22, 'Sketch'),
(23, 'Mandala'),
(24, 'Cartoon'),
(25, 'Dotwork'),
(26, 'Japanese Traditional'),
(27, 'Polynesian'),
(28, 'Celtic'),
(29, 'Black and Grey'),
(30, 'Sleeve'),
(31, 'Chest Piece'),
(32, 'Back Piece'),
(33, 'Spine'),
(34, 'Leg Piece'),
(35, 'Foot Tattoos'),
(36, 'Hand Tattoos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `especialidades_tatuador`
--

CREATE TABLE `especialidades_tatuador` (
  `id` int(11) NOT NULL,
  `id_tatuador` int(11) DEFAULT NULL,
  `especialidade` enum('Realismo','Old School','Neo Tradicional','Tribal','Blackwork','Aquarela','Pontilhismo','Geometria','Trash Polka','New School','Oriental','Surrealismo','Sketch','Minimalista','Lettering','Retrato','Fantasy','Abstrato','Body Art') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `especialidades_tatuador`
--

INSERT INTO `especialidades_tatuador` (`id`, `id_tatuador`, `especialidade`) VALUES
(1, 4, 'Old School');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tatuadores`
--

CREATE TABLE `tatuadores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `especialidades` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `portfólio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tatuadores`
--

INSERT INTO `tatuadores` (`id`, `nome`, `email`, `senha`, `telefone`, `especialidades`, `foto`, `portfólio`, `created_at`, `bio`) VALUES
(4, 'teste01', 'teste01@teste01.com.br', '$2y$10$/As7nSZyZnzsSnYvTHG1NexP.Rr.kNMDFE8ra1/0ZXumgX6H1Tixy', NULL, NULL, 'download.png', NULL, '2024-11-10 02:30:59', 'salve');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_tatuador` (`id_tatuador`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Índices de tabela `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `especialidades_tatuador`
--
ALTER TABLE `especialidades_tatuador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tatuador` (`id_tatuador`);

--
-- Índices de tabela `tatuadores`
--
ALTER TABLE `tatuadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `especialidades_tatuador`
--
ALTER TABLE `especialidades_tatuador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tatuadores`
--
ALTER TABLE `tatuadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `agendamentos_ibfk_2` FOREIGN KEY (`id_tatuador`) REFERENCES `tatuadores` (`id`);

--
-- Restrições para tabelas `especialidades_tatuador`
--
ALTER TABLE `especialidades_tatuador`
  ADD CONSTRAINT `especialidades_tatuador_ibfk_1` FOREIGN KEY (`id_tatuador`) REFERENCES `tatuadores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
