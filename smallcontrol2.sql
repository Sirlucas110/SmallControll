-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/03/2024 às 20:02
-- Versão do servidor: 10.4.14-MariaDB
-- Versão do PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `smallcontrol2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_categorias`
--

CREATE TABLE `si_categorias` (
  `categoria_id` int(11) NOT NULL,
  `categoria_nome` varchar(255) NOT NULL,
  `categoria_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `categoria_sessao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_categorias`
--

INSERT INTO `si_categorias` (`categoria_id`, `categoria_nome`, `categoria_cadastro`, `categoria_sessao`) VALUES
(1, 'Farináceos', '2023-12-18 20:36:26', '123'),
(2, 'Grãos', '2023-12-18 20:36:26', '123'),
(3, 'Enlatados', '2024-01-05 20:42:25', '349494');

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_clientes`
--

CREATE TABLE `si_clientes` (
  `cliente_id` int(11) NOT NULL,
  `cliente_imagem` varchar(255) NOT NULL,
  `cliente_nome` varchar(255) NOT NULL,
  `cliente_email` varchar(255) NOT NULL,
  `cliente_endereco` varchar(255) NOT NULL,
  `cliente_numero` varchar(50) NOT NULL,
  `cliente_bairro` varchar(255) NOT NULL,
  `cliente_cep` varchar(255) NOT NULL,
  `cliente_cidade` varchar(255) NOT NULL,
  `cliente_estado` varchar(255) NOT NULL,
  `cliente_documento` varchar(255) NOT NULL,
  `cliente_telefone` varchar(255) NOT NULL,
  `cliente_token` int(11) NOT NULL,
  `cliente_status` int(11) NOT NULL,
  `cliente_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `cliente_sessao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_clientes`
--

INSERT INTO `si_clientes` (`cliente_id`, `cliente_imagem`, `cliente_nome`, `cliente_email`, `cliente_endereco`, `cliente_numero`, `cliente_bairro`, `cliente_cep`, `cliente_cidade`, `cliente_estado`, `cliente_documento`, `cliente_telefone`, `cliente_token`, `cliente_status`, `cliente_cadastro`, `cliente_sessao`) VALUES
(37, '', 'Julio Cesar', 'teste@teste.com', 'Rua 03 de Outubro', '1', 'Jardim Helena', '08090-284', 'São Paulo', 'SP', '073.281.831-10', '(67) 99283-2500', 911, 1, '2024-02-28 19:48:19', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_devolucao`
--

CREATE TABLE `si_devolucao` (
  `devolucao_id` int(11) NOT NULL,
  `devolucao_produto_nome` varchar(255) NOT NULL,
  `devolucao_quantidade` int(11) NOT NULL,
  `devolucao_medidas` varchar(255) NOT NULL,
  `devolucao_data_despacho` date NOT NULL,
  `devolucao_motivo` varchar(500) NOT NULL,
  `devolucao_nf` varchar(255) NOT NULL,
  `devolucao_validade` varchar(255) NOT NULL,
  `devolucao_codigo` varchar(255) NOT NULL,
  `devolucao_fornecedor` varchar(255) NOT NULL,
  `devolucao_valor_nf` varchar(255) NOT NULL,
  `devolucao_sessao` varchar(255) NOT NULL,
  `devolucao_status` int(11) NOT NULL,
  `devolucao_status_liberado` int(11) NOT NULL,
  `devolucao_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_devolucao`
--

INSERT INTO `si_devolucao` (`devolucao_id`, `devolucao_produto_nome`, `devolucao_quantidade`, `devolucao_medidas`, `devolucao_data_despacho`, `devolucao_motivo`, `devolucao_nf`, `devolucao_validade`, `devolucao_codigo`, `devolucao_fornecedor`, `devolucao_valor_nf`, `devolucao_sessao`, `devolucao_status`, `devolucao_status_liberado`, `devolucao_cadastro`) VALUES
(1, 'Farinha de trigo', 50, 'unidades', '0000-00-00', 'CLIENTE NAO GOSTOU', '123DEVOLUCAO', '1 ano', '19247909', 'Fornecedor A', '1200.00', '29191705524463', 1, 0, '2024-01-17 20:47:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_entrada`
--

CREATE TABLE `si_entrada` (
  `entrada_produto_id` int(11) NOT NULL,
  `entrada_produto_nome` varchar(255) NOT NULL,
  `entrada_quantidade` int(11) NOT NULL,
  `entrada_quantidade_estoque_atual` int(11) NOT NULL,
  `entrada_quantidade_estoque` int(11) NOT NULL,
  `entrada_medidas` varchar(255) NOT NULL,
  `entrada_validade` varchar(255) NOT NULL,
  `entrada_nf` varchar(255) NOT NULL,
  `entrada_codigo` varchar(255) NOT NULL,
  `entrada_fornecedor` varchar(255) NOT NULL,
  `entrada_valor_nf` decimal(10,2) NOT NULL,
  `entrada_sessao` varchar(255) NOT NULL,
  `entrada_status` int(11) NOT NULL,
  `entrada_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_entrada`
--

INSERT INTO `si_entrada` (`entrada_produto_id`, `entrada_produto_nome`, `entrada_quantidade`, `entrada_quantidade_estoque_atual`, `entrada_quantidade_estoque`, `entrada_medidas`, `entrada_validade`, `entrada_nf`, `entrada_codigo`, `entrada_fornecedor`, `entrada_valor_nf`, `entrada_sessao`, `entrada_status`, `entrada_cadastro`) VALUES
(15, 'Farinha de trigo', 75, 73, 148, 'unidades', '1 ano', '123B', '52669760', 'Fornecedor A', '1500.00', '48071705675464', 1, '2024-02-28 17:15:24'),
(16, 'Farinha de trigo', 15, 90, 105, 'unidades', '1 ano', '123A', '82285740', 'Fornecedor A', '222.22', '13941709140684', 1, '2024-01-01 17:39:07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_fornecedores`
--

CREATE TABLE `si_fornecedores` (
  `fornecedor_id` int(11) NOT NULL,
  `fornecedor_img` varchar(255) NOT NULL,
  `fornecedor_nome` varchar(255) NOT NULL,
  `fornecedor_email` varchar(255) NOT NULL,
  `fornecedor_endereco` varchar(255) NOT NULL,
  `fornecedor_number` varchar(255) NOT NULL,
  `fornecedor_neighborhood` varchar(255) NOT NULL,
  `fornecedor_cep` varchar(255) NOT NULL,
  `fornecedor_cidade` varchar(255) NOT NULL,
  `fornecedor_estado` varchar(255) NOT NULL,
  `fornecedor_documento` varchar(255) NOT NULL,
  `fornecedor_telefone` varchar(255) NOT NULL,
  `fornecedor_status` int(11) NOT NULL,
  `fornecedor_cadastro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fornecedor_sessao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_fornecedores`
--

INSERT INTO `si_fornecedores` (`fornecedor_id`, `fornecedor_img`, `fornecedor_nome`, `fornecedor_email`, `fornecedor_endereco`, `fornecedor_number`, `fornecedor_neighborhood`, `fornecedor_cep`, `fornecedor_cidade`, `fornecedor_estado`, `fornecedor_documento`, `fornecedor_telefone`, `fornecedor_status`, `fornecedor_cadastro`, `fornecedor_sessao`) VALUES
(3, '8002-899b5210c4c7ef9a6e042125dd37eaa4d1b16cfa4412c214649ca173b30efc87179.jpg', 'Empresa Teste', 'teste@teste.com', 'Rua 03 de Outubro', '123', 'Jardim Helena', '08090-284', 'Campo Grande', 'MS', '11.111.111/1111-11', '(11) 11111-1111', 1, '2024-02-28 19:46:40', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_pedidos`
--

CREATE TABLE `si_pedidos` (
  `pedido_id` int(11) NOT NULL,
  `pedido_sessao` varchar(255) NOT NULL,
  `pedido_numero` varchar(255) NOT NULL,
  `pedido_nf` varchar(255) NOT NULL,
  `pedido_remessa` int(11) NOT NULL,
  `pedido_cidade` varchar(255) NOT NULL,
  `pedido_uf` varchar(255) NOT NULL,
  `pedido_produto_id` varchar(255) NOT NULL,
  `pedido_produto_nome` varchar(255) NOT NULL,
  `pedido_quantidade` int(11) NOT NULL,
  `pedido_quantidade_estoque` int(11) NOT NULL,
  `pedido_valor` decimal(10,2) NOT NULL,
  `pedido_valor_total` decimal(10,2) NOT NULL,
  `pedido_status` int(11) NOT NULL,
  `os_situation` int(11) NOT NULL,
  `pedido_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_pedidos`
--

INSERT INTO `si_pedidos` (`pedido_id`, `pedido_sessao`, `pedido_numero`, `pedido_nf`, `pedido_remessa`, `pedido_cidade`, `pedido_uf`, `pedido_produto_id`, `pedido_produto_nome`, `pedido_quantidade`, `pedido_quantidade_estoque`, `pedido_valor`, `pedido_valor_total`, `pedido_status`, `os_situation`, `pedido_cadastro`) VALUES
(35, '170717088296329', '170717088296329', '123A', 1, 'Sao Paulo', 'SP', '11', 'Farinha de trigo', 10, 90, '5.99', '232.32', 3, 2, '2024-02-25 02:54:08'),
(36, '170717088296329', '170717088296329', '123A', 1, 'Sao Paulo', 'SP', '1', 'Teste', 10, 140, '10.00', '232.32', 3, 2, '2024-02-25 21:33:49');

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_produtos`
--

CREATE TABLE `si_produtos` (
  `produto_id` int(11) NOT NULL,
  `produto_nome` varchar(255) NOT NULL,
  `produto_preco` decimal(10,2) NOT NULL,
  `produto_quantidade` int(11) NOT NULL,
  `produto_categoria` varchar(255) NOT NULL,
  `produto_capa` varchar(255) NOT NULL,
  `produto_status` int(11) NOT NULL,
  `produto_cadastro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `produto_sessao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_produtos`
--

INSERT INTO `si_produtos` (`produto_id`, `produto_nome`, `produto_preco`, `produto_quantidade`, `produto_categoria`, `produto_capa`, `produto_status`, `produto_cadastro`, `produto_sessao`) VALUES
(1, 'teste', '10.00', 140, '1', '5467-e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855101.', 1, '2024-02-25 21:33:49', ''),
(11, 'Farinha de trigo', '5.99', 151, '1', '7504-99883247d8f33374412b1ef076ebc1e81cc90cea150454f1dc9464dc88854c8d90.jpeg', 1, '2024-02-28 19:17:37', '848503');

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_registros_acessos`
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
-- Estrutura para tabela `si_saida`
--

CREATE TABLE `si_saida` (
  `saida_id` int(11) NOT NULL,
  `saida_produto_nome` varchar(255) NOT NULL,
  `saida_quantidade` int(11) NOT NULL,
  `saida_quantidade_estoque_atual` int(11) NOT NULL,
  `saida_quantidade_estoque` int(11) NOT NULL,
  `saida_medidas` varchar(255) NOT NULL,
  `saida_validade` varchar(255) NOT NULL,
  `saida_nf` varchar(255) NOT NULL,
  `saida_codigo` varchar(255) NOT NULL,
  `saida_fornecedor` varchar(255) NOT NULL,
  `saida_valor_nf` decimal(10,2) NOT NULL,
  `saida_sessao` varchar(255) NOT NULL,
  `saida_status` int(11) NOT NULL,
  `saida_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_saida`
--

INSERT INTO `si_saida` (`saida_id`, `saida_produto_nome`, `saida_quantidade`, `saida_quantidade_estoque_atual`, `saida_quantidade_estoque`, `saida_medidas`, `saida_validade`, `saida_nf`, `saida_codigo`, `saida_fornecedor`, `saida_valor_nf`, `saida_sessao`, `saida_status`, `saida_cadastro`) VALUES
(1, 'Farinha de trigo', 50, 73, 23, 'unidades', '1 ano', '123SAIDA', '86949188', 'Fornecedor A', '1200.00', '44691705094204', 2, '2024-02-28 21:16:44'),
(2, 'Farinha de trigo', 32, 148, 116, 'unidades', '1 ano', '123C', '93265969', 'Fornecedor A', '200.00', '44341705675505', 1, '2024-01-19 14:45:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `si_usuarios`
--

CREATE TABLE `si_usuarios` (
  `usuarios_id` int(11) NOT NULL,
  `usuarios_imagem` varchar(255) NOT NULL,
  `usuarios_nome` varchar(255) NOT NULL,
  `usuarios_email` varchar(255) NOT NULL,
  `usuarios_senha` varchar(255) NOT NULL,
  `usuarios_status` int(11) NOT NULL,
  `usuarios_nivel` int(11) NOT NULL,
  `usuarios_data` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `si_usuarios`
--

INSERT INTO `si_usuarios` (`usuarios_id`, `usuarios_imagem`, `usuarios_nome`, `usuarios_email`, `usuarios_senha`, `usuarios_status`, `usuarios_nivel`, `usuarios_data`, `token`) VALUES
(1, '', 'Julio Cesar', 'admin@admin.com', '12345', 1, 10, '2024-02-28 19:18:56', 123),
(20, '', 'Adriano', 'adriano@malzao.com', '$2y$10$1llEMPgmhQ5tO4qRtxfYAuZnOYclQnuMtM34jluPDjSwEyKRAhHQa', 1, 2, '2024-02-28 23:28:14', 782289);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_token` int(11) NOT NULL,
  `user_level` varchar(255) NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_register` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_password`, `user_token`, `user_level`, `user_status`, `user_register`, `user_update`) VALUES
(1, 'Julio', 'Campos', 'julio@admin.com', '$2y$10$jkgsUzp2HEVuQrFpRvHdNOAr8h254650c9M.zgqHslj0lt8Jduy76', 1234567890, '10', 1, '2020-10-11 23:39:11', '2024-03-04 19:00:57');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `si_categorias`
--
ALTER TABLE `si_categorias`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Índices de tabela `si_clientes`
--
ALTER TABLE `si_clientes`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Índices de tabela `si_devolucao`
--
ALTER TABLE `si_devolucao`
  ADD PRIMARY KEY (`devolucao_id`);

--
-- Índices de tabela `si_entrada`
--
ALTER TABLE `si_entrada`
  ADD PRIMARY KEY (`entrada_produto_id`);

--
-- Índices de tabela `si_fornecedores`
--
ALTER TABLE `si_fornecedores`
  ADD PRIMARY KEY (`fornecedor_id`);

--
-- Índices de tabela `si_pedidos`
--
ALTER TABLE `si_pedidos`
  ADD PRIMARY KEY (`pedido_id`);

--
-- Índices de tabela `si_produtos`
--
ALTER TABLE `si_produtos`
  ADD PRIMARY KEY (`produto_id`);

--
-- Índices de tabela `si_registros_acessos`
--
ALTER TABLE `si_registros_acessos`
  ADD PRIMARY KEY (`registros_id`);

--
-- Índices de tabela `si_saida`
--
ALTER TABLE `si_saida`
  ADD PRIMARY KEY (`saida_id`);

--
-- Índices de tabela `si_usuarios`
--
ALTER TABLE `si_usuarios`
  ADD PRIMARY KEY (`usuarios_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `si_categorias`
--
ALTER TABLE `si_categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `si_clientes`
--
ALTER TABLE `si_clientes`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `si_devolucao`
--
ALTER TABLE `si_devolucao`
  MODIFY `devolucao_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `si_entrada`
--
ALTER TABLE `si_entrada`
  MODIFY `entrada_produto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `si_fornecedores`
--
ALTER TABLE `si_fornecedores`
  MODIFY `fornecedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `si_pedidos`
--
ALTER TABLE `si_pedidos`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `si_produtos`
--
ALTER TABLE `si_produtos`
  MODIFY `produto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `si_registros_acessos`
--
ALTER TABLE `si_registros_acessos`
  MODIFY `registros_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `si_saida`
--
ALTER TABLE `si_saida`
  MODIFY `saida_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `si_usuarios`
--
ALTER TABLE `si_usuarios`
  MODIFY `usuarios_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
