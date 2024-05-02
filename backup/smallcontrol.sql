-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 19-Out-2018 às 20:49
-- Versão do servidor: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_curso`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_categorias`
--

CREATE TABLE `si_categorias` (
  `categoria_id` int(11) NOT NULL,
  `categoria_nome` varchar(255) NOT NULL,
  `categoria_cadastro` datetime NOT NULL,
  `categoria_sessao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_clientes`
--

CREATE TABLE `si_clientes` (
  `cliente_id` int(11) NOT NULL,
  `cliente_imagem` varchar(255) NOT NULL,
  `cliente_nome` varchar(255) NOT NULL,
  `cliente_email` varchar(255) NOT NULL,
  `cliente_endereco` varchar(255) NOT NULL,
  `cliente_cep` varchar(255) NOT NULL,
  `cliente_cidade` varchar(255) NOT NULL,
  `cliente_estado` varchar(255) NOT NULL,
  `cliente_documento` varchar(255) NOT NULL,
  `cliente_telefone` varchar(255) NOT NULL,
  `cliente_token` int(11) NOT NULL,
  `cliente_status` int(11) NOT NULL,
  `cliente_cadastro` datetime NOT NULL,
  `cliente_sessao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_devolucao`
--

CREATE TABLE `si_devolucao` (
  `devolucao_id` int(11) NOT NULL,
  `devolucao_produto_nome` varchar(255) NOT NULL,
  `devolucao_quantidade` int(11) NOT NULL,
  `devolucao_medidas` varchar(255) NOT NULL,
  `devolucao_data_despacho` date NOT NULL,
  `devolucao_motivo` varchar(500) NOT NULL,
  `devolucao_nf` varchar(255) NOT NULL,
  `devolucao_codigo` varchar(255) NOT NULL,
  `devolucao_fornecedor` varchar(255) NOT NULL,
  `devolucao_valor_nf` varchar(255) NOT NULL,
  `devolucao_sessao` varchar(255) NOT NULL,
  `devolucao_status` int(11) NOT NULL,
  `devolucao_status_liberado` int(11) NOT NULL,
  `devolucao_cadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_entrada`
--

CREATE TABLE `si_entrada` (
  `entrada_produto_id` int(11) NOT NULL,
  `entrada_produto_nome` varchar(255) NOT NULL,
  `entrada_quantidade` int(11) NOT NULL,
  `entrada_quantidade_estoque_atual` int(11) NOT NULL,
  `entrada_quantidade_estoque` int(11) NOT NULL,
  `entrada_medidas` varchar(255) NOT NULL,
  `entrada_validade` date NOT NULL,
  `entrada_nf` varchar(255) NOT NULL,
  `entrada_codigo` varchar(255) NOT NULL,
  `entrada_fornecedor` varchar(255) NOT NULL,
  `entrada_valor_nf` decimal(10,2) NOT NULL,
  `entrada_sessao` varchar(255) NOT NULL,
  `entrada_status` int(11) NOT NULL,
  `entrada_cadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_fornecedores`
--

CREATE TABLE `si_fornecedores` (
  `fornecedor_id` int(11) NOT NULL,
  `fornecedor_img` varchar(255) NOT NULL,
  `fornecedor_nome` varchar(255) NOT NULL,
  `fornecedor_email` varchar(255) NOT NULL,
  `fornecedor_endereco` varchar(255) NOT NULL,
  `fornecedor_cep` varchar(255) NOT NULL,
  `fornecedor_cidade` varchar(255) NOT NULL,
  `fornecedor_estado` varchar(255) NOT NULL,
  `fornecedor_documento` varchar(255) NOT NULL,
  `fornecedor_telefone` varchar(255) NOT NULL,
  `fornecedor_token` int(11) NOT NULL,
  `fornecedor_status` int(11) NOT NULL,
  `fornecedor_cadastro` datetime NOT NULL,
  `fornecedor_sessao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_ordem_servico`
--

CREATE TABLE `si_ordem_servico` (
  `os_id` int(11) NOT NULL,
  `os_produto_nome` varchar(255) NOT NULL,
  `os_quantidade` int(11) NOT NULL,
  `os_medidas` varchar(255) NOT NULL,
  `os_data_envio` date NOT NULL,
  `os_observacoes` varchar(1500) NOT NULL,
  `os_nf` varchar(255) NOT NULL,
  `os_codigo` varchar(255) NOT NULL,
  `os_cliente` varchar(255) NOT NULL,
  `os_fornecedores` varchar(255) NOT NULL,
  `os_situacao` varchar(255) NOT NULL,
  `os_valor_nf` decimal(10,2) NOT NULL,
  `os_sessao` varchar(255) NOT NULL,
  `os_status` int(11) NOT NULL,
  `os_cadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_pedido_material`
--

CREATE TABLE `si_pedido_material` (
  `pedido_id` int(11) NOT NULL,
  `pedido_observacoes` varchar(1500) NOT NULL,
  `pedido_sessao` varchar(255) NOT NULL,
  `pedido_status` int(11) NOT NULL,
  `pedido_cadastro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_produtos`
--

CREATE TABLE `si_produtos` (
  `produto_id` int(11) NOT NULL,
  `produto_nome` varchar(255) NOT NULL,
  `produto_preco` varchar(255) NOT NULL,
  `produto_quantidade` int(11) NOT NULL,
  `produto_categoria` varchar(255) NOT NULL,
  `produto_capa` varchar(255) NOT NULL,
  `produto_status` int(11) NOT NULL,
  `produto_cadastro` datetime NOT NULL,
  `produto_sessao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_registros_acessos`
--

CREATE TABLE `si_registros_acessos` (
  `registros_id` int(11) NOT NULL,
  `registros_nome` varchar(255) NOT NULL,
  `registros_entrada` datetime NOT NULL,
  `registros_saida` datetime NOT NULL,
  `registro_pagina` varchar(255) NOT NULL,
  `registros_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_saida`
--

CREATE TABLE `si_saida` (
  `saida_id` int(11) NOT NULL,
  `saida_produto_nome` varchar(255) NOT NULL,
  `saida_quantidade` int(11) NOT NULL,
  `saida_quantidade_estoque_atual` int(11) NOT NULL,
  `saida_quantidade_estoque` int(11) NOT NULL,
  `saida_medidas` varchar(255) NOT NULL,
  `saida_codigo` varchar(255) NOT NULL,
  `saida_sessao` varchar(255) NOT NULL,
  `saida_status` int(11) NOT NULL,
  `saida_cadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `si_usuarios`
--

CREATE TABLE `si_usuarios` (
  `usuarios_id` int(11) NOT NULL,
  `usuarios_nome` varchar(255) NOT NULL,
  `usuarios_email` varchar(255) NOT NULL,
  `usuarios_senha` varchar(255) NOT NULL,
  `usuarios_status` int(11) NOT NULL,
  `usuarios_nivel` int(11) NOT NULL,
  `usuarios_data` datetime NOT NULL,
  `token` int(11) NOT NULL,
  `pergunta_secreta` varchar(255) NOT NULL,
  `resposta_secreta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `si_categorias`
--
ALTER TABLE `si_categorias`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indexes for table `si_clientes`
--
ALTER TABLE `si_clientes`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indexes for table `si_devolucao`
--
ALTER TABLE `si_devolucao`
  ADD PRIMARY KEY (`devolucao_id`);

--
-- Indexes for table `si_entrada`
--
ALTER TABLE `si_entrada`
  ADD PRIMARY KEY (`entrada_produto_id`);

--
-- Indexes for table `si_fornecedores`
--
ALTER TABLE `si_fornecedores`
  ADD PRIMARY KEY (`fornecedor_id`);

--
-- Indexes for table `si_ordem_servico`
--
ALTER TABLE `si_ordem_servico`
  ADD PRIMARY KEY (`os_id`);

--
-- Indexes for table `si_pedido_material`
--
ALTER TABLE `si_pedido_material`
  ADD PRIMARY KEY (`pedido_id`);

--
-- Indexes for table `si_produtos`
--
ALTER TABLE `si_produtos`
  ADD PRIMARY KEY (`produto_id`);

--
-- Indexes for table `si_registros_acessos`
--
ALTER TABLE `si_registros_acessos`
  ADD PRIMARY KEY (`registros_id`);

--
-- Indexes for table `si_saida`
--
ALTER TABLE `si_saida`
  ADD PRIMARY KEY (`saida_id`);

--
-- Indexes for table `si_usuarios`
--
ALTER TABLE `si_usuarios`
  ADD PRIMARY KEY (`usuarios_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `si_categorias`
--
ALTER TABLE `si_categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_clientes`
--
ALTER TABLE `si_clientes`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_devolucao`
--
ALTER TABLE `si_devolucao`
  MODIFY `devolucao_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_entrada`
--
ALTER TABLE `si_entrada`
  MODIFY `entrada_produto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_fornecedores`
--
ALTER TABLE `si_fornecedores`
  MODIFY `fornecedor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_ordem_servico`
--
ALTER TABLE `si_ordem_servico`
  MODIFY `os_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_pedido_material`
--
ALTER TABLE `si_pedido_material`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_produtos`
--
ALTER TABLE `si_produtos`
  MODIFY `produto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_registros_acessos`
--
ALTER TABLE `si_registros_acessos`
  MODIFY `registros_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_saida`
--
ALTER TABLE `si_saida`
  MODIFY `saida_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `si_usuarios`
--
ALTER TABLE `si_usuarios`
  MODIFY `usuarios_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
