--------------------------------------------------------
--  DDL for Table acm_module_menu
--------------------------------------------------------
CREATE TABLE acm_module_menu 
(	
	id_module_menu NUMBER(10,0) NOT NULL,  
	id_module NUMBER(10,0) NOT NULL, 
	lang_key_rotule VARCHAR2(50 CHAR), 
	link VARCHAR2(2000 CHAR), 
	target VARCHAR2(50 CHAR), 
	javascript VARCHAR2(2000 CHAR), 
	url_img VARCHAR2(2000 CHAR), 
	description VARCHAR2(2000 CHAR), 
	order_ NUMBER(10,0), 
	dtt_inative DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index fk_amm_id_module
--------------------------------------------------------
CREATE INDEX fk_amm_id_module ON acm_module_menu (id_module);

--------------------------------------------------------
--  DDL for Index pk_acm_module_menu
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_module_menu ON acm_module_menu (id_module_menu);

--------------------------------------------------------
--  Constraints for Table acm_module_menu
--------------------------------------------------------
ALTER TABLE acm_module_menu ADD CONSTRAINT pk_acm_module_menu PRIMARY KEY (id_module_menu) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_module_menu
--------------------------------------------------------
ALTER TABLE acm_module_menu ADD CONSTRAINT fk_amm_id_module FOREIGN KEY (id_module)
	REFERENCES acm_module (id_module) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_module_menu;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_module_menu BEFORE INSERT ON acm_module_menu
FOR EACH ROW
BEGIN
  SELECT sq_acm_module_menu.NEXTVAL
    INTO :new.id_module_menu
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_module_menu ENABLE;