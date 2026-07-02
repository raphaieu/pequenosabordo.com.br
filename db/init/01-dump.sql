USE pequenos_a_bordo;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 03/07/2026 às 07:04
-- Versão do servidor: 8.0.36
-- Versão do PHP: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pequenos_a_bordo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipoInstalacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orientacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preco1` decimal(10,2) NOT NULL,
  `preco2` decimal(10,2) NOT NULL,
  `preco3` decimal(10,2) NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `imagem`, `marca`, `tipoInstalacao`, `orientacao`, `preco1`, `preco2`, `preco3`, `descricao`, `ordem`, `criado_em`, `atualizado_em`) VALUES
(1, 'Bebê Conforto Voyage Beta Preto B04', '/images/produtos/1762383776_690bd7a0d3dac.png', 'Voyage', 'Cinto de segurança', 'Virado para trás', 13.00, 12.00, 9.00, 'O Bebê Conforto Beta da Voyage tem estrutura leve, que facilita o transporte e a instalação no veículo. Item essencial para a segurança do seu filho, desde a saída da maternidade e em todos os passeios do bebê. Aprovado pelo INMETRO conforme a norma ABNT NBR 14.400 para crianças do nascimento aos 13kg (Grupo 0+) para instalação nos cintos de segurança de 3 pontos dos veículos.', 4, '2025-11-05 20:02:56', '2026-06-14 21:28:29'),
(2, 'Burigotto Bebê Conforto Touring B05', '/images/produtos/1762385179_690bdd1b74b4d.png', 'Burigotto', 'Cinto de segurança', 'Virado para trás', 13.00, 12.00, 9.00, 'Para um passeio mais tranquilo e seguro com as crianças, a Burigotto apresenta o bebê conforto Touring X, que pode ser usado para transportar seu filho no carro, carrinho ou segurando pela alça de apoio. Indicado para o grupo 0+, até 13kg, com capota e protetor para a cabeça removíveis.', 5, '2025-11-05 20:07:51', '2026-06-14 21:28:23'),
(3, 'Cadeira Litet para Auto 0-36 Kgs com Rotação LR: 01', '/images/produtos/1762385160_690bdd080d36b.png', 'Litet', 'Isofix e Top Tether ou cinto de segurança', 'Rotação 360°', 21.00, 17.00, 13.00, 'Com capacidade de uso até 36 kg, a Snugfix é uma companheira de longo prazo para o seu filho. Possui base com rotação de 360° e sistema Isofix para instalação segura.', 6, '2025-11-05 20:08:47', '2026-06-14 21:28:23'),
(4, 'Cadeira para Auto Evolve-X Cinza 9-36 kg C001', '/images/produtos/1762385131_690bdceb59a5f.png', 'COSCO', 'Isofix e Top Tether ou cinto de segurança', 'Virado para frente', 17.00, 14.00, 12.00, 'Sistema de fixação ISOFIX\r\nReclinável\r\nApoio de cabeça e cinto com ajuste simultâneo de altura\r\nAlmofadas redutoras removíveis', 17, '2025-11-05 20:10:02', '2026-06-14 21:28:07'),
(5, '1  Cadeira Para Auto Protege - Burigotto AP01', '/images/produtos/1762551034_690e64fa3d42e.png', ' Burigotto', 'Cinto de segurança ', '', 11.00, 10.00, 9.00, 'Grupos ii e iii-para crianças de 15 a 36kg\r\nProtetor para cabeça removível\r\nApoio para cabeça regulável em 3 posições\r\nEncosto ajustável\r\nReclinável em 2 posições\r\nPara grupo 3 pode ser usada como assento, retirando a parte do encosto', 22, '2025-11-05 20:10:52', '2026-06-23 18:46:20'),
(7, 'Cadeira Portátil De Alimentação - A4', '/images/produtos/1762385065_690bdca9ce740.png', 'Burigotto', '', '', 5.00, 4.00, 3.00, 'Para crianças de 6 a 36 meses, até 15kg. Possui montagem rápida e fácil, bandeja removível, design prático e funcional, além de 2 regulagens de altura. Produto dobrável e compacto quando fechado.', 37, '2025-11-05 20:12:07', '2026-06-14 21:44:44'),
(8, 'Cadeira Portátil De Alimentação Galzerano - A1', '/images/produtos/1762385057_690bdca19fbe4.png', 'Galzerano', '', '', 12.00, 10.00, 8.00, 'Para crianças de 6 a 36 meses, até 15kg. Segurança garantida com cinto de 5 pontos e 2 regulagens de altura. Produto desmontável, facilitando armazenamento e limpeza. Bandeja removível com porta-copos para maior praticidade.', 34, '2025-11-05 20:12:40', '2026-06-14 21:44:50'),
(9, 'Berço Cosco Kids, Nanny, 0 a 18kg, Azul Rajado + Colchão CE01', '/images/produtos/1764863746_6931af02be355.webp', 'COSCO', '', '', 17.00, 15.00, 13.00, '- Uso como berço e cercado\r\n\r\n- Mosquiteiro alto, com abertura por zíper no meio\r\n\r\n- 2 alturas: a mais alta para os recém-nascidos e mais baixa para os maiorzinhos\r\n\r\n- Cresce com o pequeno, até os 18kg\r\n\r\n- Soninho seguro, com colchonete fixado por zíper e trava de segurança\r\n\r\n- Bolso lateral super prático para pequenos objetos\r\n\r\n- Rodas para facilitar a movimentação em casa\r\n\r\n- Facinho de montar e desmontar\r\n\r\n- Leve pra onde for: portátil, tem bolsa de transporte\r\n\r\n- De olho no pequeno: Laterais em tela respirável\r\n\r\nCom 2 alturas, cresce junto com o pequeno. Tem mosquiteiro super prático com zíper e é facinho de transportar e montar.\r\n\r\nPrático, o Nanny tem 2 alturas e cresce com o pequeno. Quando recém-nascido, faz as sonecas na parte mais alta. Depois, quando estiver maiorzinho, usa a parte mais baixa. Portátil, é facinho levar o berço pra onde você for: ele acompanha uma bolsa de transporte pra agilizar a saída e a chegada nos passeios e viagens.\r\n\r\nXô, mosquitos! Oi, tranquilidade! Pra cuidar da criança dormindo no berço Nanny, você nem precisa tirar o mosquiteiro: ele tem zíper e abre no meio com facilidade. Assim, não precisa instalar de novo quando colocar a criança de volta.\r\n\r\nCom bolso prático na lateral, o papai e a mamãe também podem deixar por perto o que for mais útil pra hora de atender o bebê: chupeta, brinquedo, fralda ou qualquer outro objeto pequeno.\r\n\r\nO soninho do bebê no berço Nanny é seguro com colchonete fixado por zíper e com trava de segurança. Os adultos podem ficar de olho na criança com facilidade, já que a lateral é feita em tela, o que e também deixa o ambiente mais fresco e arejado. Com rodinhas, é facinho mudar a posição do berço dentro de casa sempre que precisar.\r\n\r\nAprovado pelo INMETRO conforme a norma ABNT NBR 15.860 para crianças do nascimento aos 18kg.', 38, '2025-11-05 20:13:12', '2026-06-14 21:44:44'),
(12, 'Cadeirinha Infantil 0-36kg Evolutty 360 - X Cosco Kids - CR01', '/images/produtos/1762822210_691288426c08b.webp', 'COSCO', 'Isofix e Top Tether ou cinto de segurança', '', 21.00, 17.00, 13.00, 'Segurança e conforto em todas as fases.\r\nCom giro 360°, ISOFIX e ajustes que acompanham o crescimento, a cadeirinha Evolutty 360-X da Cosco é a solução prática e completa para transportar seu filho do nascimento até os 10 anos, com muito mais facilidade e proteção.\r\nCaracterísticas da Cadeirinha:\r\n-Giratória 360° (quando instalada de costas ao movimento ou para mudança de fase)\r\n-Giro disponível também para os grupos 2 e 3 (15 a 36kg)\r\n-Pode ser usada por mais tempo de costas ao movimento: até 18kg\r\n-Encosto reclinável em 4 posições: 1 virada de costas e 3 viradas de frente\r\n-Cintos de 5 pontos, com ajuste de altura simultâneo ao apoio de cabeça', 9, '2025-11-11 00:50:10', '2026-06-14 21:29:32'),
(14, 'Cadeira de Carro All Stages 2.0 Litet - LT01', '/images/produtos/1762823239_69128c4735d53.webp', 'Litet', 'Isofix e Top Tether ou cinto de segurança', '', 20.00, 16.00, 13.00, 'Desenvolvida com tecnologia de retenção Isofix e Top Tether, a All Stages 2.0 garante a máxima segurança para o seu pequeno desde o nascimento até os 36kgs!\r\nSeu sistema Isofix é reversível e pode ser instalado em todos os grupos. Conta com cinto de segurança de 5 pontos com 3 posições de ajuste de altura para acompanhar o crescimento do seu bebê, e, além disso, possui 4 posições de recline de encosto com ângulos de inclinação super confortáveis. O estofado possui o dobro de espuma e seu tecido de alta qualidade é removível, facilitando a higiene regular. Ela também acompanha almofada redutora de corpo e cabeça para acomodar melhor os bebês menores.', 12, '2025-11-11 01:07:19', '2026-06-14 21:28:19'),
(15, ' Assento infantil para carro Burigotto Protege Assento Protege Liso preto - A01', '/images/produtos/1762823503_69128d4f7bc3d.webp', 'Burigotto', '', '', 7.00, 6.00, 5.00, 'O Assento Protege da Burigotto foi desenvolvido para os Grupos II e III, que são crianças de 15 a 36Kg. Ele possui um sistema de retenção projetado para garantir a segurança das crianças à medida que crescem, pois permite que os cintos de quadril e ombro se ajustem bem para maior proteção em caso de impacto. Também oferece grande conforto para viagens diárias e longas.', 19, '2025-11-11 01:11:43', '2026-06-14 21:30:15'),
(17, 'Carrinho De Bebê De Passeio Chicco Juvenile Ohlalà 3 - CH01', '/images/produtos/1770591312_69891450728e2.jpeg', 'Chicco', '', '', 16.00, 13.00, 12.00, 'Ultra leve;\r\nApenas 3,8 kg, tão leve que pode levantá-lo só com um dedo!\r\nFácil de conduzir;\r\nOhlalà dispõe de uma pega única que o torna fácil de conduzir, com uma só mão.\r\nCompacto e fácil de manusear;\r\nFecha-se rapidamente com uma só mão e fica em pé sozinho.\r\nHomologado desde o nascimento, ideal para as pequenas sestas durante o passeio;\r\nEncosto regulável em múltiplas posições, totalmente reclinável, e apoio das pernas ajustável, para se adaptar a todas as situações.', 29, '2025-11-11 01:25:03', '2026-06-14 21:44:54'),
(18, 'Berço Desmontável Portátil Serenata Burigotto  + Colchão CE02', '/images/produtos/1764809898_6930dcaa7052c.webp', 'Burigotto', '', '', 17.00, 15.00, 13.00, 'Colchão + Colchonete \r\nDobrável.\r\nCapacidade:  0-18kg\r\nO Berço Desmontável Portátil Serenata Black Burigotto é perfeito para garantir o conforto e a segurança do seu bebê durante viagens e passeios. Com um design elegante na cor preta, ele se adapta facilmente a qualquer ambiente.\r\n\r\nCom sua estrutura dobrável, o berço é prático de transportar e armazenar, ocupando pouco espaço. Além disso, possui rodas que facilitam a locomoção, tornando-o ideal para uso em diferentes cômodos da casa ou em viagens.\r\n\r\nO berço é adequado para crianças de 0 a 3 anos, suportando um peso máximo de 15 kg. Sua base acolchoada proporciona conforto extra ao bebê, enquanto as travas de segurança garantem estabilidade e proteção.', 39, '2025-11-11 01:34:11', '2026-06-14 21:44:44'),
(19, 'Berço Portátil Origin Compacto Cinza Cosco Kids + Colchão - CE03', '/images/produtos/1763600065_691e66c1c4264.jpg', 'COSCO', '', '', 17.00, 15.00, 13.00, 'O Berço Portátil Origin da Cosco é fácil de montar e desmontar e pode ser usado como berço ou cercadinho, acompanhando o crescimento da criança. Tem colchonete preso com zíper, dando segurança para o bebê e tranquilidade para os pais.\r\nEle é ideal para levar em viagens: além de leve, compacto e confortável para o bebê, tem bolsa de transporte com alça e laterais com tela, que ajudam a ventilar.  \r\nAprovado pelo INMETRO conforme a norma ABNT NBR 15.860 para crianças do\r\nnascimento aos 15kg.\r\nColchão + Colchonete ', 40, '2025-11-11 02:06:56', '2026-06-14 21:44:38'),
(20, 'Cadeira para Automóvel Fisher Price All-Stages FIX 2.0 0 a 36kg F03', '/images/produtos/1763130470_69173c66314c6.webp', 'Fisher Price ', 'Isofix e Top Tether ou cinto de segurança', '', 18.00, 15.00, 12.00, 'Especialmente desenvolvida pensando no conforto da criança, essa cadeira conta com enchimento com o dobro de espuma, tornando o toque muito mais macio e garantindo proteção e bem-estar para seu bebê.\r\nEla também possui protetor de cabeça removível, almofada interna para recém-nascidos e uma ótima inclinação de até 145° para garantir a posição correta para os mais pequenos, evitando desconforto e garantindo maior segurança.\r\nAlém disso, o modelo All-Stages FIX 2.0 possui cinto de segurança ajustável, 14 posições para acompanhar o crescimento da criança e instalação Isofix que garante uma montagem muito mais fácil, rápida e segura.\r\nCom uma coloração neutra e um design primoroso, essa cadeira para auto é perfeita para meninos e meninas usarem até completarem 36kg, ou seja, é indicada para todos os grupos (0, I, II e III).', 16, '2025-11-14 14:27:50', '2026-06-14 21:28:12'),
(21, 'Multikids Cadeira Alimentacao Portatil Refeição 3 x 1 - A2', '/images/produtos/1763131052_69173eac65ccc.webp', 'Multikids', 'Portátil', '', 12.00, 10.00, 8.00, 'Berry, a cadeira de alimentação mais versátil e funcional do mercado!\r\n\r\nTransformável e conversível, a Berry pode ser usada como cadeira alta, cadeira baixa e assento elevatório. Ideal para ser usada dos 6 meses até os 15 kgs no modo de cadeira alta ou baixa, e 25 kgs no modo de assento elevatório. A Berry é perfeita para qualquer situação: em casa no dia a dia, em viagens, passeios ou restaurantes, como cadeira de alimentação ou cadeira de atividades.\r\n\r\nSuper segura e confortável, ela possui fitas de fixação que prendem à cadeira de adulto, pés antiderrapantes, cinto de segurança de 5 pontos, apoio de pés e espuma no encosto e assento. Sua bandeja é ajustável em até 3 posições, proporcionando encaixe ideal nos diferentes tipos de mesas, oferecendo segurança onde quer que ela seja usada.', 35, '2025-11-14 14:37:32', '2026-06-14 21:44:50'),
(23, 'Carrinho De Bebê Chicco Goody Plus Capacidade 22kg CH02', '/images/produtos/1763599344_691e63f0b91a4.jpg', 'Chicco', '', 'CAP 22KG', 17.00, 15.00, 13.00, 'Com 3 posições para reclinar.\r\nA alça é regulável.\r\nDimensões do carrinho aberto: 47 cm de largura x 105 cm de altura.\r\nCom capota retrátil e sistema de suspensão.\r\nPossui capota com visor.\r\nPossui tecido removível.\r\nPossui tiras ajustáveis.\r\nPossui almofada redutora para bebês.\r\nA estrutura é de metal e o tecido da almofada de poliéster.', 30, '2025-11-20 00:42:24', '2026-06-14 21:44:54'),
(24, 'Cadeira infantil para carro Fisher-Price Snugfix 360º preto- FR01', '/images/produtos/1769558727_697952c702f77.webp', 'Fisher Price ', 'Isofix e Top Tether ou cinto de segurança', '', 21.00, 17.00, 13.00, 'Cadeira para Auto Snugfix 360º Rotacional Preta - Fisher Price\r\n\r\nPrincipais Características:\r\n- SIP: Proteção extra lateral - Maior segurança em caso de colisão\r\n- Isofix: A instalação pode ser feita com o cinto do carro ou Isofix\r\n- Encosto da Cabeça: 13 opções de ajuste na altura do encosto de cabeça\r\n- Base giratória em 360º - Maior facilidade de colocar e tirar a criança da cadeira\r\n- Reclínio Perfeito: 4 opções de reclínios para o maior conforto da criança.\r\n\r\nEspecificações Técnicas:\r\n- Base para Automóvel\r\n- Base Ajustável e Giratória\r\n- Para crianças de 0 a 36Kg (0+, I,II,III)\r\n- Cinto de Segurança: 5 pontos, ajustável em até 3 alturas.\r\n- Compatível com o Cinto de Segurança do Carro\r\n- Certificado pelos Órgãos Autorizados - OCP’S (Organismos de Certificação de Produtos)', 10, '2025-11-20 00:48:48', '2026-06-14 21:29:19'),
(25, 'Carrinho de Bebê Portátil Minny Cosco - MC01', '/images/produtos/1763730813_6920657d94aed.webp', 'COSCO', '', 'Peso 5,5 Kg', 16.00, 13.00, 12.00, 'O Minny da Cosco é o carrinho compacto que você sempre quis! Mais prático para o dia a dia, com alça telescópica, como uma mala, para levar onde precisar e nunca enjoar. Pode ser usado desde o nascimento e continuar acompanhando o bebê em suas aventuras mesmo maiorzinho.\r\n\r\nMuito confortável, tem assento reclinável em múltiplas posições e fechamento simplificado com apenas uma das mãos. A alça telescópica pode ser levantada e recolhida facilmente para levar de um lugar a outro, mesmo em viagens. Leve, com estrutura em alumínio. Conta com ajuste para o apoio dos pés, barra frontal removível e ampla capota retrátil, com visor e FPS UV+, que vai oferecer a proteção necessária nos dia mais ensolarados. Além disso, tem cinto de cinco pontos com ajuste de altura e largura, rodas dianteiras giratórias com trava de movimento, freios interligados e cesto porta-objetos com capacidade para 2 kg.\r\n\r\nMonte o seu conjunto de viagem: acompanha adaptadores para encaixe do bebê conforto Bliss (bebê conforto vendido separadamente).\r\n\r\nAprovado pelo INMETRO conforme a norma ABNT NBR 14.389 para crianças do nascimento aos 15kg.  \r\n\r\nFechamento compacto com apenas uma das mãos\r\nAlça telescópica para levar como uma mala\r\nEstrutura leve em alumínio\r\nAmpla capota retrátil, com visor e FPS UV+\r\nMúltiplas posições de inclinação\r\nApoio para os pés ajustável\r\nBarra frontal removível\r\nCesto porta-objetos ', 28, '2025-11-21 13:13:33', '2026-06-14 21:44:54'),
(26, 'Cadeira para Automóvel Fisher Price All-Stages FIX 2.0 0 a 36kg - F02', '/images/produtos/1764808351_6930d69f57e03.webp', 'Fisher Price ', 'Isofix e Top Tether ou cinto de segurança', '', 20.00, 16.00, 13.00, 'Especialmente desenvolvida pensando no conforto da criança, essa cadeira conta com enchimento com o dobro de espuma, tornando o toque muito mais macio e garantindo proteção e bem-estar para seu bebê.\r\nEla também possui protetor de cabeça removível, almofada interna para recém-nascidos e uma ótima inclinação de até 145° para garantir a posição correta para os mais pequenos, evitando desconforto e garantindo maior segurança.\r\nAlém disso, o modelo All-Stages FIX 2.0 possui cinto de segurança ajustável, 14 posições para acompanhar o crescimento da criança e instalação Isofix que garante uma montagem muito mais fácil, rápida e segura.\r\nCom uma coloração neutra e um design primoroso, essa cadeira para auto é perfeita para meninos e meninas usarem até completarem 36kg, ou seja, é indicada para todos os grupos (0, I, II e III).', 15, '2025-12-04 00:32:31', '2026-06-14 21:29:54'),
(27, 'Berço Desmontável Portátil Serenata Burigotto  + Colchonete ', '/images/produtos/1764810294_6930de364a664.webp', 'Burigotto', '', '', 15.00, 13.00, 12.00, 'Colchonete\r\nDobrável.\r\nCapacidade:  0-18kg\r\nO Berço Desmontável Portátil Serenata Black Burigotto é perfeito para garantir o conforto e a segurança do seu bebê durante viagens e passeios. Com um design elegante na cor preta, ele se adapta facilmente a qualquer ambiente.\r\n\r\nCom sua estrutura dobrável, o berço é prático de transportar e armazenar, ocupando pouco espaço. Além disso, possui rodas que facilitam a locomoção, tornando-o ideal para uso em diferentes cômodos da casa ou em viagens.\r\n\r\nO berço é adequado para crianças de 0 a 3 anos, suportando um peso máximo de 15 kg. Sua base acolchoada proporciona conforto extra ao bebê, enquanto as travas de segurança garantem estabilidade e proteção.', 43, '2025-12-04 01:04:54', '2026-06-14 21:44:38'),
(28, 'Cadeira Litet para Auto 0-36 Kgs Isofix com Rotação LR03', '/images/produtos/1769558408_697951888f519.webp', 'Litet', 'Isofix e Top Tether ou cinto de segurança', 'Rotação 360°', 21.00, 17.00, 13.00, 'Com capacidade de uso até 36 kg, a Snugfix é uma companheira de longo prazo para o seu filho. Possui base com rotação de 360° e sistema Isofix para instalação segura.', 8, '2025-12-04 01:11:05', '2026-06-14 21:29:32'),
(29, 'Bebê Conforto Beta Voyage Cinza B03', '/images/produtos/1765040347_693460db942f9.webp', 'Voyage', 'Cinto de segurança ', '', 13.00, 12.00, 9.00, 'Bebê Conforto Infantil Beta Cinza Mescla- Voyage\r\n\r\n5 modos de uso fixo, balanço, transporte e instalação no carrinho e no automóvel. Almofada acolchoada e capota removível. Capa lavável na máquina.\r\nO Bebê Conforto Beta da Voyage tem estrutura leve, que facilita o transporte e a instalação no veículo. Item essencial para a segurança do seu filho, desde a saída da maternidade e em todos os passeios do bebê.\r\nAlça com 4 posições modos fixo, balanço, carregar e instalar no carro ou no carrinho. Com a alça ajustável para modo fixo ou balanço, é possível utilizar o Beta como uma cadeira de descanso, em casa, para deixar o bebê sempre próximo ou distraí lo com o modo balanço.\r\nConta ainda com almofadas redutoras super macias e acolchoadas para melhor adaptação dos recém nascidos. Os tecidos são macios para manter o conforto do bebê mesmo em viagens longas e a capota é removível, para uso em ambientes internos.', 3, '2025-12-06 16:59:07', '2026-06-14 21:28:29'),
(30, 'Carrinho De Bebê Chicco London Up Matrix Preto Leve Compacto - CH04', '/images/produtos/1765582274_693ca5c2a318a.webp', 'Chicco', '', '', 15.00, 13.00, 12.00, 'O carrinho de bebê é um item essencial para pais e cuidadores, oferecendo mobilidade e conforto para os pequenos. Com designs modernos, eles são seguros e práticos para o dia a dia. Modelos compactos, com assentos reclináveis, e sistemas de viagem adaptáveis garantem versatilidade. O carrinho de bebê passeio da Chicco é reclinável em 04 posições com assento regulável. Suporta até 15kg e apoio ajustável para pernas, tornando o carrinho London ideal para todas as situações. Conta com assento espaçoso, com encosto rígido e cinto de 5 pontos, garantindo máximo conforto e segurança para o bebê. No momento de carregá-lo, não é necessário se preocupar: o carrinho London é compacto também quando fechado, com fechamento guarda-chuva.', 32, '2025-12-12 23:31:14', '2026-06-14 21:44:50'),
(32, 'Banheira Dobrável Infantil  49l Portá B01', '/images/produtos/1777660306_69f4f192826f6.jpeg', 'Eco Aventura', '', '', 6.00, 6.00, 5.00, 'A Banheira Smile da Safety 1st foi criada para aquele momento delicioso e refrescante do banho seja repleto de alegria para o bebê, com a tranquilidade que os pais precisam, desde o primeiro banho, proporcionada pelo redutor que traz confiança e mais segurança para a realização desta tarefa. O redutor foi confeccionado em tela, macio e de secagem rápida, tem encaixe super fácil, para maior praticidade no uso diário. Falando em praticidade, possui saboneteira, válvula para esvaziamento, feita em borracha macia e o fechamento compacto tanto para armazenar em pequenos espaços ou levar, o que torna a Smile a companheira inseparável do seu bebê.', 44, '2025-12-16 00:40:09', '2026-06-14 21:44:38'),
(33, 'Cadeira para Auto Snugfix 360º Rotacional  - Fisher Price - FR02', '/images/produtos/1766011513_694332790f9d9.webp', 'Fisher Price ', 'Isofix e Top Tether ou cinto de segurança', '', 21.00, 17.00, 13.00, 'Principais Características:\r\n- SIP: Proteção extra lateral - Maior segurança em caso de colisão\r\n- Isofix: A instalação pode ser feita com o cinto do carro ou Isofix\r\n- Encosto da Cabeça: 13 opções de ajuste na altura do encosto de cabeça\r\n- Base giratória em 360º - Maior facilidade de colocar e tirar a criança da cadeira\r\n- Reclínio Perfeito: 4 opções de reclínios para o maior conforto da criança.\r\n\r\nEspecificações Técnicas:\r\n- Base para Automóvel\r\n- Base Ajustável e Giratória\r\n- Para crianças de 0 a 36Kg (0+, I,II,III)\r\n- Cinto de Segurança: 5 pontos, ajustável em até 3 alturas.\r\n- Compatível com o Cinto de Segurança do Carro\r\n- Certificado pelos Órgãos Autorizados - OCP’S (Organismos de Certificação de Produtos)', 11, '2025-12-17 22:45:13', '2026-06-14 21:28:19'),
(34, 'Cadeira de Carro All Stages 2.0 Isofix 0-36kgs Preto – Litet - LT02', '/images/produtos/1766011914_6943340ad74f1.webp', 'Litet', 'Isofix e Top Tether ou cinto de segurança', '', 20.00, 16.00, 13.00, 'Desenvolvida com tecnologia de retenção Isofix e Top Tether, a All Stages 2.0 garante a máxima segurança para o seu pequeno desde o nascimento até os 36kgs!\r\nSeu sistema Isofix é reversível e pode ser instalado em todos os grupos. Conta com cinto de segurança de 5 pontos com 3 posições de ajuste de altura para acompanhar o crescimento do seu bebê, e, além disso, possui 4 posições de recline de encosto com ângulos de inclinação super confortáveis. O estofado possui o dobro de espuma e seu tecido de alta qualidade é removível, facilitando a higiene regular. Ela também acompanha almofada redutora de corpo e cabeça para acomodar melhor os bebês menores.', 13, '2025-12-17 22:51:54', '2026-06-14 21:29:48'),
(35, 'Cadeira Para Auto Fisher Price All-Stages Fix Até 36 Kg - F01', '/images/produtos/1766428442_69498f1aa6d52.jpg', 'Fisher Price ', 'Isofix e Top Tether ou cinto de segurança', '', 20.00, 16.00, 13.00, 'Com a cadeira para auto da Multikids Baby os passeios de carro ficarão mais confortáveis para as crianças, pois possui proteção lateral contra impactos fornecendo maior segurança para a cabeça, corpo e quadris. Encosto de cabeça ajustável com 14 posições que acompanham o crescimento da criança. 4 posições de reclínio ativadas com apenas uma mão, para maior conforto das crianças. Cinto de 5 pontos, 3 posições de altura mantém o bebê confortável e seguro. Estofado removível feito de tecidos de alta qualidade para uma higiene regular. Feito para crianças de 0 a 36kg , 0, i, ii, iii. Imagens meramente ilustrativas.', 14, '2025-12-22 18:34:02', '2026-06-14 21:29:54'),
(36, 'Cadeira de Alimentação Toast : A3', '/images/produtos/1766848089_694ff6594b337.jpeg', 'Toast', 'Cinto ', '', 7.00, 6.00, 5.00, 'Até 15 kg', 36, '2025-12-27 15:08:09', '2026-06-14 21:44:44'),
(38, 'Berço Portátil Infantil Cercado Lune Maxi Baby + colchão - CE04', '/images/produtos/1767809633_695ea2618d642.jpeg', 'Máxi Baby', '', '', 18.00, 15.00, 13.00, 'Capacidade 15 kg ', 41, '2026-01-07 18:13:53', '2026-06-14 21:44:38'),
(39, '2 Assento Burigotto - A02', '/images/produtos/1768487922_6968fbf2f0f2b.jpeg', 'Burigotto', '', '', 7.00, 6.00, 5.00, 'Assento ', 20, '2026-01-15 14:38:43', '2026-06-14 21:33:36'),
(40, 'Carrinho Ping 3 Trekking ABC Capacidade 22 Kg AB04', '/images/produtos/1769368259_69766ac3b8b14.jpeg', 'ABC  Design', '', '', 17.00, 14.00, 13.00, 'Carrinho Ping 3 Trekking ABC Design, o companheiro perfeito para famílias que vivem em movimento. Para uso do nascimento até aproximadamente 3 anos (até no máximo 22 kg conforme normas europeias).\r\n\r\nDe fácil manuseio e mecanismo dobrável no fechamento.\r\nNosso carrinho de viagem Ping 3 Trekking é compacto e pode ser levado no avião como bagagem de mão.\r\n\r\nDESIGN ULTRALEVE E COMPACTO\r\nRodas leves e sem câmara, com suspensão individual e no eixo traseiro, garantem um passeio suave em qualquer superfície. Cesto inferior suporta até 5 kg para compras e o carrinho acompanha bolsa e alça para transporte, com dimensões pensadas para facilitar cada aventura com o bebê.\r\n\r\nCONFORTO AJUSTÁVEL PARA O BEBÊ\r\nEncosto super acolchoado com várias posições, incluindo modo deitar totalmente plano, além de apoio para os pés ajustável em duas alturas. Assim, o bebê tem o máximo de conforto em qualquer situação, seja para tirar uma soneca ou acompanhar tudo ao redor durante o passeio.', 27, '2026-01-25 19:10:59', '2026-06-14 21:44:54'),
(41, 'Cadeira Auto 0-36kg Isofix Rotação Litet Preto/cinza LR02', '/images/produtos/1769558018_69795002585fa.webp', 'Litet ', 'Isofix ', '', 21.00, 17.00, 14.00, 'Com formato inspirado na aparência e funcionalidade dos casulos, a cadeirinha Snugfix foi desenvolvida para proporcionar a sensação de ninho aos recém nascidos.\r\nJuntamente com as almofadas redutoras, ela acomoda perfeitamente os bebês menores, trazendo segurança para os pais e conforto para o bebê. Seu alcance, no entanto, é até os 36 kg, e para acompanhar os pequenos durante essa longa jornada, a Snugfix é versátil e adaptável.\r\n\r\nSão 4 posições de recline de encosto para que a criança esteja sempre confortável, 13 posições de altura de apoio de cabeça e o cinto de 5 pontos, que se ajusta de maneira automática de acordo com a posição escolhida do apoio de cabeça.\r\n\r\nO ajuste automático do cinto, além de trazer facilidade, garante a instalação e acomodação correta da criança mais facilmente.\r\n\r\nA base com rotação 360 descomplica a missão de tirar e colocar a criança do carro e permite que o isofix seja usado em todos os grupos. Apesar de o modo de retenção principal ser o isofix, a Snugfix também pode ser instalada com o cinto de segurança do veículo em todos os grupos. Seu tecido é extremamente macio, com toque suave à pele e 100% removível para facilitar na higienização.', 7, '2026-01-27 13:13:08', '2026-06-14 21:29:29'),
(42, 'Carrinho De Bebe Compacto Mini  Abc Design Capacidade 22kg - AB01', '/images/produtos/1769520068_6978bbc438d71.jpeg', 'ABC Design ', '', 'Cap Até 22kg', 17.00, 14.00, 13.00, 'O carrinho de passeio ultracompacto ABC Design Mini é um modelo popular que suporta até 22 kg e é conhecido por sua praticidade, leveza e design inteligente, sendo aceito na maioria das cabines de avião. \r\nCaracterísticas Principais\r\nCapacidade de Peso: Suporta até 22 kg, de acordo com as normas europeias, sendo adequado desde o nascimento (recém-nascido).\r\nDesign Ultracompacto: Possui um sistema de fechamento rápido e prático, tornando-o extremamente compacto e fácil de transportar, ideal para viagens e rotinas corridas.\r\nPeso: É um carrinho leve, pesando apenas 7,60 kg, o que facilita o manuseio e transporte.\r\nConforto: O assento é reclinável para garantir o conforto do bebê, seja sentado ou deitado. Os tecidos premium são projetados para estimular a circulação de ar e possuem proteção solar 50+, além de serem resistentes à água e terem um toque macio.\r\nMobilidade: Conta com rodas giratórias 360° para facilitar a direção e manobras em diferentes superfícies.', 24, '2026-01-27 13:21:08', '2026-06-14 21:45:00'),
(43, '2 Carrinho De Bebe Compacto Mini  Abc Design Capacidade 22kg AB02', '/images/produtos/1769520184_6978bc3831d0b.jpeg', 'ABC Design loop', '', '', 17.00, 14.00, 13.00, 'O carrinho de passeio ultracompacto ABC Design Mini é um modelo popular que suporta até 22 kg e é conhecido por sua praticidade, leveza e design inteligente, sendo aceito na maioria das cabines de avião. \r\nCaracterísticas Principais\r\nCapacidade de Peso: Suporta até 22 kg, de acordo com as normas europeias, sendo adequado desde o nascimento (recém-nascido).\r\nDesign Ultracompacto: Possui um sistema de fechamento rápido e prático, tornando-o extremamente compacto e fácil de transportar, ideal para viagens e rotinas corridas.\r\nPeso: É um carrinho leve, pesando apenas 7,60 kg, o que facilita o manuseio e transporte.\r\nConforto: O assento é reclinável para garantir o conforto do bebê, seja sentado ou deitado. Os tecidos premium são projetados para estimular a circulação de ar e possuem proteção solar 50+, além de serem resistentes à água e terem um toque macio.\r\nMobilidade: Conta com rodas giratórias 360° para facilitar a direção e manobras em diferentes superfícies.', 25, '2026-01-27 13:23:04', '2026-06-14 21:45:00'),
(44, 'Bebê Conforto Com Base Burigotto Materna - B01', '/images/produtos/1769556389_697949a564d57.webp', 'Burigotto', 'Cinto de segurança com base', '', 16.00, 14.00, 12.00, 'Bebê conforto + Base, desenvolvido com uma estrutura em plástico de engenharia, leve e resistente, com a concha arredondada para balanço.\r\n\r\nCom alça que pode ser utilizada como apoio para facilitar o transporte do bebê. Possui cinto de segurança de 3 pontos com protetor acolchoado para os ombros do bebê. A capota é regulável e removível.\r\n\r\nACOMPANHA A BASE DO BEBÊ CONFORTO\r\n\r\nCARACTERÍSTICAS:\r\n- Protetor para a cabeça removível\r\n- Capota removível\r\n- Regulagem do cinto na altura dos ombros\r\n- Sistema central de ajuste do cinto\r\n- Alça de apoio e para transporte\r\n- Cinto de segurança de 3 pontos\r\n- Protetor acolchoado para os ombros\r\n- Estrutura em plástico de engenharia, leve e resistente\r\n- Concha arredondada para balanço', 1, '2026-01-27 23:26:29', '2026-06-14 19:43:34'),
(45, 'Carrinho De Bebê ABC Treviso 3 AB03', '/images/produtos/1770590332_6989107c9ba7b.jpeg', 'ABC Design', '', '', 17.00, 14.00, 13.00, 'Descrição do produto\r\n\r\nIndicação de Uso: 0-22kg\r\nO Carrinho Treviso 3 ABC Design, agora possui um design moderno com três rodas robustas ideais para qualquer terreno, além de incluir acabamento especial nas manoplas com costura à mão e pesando apenas 7,8 kg, a estrutura do carrinho Treviso 3 é leve e ultra resistente, composta de carbono e aço, proporcionando durabilidade e muita segurança. O Carrinho Treviso 3 ABC Design também possui as rodas dianteiras removíveis e giratórias 360° e podem ser travadas em uma única direção. As rodas traseiras são fixas no eixo que pode ser removido para limpeza e higienização, sendo Ideal para passeios ao ar-livre, possuindo também capota estendida com tecido tecnológico resistente a água e com fator de proteção solar 50+ para proteger a pele sensível do bebê contra os raios nocivos do sol.\r\n\r\nCaracterísticas:\r\n\r\n- Com uma estrutura totalmente dobrável, o modelo Treviso 3 possui fechamento envelope prático e rápido.\r\n- Com 3 tem rodas frontais giratórias 360º, que podem ser travadas em uma única direção para melhor performance em terrenos mais acidentados.\r\n- O Cesto de Objetos é espaçoso e suporta até 5 kg.\r\n- Capota com fator de proteção solar UV50+;\r\n- Resistente a água;\r\n- Tecido Poliéster;\r\n- Estrutura Aço Tubular + Carbono;\r\n- Roda Dianteira removível e eixo traseiro removível;\r\n- Cesto de Objetos;\r\n- Capota Estendida com visor;\r\n- Assento com 4 tipos de Inclinação;\r\n- Cinto de segurança 5 pontos com protetores;\r\n- Barra de proteção adicional;\r\n- Fácil fechamento;\r\n- Apoio ajustável para os Pés;\r\n', 26, '2026-02-08 22:38:52', '2026-06-14 21:45:00'),
(46, 'Carrinho De Carga Camping Praia Dobrável Premium + 50kg - CP01', '/images/produtos/1770592458_698918caba609.jpeg', 'BCX', '', 'Capacidade 100 kg', 16.00, 13.00, 12.00, 'TRANSPORTE MAIS FÁCIL E SEM ESFORÇO - Carrinho dobrável com estrutura em aço inoxidável que suporta até 100 kg, ideal para camping, praia, eventos e compras. Rodas dianteiras 360° garantem manobras precisas. Rodas traseiras texturizadas aumentam a aderência em areia, grama e pedras. Design compacto que abre e fecha em segundos.\r\nRESISTÊNCIA E DURABILIDADE PARA O DIA A DIA - Cesta com tecido impermeável e reforçado, fácil de limpar e feita para uso intenso. Estrutura sólida que aguenta peso com estabilidade. Componentes de alta qualidade para longa vida útil. Ideal para famílias, lojistas e aventureiros.\r\nCONFORTO NA PEGADA E POSTURA CORRETA - Alça ergonômica com regulagem de altura para diferentes usuários. Empunhadura confortável que reduz a fadiga em trajetos longos. Condução leve e estável mesmo com carga. Mais controle em espaços apertados ou movimentados.\r\nAMPLA CAPACIDADE, ESPAÇO MUITO BEM APROVEITADO - Leve mochilas, caixas, colchonetes, garrafas e equipamentos organizados. Volume interno otimizado com fácil acesso. Excelente para levar itens da família à praia ou camping. Mantém tudo no lugar durante o percurso.\r\nMOBILIDADE TOTAL EM QUALQUER TERRENO - Rodas 360° que giram sem travar para curvas rápidas. Traseiras maiores e texturizadas para tração extra. Deslocamento mais silencioso e estável. Perfeito para calçadas, gramados, areia e pisos irregulares.\r\nDOBRA RÁPIDA E ARMAZENAMENTO SEM COMPLICAÇÃO - Fecha em formato compacto para caber no porta‑malas e pequenos espaços. Nenhuma ferramenta necessária para abrir ou fechar. Ideal para apartamentos e depósitos. Sempre pronto para a próxima saída.', 33, '2026-02-08 23:14:18', '2026-06-14 21:44:50'),
(47, 'Cadeirinha com Isofix Road-X de 9 a 36kg, Cosco, Preto C002', '/images/produtos/1777659589_69f4eec54ae61.jpeg', 'Cosco ', 'Isofix ou cinto ', '', 15.00, 13.00, 12.00, 'Sistema de fixação ISOFIX\r\n2 ajustes da altura do cinto\r\nNão reclina e não possui redutor.', 18, '2026-04-27 14:25:31', '2026-06-14 21:30:15'),
(48, 'Carrinho De Bebê De Passeio Chicco Liteway 3 - CH03', '/images/produtos/1777300525_69ef742ddf4e4.jpeg', 'Chicco', '', 'Cap : 15 kg', 15.00, 12.00, 11.00, 'O Carrinho de Passeio - Liteway 3 da Chicco possui estilo e design inconfundível, para os pais e os pequenos que gostam de impressionar! As linhas modernas e elegantes possuem detalhes que o tornam totalmente exclusivo! É fácil de ser manuseado e transportado, graças às alças para transporte. Possui rodas ultra ágeis, o que garante facilidade para movê-lo em qualquer situação, até mesmo em espaços estreitos. O encosto pode ser reclinado em 5 diferentes posições, com apenas uma mão, o apoio de pernas é ajustável e garante a postura perfeita para a criança, desde o nascimento até aproximadamente os 3 anos de idade.', 31, '2026-04-27 14:35:25', '2026-06-14 21:44:50'),
(49, 'Bebê Conforto Com Base Burigotto Materna - B02', '/images/produtos/1781466372_6a2f050496f5c.jpeg', 'Buriggoto', 'Cinto ', '', 15.00, 13.00, 11.00, 'Bebê conforto desenvolvido com uma estrutura em plástico de engenharia, leve e resistente, com a concha arredondada para balanço.\r\n\r\nCom alça que pode ser utilizada como apoio para facilitar o transporte do bebê. Possui cinto de segurança de 3 pontos com protetor acolchoado para os ombros do bebê. A capota é regulável e removível.\r\n\r\nACOMPANHA A BASE DO BEBÊ CONFORTO\r\n\r\nCARACTERÍSTICAS:\r\n- Protetor para a cabeça removível\r\n- Capota removível\r\n- Regulagem do cinto na altura dos ombros\r\n- Sistema central de ajuste do cinto\r\n- Alça de apoio e para transporte\r\n- Cinto de segurança de 3 pontos\r\n- Protetor acolchoado para os ombros\r\n- Estrutura em plástico de engenharia, leve e resistente\r\n- Concha arredondada para balanço', 2, '2026-06-14 19:46:12', '2026-06-14 21:28:29'),
(50, 'Berço Portátil Infantil Cercado Lune Maxi Baby + colchão - CE05', '/images/produtos/1781469310_6a2f107e57c66.jpeg', 'Máxi Baby', '', '', 17.00, 15.00, 13.00, 'Capacidade 15kg', 42, '2026-06-14 20:35:10', '2026-06-14 21:44:38'),
(51, 'Assento infantil Burigotto A03', '/images/produtos/1781473078_6a2f1f36b7673.jpg', 'Burigotto', '', '', 7.00, 6.00, 5.00, 'ASSENTO', 21, '2026-06-14 21:37:58', '2026-06-14 21:38:34'),
(52, 'Cadeira Auto Protege Reclinável Mesclado Cinza - Burigotto - AP02', '/images/produtos/1781473472_6a2f20c0bacd5.webp', 'Burigotto', '', '', 11.00, 10.00, 9.00, 'Suporta crianças de 15 kg a 36 kg utilizando o cinto de segurança do veículo para fixação em grupos 2 e 3.\r\nPossui encosto regulável em 2 posições de inclinação para o posicionamento da coluna durante o trajeto.\r\nApoio de cabeça ajustável em 3 posições que acompanha o crescimento e a estatura da criança até os 8 anos.\r\nEstrutura com base fechada em plástico de engenharia que preserva o revestimento do banco automotivo.\r\nPermite a remoção do encosto para utilização como assento de elevação atendendo às necessidades do grupo 3.\r\nTecido removível que permite a higienização frequente para manter a conservação da superfície de contato.', 23, '2026-06-14 21:43:33', '2026-06-23 18:47:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id` int NOT NULL,
  `nome_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `local_entrega` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horario_entrega` time DEFAULT NULL,
  `local_devolucao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horario_devolucao` time DEFAULT NULL,
  `obs_logistica` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `forma_pagamento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PIX',
  `status` enum('pendente','entregue','concluido','cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendente',
  `arquivado` tinyint(1) NOT NULL DEFAULT '0',
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `reservas`
--

INSERT INTO `reservas` (`id`, `nome_completo`, `telefone`, `cpf`, `endereco`, `local_entrega`, `horario_entrega`, `local_devolucao`, `horario_devolucao`, `obs_logistica`, `data_inicio`, `data_fim`, `forma_pagamento`, `status`, `arquivado`, `criado_em`, `atualizado_em`, `deleted_at`) VALUES
(169, 'Tamyres Dimyle da Silva Carvalho', '(32) 99117‑0836‬', '021.451.356-42', 'Rua Victorio Justo Turola, 40 - Fontesville Juiz de Fora', 'Aeroporto', '09:30:00', 'Kasa Azul', NULL, 'OBS: JÁ PAGO R$ 70\r\nDevolução via Uber', '2026-05-07', '2026-05-13', 'PIX', 'concluido', 1, '2026-04-08 12:42:50', '2026-05-13 15:59:17', NULL),
(178, 'Kleber Andrade Oliveira', '+353838987213', '947.560.235-68', 'Irlanda', 'Aeroporto', '14:00:00', 'Aeroporto', '12:00:00', 'Ainda não definido o local da devolução, provavelmente aeroporto', '2026-05-11', '2026-05-25', 'PIX', 'concluido', 1, '2026-04-29 10:10:37', '2026-05-25 15:33:09', NULL),
(183, 'Felipe Reis Camargo Pacheco   ', '(61) 99876‑2144‬', '723.580.841-15', '', 'Aeroporto', '17:00:00', 'Aeroporto', NULL, 'Valor total com desconto R$ 420,00 contemplando entrega e devolução no Aeroporto . Pago 50% do valor.', '2026-05-24', '2026-06-05', 'PIX', 'concluido', 1, '2026-05-05 13:52:43', '2026-06-06 17:29:59', NULL),
(184, '~Sabiao', '(11) 98158‑7200', '947.560.235-68', '', 'Aeroporto', '13:00:00', '', NULL, 'Provável devolução na Unidas, aguardar contato para definir horário', '2026-05-12', '2026-05-18', 'PIX', 'concluido', 1, '2026-05-07 20:53:37', '2026-05-18 18:48:37', NULL),
(187, 'Renata Bitencourt de Souza Bezerra ', '‪+55 71 99303‑6233‬', '030.135.805-26', 'Rua Romulo Galvão, 258, Ed bosque das Mangueiras, Narandiba', '', NULL, '', NULL, 'Retirada Casa AZul', '2026-06-07', '2026-06-24', 'PIX', 'concluido', 1, '2026-05-11 13:35:28', '2026-06-24 21:22:47', NULL),
(188, '~Malta', '(71) 99993‑8160‬', '947.560.235-68', '', '', NULL, '', NULL, '', '2026-05-12', '2026-05-15', 'PIX', 'concluido', 1, '2026-05-12 13:54:25', '2026-05-18 09:34:54', NULL),
(189, 'Raphael dos Santos Martins', '11948863848', '014.218.125-09', 'Teste', 'Kasa Azul', '09:00:00', 'Kasa Azul', '10:00:00', 'Irão mandar o uber', '2026-05-13', '2026-05-15', 'PIX', 'concluido', 1, '2026-05-12 22:49:39', '2026-05-13 12:41:11', '2026-05-13 12:41:11'),
(190, 'Eloisa Veiga ', '‪+55 19 99584‑1245‬', '94756023568', '', 'Casa Azul', NULL, '', NULL, '', '2026-05-15', '2026-05-18', 'PIX', 'concluido', 1, '2026-05-15 15:41:00', '2026-05-18 18:48:33', NULL),
(191, 'Caroline dos santos', '‪+41 79 725 17 39‬', '70257211152', 'Endereço é fora : 28 rue Jacques Grosselin, 1227 carouge, Suíça', 'Aeroporto ', NULL, '', NULL, 'Foi aplicado um desconto e o valor total ficou de R$ 540,00 já pago 50% .', '2026-06-08', '2026-06-20', 'PIX', 'concluido', 1, '2026-05-17 12:28:58', '2026-06-21 16:44:42', NULL),
(192, 'Vinicius Rotondano Cam', '‪+55 98 98486‑2727‬', '94756023568', '', '', NULL, '', NULL, '', '2026-05-21', '2026-05-24', 'PIX', 'concluido', 1, '2026-05-23 23:40:42', '2026-05-25 15:33:16', NULL),
(193, '~Katia Rocha', '‪+55 71 99274‑2652‬', '94756023568', '', '', NULL, '', NULL, 'Casa Azul', '2026-05-25', '2026-06-01', 'PIX', 'concluido', 1, '2026-05-25 20:00:52', '2026-06-03 15:56:24', NULL),
(194, 'Natália Luiza de Souza Alves Avarenga', '+55 31 99848-0504', '09734308696', 'Rua Marino pinheiro de Souza150 AP:102 Bairro :Serrano , Cep: 30882655', 'Aeroporto de SSA', NULL, 'Aeroporto ', NULL, 'Foi aplicado desconto e o valor total ficou por R$ 270,00\r\nPago : 50% ', '2026-06-07', '2026-06-13', 'PIX', 'concluido', 1, '2026-05-27 23:07:50', '2026-06-13 16:39:34', NULL),
(195, '~Raissa Valença Nunes', '‪+55 79 99677‑2368‬', '94756023568', '', 'Casa Azul', NULL, '', NULL, '', '2026-06-04', '2026-06-08', 'PIX', 'concluido', 1, '2026-06-02 01:38:43', '2026-06-13 16:39:14', NULL),
(196, '~Kalila Amorim', '‪+55 51 98431‑2150‬', '94756023568', '', 'Aeroporto ', NULL, 'Aeroporto ', NULL, '', '2026-07-17', '2026-07-27', 'PIX', 'pendente', 0, '2026-06-02 19:12:58', '2026-06-05 19:59:43', NULL),
(197, '~💞Lù Dòrea👑', '‪+55 71 99301‑3513‬', '94756023568', '', '', NULL, '', NULL, '', '2026-05-28', '2026-06-01', 'PIX', 'concluido', 1, '2026-06-02 21:12:46', '2026-06-03 20:23:10', NULL),
(198, 'Deivide  Santos Andrade ', '7198349039', '034.105.265-52', 'R. Maringá 26-E\r\nJardim Nova Esperança ', 'Kasa Azul', NULL, '', NULL, '', '2026-06-22', '2026-06-27', 'PIX', 'entregue', 0, '2026-06-03 21:41:11', '2026-06-21 20:56:07', NULL),
(199, 'Vitor Leme de Menezes ', '11976293950', '', '', 'Hotel Deville ', '19:00:00', 'Hotel Deville ', '18:00:00', 'Entregue', '2026-06-04', '2026-06-14', 'PIX', 'concluido', 1, '2026-06-03 23:03:17', '2026-06-15 12:29:55', NULL),
(200, 'Stephanie Andrade', '71993710989', '', '', 'Kasa Azul', NULL, '', NULL, '', '2026-06-05', '2026-06-07', 'PIX', 'concluido', 1, '2026-06-04 12:06:26', '2026-06-10 20:08:24', NULL),
(201, '~Ana 🌸', '‪+55 61 98560‑0372‬', '94756023568', '', 'Casa Azul', NULL, '', NULL, '', '2026-06-06', '2026-06-10', 'PIX', 'concluido', 1, '2026-06-04 17:36:27', '2026-06-13 16:39:20', NULL),
(202, '~Ana Rosa Arruda', '‪+55 61 98134‑7317‬', '94756023568', '', 'Casa Azul', NULL, '', NULL, '', '2026-06-06', '2026-06-12', 'PIX', 'concluido', 1, '2026-06-04 18:30:16', '2026-06-13 16:39:25', NULL),
(203, '~Ju Viana Maron', '‪+55 71 98815‑2341‬', '94756023568', '', 'Casa Azul', NULL, '', NULL, '', '2026-06-26', '2026-07-04', 'PIX', 'entregue', 0, '2026-06-05 16:25:01', '2026-06-26 13:39:13', NULL),
(204, 'Joao Paulo Lima', '+55 71 99215-6455', '94756023568', '', 'Casa Azul ', NULL, '', NULL, '', '2026-06-06', '2026-06-29', 'PIX', 'concluido', 1, '2026-06-06 17:49:10', '2026-06-30 12:23:32', NULL),
(205, '~Anna Cláudia', '‪+55 77 99947‑8704‬', '94756023568', '', '', NULL, '', NULL, '', '2026-06-07', '2026-06-12', 'PIX', 'concluido', 1, '2026-06-07 12:40:26', '2026-06-13 19:40:34', NULL),
(206, '~Lucimara Cardoso', '‪+55 71 99714‑9927‬', '94756023568', '', 'Vai pedir Uber ', '19:07:00', '', NULL, '', '2026-06-19', '2026-06-29', 'PIX', 'pendente', 0, '2026-06-07 22:09:30', '2026-06-08 13:18:56', '2026-06-08 13:18:56'),
(207, '~Lucimara Cardoso', '‪+55 71 99714‑9927‬', '94756023568', '', 'Vai pedir Uber ', '19:07:00', '', NULL, '', '2026-06-19', '2026-06-29', 'PIX', 'pendente', 0, '2026-06-07 22:10:22', '2026-06-08 13:19:08', '2026-06-08 13:19:08'),
(208, '~Lucimara Cardoso', '‪+55 71 99714‑9927‬', '94756023568', '', 'Vai pedir Uber ', '19:07:00', '', NULL, '', '2026-06-19', '2026-06-29', 'PIX', 'concluido', 1, '2026-06-07 22:10:42', '2026-06-30 18:10:34', NULL),
(209, '~Paulo ', '‪+55 11 96450‑1474‬', '94756023568', '', 'Casa Azul', NULL, '', NULL, '', '2026-06-10', '2026-06-22', 'PIX', 'concluido', 1, '2026-06-10 20:08:01', '2026-06-22 17:38:07', NULL),
(210, '~Mila Barbosa', '‪+55 71 98524‑4652‬', '71981935612', '', 'Casa Azul ', '11:00:00', '', NULL, '', '2026-06-13', '2026-06-15', 'PIX', 'concluido', 1, '2026-06-12 18:21:54', '2026-06-16 12:43:06', NULL),
(211, '~Claudio Garcia', '‪+55 51 99869‑3321‬', '94756023568', '', 'Casa Azul ', NULL, '', NULL, '', '2026-06-14', '2026-06-20', 'PIX', 'concluido', 1, '2026-06-12 21:06:59', '2026-06-21 16:44:14', NULL),
(212, '~Laura Reis', '‪+55 11 95530‑3883‬', '94756023568', 'Na quarta-feira quem irá retirar será o motorista, weldon. Ele ja conhece o local pq ja aluguei com vocês no final do ano.', 'Casa Azul ', NULL, '', NULL, '', '2026-06-17', '2026-06-25', 'PIX', 'concluido', 1, '2026-06-13 16:36:50', '2026-06-25 14:14:36', NULL),
(213, '~Natasha', '‪+55 71 99910‑5449‬', '94756023568', '', 'Casa Azul ', NULL, '', NULL, '', '2026-06-20', '2026-06-26', 'PIX', 'pendente', 1, '2026-06-13 17:26:14', '2026-06-19 11:54:46', NULL),
(214, '~Sarah Esquivel', '‪+55 19 98451‑6910‬', '94756023568', '', 'Casa Azul', NULL, '', NULL, '', '2026-06-14', '2026-06-30', 'PIX', 'concluido', 1, '2026-06-13 17:36:42', '2026-06-30 18:10:49', NULL),
(215, 'Jessica ', '‪+55 71 99637‑6086‬', '94756023568', '', 'Casa Azul ', NULL, '', NULL, '', '2026-06-19', '2026-06-25', 'PIX', 'concluido', 1, '2026-06-15 17:16:33', '2026-06-25 14:14:43', NULL),
(216, '~Tarcio', '‪+55 71 99722‑9473‬', '94756023568', '', 'Casa Azul', NULL, '', NULL, '', '2026-06-19', '2026-06-26', 'PIX', 'concluido', 1, '2026-06-17 01:27:54', '2026-06-27 12:22:47', NULL),
(217, '~Marina Bortoluzzi', '‪+55 54 99113‑0307‬', '94756023568', '', 'Aeroporto ', '17:50:00', '', NULL, 'Entrega Aeroporto cliente não vai alugar carro ', '2026-06-20', '2026-06-25', 'PIX', 'concluido', 1, '2026-06-18 16:32:32', '2026-06-25 11:53:59', NULL),
(218, 'Weler da Silva Mendes', '19994770277', '42227907840', 'Santa Bárbara do Oeste', '', NULL, '', NULL, '', '2026-06-18', '2026-06-25', 'PIX', 'concluido', 1, '2026-06-18 16:59:48', '2026-06-25 18:31:11', NULL),
(219, '~Gabrielle Bezerra', '‪+55 87 99187‑1379‬', '94756023568', 'Entrega em Lauro ', '', NULL, '', NULL, '', '2026-06-21', '2026-06-29', 'PIX', 'concluido', 1, '2026-06-19 00:38:15', '2026-06-30 12:23:15', NULL),
(220, '~Mila Barbosa', '‪+55 71 98524‑4652‬', '94756023368', '', '', NULL, '', NULL, '', '2026-06-21', '2026-06-25', 'PIX', 'concluido', 1, '2026-06-19 11:21:11', '2026-06-28 16:53:32', NULL),
(221, 'Marcleide', '71986344567', '06450269561', 'Volina Azul- Pau da Lima ', 'Uber ebtrega', NULL, '', NULL, '', '2026-06-20', '2026-06-25', 'PIX', 'concluido', 1, '2026-06-19 17:09:35', '2026-06-25 18:42:10', NULL),
(222, 'Natacia dos Santos Teles', '75981679329', '', 'Pagou 153,00 Pity deu desconto. ', '', NULL, '', NULL, 'Uber pegou na kasa Azul', '2026-06-20', '2026-06-29', 'PIX', 'concluido', 1, '2026-06-20 11:12:30', '2026-06-30 12:22:39', NULL),
(223, 'Jorge ', '71981560730', '', 'Pagou em dinheiro,  devo 20,00 de troco ', 'Kasa Azul ', NULL, '', NULL, '', '2026-06-20', '2026-06-24', 'PIX', 'concluido', 1, '2026-06-20 18:10:47', '2026-06-24 15:57:49', NULL),
(224, 'MARLON', '71982870906', '', 'Vai pagar 250,00quando receber os ítens. Marco deu desconto. ', 'Kasa Azul ', NULL, '', NULL, '', '2026-06-20', '2026-06-30', 'PIX', 'concluido', 1, '2026-06-20 18:14:32', '2026-06-30 18:11:01', NULL),
(225, 'Milena Bacelar', '71983918509', '', '', 'Kasa Azul ', '08:00:00', '', NULL, 'Á pagar 70,00 na retirada', '2026-06-22', '2026-06-25', 'PIX', 'concluido', 1, '2026-06-22 10:49:14', '2026-06-25 18:30:52', NULL),
(226, '~Raissa Valença Nunes', '‪+55 79 99677‑2368‬', '94756023568', '', '', NULL, '', NULL, '', '2026-06-23', '2026-06-30', 'PIX', 'concluido', 1, '2026-06-22 12:15:35', '2026-06-30 22:43:10', NULL),
(227, 'Erica ', '‪+55 71 98191‑1967‬', '94756023568', '', 'Retirada Casa Azul ', '07:30:00', '', NULL, '', '2026-06-26', '2026-06-29', 'PIX', 'concluido', 1, '2026-06-23 22:58:21', '2026-06-29 10:27:11', NULL),
(228, 'Jessyka Silva Castilho', '‪+55 61 98412‑6129‬', '02823394184', 'Endereço: Brasília/DF (71907-000)\r\nBairro: Águas Claras, Quadra 102 lote 5 Bloco B apto 1402 Praça Perdiz Residencial Matisse Antares', 'Aeroporto e Stella Mares ', NULL, 'Aeroporto e Stella Mares ', NULL, 'Foi realizado um desconto . E a cliente realizou o pagamento de 50% do valor total R$ 271,00', '2026-12-26', '2027-01-03', 'PIX', 'pendente', 0, '2026-06-24 18:01:38', '2026-06-24 18:03:12', NULL),
(229, 'Olane Alves', '77998175843', '', '', 'Kasa Azul ', NULL, '', NULL, '', '2026-06-25', '2026-06-26', 'PIX', 'concluido', 1, '2026-06-25 14:44:18', '2026-06-26 23:15:17', NULL),
(230, 'Verônica ', '75982287308', '', '', 'Kasa Azul ', NULL, '', NULL, '', '2026-06-25', '2026-06-26', 'PIX', 'concluido', 1, '2026-06-25 14:47:06', '2026-06-26 12:09:44', NULL),
(231, 'Stephanie ', '71993710989', '', 'Vai devolver hoje mesmo, a noite, ficou 21,00', 'Kasa Azul', NULL, '', NULL, '', '2026-06-27', '2026-07-02', 'PIX', 'entregue', 0, '2026-06-26 13:26:31', '2026-07-01 21:43:09', NULL),
(232, 'Jaqueline ', '71 99407 6524', '', '', 'Kasa Azul ', NULL, '', NULL, 'Pagou aqui na hora', '2026-06-26', '2026-07-25', 'PIX', 'entregue', 0, '2026-06-27 10:10:15', '2026-06-27 10:13:26', NULL),
(233, '~Michelle Aliaga', '‪+56 9 9092 4930‬', '94756023568', '', 'Casa Azul ', NULL, '', NULL, '', '2026-06-28', '2026-07-05', 'PIX', 'entregue', 0, '2026-06-28 20:45:32', '2026-06-28 20:45:43', NULL),
(234, 'Vitor Leme de Menezes ', '11976293950', '', '', 'Gran Hotel Stella Maris ', '17:30:00', '', NULL, '', '2026-07-02', '2026-07-12', 'PIX', 'entregue', 0, '2026-07-01 11:49:41', '2026-07-01 21:41:14', NULL),
(235, 'Marly Moraes', '71 991511000', '', 'Vila militar- Itapuã ', 'Kasa Azul', NULL, '', NULL, '', '2026-06-30', '2026-07-01', 'PIX', 'concluido', 1, '2026-07-01 11:53:50', '2026-07-01 11:54:47', NULL),
(236, 'Vitor Leme de Menezes ', '11976293950', '', '', 'Gran Hotel Stella Maris ', NULL, '', NULL, '', '2026-07-03', '2026-07-05', 'PIX', 'entregue', 0, '2026-07-01 12:32:59', '2026-07-01 21:41:32', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva_produtos`
--

