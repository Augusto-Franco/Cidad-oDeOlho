
O seguinte projeto vai acessar os dados da API "/dadosabertos.almg.gov.br", recuperar alguns dados específicos e usá-los para, em uma view, imprimir as redes sociais mais usadas entre os deputados e em outra para imprimir os 5 deputados que mais reembolsaram dinheiro de verbas em cada mês de 2019. Para o programa funcionar é necessário que você crie algumas tabelas no MySql através dos comandos abaixo ou utilizar o "php artisan migrate" nesse projeto, mas se você usar o artisan migrate você precisa dar uns Alter Table no MySql para permitir que alguns valores que serão recuperados e salvos nas tabelas sejam nulos. 

Nas pastas Controllers, Models, migrations e views estão todos os arquivos que eu criei para o projeto.

Comandos pra gerar o schema e as tabelas: 

CREATE DATABASE `laravel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

CREATE TABLE `deputados` (
  `id` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `nomeServidor` varchar(255) DEFAULT NULL,
  `partido` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `atividadeProfissional` varchar(255) DEFAULT NULL,
  `naturalidadeMunicipio` varchar(255) DEFAULT NULL,
  `naturalidadeUf` varchar(255) DEFAULT NULL,
  `dataNascimento` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `redesociais` (
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `valors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_deputado` bigint(20) unsigned NOT NULL,
  `valorTotal` double NOT NULL,
  `nome` varchar(255) NOT NULL,
  `mes` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;