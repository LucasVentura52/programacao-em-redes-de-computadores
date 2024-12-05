-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Nov-2024 às 01:53
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `barbearia_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `colaborador_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `data_hora` datetime NOT NULL,
  `status` enum('pendente','confirmado','cancelado') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `cliente_id`, `colaborador_id`, `servico_id`, `data_hora`, `status`) VALUES
(1, 2, 1, 1, '2024-10-26 01:57:31', 'cancelado'),
(14, 1, 1, 1, '2024-10-25 21:25:00', 'confirmado'),
(15, 2, 1, 3, '2024-10-26 22:25:00', 'confirmado'),
(16, 5, 1, 3, '2024-11-01 22:25:00', 'confirmado'),
(17, 5, 2, 1, '2024-10-26 22:25:00', 'confirmado'),
(18, 1, 1, 1, '2024-11-06 21:28:00', 'confirmado'),
(19, 1, 1, 1, '2024-11-06 22:07:00', 'confirmado'),
(20, 2, 1, 1, '2024-11-06 22:11:00', 'cancelado'),
(21, 2, 2, 1, '2024-11-07 22:27:00', 'confirmado'),
(22, 4, 2, 3, '2024-11-09 22:58:00', 'cancelado'),
(27, 1, 1, 1, '2024-11-06 20:02:00', 'cancelado'),
(28, 1, 1, 1, '2024-11-06 20:04:00', 'confirmado'),
(29, 1, 1, 1, '2024-11-06 21:04:00', 'cancelado'),
(30, 1, 1, 1, '2024-11-06 19:00:00', 'cancelado'),
(31, 1, 1, 1, '2024-11-06 19:15:00', 'cancelado'),
(32, 1, 1, 1, '2024-11-06 18:00:00', 'cancelado'),
(34, 1, 1, 1, '2024-11-06 18:10:00', 'confirmado'),
(41, 1, 1, 1, '2024-11-06 09:30:00', 'pendente'),
(42, 2, 1, 1, '2024-11-06 11:00:00', 'pendente'),
(43, 4, 2, 2, '2024-11-06 15:30:00', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `sobrenome` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `telefone`, `email`, `endereco`, `status`, `sobrenome`, `cpf`, `data_nascimento`, `criado_em`, `atualizado_em`) VALUES
(1, 'Lucas', '541233', 'lucas@gmail.com', 'Rua Capivari', 'ativo', 'Ventura', '13798673985', '2024-10-11', '2024-10-19 03:08:50', '2024-10-30 03:29:56'),
(2, 'Vitão', '1234569', 'vitao@gmail.com', 'Rua das quengas', 'ativo', 'Alexandre', '123', '2024-10-07', '2024-10-19 03:08:50', '2024-10-30 03:30:06'),
(4, 'Diego', '456456', 'diego@gmail.com', 'Rua das raparigas', 'ativo', 'Maiochi', '76117215002', '2024-10-23', '2024-10-19 03:08:50', '2024-11-08 02:28:02'),
(5, 'Gustavo', '21321213', 'gustavo@gmail.com', 'Rua das gralhass', 'ativo', 'Basso', '345345', '2024-10-19', '2024-10-19 03:11:31', '2024-11-13 23:12:40'),
(26, 'TESTE', '1231231', 'sadasd@asdasd', 'asdasd', 'inativo', 'TESTE', '32123132132', '2024-10-28', '2024-10-28 20:56:34', '2024-10-28 20:56:45'),
(27, 'Teste', '123123', 'sad@asd', 'asd', 'inativo', 'Teste', '13213213213', '2024-10-28', '2024-10-28 20:57:44', '2024-10-30 03:17:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaboradores`
--

CREATE TABLE `colaboradores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `colaboradores`
--

INSERT INTO `colaboradores` (`id`, `nome`, `telefone`, `email`, `cargo`, `sobrenome`, `cpf`, `data_nascimento`, `status`, `criado_em`, `atualizado_em`) VALUES
(1, 'Felipe', '123456', 'felipe@gmail.com', 'Barbeiro', 'Carlos', '123123123', '2024-11-06', 'ativo', '2024-11-06 03:53:00', '2024-11-06 04:00:18'),
(2, 'Paulo', '45623132', 'paulo@gmail.com', 'Barbeiro', 'Teste', '123123123', '2024-11-02', 'ativo', '2024-11-06 03:53:00', '2024-11-06 04:00:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`id`, `nome`, `descricao`, `preco`, `status`) VALUES
(1, 'Corte Masculino simples', 'Masculino', '10.00', 'ativo'),
(2, 'Corte Masculino degradê', 'Corte realizado por tesoura', '20.00', 'ativo'),
(3, 'Corte Feminino', 'Corte realizado por tesoura', '20.00', 'ativo');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `colaborador_id` (`colaborador_id`),
  ADD KEY `servico_id` (`servico_id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices para tabela `colaboradores`
--
ALTER TABLE `colaboradores`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `colaboradores`
--
ALTER TABLE `colaboradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `agendamentos_ibfk_2` FOREIGN KEY (`colaborador_id`) REFERENCES `colaboradores` (`id`),
  ADD CONSTRAINT `agendamentos_ibfk_3` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
