<?php
/*
    ***********************************************
    CONFIG.PHP - PARAMETRIZAÇÃO DE NOSSA APLICAÇÃO.
    ***********************************************
    Copyright (c) 2020, Jeferson Souza MESTRES DO PHP
*/

//Iniciando a Sessão em Toda Nossa Aplicação
//session_start();
//Chamar a conexão
include_once 'connection.php';

$_SESSION['user'] = 'Julio Cesar';

//Configurando o Timezone e a Data Hora do Nosso Servidor
date_default_timezone_set("America/Sao_paulo");

/*Configuações da Aplicação */
$configBase = "http://localhost/smallcontrol/"; //Url da Aplicação;
$titleSite = "SmallControl"; //Título de sua Aplicação
$description = "Plataforma dedicada ao controle de estoque"; //Descrição da Aplicação
$mailSite = "jcesarc19@hotmail.com"; //E-mail do Cliente ou Dono da Aplicação
$phoneSite = "(XX) xxxxx-xxxx"; //Telefone do Cliente ou Empresa Cliente
$statusSite = 1; //0=>offline, 1=>online, 2=>maintenance  [Status da aplicação]
$helloBar = 1;  //0=>offline, 1=>online [Status do HelloBar]

/* Configurações do Autor */
$nameAuthorSite = "Julio Cesar, Victor Sakamoto, Thiago Nantes, Lucas Moraes e Geovane Novaes."; //Nome do Autor
$mainAuthorSite = "jcesarc19@hotmail.com"; //E-mail do Autor
$phoneAuthorSite = "(XX) xxxxx-xxxx"; //Telefone do Autor

/* Configurações de Servidor de E-mail */
$mailHost = ""; //Definição Configuração de Host do Servidor
$mailSMTP =  ""; //Definição Configuração de SMTP do Servidor
$mailUser = ""; //Definição Configuração de Login de Usuário
$mailPass = ""; //Definição Configuração de Senha de Acesso
$mailResponse = ""; //Definição Configuração de E-mail Para Resposta
$mailPort = 465; //Definição Configuração de Porta do Servidor [587 ou 465]
$mailSecure = "SSL"; //Definição Configuração de Segurança [TLS/SSL]

/* Configurações de Temas */
$themeSite = "sistema"; //Definição Configuração Tema do Site

/* Configurações de Diretórios de Temas */
$themePathSite =  "Themes/".$themeSite; //Definição Configuração do Diretório do Tema do Site

/* Configurações de Níveis de Acesso */
define("LEVEL_USER", 1); //Nível de Acesso Para Usuários [Operacionais]
define("LEVEL_CLIENT", 2); //Nível de Acesso Para Clientes [Coordenadores de Equipes]
define("LEVEL_ADMIN", 9); //Nível de Acesso Para Administradores [Administrador Responsável pela Aplicação]
define("LEVEL_SUPER", 10); //Nível de Acesso Para Profissional Web [Você]

/* Configurações de Tabelas do Database */
define("DB_USERS", "si_usuarios"); //Definição da Constante Para Tabela USERS
define("DB_CLIENTS", "si_clientes"); //Definição da Constante Para Tabela CLIENTS
define("DB_ORDERS", "si_pedidos"); //Definição da Constante Para Tabela ORDERS
define("DB_PRODUCT", "si_produtos"); //Definição da Constante Para Tabela PRODUCT
define("DB_PROVIDERS", "si_fornecedores"); //Definição da Constante Para Tabela PROVIDERS
define("DB_CATEGORY", "si_categorias"); //Definição da Constante Para Tabela CATEGORY
define("DB_LOGIN", "users"); // Definição para a tabela Users referente ao login
define("DB_STOCKIN", "si_entrada"); // Definição da constante para a tabela de estoque de ENTRADA
define("DB_STOCKOUT", "si_saida"); // Definição da constante para a tabela de estoque de SAIDA
define("DB_DEVOLUTION", "si_devolucao"); // Definição da constante para a tabela de estoque de DEVOLUCAO

define('BLOCKED', 1); //Bloqueio o Usuário Após 6 Tentativas de Senha Errado
define('TIMESBLOCKED', 6); //Quantas Tentativas Usuário Pode Fazer Antes de Bloquear
define('REMEMBER', 1); //Lembrar Senha


/*Criação do Guid*/
if (!function_exists('com_create_guid')) {
    function com_create_guid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

/* Configurações de Níveis de Acesso */
//define("LEVEL_USER", 1); //Nível de Acesso Para Usuários [Operacionais]
//define("LEVEL_CLIENT", 2); //Nível de Acesso Para Clientes [Coordenadores de Equipes]
//define("LEVEL_ADMIN", 9); //Nível de Acesso Para Administradores [Administrador Responsável pela Aplicação]
//define("LEVEL_SUPER", 10); //Nível de Acesso Para Profissional Web [Você]

/* Configurações de Servidor de E-mail */
define("MAIL_HOST", "mail.servidor.com.br"); //Definição Configuração de Host do Servidor
define("MAIL_SMTP", "smtp.servidor.com.br"); //Definição Configuração de SMTP do Servidor
define("MAIL_USER", "contato@interligsolucoes.com.br"); //Definição Configuração de Login de Usuário
define("MAIL_PASS", "12344"); //Definição Configuração de Senha de Acesso
define("MAIL_RESPONSE", "contato@interligsolucoes.com.br"); //Definição Configuração de E-mail Para Resposta
define("MAIL_PORT", 465); //Definição Configuração de Porta do Servidor [587 ou 465]
define("MAIL_SECURE", "SSL"); //Definição Configuração de Segurança [TLS/SSL]

/*Configurações de Módulos*/
//define('BLOCKED', 1); //Bloqueio o Usuário Após 6 Tentativas de Senha Errado
//define('TIMESBLOCKED', 6); //Quantas Tentativas Usuário Pode Fazer Antes de Bloquear
//define('REMEMBER', 1); //Lembrar Senha
define('TITLE_LOGIN', 'Smallcontrol'); //Nome da Aplicação
define('LOGINACTIVE', 1); //Login Ativo - Módulo Possibilita Acesso Direto, Se Houver Cookies. Para Funcionar Precisa do Remember Ativo.
define('LOGCREATE', 1); //Cria Log com .txt de Login (NOT APPLICATED)
define('LOGINHISTORY', 1); //Cria Histórico de Login - Salve no Banco de Dados. (NOT APPLICATED)