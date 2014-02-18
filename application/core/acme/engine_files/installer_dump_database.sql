USE `<DATABASE>`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- ------------------------------------------------------
-- Server version	5.5.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acm_user`
--

DROP TABLE IF EXISTS `acm_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_group` int(11) NOT NULL,
  `login` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `url_img` text,
  `url_img_large` text,
  `observation` text,
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `acm_user_id_user_UNIQUE` (`id_user`),
  UNIQUE KEY `acm_user_login_UNIQUE` (`login`),
  KEY `fk_acm_user_acm_user_group` (`id_user_group`),
  CONSTRAINT `fk_acm_user_acm_user_group1` FOREIGN KEY (`id_user_group`) REFERENCES `acm_user_group` (`id_user_group`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_user`
--

LOCK TABLES `acm_user` WRITE;
/*!40000 ALTER TABLE `acm_user` DISABLE KEYS */;
INSERT INTO `acm_user` VALUES (1,1,'acmeengine','7c58c7b6630b6c2377b41a0c56cea568','ACME Engine - Usuário ROOT','leandro.w3c@gmail.com','<acme eval=\"URL_UPLOAD\" />/thumbnail_resize_51e07a6abff4b.jpg','<acme eval=\"URL_UPLOAD\" />/resize_51e07a6abff4b.jpg','',NULL,'2013-04-03 20:40:57');
/*!40000 ALTER TABLE `acm_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_log_error`
--

DROP TABLE IF EXISTS `acm_log_error`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_log_error` (
  `id_log_error` int(11) NOT NULL AUTO_INCREMENT,
  `error_type` varchar(50) DEFAULT NULL,
  `header` text,
  `message` text,
  `status_code` varchar(10) DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log_error`),
  UNIQUE KEY `acm_log_error_id_log_error_UNIQUE` (`id_log_error`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_log_error`
--

LOCK TABLES `acm_log_error` WRITE;
/*!40000 ALTER TABLE `acm_log_error` DISABLE KEYS */;
/*!40000 ALTER TABLE `acm_log_error` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_module_form`
--

DROP TABLE IF EXISTS `acm_module_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_module_form` (
  `id_module_form` int(11) NOT NULL AUTO_INCREMENT,
  `id_module` int(11) NOT NULL,
  `operation` varchar(45) DEFAULT NULL,
  `action` varchar(250) DEFAULT NULL,
  `method` varchar(20) DEFAULT NULL,
  `enctype` varchar(50) DEFAULT NULL,
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_module_form`),
  UNIQUE KEY `acm_module_form_id_module_form_UNIQUE` (`id_module_form`),
  KEY `fk_acm_module_form_acm_module` (`id_module`),
  CONSTRAINT `fk_acm_module_form_acm_module1` FOREIGN KEY (`id_module`) REFERENCES `acm_module` (`id_module`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_module_form`
--

LOCK TABLES `acm_module_form` WRITE;
/*!40000 ALTER TABLE `acm_module_form` DISABLE KEYS */;
INSERT INTO `acm_module_form` VALUES (2,6,'filter',NULL,NULL,NULL,NULL,'2013-04-03 21:16:33'),(3,6,'view',NULL,NULL,NULL,NULL,'2013-04-05 21:20:58'),(4,8,'delete',NULL,NULL,NULL,NULL,'2013-04-05 21:34:08'),(5,8,'view',NULL,NULL,NULL,NULL,'2013-04-05 21:34:08'),(6,8,'filter',NULL,NULL,NULL,NULL,'2013-04-05 21:46:38'),(23,3,'filter',NULL,NULL,NULL,NULL,'2013-05-10 15:11:44'),(24,4,'insert',NULL,NULL,NULL,NULL,'2013-07-09 14:58:51'),(25,4,'update',NULL,NULL,NULL,NULL,'2013-07-09 15:01:34'),(26,4,'view',NULL,NULL,NULL,NULL,'2013-07-09 15:02:37'),(27,4,'filter',NULL,NULL,NULL,NULL,'2013-07-09 15:03:51'),(28,6,'delete',NULL,NULL,NULL,NULL,'2013-07-09 22:16:34'),(29,19,'filter',NULL,NULL,NULL,NULL,'2013-07-24 16:56:14'),(30,19,'insert',NULL,NULL,NULL,NULL,'2013-07-24 17:11:42'),(31,19,'update',NULL,NULL,NULL,NULL,'2013-07-24 17:21:08'),(32,19,'view',NULL,NULL,NULL,NULL,'2013-07-24 17:28:34'),(33,19,'delete',NULL,NULL,NULL,NULL,'2013-07-24 17:31:00');
/*!40000 ALTER TABLE `acm_module_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_module_action`
--

DROP TABLE IF EXISTS `acm_module_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_module_action` (
  `id_module_action` int(11) NOT NULL AUTO_INCREMENT,
  `id_module` int(11) NOT NULL,
  `lang_key_rotule` varchar(250) DEFAULT NULL,
  `link` text,
  `target` varchar(50) DEFAULT NULL,
  `javascript` text,
  `url_img` text,
  `description` text,
  `order` int(11) DEFAULT NULL,
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_module_action`),
  UNIQUE KEY `acm_module_action_id_module_action_UNIQUE` (`id_module_action`),
  KEY `fk_acm_module_action_acm_module` (`id_module`),
  CONSTRAINT `fk_acm_module_menu_acm_module0` FOREIGN KEY (`id_module`) REFERENCES `acm_module` (`id_module`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_module_action`
--

LOCK TABLES `acm_module_action` WRITE;
/*!40000 ALTER TABLE `acm_module_action` DISABLE KEYS */;
INSERT INTO `acm_module_action` VALUES (3,6,'Visualizar Log','<acme eval=\"URL_ROOT\"/>/acme_log/form/view/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_view.png','Visualizar Log',NULL,NULL,'2013-04-05 21:20:20'),(4,8,'Deleção','<acme eval=\"URL_ROOT\"/>/acme_log_error/form/delete/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_delete.png','Deleção',NULL,NULL,'2013-04-05 21:34:08'),(5,8,'Visualização','<acme eval=\"URL_ROOT\"/>/acme_log_error/form/view/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_view.png','Visualização',NULL,NULL,'2013-04-05 21:34:08'),(14,3,'Gerência de Permissões','<acme eval=\"URL_ROOT\"/>/acme_user/permission_manager/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_permission_manager.png',NULL,10,NULL,'2013-04-08 15:40:07'),(27,4,'Editar','<acme eval=\"URL_ROOT\"/>/acme_user_group/form/update/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_update.png','Editar',30,NULL,'2013-07-09 15:01:23'),(28,4,'Visualizar','<acme eval=\"URL_ROOT\"/>/acme_user_group/form/view/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_view.png','Visualizar',30,NULL,'2013-07-09 15:02:35'),(29,6,'Deletar','<acme eval=\"URL_ROOT\"/>/acme_log/form/delete/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_delete.png','Deletar',30,NULL,'2013-07-09 22:16:34'),(30,3,'Editar','<acme eval=\"URL_ROOT\"/>/acme_user/form_update_custom/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_update.png',NULL,5,NULL,'2013-07-11 15:09:52'),(32,3,'Solicitar Alteração de Senha','<acme eval=\"URL_ROOT\" />/acme_user/reset_password/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_reset_password.png',NULL,20,NULL,'2013-07-12 13:52:59'),(33,3,'Visualizar Perfil de Usuário','<acme eval=\"URL_ROOT\" />/acme_user/user_profile/{0}',NULL,NULL,'<acme eval=\"URL_IMG\" />/icon_user_profile.png',NULL,25,NULL,'2013-07-12 17:32:57'),(35,18,'Detalhes do Pacote de Atualização','<acme eval=\"URL_ROOT\"/>/acme_updater/package_details/{0}','','','<acme eval=\"URL_IMG\"/>/icon_view.png','Detalhes do Pacote de Atualização',10,NULL,'2013-07-15 21:25:10'),(36,19,'Editar','<acme eval=\"URL_ROOT\"/>/acme_query_report/form/update/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_update.png','Editar',30,NULL,'2013-07-24 17:21:09'),(37,19,'Visualizar Dados do Relatório','<acme eval=\"URL_ROOT\"/>/acme_query_report/form/view/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_view.png','Visualizar',30,NULL,'2013-07-24 17:28:35'),(38,19,'Deletar','<acme eval=\"URL_ROOT\"/>/acme_query_report/form/delete/{0}',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_delete.png','Deletar',30,NULL,'2013-07-24 17:31:01'),(39,19,'Executar Relatório','<acme eval=\"URL_ROOT\"/>/acme_query_report/run_report/{0}','_blank',NULL,'<acme eval=\"URL_IMG\"/>/icon_run.png',NULL,5,NULL,'2013-07-24 17:35:29');
/*!40000 ALTER TABLE `acm_module_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_app_package_update_error_message`
--

DROP TABLE IF EXISTS `acm_app_package_update_error_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_app_package_update_error_message` (
  `id_app_package_update_error_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_app_package_update` int(11) NOT NULL,
  `message` text,
  `order` int(11) DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_app_package_update_error_message`),
  UNIQUE KEY `id_app_package_update_error_message_UNIQUE` (`id_app_package_update_error_message`),
  KEY `fk_acm_app_package_update_error_message_id_acm_package_update` (`id_app_package_update`),
  CONSTRAINT `fk_acm_app_package_update_error_message_id_acm_package_update` FOREIGN KEY (`id_app_package_update`) REFERENCES `acm_app_package_update` (`id_app_package_update`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_app_package_update_error_message`
--

LOCK TABLES `acm_app_package_update_error_message` WRITE;
/*!40000 ALTER TABLE `acm_app_package_update_error_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `acm_app_package_update_error_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_user_config`
--

DROP TABLE IF EXISTS `acm_user_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_user_config` (
  `id_user_config` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `lang_default` varchar(10) DEFAULT 'pt_BR',
  `url_default` text,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user_config`),
  UNIQUE KEY `acm_user_config_id_user_config_UNIQUE` (`id_user_config`),
  KEY `fk_acm_user_config_acm_user` (`id_user`),
  CONSTRAINT `fk_acm_user_config_acm_user1` FOREIGN KEY (`id_user`) REFERENCES `acm_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_user_config`
--

LOCK TABLES `acm_user_config` WRITE;
/*!40000 ALTER TABLE `acm_user_config` DISABLE KEYS */;
INSERT INTO `acm_user_config` VALUES (1,1,'pt_BR','<acme eval=\"URL_ROOT\"/>/acme_dashboard','2013-04-03 13:55:08');
/*!40000 ALTER TABLE `acm_user_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_app_config`
--

DROP TABLE IF EXISTS `acm_app_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_app_config` (
  `id_app_config` int(11) NOT NULL AUTO_INCREMENT,
  `config` varchar(250) DEFAULT NULL,
  `value` text,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_app_config`),
  UNIQUE KEY `acm_app_config_id_app_config_UNIQUE` (`id_app_config`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_app_config`
--

LOCK TABLES `acm_app_config` WRITE;
/*!40000 ALTER TABLE `acm_app_config` DISABLE KEYS */;
INSERT INTO `acm_app_config` VALUES (1,'app_logo','<acme eval=\"URL_IMG\"/>/logo.png','2013-04-03 12:51:22');
/*!40000 ALTER TABLE `acm_app_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_module_menu`
--

DROP TABLE IF EXISTS `acm_module_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_module_menu` (
  `id_module_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_module` int(11) NOT NULL,
  `lang_key_rotule` varchar(50) DEFAULT NULL,
  `link` text,
  `target` varchar(50) DEFAULT NULL,
  `javascript` text,
  `url_img` text,
  `description` text,
  `order` int(11) DEFAULT NULL,
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_module_menu`),
  UNIQUE KEY `acm_module_menu_id_module_menu_UNIQUE` (`id_module_menu`),
  KEY `fk_acm_module_menu_acm_module` (`id_module`),
  CONSTRAINT `fk_acm_module_menu_acm_module` FOREIGN KEY (`id_module`) REFERENCES `acm_module` (`id_module`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_module_menu`
--

LOCK TABLES `acm_module_menu` WRITE;
/*!40000 ALTER TABLE `acm_module_menu` DISABLE KEYS */;
INSERT INTO `acm_module_menu` VALUES (6,3,'Novo Usuário','<acme eval=\"URL_ROOT\"/>/acme_user/form_insert_custom',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_insert.png',NULL,10,NULL,'2013-04-08 15:43:51'),(15,4,'Novo Grupo de Usuário','<acme eval=\"URL_ROOT\"/>/acme_user_group/form/insert',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_insert.png',NULL,NULL,NULL,'2013-07-09 14:58:29'),(17,18,'Instalar Novo Pacote','<acme eval=\"URL_ROOT\"/>/acme_updater/package_install/','','','<acme eval=\"URL_IMG\"/>/icon_install_package.png','Instalar Novo Pacote',10,NULL,'2013-07-15 21:25:10'),(18,19,'Novo Relatório','<acme eval=\"URL_ROOT\"/>/acme_query_report/form/insert',NULL,NULL,'<acme eval=\"URL_IMG\"/>/icon_insert.png',NULL,10,NULL,'2013-07-24 17:11:43');
/*!40000 ALTER TABLE `acm_module_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_module`
--

DROP TABLE IF EXISTS `acm_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_module` (
  `id_module` int(11) NOT NULL AUTO_INCREMENT,
  `ini_file` text,
  `table` varchar(50) DEFAULT NULL,
  `controller` varchar(50) NOT NULL,
  `lang_key_rotule` varchar(250) NOT NULL,
  `sql_list` text,
  `items_per_page` int(11) DEFAULT '100',
  `url_img` text,
  `description` text,
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_module`),
  UNIQUE KEY `acm_module_id_module_UNIQUE` (`id_module`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_module`
--

LOCK TABLES `acm_module` WRITE;
/*!40000 ALTER TABLE `acm_module` DISABLE KEYS */;
INSERT INTO `acm_module` VALUES (1,NULL,'acm_module','acme_module_manager','Administração de Módulos',NULL,100,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/module_acme_module_manager.png','Este módulo lista outros módulos cadastrados no sistema. Utilize-o para gerenciar estes módulos editando preferências, permissões, formulários, etc., de cada um. Cada uma das linhas abaixo representa um módulo cadastrado e os ícones da esquerda representam ações disponíveis para cada um destes módulos.',NULL,'2013-04-03 13:47:49'),(2,NULL,NULL,'acme_maker','Maker',NULL,100,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/module_acme_maker.png',NULL,NULL,'2013-04-03 13:47:49'),(3,NULL,'acm_user','acme_user','Usuários','SELECT u.id_user AS \'#\',\n       u.name,\n       u.email,\n       u.login,\n       g.name as \'GROUP\',\n       CASE WHEN u.dtt_inative IS NULL THEN \'S\' ELSE \'N\' END AS ativo\n  FROM acm_user u \n  INNER JOIN acm_user_group g ON (g.id_user_group = u.id_user_group);',100,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/module_acme_user.png','Gerencie neste módulo os usuários cadastrados no sistema. Você pode criar um novo usuário, mas tenha certeza de ter criado um grupo para o qual este novo usuário irá pertencer. Altere ou visualize configurações do perfil de cada usuário através dos ícones da esquerda.',NULL,'2013-04-03 13:47:49'),(4,NULL,'acm_user_group','acme_user_group','Grupos de Usuários','SELECT g.id_user_group AS \'#\',\n	   g.name AS grupo,\n	   g.description\n  FROM acm_user_group g',100,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/module_acme_user_group.png','Este módulo exibe os grupos de usuário cadastrados no sistema. Cada usuário pertence a um grupo, e os menus do sistema são configurados e exibidos também por grupo. Tenha em mente isso!',NULL,'2013-04-03 13:47:49'),(5,NULL,NULL,'acme_dashboard','Dashboard',NULL,100,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/module_acme_dashboard.png',NULL,NULL,'2013-04-03 13:47:49'),(6,NULL,'acm_log','acme_log','Logs do Sistema','SELECT l.id_log AS \'#\',\n             u.login,\n             l.`table`,\n             l.action,\n             l.browser_name,\n             l.ip_address,\n             l.log_dtt_ins AS \'when\'\n  FROM acm_log l\n  INNER JOIN acm_user u ON (l.id_user = u.id_user)',20,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/module_acme_log.png','Logs registrados no sistema. Para cada registro de log é possível visualizar informações do usuário que o  disparou, como nome do browser, endereço ip, entre outros. Para mais detalhes de determinado log utilize o ícone de visualização a esquerda.',NULL,'2013-04-03 13:47:49'),(7,NULL,'acm_menu','acme_menu','Menus do Sistema','SELECT m.id_menu as \'#\',\n             mp.lang_key_rotule as menu_parent,\n             m.lang_key_rotule as menu_name,\n             g.name as `group`\n  FROM acm_menu m\n  LEFT JOIN acm_menu mp ON (mp.id_menu = m.id_menu_parent)\n  INNER JOIN acm_user_group g ON (g.id_user_group = m.id_user_group)\n  ORDER BY g.name, mp.id_menu, m.`order`',100,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/module_acme_menu.png','Este módulo lista e permite gerenciamento dos menus do sistema. Um conjunto de menus de sistema pertence a um grupo previamente cadastrado. Isso faz com que o grupo de usuário defina o menu que este usuário visualizará.',NULL,'2013-04-03 13:47:49'),(8,NULL,'acm_log_error','acme_log_error','Logs de Erros','SELECT * FROM acm_log_error',100,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/module_acme_log_error.png','Listagem de log de erros',NULL,'2013-04-05 21:33:26'),(14,NULL,NULL,'acme_session','Sessão',NULL,100,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/module_acme_session.png','Visualize neste módulo as variáveis de sessão atualmente registradas no sistema. No bloco abaixo você poderá visualizar o nome do índice da variável a esquerda, e a direita seu respectivo valor.',NULL,'2013-06-28 19:52:26'),(15,NULL,NULL,'acme_config','Variáveis e Constantes',NULL,100,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/module_acme_config.png','Visualize neste módulo as constantes e variáveis atualmente registradas no sistema. No bloco abaixo você poderá visualizar o nome do índice da variável ou constante a esquerda, e a direita o seu respectivo valor.\r\n\r\n<h6 class=\"font_error\">ATENÇÃO! A alteração dos valores de configurações e constantes é manual, para isto acesse o arquivo localizado /application/config/application_settings.php. Tenha em mente que algumas configurações são extremamente importantes para o funcionamento do restante do sistema.</h6>',NULL,'2013-06-28 20:19:15'),(18,NULL,NULL,'acme_updater','Atualizações',NULL,100,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/module_acme_updater.png',NULL,NULL,'2013-07-15 21:25:10'),(19,NULL,'acm_query_report','acme_query_report','Relatórios','SELECT r.id_query_report AS \'#\',\r\n       r.lang_key_rotule AS NOME,\r\n       r.description AS \'DESCRIÇÃO\'\r\n  FROM acm_query_report r ORDER BY id_query_report',100,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/module_acme_query_report.png','Utilize este módulo para criar, registrar e executar relatórios genéricos construídos através da linguagem SQL.',NULL,'2013-07-24 16:50:44');
/*!40000 ALTER TABLE `acm_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_user_bookmark`
--

DROP TABLE IF EXISTS `acm_user_bookmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_user_bookmark` (
  `id_user_bookmark` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `link` text,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user_bookmark`),
  UNIQUE KEY `acm_user_bookmark_id_user_bookmark_UNIQUE` (`id_user_bookmark`),
  KEY `fk_acm_user_bookmark_acm_user` (`id_user`),
  CONSTRAINT `fk_acm_user_config_acm_user10` FOREIGN KEY (`id_user`) REFERENCES `acm_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_user_bookmark`
--

LOCK TABLES `acm_user_bookmark` WRITE;
/*!40000 ALTER TABLE `acm_user_bookmark` DISABLE KEYS */;
/*!40000 ALTER TABLE `acm_user_bookmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_user_permission`
--

DROP TABLE IF EXISTS `acm_user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_user_permission` (
  `id_user_permission` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_module_permission` int(11) NOT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user_permission`),
  UNIQUE KEY `acm_user_permission_id_user_permission_UNIQUE` (`id_user_permission`),
  KEY `fk_acm_user_permission_acm_user` (`id_user`),
  KEY `fk_acm_user_permission_acm_module_permission` (`id_module_permission`),
  CONSTRAINT `fk_acm_user_permission_acm_module_permission1` FOREIGN KEY (`id_module_permission`) REFERENCES `acm_module_permission` (`id_module_permission`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_acm_user_permission_acm_user1` FOREIGN KEY (`id_user`) REFERENCES `acm_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_user_permission`
--

LOCK TABLES `acm_user_permission` WRITE;
/*!40000 ALTER TABLE `acm_user_permission` DISABLE KEYS */;
INSERT INTO `acm_user_permission` VALUES (1,1,1,'2013-04-03 13:55:47'),(2,1,2,'2013-04-03 13:55:47'),(3,1,3,'2013-04-03 13:55:47'),(4,1,4,'2013-04-03 13:55:47'),(5,1,5,'2013-04-03 13:55:47'),(6,1,6,'2013-04-03 13:55:47'),(7,1,7,'2013-04-03 13:55:47'),(8,1,8,'2013-04-03 13:55:47'),(9,1,9,'2013-04-03 13:55:47'),(10,1,10,'2013-04-04 15:24:38'),(11,1,15,'2013-04-05 21:23:49'),(13,1,19,'2013-04-05 21:35:52'),(14,1,20,'2013-04-05 21:35:52'),(17,1,28,'2013-04-08 15:41:21'),(18,1,21,'2013-04-08 15:42:48'),(36,1,53,'2013-06-26 18:27:18'),(37,1,52,'2013-06-26 19:30:00'),(38,1,54,'2013-06-26 20:10:03'),(39,1,55,'2013-06-28 19:57:05'),(41,1,18,'2013-07-09 13:45:11'),(42,1,59,'2013-07-09 15:05:55'),(43,1,57,'2013-07-09 15:05:57'),(44,1,58,'2013-07-09 15:05:58'),(45,1,60,'2013-07-09 15:05:59'),(46,1,61,'2013-07-11 14:10:24'),(47,1,62,'2013-07-11 14:10:25'),(52,1,63,'2013-07-12 19:30:53'),(53,1,64,'2013-07-14 20:01:22'),(54,1,66,'2013-07-15 14:31:48'),(55,1,65,'2013-07-15 14:31:48'),(95,1,67,'2013-07-15 18:49:45'),(96,1,71,'2013-07-15 21:27:29'),(97,1,72,'2013-07-15 21:27:30'),(98,1,73,'2013-07-15 21:27:30'),(99,1,78,'2013-07-24 17:04:06'),(100,1,74,'2013-07-24 17:04:06'),(101,1,75,'2013-07-24 17:04:07'),(102,1,79,'2013-07-24 17:04:08'),(103,1,76,'2013-07-24 17:04:08'),(104,1,77,'2013-07-24 17:04:09'),(106,1,56,'2013-07-24 17:04:38');
/*!40000 ALTER TABLE `acm_user_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_user_reset_password`
--

DROP TABLE IF EXISTS `acm_user_reset_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_user_reset_password` (
  `id_user_reset_password` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `key_access` text NOT NULL,
  `dtt_updated` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user_reset_password`),
  UNIQUE KEY `acm_user_reset_password_id_user_reset_password_UNIQUE` (`id_user_reset_password`),
  KEY `fk_acm_user_reset_password_acm_user` (`id_user`),
  CONSTRAINT `fk_acm_user_reset_password_acm_user1` FOREIGN KEY (`id_user`) REFERENCES `acm_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_user_reset_password`
--

LOCK TABLES `acm_user_reset_password` WRITE;
/*!40000 ALTER TABLE `acm_user_reset_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `acm_user_reset_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_log`
--

DROP TABLE IF EXISTS `acm_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `table` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `log` text,
  `array_data` text,
  `user_agent` text,
  `browser_name` varchar(50) DEFAULT NULL,
  `browser_version` varchar(50) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  UNIQUE KEY `acm_log_id_log_UNIQUE` (`id_log`),
  KEY `fk_acm_log_acm_user` (`id_user`),
  CONSTRAINT `fk_acm_log_acm_user1` FOREIGN KEY (`id_user`) REFERENCES `acm_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_log`
--

LOCK TABLES `acm_log` WRITE;
/*!40000 ALTER TABLE `acm_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `acm_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_module_permission`
--

DROP TABLE IF EXISTS `acm_module_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_module_permission` (
  `id_module_permission` int(11) NOT NULL AUTO_INCREMENT,
  `id_module` int(11) NOT NULL,
  `lang_key_rotule` varchar(250) DEFAULT NULL,
  `permission` varchar(50) NOT NULL,
  `description` text,
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_module_permission`),
  UNIQUE KEY `acm_module_permission_id_module_permission_UNIQUE` (`id_module_permission`),
  KEY `fk_acm_module_permission_acm_module` (`id_module`),
  CONSTRAINT `fk_acm_module_menu_acm_module00` FOREIGN KEY (`id_module`) REFERENCES `acm_module` (`id_module`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_module_permission`
--

LOCK TABLES `acm_module_permission` WRITE;
/*!40000 ALTER TABLE `acm_module_permission` DISABLE KEYS */;
INSERT INTO `acm_module_permission` VALUES (1,1,'Permissão de entrada do módulo','enter',NULL,NULL,'2013-04-03 13:54:35'),(2,1,'Configuração de formulários','config_forms',NULL,NULL,'2013-04-03 13:54:35'),(3,2,'Permissão de entrada','enter',NULL,NULL,'2013-04-03 13:54:35'),(4,2,'Criar novos módulos','create_module',NULL,NULL,'2013-04-03 13:54:35'),(5,3,'Permissão de entrada','enter',NULL,NULL,'2013-04-03 13:54:35'),(6,4,'Permissão de entrada','enter',NULL,NULL,'2013-04-03 13:54:35'),(7,5,'Visualizar dashboard','view_dashboard',NULL,NULL,'2013-04-03 13:54:35'),(8,6,'Permissão de entrada','enter',NULL,NULL,'2013-04-03 13:54:35'),(9,7,'Entrada do Módulo','enter',NULL,NULL,'2013-04-03 13:54:35'),(10,1,'Administrar Módulo','administration',NULL,NULL,'2013-04-04 15:24:20'),(15,6,'Visualização de Log','view','Esta permissão é testada quando há a tentativa de acesso à página de visualização de um registro de log.',NULL,'2013-04-05 21:23:33'),(16,8,'Inserção de Log de Erro','insert',NULL,NULL,'2013-04-05 21:34:08'),(17,8,'Edição de Log de Erro','update',NULL,NULL,'2013-04-05 21:34:08'),(18,8,'Deleção de Log de Erro','delete',NULL,NULL,'2013-04-05 21:34:08'),(19,8,'Visualização de Log de Erro','view',NULL,NULL,'2013-04-05 21:34:08'),(20,8,'Entrada do Módulo','enter',NULL,NULL,'2013-04-05 21:34:08'),(21,1,'Alterar dados de módulos internos (ACME)','manage_acme_modules','Esta permissão é testada toda vez que o usuário tentar alterar alguma propriedade ou inserir alguma permissão, ação ou menu para um módulo interno, ou seja, do próprio ACME.',NULL,'2013-04-07 01:11:29'),(28,3,'Gerenciar Permissões','permission_manager','Esta permissão é testada quando há a tentativa de acesso à tela de edição de permissões de um determinado usuário.',NULL,'2013-04-08 15:40:49'),(52,7,'Edição de Menu','update','Esta permissão é testada quando uma edição de menu ocorre ou quando a reordenação da árvore de menus acontece.',NULL,'2013-06-26 15:02:54'),(53,7,'Deleção de Menu','delete','Esta permissão é testada quando há tentativa de deleção de um determinado menu do sistema.',NULL,'2013-06-26 18:26:54'),(54,7,'Inserção de Menu','insert','Esta permissão é testada quando ocorre a tentativa de inserção de um novo menu de sistema.',NULL,'2013-06-26 20:09:51'),(55,14,'Entrada do Módulo','enter','Esta permissão é testada quando há a tentativa de entrada no módulo.',NULL,'2013-06-28 19:53:10'),(56,15,'Entrada do Módulo','enter','Esta permissão é testada quando há a tentativa de acesso ao módulo.',NULL,'2013-06-28 20:19:52'),(57,4,'Inserção de Grupo de Usuário','insert','Esta permissão é testada quando há a tentativa de acesso ao formulário de inserção de grupo de usuário.',NULL,'2013-07-09 14:51:38'),(58,4,'Edição de Grupo de Usuário','update','Esta permissão é testada quando há a tentativa de acesso ao formulário de edição de um determinado grupo de usuário.',NULL,'2013-07-09 14:52:14'),(59,4,'Deleção de Grupo de Usuário','delete','Esta permissão é testada quando há a tentativa de acesso ao formulário de deleção de um determinado grupo de usuário.',NULL,'2013-07-09 14:52:58'),(60,4,'Visualização de Grupo de Usuário','view','Esta permissão é testada quando há a tentativa de acesso ao formulário de visualização de um determinado grupo de usuário.',NULL,'2013-07-09 14:53:37'),(61,3,'Inserção de Usuário','insert','Esta permissão é testada quando ocorre a abertura do formulário de inserção de usuário.',NULL,'2013-07-11 14:09:26'),(62,3,'Edição de Usuário','update','Esta permissão é testada quando ocorre a abertura do formulário de edição de usuário.',NULL,'2013-07-11 14:09:42'),(63,3,'Edição de Perfil de Usuário','edit_profile','Esta permissão abre funcionalidades na tela de edição de um determinado perfil de usuário, como alteração de dados básicos e edição de imagem.',NULL,'2013-07-12 18:25:09'),(64,3,'Solicitação de Alteração de Senha','reset_password','Esta permissão é testada quando há a tentativa de acesso à funcionalidade de solicitação de alteração de senha (enviada por email).',NULL,'2013-07-14 20:01:05'),(65,3,'Gerência de Favoritos','bookmark_manager','Esta permissão é testada quando há tentativa de acesso à um favorito de um outro usuário.',NULL,'2013-07-15 14:02:59'),(66,3,'Cópia de Permissões','copy_permissions','Esta permissão é testada quando há tentativa de cópia de permissões de um determinado usuário para outro.',NULL,'2013-07-15 14:03:56'),(67,6,'Deleção de Log','delete','Esta permissão é testada quando há a tentativa de acesso à página de deleção de um registro de log.',NULL,'2013-07-15 18:49:11'),(71,18,'Permissão de entrada do módulo','enter','Esta permissão é testada quando este módulo é acessado.',NULL,'2013-07-15 21:25:10'),(72,18,'Instalação de Pacote de Atualização','install_package_update','Esta permissão é testada quando há a tentativa de acesso à tela de instalação de pacote de atualização.',NULL,'2013-07-15 21:25:10'),(73,18,'Visualização de Detalhes do Pacote','view','Esta permissão é testada quando há a tentativa de acesso à tela de visualização de detalhes de um pacote de atualização.',NULL,'2013-07-15 21:25:10'),(74,19,'Permissão de entrada do módulo','enter','Esta permissão é testada quando há tentativa de entrada no módulo.',NULL,'2013-07-24 16:57:55'),(75,19,'Inserção de Relatório','insert','Esta permissão é testada quando há tentativa de acesso à tela de inserção de relatório.',NULL,'2013-07-24 16:58:36'),(76,19,'Edição de Relatório','update','Esta permissão é testada quando há tentativa de acesso à tela de edição de relatório.',NULL,'2013-07-24 16:59:27'),(77,19,'Visualização de Relatório','view','Esta permissão é testada quando há tentativa de acesso à tela de visualização de relatório.',NULL,'2013-07-24 16:59:47'),(78,19,'Deleção de Relatório','delete','Esta permissão é testada quando há tentativa de acesso à tela de deleção de relatório.',NULL,'2013-07-24 17:00:11'),(79,19,'Executar Relatório','run_report','Esta permissão é testada quando há tentativa de acesso à execução de um determinado relatório.',NULL,'2013-07-24 17:00:44');
/*!40000 ALTER TABLE `acm_module_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_menu`
--

DROP TABLE IF EXISTS `acm_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu_parent` int(11) DEFAULT NULL,
  `id_user_group` int(11) NOT NULL,
  `lang_key_rotule` varchar(250) DEFAULT NULL,
  `link` text,
  `target` varchar(50) DEFAULT NULL,
  `javascript` text,
  `url_img` text,
  `description` text,
  `order` int(11) DEFAULT NULL,
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_menu`),
  UNIQUE KEY `acm_menu_id_menu_UNIQUE` (`id_menu`),
  KEY `fk_acm_menu_acm_user_group` (`id_user_group`),
  KEY `fk_acm_menu_acm_menu` (`id_menu_parent`),
  CONSTRAINT `fk_acm_menu_level_one_acm_menu_level_one1` FOREIGN KEY (`id_menu_parent`) REFERENCES `acm_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_acm_menu_level_one_acm_user_group1` FOREIGN KEY (`id_user_group`) REFERENCES `acm_user_group` (`id_user_group`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_menu`
--

LOCK TABLES `acm_menu` WRITE;
/*!40000 ALTER TABLE `acm_menu` DISABLE KEYS */;
INSERT INTO `acm_menu` VALUES (1,NULL,1,'Sistema',NULL,NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_cog.png','Mnannana',2,NULL,'2013-04-03 12:54:04'),(2,1,1,'Módulos',NULL,NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module.png',NULL,1,NULL,'2013-04-03 12:54:04'),(3,2,1,'Administração de Módulos','<acme eval=\"URL_ROOT\" />/acme_module_manager/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module_acme_module_manager.png',NULL,2,NULL,'2013-04-03 12:59:44'),(4,2,1,'Maker - Construtor de Módulos','<acme eval=\"URL_ROOT\" />/acme_maker/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module_acme_maker.png',NULL,1,NULL,'2013-04-03 12:59:44'),(5,1,1,'Grupos e Usuários',NULL,NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_groups_and_users.png',NULL,2,NULL,'2013-04-03 12:59:44'),(6,5,1,'Usuários','<acme eval=\"URL_ROOT\" />/acme_user/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module_acme_user.png',NULL,1,NULL,'2013-04-03 12:59:44'),(7,5,1,'Grupos de Usuários','<acme eval=\"URL_ROOT\" />/acme_user_group/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module_acme_user_group.png',NULL,2,NULL,'2013-04-03 12:59:44'),(9,26,1,'Logs do Sistema','<acme eval=\"URL_ROOT\" />/acme_log/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/icon_menu_module_acme_log.png',NULL,1,NULL,'2013-04-03 13:00:23'),(10,1,1,'Menus do Sistema','<acme eval=\"URL_ROOT\" />/acme_menu/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_menus.png',NULL,60,NULL,'2013-04-03 13:11:46'),(11,26,1,'Logs de Erros','<acme eval=\"URL_ROOT\"/>/acme_log_error',NULL,NULL,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/icon_menu_module_acme_log_error.png',NULL,4,NULL,'2013-04-05 21:33:26'),(12,1,1,'Dashboard','<acme eval=\"URL_ROOT\"/>/acme_dashboard',NULL,NULL,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/icon_menu_module_acme_dashboard.png',NULL,62,NULL,'2013-05-02 19:35:57'),(23,24,1,'Sessão','<acme eval=\"URL_ROOT\" />/acme_session/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module_acme_session.png',NULL,2,NULL,'2013-06-28 19:56:37'),(24,1,1,'Configurações',NULL,NULL,NULL,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/icon_menu_configuracoes.png',NULL,4,NULL,'2013-06-28 20:06:23'),(25,24,1,'Variáveis e Constantes','<acme eval=\"URL_ROOT\" />/acme_config/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module_acme_config.png',NULL,1,NULL,'2013-06-28 20:07:43'),(26,1,1,'Logs',NULL,NULL,NULL,'<acme eval=\"URL_TEMPLATE\" />/_acme/_includes/img/icon_menu_logs.png',NULL,3,NULL,'2013-07-09 00:50:52'),(28,30,1,'Atualizações','<acme eval=\"URL_ROOT\"/>/acme_updater',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module_acme_updater.png',NULL,1,NULL,'2013-07-15 21:25:10'),(29,1,1,'Relatórios','<acme eval=\"URL_ROOT\" />/acme_query_report/',NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_module_acme_query_report.png',NULL,61,NULL,'2013-07-24 16:42:10'),(30,1,1,'Ajuda',NULL,NULL,NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_ajuda.png',NULL,62,NULL,'2013-07-24 19:36:04'),(31,30,1,'Sobre o ACME Engine','javascript:void(0)',NULL,'onclick=\"iframe_modal(\'<acme eval=\"lang(\'Sobre o ACME Engine\')\"/>\', \'<acme eval=\"URL_ROOT\"/>/acme_updater/about_acme\', \'<acme eval=\"URL_IMG\"/>/icon_info.png\', 600, 470)\"','<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_about_acme.png',NULL,10,NULL,'2013-07-24 19:40:02'),(32,30,1,'Documentação e API','http://www.acmeengine.org/documentation','_blank',NULL,'<acme eval=\"URL_TEMPLATE\"/>/_acme/_includes/img/icon_menu_documentation.png',NULL,5,NULL,'2013-07-24 21:38:34');
/*!40000 ALTER TABLE `acm_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_module_form_field`
--

DROP TABLE IF EXISTS `acm_module_form_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_module_form_field` (
  `id_module_form_field` int(11) NOT NULL AUTO_INCREMENT,
  `id_module_form` int(11) NOT NULL,
  `table_column` varchar(50) DEFAULT NULL COMMENT 'nome da coluna a qual o campo representa na tabela do modulo',
  `type` varchar(50) DEFAULT NULL COMMENT 'input, textarea, file, checkbox, radio, select.',
  `lang_key_label` varchar(100) DEFAULT NULL,
  `description` text,
  `id_html` varchar(50) DEFAULT NULL,
  `class_html` varchar(50) DEFAULT NULL,
  `maxlength` int(11) DEFAULT '50',
  `options_rotules` text,
  `options_values` text,
  `options_sql` text,
  `style` text,
  `javascript` text,
  `masks` varchar(100) DEFAULT NULL,
  `validations` varchar(250) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_module_form_field`),
  UNIQUE KEY `acm_module_form_field_id_module_form_field_UNIQUE` (`id_module_form_field`),
  KEY `fk_acm_module_form_field_acm_module_form` (`id_module_form`),
  CONSTRAINT `fk_acm_module_form_field_acm_module_form1` FOREIGN KEY (`id_module_form`) REFERENCES `acm_module_form` (`id_module_form`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_module_form_field`
--

LOCK TABLES `acm_module_form_field` WRITE;
/*!40000 ALTER TABLE `acm_module_form_field` DISABLE KEYS */;
INSERT INTO `acm_module_form_field` VALUES (4,2,'l.id_log','text','#',NULL,'id_log',NULL,NULL,NULL,NULL,NULL,'width:50px',NULL,'integer',NULL,10,NULL,'2013-04-03 21:17:49'),(5,2,'login','text','Login',NULL,'login',NULL,NULL,NULL,NULL,NULL,'width:100px',NULL,NULL,NULL,20,NULL,'2013-04-03 21:20:51'),(6,2,'l.table','select','Tabela',NULL,'table',NULL,NULL,NULL,NULL,'SELECT DISTINCT `table`, `table` FROM acm_log ORDER BY `table`','width:120px',NULL,NULL,NULL,30,NULL,'2013-04-03 21:22:12'),(7,3,'id_user','select','id_user','','id_user',NULL,11,NULL,NULL,'SELECT id_user, id_user FROM acm_user','width:150px',NULL,'integer','integer',20,NULL,'2013-04-05 21:21:25'),(8,3,'table','text','table',NULL,'table',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',30,NULL,'2013-04-05 21:21:35'),(9,3,'action','text','action',NULL,'action',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',40,NULL,'2013-04-05 21:21:44'),(10,3,'log','textarea','log',NULL,'log',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',50,NULL,'2013-04-05 21:21:53'),(11,3,'array_data','textarea','array_data',NULL,'array_data',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',60,NULL,'2013-04-05 21:22:04'),(12,3,'ip_address','text','ip_address',NULL,'ip_address',NULL,20,NULL,NULL,NULL,'width:20px',NULL,NULL,'',100,NULL,'2013-04-05 21:22:12'),(13,3,'browser_version','text','browser_version',NULL,'browser_version',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',90,NULL,'2013-04-05 21:22:20'),(14,3,'browser_name','text','browser_name',NULL,'browser_name',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',80,NULL,'2013-04-05 21:22:28'),(15,3,'user_agent','textarea','user_agent',NULL,'user_agent',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',70,NULL,'2013-04-05 21:22:36'),(16,3,'log_dtt_ins','text','log_dtt_ins','Formato DD/MM/AAAA','log_dtt_ins',NULL,NULL,NULL,NULL,NULL,'width:130px',NULL,'date','date',110,NULL,'2013-04-05 21:22:46'),(17,4,'id_log_error','text','id_log_error','Somente números','id_log_error',NULL,11,NULL,NULL,NULL,NULL,NULL,'integer','required;integer',10,NULL,'2013-04-05 21:34:08'),(18,4,'error_type','text','error_type',NULL,'error_type',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',20,NULL,'2013-04-05 21:34:08'),(19,4,'header','textarea','header',NULL,'header',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',30,NULL,'2013-04-05 21:34:08'),(20,4,'message','textarea','message',NULL,'message',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',40,NULL,'2013-04-05 21:34:08'),(21,4,'status_code','text','status_code',NULL,'status_code',NULL,10,NULL,NULL,NULL,'width:10px',NULL,NULL,'',50,NULL,'2013-04-05 21:34:08'),(22,4,'log_dtt_ins','text','log_dtt_ins','Formato DD/MM/AAAA','log_dtt_ins',NULL,NULL,NULL,NULL,NULL,'width:130px',NULL,'date','date',60,NULL,'2013-04-05 21:34:08'),(23,5,'id_log_error','text','id_log_error','Somente números','id_log_error',NULL,11,NULL,NULL,NULL,NULL,NULL,'integer','required;integer',10,NULL,'2013-04-05 21:34:08'),(24,5,'error_type','text','error_type',NULL,'error_type',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',20,NULL,'2013-04-05 21:34:08'),(25,5,'header','textarea','header',NULL,'header',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',30,NULL,'2013-04-05 21:34:08'),(26,5,'message','textarea','message',NULL,'message',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',40,NULL,'2013-04-05 21:34:08'),(27,5,'status_code','text','status_code',NULL,'status_code',NULL,10,NULL,NULL,NULL,'width:10px',NULL,NULL,'',50,NULL,'2013-04-05 21:34:08'),(28,5,'log_dtt_ins','text','log_dtt_ins','Formato DD/MM/AAAA','log_dtt_ins',NULL,NULL,NULL,NULL,NULL,'width:130px',NULL,'date','date',60,NULL,'2013-04-05 21:34:08'),(29,6,'acm_log_error.error_type','select','Tipo de Erro',NULL,'error_type',NULL,NULL,NULL,NULL,'SELECT distinct error_type, error_type FROM acm_log_error',NULL,NULL,NULL,NULL,10,NULL,'2013-04-05 21:47:39'),(166,23,'login','text','Login',NULL,'login',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-05-10 15:12:10'),(167,24,'name','text','Nome',NULL,'name',NULL,100,NULL,NULL,NULL,'width:250px',NULL,NULL,'required;',20,NULL,'2013-07-09 14:59:48'),(168,24,'description','textarea','Descrição do Grupo',NULL,'description',NULL,NULL,NULL,NULL,NULL,'width:250px;height:100px',NULL,NULL,NULL,30,NULL,'2013-07-09 15:00:07'),(169,25,'name','text','Nome',NULL,'name',NULL,100,NULL,NULL,NULL,'width:250px',NULL,NULL,'required;',20,NULL,'2013-07-09 15:01:43'),(170,25,'description','textarea','Descrição do Grupo',NULL,'description',NULL,NULL,NULL,NULL,NULL,'width:250px;height:100px',NULL,NULL,NULL,30,NULL,'2013-07-09 15:01:53'),(171,26,'id_user_group','text','#','Somente números','id_user_group',NULL,11,NULL,NULL,NULL,NULL,NULL,'integer','required;integer',10,NULL,'2013-07-09 15:02:46'),(172,26,'name','text','Nome',NULL,'name',NULL,100,NULL,NULL,NULL,'width:100px',NULL,NULL,'required;',20,NULL,'2013-07-09 15:02:53'),(173,26,'description','textarea','Descrição do Grupo',NULL,'description',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,NULL,30,NULL,'2013-07-09 15:03:02'),(174,27,'g.name','select','Grupo',NULL,'name',NULL,NULL,NULL,NULL,'SELECT g.name, g.name FROM acm_user_group g ORDER BY g.name','width:150px',NULL,NULL,NULL,10,NULL,'2013-07-09 15:05:18'),(175,28,'id_log','text','id_log','Somente números','id_log',NULL,11,NULL,NULL,NULL,NULL,NULL,'integer','required;integer',10,'2013-07-09 22:17:40','2013-07-09 22:17:16'),(176,28,'id_user','select','id_user','','id_user',NULL,11,NULL,NULL,'SELECT id_user, id_user FROM acm_user','width:150px',NULL,'integer','integer',20,NULL,'2013-07-09 22:17:51'),(177,28,'table','text','table',NULL,'table',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',30,NULL,'2013-07-09 22:18:02'),(178,28,'action','text','action',NULL,'action',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',40,NULL,'2013-07-09 22:18:12'),(179,28,'log','textarea','log',NULL,'log',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',50,NULL,'2013-07-09 22:18:22'),(180,28,'array_data','textarea','array_data',NULL,'array_data',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',60,NULL,'2013-07-09 22:18:33'),(181,28,'user_agent','textarea','user_agent',NULL,'user_agent',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,'',70,NULL,'2013-07-09 22:18:43'),(182,28,'browser_name','text','browser_name',NULL,'browser_name',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',80,NULL,'2013-07-09 22:18:57'),(183,28,'browser_version','text','browser_version',NULL,'browser_version',NULL,50,NULL,NULL,NULL,'width:50px',NULL,NULL,'',90,NULL,'2013-07-09 22:52:28'),(184,28,'ip_address','text','ip_address',NULL,'ip_address',NULL,20,NULL,NULL,NULL,'width:20px',NULL,NULL,'',100,NULL,'2013-07-09 22:52:40'),(185,28,'log_dtt_ins','text','log_dtt_ins','Formato DD/MM/AAAA','log_dtt_ins',NULL,NULL,NULL,NULL,NULL,'width:130px',NULL,'date','date',110,NULL,'2013-07-09 22:53:08'),(186,29,'r.id_query_report','text','#',NULL,'id_query_report',NULL,10,NULL,NULL,NULL,'width:50px',NULL,'integer',NULL,10,NULL,'2013-07-24 16:57:22'),(187,30,'controller_action_executor','text','Controlador/Ação Executor','Caso um controlador/ação seja informado aqui este terá prioridade na execução. Isto é, ao executar o relatório este será redirecionado para este controlador/ação recebendo como parâmetro o id deste mesmo relatório.','controller_action_executor',NULL,100,NULL,NULL,NULL,'width:300px',NULL,NULL,NULL,20,NULL,'2013-07-24 17:12:23'),(188,30,'lang_key_rotule','text','Título',NULL,'lang_key_rotule',NULL,250,NULL,NULL,NULL,'width:300px',NULL,NULL,'required;',30,NULL,'2013-07-24 17:12:46'),(189,30,'description','textarea','Descrição',NULL,'description',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,NULL,40,NULL,'2013-07-24 17:12:57'),(190,30,'sql','textarea','SQL','O conjunto de dados deste SQL será convertido em uma tabela de dados exportável.','sql','script',NULL,NULL,NULL,NULL,'width:500px;height:300px',NULL,NULL,NULL,50,NULL,'2013-07-24 17:14:03'),(191,31,'controller_action_executor','text','Controlador/Ação Executor','Caso um controlador/ação seja informado aqui este terá prioridade na execução. Isto é, ao executar o relatório este será redirecionado para este controlador/ação recebendo como parâmetro o id deste mesmo relatório.','controller_action_executor',NULL,100,NULL,NULL,NULL,'width:300px',NULL,NULL,NULL,20,NULL,'2013-07-24 17:21:20'),(192,31,'lang_key_rotule','text','Título',NULL,'lang_key_rotule',NULL,250,NULL,NULL,NULL,'width:300px',NULL,NULL,'required;',30,NULL,'2013-07-24 17:22:38'),(193,31,'description','textarea','Descrição',NULL,'description',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,NULL,40,NULL,'2013-07-24 17:22:47'),(194,31,'sql','textarea','SQL','O conjunto de dados deste SQL será convertido em uma tabela de dados exportável.','sql','script',NULL,NULL,NULL,NULL,'width:500px;height:300px',NULL,NULL,NULL,50,NULL,'2013-07-24 17:22:55'),(195,32,'id_query_report','text','#','Somente números','id_query_report',NULL,11,NULL,NULL,NULL,NULL,NULL,'integer','required;integer',10,NULL,'2013-07-24 17:28:45'),(196,32,'log_dtt_ins','text','Data de Inserção',NULL,'log_dtt_ins',NULL,NULL,NULL,NULL,NULL,'width:130px',NULL,'date','date',60,NULL,'2013-07-24 17:28:54'),(197,32,'controller_action_executor','text','Controlador/Ação Executor',NULL,'controller_action_executor',NULL,100,NULL,NULL,NULL,'width:100px',NULL,NULL,NULL,20,NULL,'2013-07-24 17:29:02'),(198,32,'lang_key_rotule','text','Título',NULL,'lang_key_rotule',NULL,250,NULL,NULL,NULL,'width:250px',NULL,NULL,'required;',30,NULL,'2013-07-24 17:29:10'),(199,32,'description','textarea','Descrição',NULL,'description',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,NULL,40,NULL,'2013-07-24 17:29:18'),(200,32,'sql','textarea','SQL',NULL,'sql',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,NULL,50,NULL,'2013-07-24 17:29:28'),(201,33,'id_query_report','text','id_query_report','Somente números','id_query_report',NULL,11,NULL,NULL,NULL,NULL,NULL,'integer','required;integer',10,NULL,'2013-07-24 17:31:10'),(202,33,'controller_action_executor','text','Controlador/Ação Executor',NULL,'controller_action_executor',NULL,100,NULL,NULL,NULL,'width:100px',NULL,NULL,NULL,20,NULL,'2013-07-24 17:31:19'),(203,33,'lang_key_rotule','text','Título',NULL,'lang_key_rotule',NULL,250,NULL,NULL,NULL,'width:250px',NULL,NULL,'required;',30,NULL,'2013-07-24 17:31:28'),(204,33,'description','textarea','Descrição',NULL,'description',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,NULL,40,NULL,'2013-07-24 17:31:38'),(205,33,'sql','textarea','SQL',NULL,'sql',NULL,NULL,NULL,NULL,NULL,'width:300px;height:100px',NULL,NULL,NULL,50,NULL,'2013-07-24 17:31:47'),(206,33,'log_dtt_ins','text','Data de Inserção',NULL,'log_dtt_ins',NULL,NULL,NULL,NULL,NULL,'width:130px',NULL,'date','date',60,NULL,'2013-07-24 17:31:54');
/*!40000 ALTER TABLE `acm_module_form_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_app_package_update`
--

DROP TABLE IF EXISTS `acm_app_package_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_app_package_update` (
  `id_app_package_update` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(20) NOT NULL,
  `version_father` varchar(20) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `description` text,
  `path_file` varchar(250) DEFAULT NULL,
  `dtt_package_available` timestamp NULL DEFAULT NULL,
  `dtt_package_installed` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_app_package_update`),
  UNIQUE KEY `id_package_update_UNIQUE` (`id_app_package_update`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_app_package_update`
--

LOCK TABLES `acm_app_package_update` WRITE;
/*!40000 ALTER TABLE `acm_app_package_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `acm_app_package_update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_user_group`
--

DROP TABLE IF EXISTS `acm_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_user_group` (
  `id_user_group` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `dtt_inative` timestamp NULL DEFAULT NULL,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user_group`),
  UNIQUE KEY `acm_user_group_id_user_group_UNIQUE` (`id_user_group`),
  UNIQUE KEY `acm_user_group_name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_user_group`
--

LOCK TABLES `acm_user_group` WRITE;
/*!40000 ALTER TABLE `acm_user_group` DISABLE KEYS */;
INSERT INTO `acm_user_group` VALUES (1,'ROOT','Usuários-mestre do sistema. Estes usuários possuem acesso a modulos internos, responsáveis pelo gerenciamento da aplicação.',NULL,'2013-04-03 12:48:21');
/*!40000 ALTER TABLE `acm_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acm_query_report`
--

DROP TABLE IF EXISTS `acm_query_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acm_query_report` (
  `id_query_report` int(11) NOT NULL AUTO_INCREMENT,
  `controller_action_executor` varchar(100) DEFAULT NULL,
  `lang_key_rotule` varchar(250) NOT NULL,
  `description` text,
  `sql` text,
  `log_dtt_ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_query_report`),
  UNIQUE KEY `id_query_report_UNIQUE` (`id_query_report`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acm_query_report`
--

LOCK TABLES `acm_query_report` WRITE;
/*!40000 ALTER TABLE `acm_query_report` DISABLE KEYS */;
INSERT INTO `acm_query_report` VALUES (1,NULL,'Listagem de Usuários','Este relatório exibe uma listagem de usuários com informação de grupo e afins.','SELECT u.id_user AS \'#\',\n       u.login,\n       u.name AS nome,\n       u.email,\n       ug.name AS \'grupo\'\n  FROM acm_user u\nINNER JOIN acm_user_group ug ON (ug.id_user_group = u.id_user_group)\nORDER BY u.login\n       ','2013-07-24 17:27:45');
/*!40000 ALTER TABLE `acm_query_report` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-02 18:44:45
