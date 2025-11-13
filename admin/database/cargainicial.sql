-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: local-dev    Database: pequenos_a_bordo
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipoInstalacao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orientacao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preco1` decimal(10,2) NOT NULL,
  `preco2` decimal(10,2) NOT NULL,
  `preco3` decimal(10,2) NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'Bebê Conforto Voyage Beta','/images/produtos/1762383776_690bd7a0d3dac.png','Voyage','Cinto de segurança','Virado para trás',11.00,10.00,8.00,'O Bebê Conforto Beta da Voyage tem estrutura leve, que facilita o transporte e a instalação no veículo. Item essencial para a segurança do seu filho, desde a saída da maternidade e em todos os passeios do bebê. Aprovado pelo INMETRO conforme a norma ABNT NBR 14.400 para crianças do nascimento aos 13kg (Grupo 0+) para instalação nos cintos de segurança de 3 pontos dos veículos.','2025-11-05 20:02:56','2025-11-06 15:22:16'),(2,'Burigotto Bebê Conforto Touring','/images/produtos/1762385179_690bdd1b74b4d.png','Burigotto','Cinto de segurança','Virado para trás',11.00,10.00,8.00,'Para um passeio mais tranquilo e seguro com as crianças, a Burigotto apresenta o bebê conforto Touring X, que pode ser usado para transportar seu filho no carro, carrinho ou segurando pela alça de apoio. Indicado para o grupo 0+, até 13kg, com capota e protetor para a cabeça removíveis.','2025-11-05 20:07:51','2025-11-06 15:22:27'),(3,'Cadeira para Auto 0-36 Kgs Isofix com Rotação','/images/produtos/1762385160_690bdd080d36b.png','Litet','Isofix e Top Tether ou cinto de segurança','Rotação 360°',20.00,17.00,13.00,'Com capacidade de uso até 36 kg, a Snugfix é uma companheira de longo prazo para o seu filho. Possui base com rotação de 360° e sistema Isofix para instalação segura.','2025-11-05 20:08:47','2025-11-06 15:22:50'),(4,'Cadeirinha com Isofix Road-X','/images/produtos/1762385131_690bdceb59a5f.png','COSCO','Isofix e Top Tether ou cinto de segurança','Virado para frente',15.00,12.00,10.00,'Cadeirinha para crianças de 9kg até 36kg, com redutor de assento acolchoado e sistema de fixação ISOFIX.','2025-11-05 20:10:02','2025-11-06 15:23:05'),(5,'Cadeira para Auto Evolve-X Cinza 9-36 kg Cosco DOREL','/images/produtos/1762385086_690bdcbe81b63.png','COSCO DOREL','Cinto de segurança / Sistema Isofix de fixação','Diversas posições de inclinação do assento',17.00,14.00,12.00,'Cadeirinha com ISOFIX. Possui ajuste de encosto através do botão giratório frontal, ajuste do apoio para a cabeça em conjunto com o cinto de segurança facilita a vida dos pais acompanhando o crescimento, o assento ultra macio com almofada redutora para as crianças menores. Grupos II e III para crianças de 9 a 36kg.','2025-11-05 20:10:52','2025-11-06 15:23:15'),(6,'Carrinho De Bebê Ohlalà 3 Jet Black Chicco','/images/produtos/1762385077_690bdcb5f2fb6.png','Chicco','Portátil','',16.00,13.00,12.00,'Carrinho de bebê ultraleve e compacto, com apenas 4kg, ideal para passeios e com amortecedores nas 4 rodas.','2025-11-05 20:11:26','2025-11-06 15:23:28'),(7,'Cadeira Portátil De Alimentação Burigotto Kiwi Baby','/images/produtos/1762385065_690bdca9ce740.png','Burigotto','','',5.00,4.00,3.00,'Para crianças de 6 a 36 meses, até 15kg. Possui montagem rápida e fácil, bandeja removível, design prático e funcional, além de 2 regulagens de altura. Produto dobrável e compacto quando fechado.','2025-11-05 20:12:07','2025-11-06 15:24:34'),(8,'Cadeira Portátil De Alimentação Galzerano','/images/produtos/1762385057_690bdca19fbe4.png','Galzerano','','',12.00,10.00,8.00,'Para crianças de 6 a 36 meses, até 15kg. Segurança garantida com cinto de 5 pontos e 2 regulagens de altura. Produto desmontável, facilitando armazenamento e limpeza. Bandeja removível com porta-copos para maior praticidade.','2025-11-05 20:12:40','2025-11-06 15:23:46'),(9,'Berço Desmontável Portátil Burigotto','/images/produtos/1762385024_690bdc801072c.png','Burigotto','','',15.00,13.00,12.00,'Berço desmontável com regulagem de altura da base acolchoada, laterais em tela para ventilação e rodas com freios.','2025-11-05 20:13:12','2025-11-06 15:24:03');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `nome_completo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `forma_pagamento` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PIX',
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_produto_id` (`produto_id`),
  KEY `idx_data_inicio` (`data_inicio`),
  KEY `idx_data_fim` (`data_fim`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-06 19:34:03
