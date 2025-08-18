-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/08/2025 às 21:54
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
  `setor` varchar(150) NOT NULL,
  `cpf` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `participantes`
--

INSERT INTO `participantes` (`id`, `nome`, `email`, `telefone`, `id_reuniao`, `setor`, `cpf`) VALUES
(121, 'Renan Yukio Arida', 'maria@teste12.com.br', '(22) 2222-2222', 175, 'Tech', '534.321.890-36'),
(151, 'Yukio arida', 'adm@teste.com.br', '(33) 3333-3333', 175, 'admin', '716.697.480-06'),
(154, 'Luan TI', 'egcghzsxhdjznzo.yukio.arida@gamail.com', '(11) 61651-1213', 175, 'admin', '834.805.630-07'),
(164, 'wfgrhtgk', 'esrdf@gxfhc', '(32) 45678-5436', 175, 'dgfxh', '349.186.790-80'),
(182, 'Renan Arida Yukio', 'renan.yukio.arida@gamail.com', '(22) 2222-11111', 180, 'matriz', '391.997.010-14'),
(192, 'aaaaaaaaaaaaaaaaa', 'jose@teste.com.br', '(11) 11111-111222455', 175, 'aaaaaaaa', '850.638.330-71'),
(193, 'enzo', 'renan.arida121121@gazin.com.br', '(11) 61651-1213', 180, 'R', '161.480.540-78'),
(196, 'Andreia midori', 'andreia@gmail.com', '(44) 51515-6456', 180, 'Tech', '154.059.650-81'),
(197, 'Leticia Arida', 'leticia@gmail.com', '(91) 95959-5957', 180, 'dent', '572.339.010-40'),
(203, 'Joao', 'joao123@gmail.com', '(22) 2222-2222', 180, 'Tech', '382.974.170-77'),
(204, 'kenzo wakatsuki ', 'kenzo.wakatsuki@gmail.com', '44445611516161', 180, 'Tech', '571.381.380-08'),
(206, 'teste 29', 'enzo.yukio.arida@gamail.com', '(22) 2222-2222', 182, '222122', '544.702.260-68'),
(207, 'teste 30', 'adm30@teste.com.br', '(11) 11111-1111', 182, 'Tech', '547.326.350-08'),
(211, 'enzo', 'renan.arida121121@gazin.com.br', '(11) 61651-1213', 175, 'RH', '027.372.100-38'),
(212, 'erick', 'erick.teste@gmail.com', '(11) 11111-1111', 182, 'tech', '553.414.010-00'),
(219, 'Renan Yukio Arida', 'renan.arida@gazin.com.br', '(44) 95511-2345', 188, 'Gazin_tech', '931.614.940-16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `participantes_reunioes`
--

CREATE TABLE `participantes_reunioes` (
  `id` int(11) NOT NULL,
  `id_participante` int(11) NOT NULL,
  `id_reuniao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `participantes_reunioes`
--

INSERT INTO `participantes_reunioes` (`id`, `id_participante`, `id_reuniao`) VALUES
(2, 219, 188);

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
(175, '2025-07-01', '15:25:00', 'gazin-matriz30000', 'He'),
(176, '2025-07-01', '17:00:00', 'gazin tech', 'reuniao na matriz'),
(180, '2025-07-01', '16:00:00', 'gazin tech novo', 'aaaaaaaaaaaaaaaa'),
(181, '2025-07-01', '18:00:00', 'teams', 'asssunto serio'),
(182, '2025-07-04', '16:10:00', 'gazin-matriz', 'reuniao na matriz'),
(188, '2025-08-13', '15:52:00', 'gazin-matriz', 'desenvolvimento');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `adm_poderoso` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL,
  `cpf` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `adm_poderoso`, `token`, `token_expira`, `cpf`) VALUES
(35, 'Renan Arida Yukio', 'renan.arida@gazin.com.br', '101010', 1, NULL, NULL, '931.614.940-16'),
(36, 'Arida Renan Yukio', 'adm@teste.com.br', '101010', 0, NULL, NULL, ''),
(37, 'marcia wakatsu', 'marciawakatsu@gmail.com', '123456', 0, NULL, NULL, ''),
(38, 'Renan Yukio Arida', 'testeteste10@gmail.com', '101010', 0, NULL, NULL, ''),
(39, 'teste', 'teste202@gmail.com', '101010', 0, NULL, NULL, '534.321.890-36'),
(40, 'Milenio Rocha', 'milenio.rocha@gmail.com', 'teste123', 1, NULL, NULL, '154.059.650-81');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `id_reuniao` (`id_reuniao`);

--
-- Índices de tabela `participantes_reunioes`
--
ALTER TABLE `participantes_reunioes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_participante` (`id_participante`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT de tabela `participantes_reunioes`
--
ALTER TABLE `participantes_reunioes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `reunioes`
--
ALTER TABLE `reunioes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`id_reuniao`) REFERENCES `reunioes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `participantes_reunioes`
--
ALTER TABLE `participantes_reunioes`
  ADD CONSTRAINT `participantes_reunioes_ibfk_1` FOREIGN KEY (`id_participante`) REFERENCES `participantes` (`id`),
  ADD CONSTRAINT `participantes_reunioes_ibfk_2` FOREIGN KEY (`id_reuniao`) REFERENCES `reunioes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
