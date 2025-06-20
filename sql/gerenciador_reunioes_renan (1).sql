-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/06/2025 às 21:55
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
-- Banco de dados: `gerenciador_reunioes_renan`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `id_reuniao` int(11) DEFAULT NULL,
  `setor` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `participantes`
--

INSERT INTO `participantes` (`id`, `nome`, `email`, `telefone`, `id_reuniao`, `setor`) VALUES
(45, 'Marcia akemi', 'Marcia.akemi@gmail.com', '2147483647', 2, 'Tech'),
(47, 'Marcia akemi', 'Marcia.akemi@gmail.com', '2147483647', 2, 'Tech'),
(62, 'Renan Arida', 'arida@gmail.com', '12124454', 158, 'Tech'),
(65, 'Renan Yukio Arida', 'yukio100@gmail.com', '369985214', 164, 'Tech'),
(66, 'Enzo hamada', 'enzo.hamada@gmail.com', '12465487', 164, 'matriz'),
(67, 'Andreia midori Arida', 'andreia@gmail.com', '2132654449', 158, 'Tech'),
(69, 'Andreia midori', 'andreia@gmail.com', '2132654449', 158, 'Tech'),
(77, 'otavio silva', 'otavio.silva@gmail.com', '112121563', 164, 'admin'),
(92, 'Lucas bonfim', 'lucas@gmail.com', '(44) 99132-1556', 165, 'Tech'),
(93, 'Lucas bonfim', 'lucas@gmail.com', '(44) 99132-1556', 165, 'Tech'),
(94, 'Lucas bonfim', 'lucas@gmail.com', '(44) 99132-1556', 165, 'Tech'),
(95, 'Lucas bonfim', 'lucas@gmail.com', '(44) 99132-1556', 165, 'Tech'),
(96, 'Gladson', 'gladson@gmail.com', '(44) 99122-5544', 158, 'Tech');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reunioes`
--

CREATE TABLE `reunioes` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `local` varchar(100) DEFAULT NULL,
  `assunto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reunioes`
--

INSERT INTO `reunioes` (`id`, `data`, `hora`, `local`, `assunto`) VALUES
(2, '2026-05-13', '07:00:00', 'gazin tech novo', 'atacado-tech324'),
(156, '2025-07-11', '17:00:00', 'gazin tech', 'Reunião sobre os aprendiz'),
(158, '2025-06-17', '13:58:00', 'teste20', 'Projetos futuros'),
(164, '2025-07-14', '16:00:00', 'gazin-matriz', 'promoção de cargo'),
(165, '2025-06-13', '16:30:00', 'varejo', 'vendas baixas24'),
(167, '2025-06-17', '17:38:00', 'gazin-matriz', 'reuniao na matriz');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `adm_poderoso` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `adm_poderoso`) VALUES
(18, 'Renan Yukio Arida', 'maria34235@teste.com.br', '123456', 0),
(19, 'Renan Yukio Arida', 'jos123213e@teste.com.br', '123456', 0),
(20, 'Luan TI', 'enzo.yukio.arid13123a@gamail.com', '123456', 0),
(21, 'wesley', 'wesley@gmail.com', '111111', 0),
(22, 'otavio', 'otavio.teste@gmail.com', '123456', 0),
(31, 'Marcia akemi', 'Marcia.akemi@gmail.com', '123456', 0),
(32, 'gustavo francisco', 'gustavo10@gmail.com', '123456', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reuniao` (`id_reuniao`);

--
-- Índices de tabela `reunioes`
--
ALTER TABLE `reunioes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de tabela `reunioes`
--
ALTER TABLE `reunioes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`id_reuniao`) REFERENCES `reunioes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