CREATE TABLE `reserva_produtos` (
  `id` int NOT NULL,
  `reserva_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `valor_cobrado` decimal(10,2) NOT NULL DEFAULT '0.00',
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `reserva_produtos`
--

INSERT INTO `reserva_produtos` (`id`, `reserva_id`, `produto_id`, `valor_cobrado`, `criado_em`) VALUES
(366, 188, 3, 21.00, '2026-05-12 23:40:53'),
(367, 169, 3, 17.00, '2026-05-12 23:41:53'),
(368, 169, 45, 14.00, '2026-05-12 23:41:53'),
(387, 189, 29, 13.00, '2026-05-13 00:58:59'),
(388, 189, 12, 21.00, '2026-05-13 00:58:59'),
(389, 189, 33, 21.00, '2026-05-13 00:58:59'),
(391, 190, 25, 17.00, '2026-05-15 15:41:23'),
(401, 184, 33, 17.00, '2026-05-18 09:36:52'),
(403, 192, 26, 20.00, '2026-05-23 23:43:53'),
(407, 178, 38, 15.00, '2026-05-25 15:32:41'),
(408, 178, 21, 10.00, '2026-05-25 15:32:41'),
(409, 193, 34, 16.00, '2026-05-25 20:00:52'),
(411, 187, 43, 13.00, '2026-05-26 17:23:45'),
(424, 194, 19, 15.00, '2026-05-29 02:09:29'),
(425, 194, 38, 15.00, '2026-05-29 02:09:29'),
(426, 194, 46, 8.60, '2026-05-29 02:09:29'),
(430, 196, 46, 13.00, '2026-06-02 19:13:35'),
(431, 196, 35, 16.00, '2026-06-02 19:13:35'),
(432, 195, 14, 20.00, '2026-06-02 20:14:40'),
(433, 197, 4, 17.00, '2026-06-02 21:12:46'),
(434, 198, 4, 14.00, '2026-06-03 21:41:11'),
(443, 200, 33, 21.00, '2026-06-04 12:06:26'),
(444, 201, 26, 20.00, '2026-06-04 17:36:27'),
(445, 201, 15, 6.00, '2026-06-04 17:36:27'),
(446, 202, 5, 8.00, '2026-06-04 18:30:16'),
(448, 183, 9, 15.00, '2026-06-05 19:59:29'),
(449, 183, 8, 4.31, '2026-06-05 19:59:29'),
(450, 183, 46, 13.00, '2026-06-05 19:59:29'),
(451, 204, 35, 13.00, '2026-06-06 17:49:10'),
(452, 205, 23, 15.00, '2026-06-07 12:40:26'),
(453, 206, 15, 6.00, '2026-06-07 22:09:30'),
(455, 207, 15, 6.00, '2026-06-07 22:10:22'),
(460, 208, 15, 6.00, '2026-06-07 22:12:59'),
(461, 199, 40, 17.00, '2026-06-10 20:05:30'),
(462, 199, 1, 13.00, '2026-06-10 20:05:30'),
(464, 191, 44, 13.00, '2026-06-10 20:10:32'),
(465, 191, 43, 14.00, '2026-06-10 20:10:32'),
(466, 191, 19, 13.55, '2026-06-10 20:10:32'),
(467, 191, 15, 1.00, '2026-06-10 20:10:32'),
(469, 210, 38, 18.00, '2026-06-12 21:02:32'),
(470, 210, 3, 21.00, '2026-06-12 21:02:32'),
(471, 211, 47, 13.00, '2026-06-12 21:06:59'),
(472, 212, 28, 17.00, '2026-06-13 16:36:50'),
(473, 213, 34, 16.00, '2026-06-13 17:26:14'),
(474, 214, 14, 13.00, '2026-06-13 17:36:42'),
(475, 215, 35, 16.00, '2026-06-15 17:16:33'),
(476, 216, 24, 17.00, '2026-06-17 01:27:54'),
(477, 217, 1, 12.00, '2026-06-18 16:32:32'),
(479, 218, 12, 17.00, '2026-06-18 17:41:54'),
(480, 219, 28, 17.00, '2026-06-19 00:38:15'),
(481, 219, 15, 6.00, '2026-06-19 00:38:15'),
(482, 220, 33, 21.00, '2026-06-19 11:21:11'),
(483, 220, 18, 17.00, '2026-06-19 11:21:11'),
(484, 221, 3, 17.00, '2026-06-19 17:09:35'),
(485, 222, 26, 16.00, '2026-06-20 11:12:30'),
(486, 209, 35, 16.00, '2026-06-20 17:52:06'),
(487, 223, 35, 16.00, '2026-06-20 18:10:47'),
(492, 224, 2, 12.00, '2026-06-20 19:55:45'),
(493, 224, 26, 15.00, '2026-06-20 19:55:45'),
(495, 225, 47, 15.00, '2026-06-22 10:50:08'),
(496, 226, 12, 17.00, '2026-06-22 12:15:35'),
(497, 227, 5, 11.00, '2026-06-23 22:58:21'),
(502, 228, 3, 15.00, '2026-06-24 18:03:12'),
(503, 228, 41, 15.00, '2026-06-24 18:03:12'),
(504, 228, 18, 15.00, '2026-06-24 18:03:12'),
(505, 228, 19, 15.00, '2026-06-24 18:03:12'),
(506, 229, 3, 20.00, '2026-06-25 14:44:18'),
(507, 230, 24, 20.00, '2026-06-25 14:47:06'),
(508, 203, 43, 14.00, '2026-06-26 10:14:27'),
(511, 232, 1, 5.00, '2026-06-27 10:13:26'),
(512, 233, 14, 16.00, '2026-06-28 20:45:32'),
(513, 233, 5, 10.00, '2026-06-28 20:45:32'),
(518, 235, 29, 15.00, '2026-07-01 11:54:23'),
(521, 234, 45, 16.00, '2026-07-01 12:31:25'),
(522, 236, 24, 21.00, '2026-07-01 12:32:59'),
(523, 231, 3, 21.00, '2026-07-01 21:43:09');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ordem` (`ordem`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_data_inicio` (`data_inicio`),
  ADD KEY `idx_data_fim` (`data_fim`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_arquivado` (`arquivado`),
  ADD KEY `idx_deleted_at` (`deleted_at`);

--
-- Índices de tabela `reserva_produtos`
--
ALTER TABLE `reserva_produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reserva_produto` (`reserva_id`,`produto_id`),
  ADD KEY `idx_reserva_id` (`reserva_id`),
  ADD KEY `idx_produto_id` (`produto_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT de tabela `reserva_produtos`
--
ALTER TABLE `reserva_produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reserva_produtos`
--
ALTER TABLE `reserva_produtos`
  ADD CONSTRAINT `reserva_produtos_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserva_produtos_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
