
/* -----------------------------------------------------
--  DDL for Table acm_user_group
-- -------------------------------------------------- */
CREATE TABLE acm_user_group
(
	id_user_group SERIAL NOT NULL,
	name VARCHAR(100) NOT NULL,
	description TEXT,
	PRIMARY KEY (id_user_group),
	CONSTRAINT acm_user_group_id_user_group_UNIQUE UNIQUE (id_user_group)
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_user
-- -------------------------------------------------- */
CREATE TABLE acm_user
(
	id_user SERIAL NOT NULL,
	id_user_group INTEGER NOT NULL,
	name VARCHAR(250) NOT NULL,
	email VARCHAR(250) NOT NULL,
	password TEXT NOT NULL,
	description TEXT,
	dtt_inative TIMESTAMP,
	log_dtt_ins TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id_user),
	CONSTRAINT acm_user_id_user_UNIQUE UNIQUE(id_user),
	CONSTRAINT acm_user_email_UNIQUE UNIQUE(email),
	CONSTRAINT FK_acm_user_acm_user_group FOREIGN KEY (id_user_group) REFERENCES acm_user_group (id_user_group) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_log
-- -------------------------------------------------- */
CREATE TABLE acm_log
(
	id_log SERIAL NOT NULL,
	id_user INTEGER,
	table_name VARCHAR(50),
	action VARCHAR(50),
	log_description TEXT,
	additional_data TEXT,
	user_agent TEXT,
	browser_name VARCHAR(50),
	browser_version VARCHAR(50),
	device_name VARCHAR(100),
	device_version VARCHAR(100),
	platform VARCHAR(100),
	ip_address VARCHAR(20),
	log_dtt_ins TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id_log),
	CONSTRAINT acm_log_id_log_UNIQUE UNIQUE (id_log),
	CONSTRAINT FK_acm_log_acm_user FOREIGN KEY (id_user) REFERENCES acm_user (id_user) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_log_error
-- -------------------------------------------------- */
CREATE TABLE acm_log_error
(
	id_log_error SERIAL NOT NULL,
	id_user INTEGER NULL,
	error_type VARCHAR(50),
	header TEXT,
	message TEXT,
	status_code VARCHAR(10),
	additional_data TEXT,
	user_agent TEXT,
	browser_name VARCHAR(50),
	browser_version VARCHAR(50),
	device_name VARCHAR(100),
	device_version VARCHAR(100),
	platform VARCHAR(100),
	ip_address VARCHAR(20),
	log_dtt_ins TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id_log_error),
	CONSTRAINT acm_log_error_id_log_error_UNIQUE UNIQUE (id_log_error),
	CONSTRAINT FK_acm_log_error_acm_user FOREIGN KEY (id_user) REFERENCES acm_user (id_user) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_menu
-- -------------------------------------------------- */
CREATE TABLE acm_menu
(
	id_menu SERIAL NOT NULL,
	id_menu_parent INTEGER,
	id_user_group INTEGER NOT NULL,
	label VARCHAR(250),
	link TEXT,
	target VARCHAR(50),
	url_img TEXT,
	order_ INTEGER,
	PRIMARY KEY (id_menu),
	CONSTRAINT acm_menu_id_menu_UNIQUE UNIQUE (id_menu),
	CONSTRAINT FK_acm_menu_acm_menu FOREIGN KEY (id_menu_parent) REFERENCES acm_menu (id_menu) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT FK_acm_menu_acm_user_group FOREIGN KEY (id_user_group) REFERENCES acm_user_group (id_user_group) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_module
-- -------------------------------------------------- */
CREATE TABLE acm_module
(
	id_module SERIAL NOT NULL,
	def_file TEXT,
	table_name VARCHAR(50),
	controller VARCHAR(50) NOT NULL,
	label VARCHAR(250) NOT NULL,
	sql_list TEXT,
	url_img TEXT,
	description TEXT,
	log_dtt_ins TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id_module),
	CONSTRAINT acm_module_id_module_UNIQUE UNIQUE (id_module),
	CONSTRAINT acm_module_controller_UNIQUE UNIQUE (controller)
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_module_action
-- -------------------------------------------------- */
CREATE TABLE acm_module_action
(
	id_module_action SERIAL NOT NULL,
	id_module INTEGER NOT NULL,
	label VARCHAR(250),
	link TEXT,
	target VARCHAR(50),
	url_img TEXT,
	order_ INTEGER,
	PRIMARY KEY (id_module_action),
	CONSTRAINT acm_module_action_id_module_action_UNIQUE UNIQUE (id_module_action),
	CONSTRAINT FK_acm_module_action_acm_module FOREIGN KEY (id_module) REFERENCES acm_module (id_module) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_module_form
-- -------------------------------------------------- */
CREATE TABLE acm_module_form
(
	id_module_form SERIAL NOT NULL,
	id_module INTEGER NOT NULL,
	operation VARCHAR(45),
	action VARCHAR(250),
	method VARCHAR(20),
	enctype VARCHAR(50),
	dtt_inative TIMESTAMP,
	PRIMARY KEY (id_module_form),
	CONSTRAINT acm_module_form_id_module_form_UNIQUE UNIQUE (id_module_form),
	CONSTRAINT FK_acm_module_form_acm_module FOREIGN KEY (id_module) REFERENCES acm_module (id_module) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_module_form_field
-- -------------------------------------------------- */
CREATE TABLE acm_module_form_field
(
	id_module_form_field SERIAL NOT NULL,
	id_module_form INTEGER NOT NULL,
	table_column VARCHAR(50),
	type VARCHAR(50),
	label VARCHAR(100),
	description TEXT,
	id_html VARCHAR(50),
	class_html VARCHAR(50),
	maxlength INTEGER DEFAULT '50',
	options_json TEXT,
	options_sql TEXT,
	style TEXT,
	javascript TEXT,
	masks VARCHAR(100),
	validations VARCHAR(250),
	order_ INTEGER DEFAULT '0',
	dtt_inative TIMESTAMP,
	PRIMARY KEY (id_module_form_field),
	CONSTRAINT acm_module_form_field_id_module_form_field_UNIQUE UNIQUE (id_module_form_field),
	CONSTRAINT FK_acm_module_form_field_acm_module_form FOREIGN KEY (id_module_form) REFERENCES acm_module_form (id_module_form) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
COMMENT ON COLUMN acm_module_form_field.table_column IS 'Column name which the field represents on module table.';


<<|SEPARATOR|>>
COMMENT ON COLUMN acm_module_form_field.type IS 'input, textarea, file, checkbox, radio, select.';


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_module_menu
-- -------------------------------------------------- */
CREATE TABLE acm_module_menu
(
	id_module_menu SERIAL NOT NULL,
	id_module INTEGER NOT NULL,
	label VARCHAR(50),
	link TEXT,
	target VARCHAR(50),
	url_img TEXT,
	order_ INTEGER,
	PRIMARY KEY (id_module_menu),
	CONSTRAINT acm_module_menu_id_module_menu_UNIQUE UNIQUE (id_module_menu),
	CONSTRAINT FK_acm_module_menu_acm_module FOREIGN KEY (id_module) REFERENCES acm_module (id_module) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_module_permission
-- -------------------------------------------------- */
CREATE TABLE acm_module_permission
(
	id_module_permission SERIAL NOT NULL,
	id_module INTEGER NOT NULL,
	label VARCHAR(250),
	permission VARCHAR(50) NOT NULL,
	description TEXT,
	PRIMARY KEY (id_module_permission),
	CONSTRAINT acm_module_permission_id_module_permission_UNIQUE UNIQUE (id_module_permission),
	CONSTRAINT FK_acm_module_permission_acm_module FOREIGN KEY (id_module) REFERENCES acm_module (id_module) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_user_config
-- -------------------------------------------------- */
CREATE TABLE acm_user_config
(
	id_user_config SERIAL NOT NULL,
	id_user INTEGER NOT NULL,
	lang_default VARCHAR(10) DEFAULT 'en_US',
	url_img TEXT,
	url_img_large TEXT,
	url_default TEXT,
	PRIMARY KEY (id_user_config),
	CONSTRAINT acm_user_config_id_user_config_UNIQUE UNIQUE (id_user_config),
	CONSTRAINT FK_acm_user_config_acm_user FOREIGN KEY (id_user) REFERENCES acm_user (id_user) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DDL for Table acm_user_permission
-- -------------------------------------------------- */
CREATE TABLE acm_user_permission
(
	id_user_permission SERIAL NOT NULL,
	id_user INTEGER NOT NULL,
	id_module_permission INTEGER NOT NULL,
	PRIMARY KEY (id_user_permission),
	CONSTRAINT acm_user_permission_id_user_permission_UNIQUE UNIQUE (id_user_permission),
	CONSTRAINT FK_acm_user_permission_acm_user FOREIGN KEY (id_user) REFERENCES acm_user (id_user) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT FK_acm_user_permission_acm_module_permission FOREIGN KEY (id_module_permission) REFERENCES acm_module_permission (id_module_permission) MATCH SIMPLE ON DELETE NO ACTION ON UPDATE NO ACTION
);

<<|SEPARATOR|>>
/* -----------------------------------------------------
--  DML for Sequences
-- -------------------------------------------------- */
ALTER SEQUENCE acm_log_error_id_log_error_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_log_id_log_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_menu_id_menu_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_module_action_id_module_action_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_module_form_field_id_module_form_field_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_module_form_id_module_form_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_module_id_module_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_module_menu_id_module_menu_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_module_permission_id_module_permission_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_user_config_id_user_config_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_user_group_id_user_group_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_user_id_user_seq RESTART WITH 300;<<|SEPARATOR|>>
ALTER SEQUENCE acm_user_permission_id_user_permission_seq RESTART WITH 300;


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  INSERTS for Table acm_user_group
-- -------------------------------------------------- */
INSERT INTO acm_user_group VALUES (1,'ROOT','Users with application super privileges.');


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  INSERTS for Table acm_user
-- -------------------------------------------------- */
INSERT INTO acm_user VALUES (1,1,'ACME','leandrowkz@gmail.com','7c58c7b6630b6c2377b41a0c56cea568',NULL,NULL,CURRENT_TIMESTAMP);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  INSERTS for Table acm_user_config
-- -------------------------------------------------- */
INSERT INTO acm_user_config VALUES (1,1,'en_US',NULL,NULL,'{URL_ROOT}/app-dashboard');


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  INSERTS for Table acm_menu
-- -------------------------------------------------- */
INSERT INTO acm_menu VALUES (2,NULL,1,NULL,'{URL_ROOT}/app-dashboard',NULL,'<i class="fa fa-fw fa-home"></i>',10);<<|SEPARATOR|>>
INSERT INTO acm_menu VALUES (1,NULL,1,'System',NULL,NULL,'<i class="fa fa-fw fa-cog"></i>',20);<<|SEPARATOR|>>
INSERT INTO acm_menu VALUES (3,1,1,'Modules',NULL,NULL,'<i class="fa fa-fw fa-cube"></i>',30);<<|SEPARATOR|>>
INSERT INTO acm_menu VALUES (4,3,1,'Administration','{URL_ROOT}/app-module-manager/',NULL,'<i class="fa fa-fw fa-cubes"></i>',40);<<|SEPARATOR|>>
INSERT INTO acm_menu VALUES (5,3,1,'Module maker','{URL_ROOT}/app-module-maker/',NULL,'<i class="fa fa-fw fa-flask"></i>',50);<<|SEPARATOR|>>
INSERT INTO acm_menu VALUES (6,1,1,'Settings','{URL_ROOT}/app-config/',NULL,'<i class="fa fa-fw fa-cogs"></i>',60);<<|SEPARATOR|>>
INSERT INTO acm_menu VALUES (7,1,1,'Logs','{URL_ROOT}/app-log/',NULL,'<i class="fa fa-fw fa-tags"></i>',70);<<|SEPARATOR|>>
INSERT INTO acm_menu VALUES (8,1,1,'Menus','{URL_ROOT}/app-menu/',NULL,'<i class="fa fa-fw fa-tasks"></i>',80);<<|SEPARATOR|>>
INSERT INTO acm_menu VALUES (9,1,1,'Users','{URL_ROOT}/app-user/',NULL,'<i class="fa fa-fw fa-users"></i>',90);



<<|SEPARATOR|>>
/* -----------------------------------------------------
--  INSERTS for Table acm_module
-- -------------------------------------------------- */
INSERT INTO acm_module VALUES (1,NULL,'acm_module','App_Module_Manager','Administration',NULL,'<i class="fa fa-fw fa-cubes"></i>','Application modules',CURRENT_TIMESTAMP);<<|SEPARATOR|>>
INSERT INTO acm_module VALUES (2,NULL,NULL,'App_Module_Maker','Module maker',NULL,'<i class="fa fa-fw fa-flask"></i>','Create new modules',CURRENT_TIMESTAMP);<<|SEPARATOR|>>
INSERT INTO acm_module VALUES (3,NULL,'acm_user','App_User','Users',NULL,'<i class="fa fa-fw fa-users"></i>','Manage groups and users',CURRENT_TIMESTAMP);<<|SEPARATOR|>>
INSERT INTO acm_module VALUES (5,NULL,NULL,'App_Dashboard','Dashboard',NULL,'<i class="fa fa-fw fa-home"></i>','General statistics',CURRENT_TIMESTAMP);<<|SEPARATOR|>>
INSERT INTO acm_module VALUES (6,NULL,'acm_log','App_Log','Application logs',NULL,'<i class="fa fa-fw fa-tags"></i>','Activities and errors',CURRENT_TIMESTAMP);<<|SEPARATOR|>>
INSERT INTO acm_module VALUES (7,NULL,'acm_menu','App_Menu','Menus',NULL,'<i class="fa fa-fw fa-tasks"></i>','Manage application menus',CURRENT_TIMESTAMP);<<|SEPARATOR|>>
INSERT INTO acm_module VALUES (15,NULL,NULL,'App_Config','Settings',NULL,'<i class="fa fa-fw fa-cogs"></i>','See settings and session',CURRENT_TIMESTAMP);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  INSERTS for Table acm_module_permission
-- -------------------------------------------------- */
INSERT INTO acm_module_permission VALUES (1,1,'Module entrance','ENTER',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (10,1,'Update module settings','CONFIG',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (3,2,'Module entrance','ENTER',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (4,2,'Create a new module','CREATE_MODULE',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (5,3,'Module entrance','ENTER',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (28,3,'Manage permissions','PERMISSION_MANAGER','Checked on user permissions page');<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (61,3,'Insert','INSERT',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (62,3,'Update','UPDATE',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (64,3,'Request reset password','RESET_PASSWORD','Checked on user request reset password');<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (7,5,'See dashboard','VIEW_DASHBOARD',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (8,6,'Module entrance','ENTER',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (15,6,'View','VIEW',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (67,6,'Delete','DELETE',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (9,7,'Module entrance','ENTER',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (52,7,'Update','UPDATE',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (53,7,'Delete','DELETE',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (54,7,'Insert','INSERT',NULL);<<|SEPARATOR|>>
INSERT INTO acm_module_permission VALUES (56,15,'Module entrance','ENTER',NULL);


<<|SEPARATOR|>>
/* -----------------------------------------------------
--  INSERTS for Table acm_user_permission
-- -------------------------------------------------- */
INSERT INTO acm_user_permission VALUES (1,1,1);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (3,1,3);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (4,1,4);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (5,1,5);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (7,1,7);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (8,1,8);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (9,1,9);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (10,1,10);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (11,1,15);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (17,1,28);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (36,1,53);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (37,1,52);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (38,1,54);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (46,1,61);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (47,1,62);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (53,1,64);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (95,1,67);<<|SEPARATOR|>>
INSERT INTO acm_user_permission VALUES (106,1,56);