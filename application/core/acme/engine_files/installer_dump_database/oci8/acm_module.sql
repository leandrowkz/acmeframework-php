--------------------------------------------------------
--  DDL for Table acm_module
--------------------------------------------------------
CREATE TABLE acm_module 
(	
	id_module NUMBER(10,0) NOT NULL, 
	ini_file VARCHAR2(2000 CHAR), 
	table_name VARCHAR2(50 CHAR), 
	controller VARCHAR2(50 CHAR) NOT NULL, 
	lang_key_rotule VARCHAR2(250 CHAR) NOT NULL,  
	sql_list VARCHAR2(2000 CHAR), 
	items_per_page NUMBER(10,0) DEFAULT '100', 
	url_img VARCHAR2(2000 CHAR), 
	description VARCHAR2(2000 CHAR), 
	dtt_inative DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_module
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_module ON acm_module (id_module);

--------------------------------------------------------
--  Constraints for Table acm_module
--------------------------------------------------------
ALTER TABLE acm_module ADD CONSTRAINT pk_acm_module PRIMARY KEY (id_module) ENABLE;

--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_module;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_module BEFORE INSERT ON acm_module
FOR EACH ROW
BEGIN
  SELECT sq_acm_module.NEXTVAL
    INTO :new.id_module
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_module ENABLE;