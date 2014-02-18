--------------------------------------------------------
--  DDL for Table acm_module_action
--------------------------------------------------------
CREATE TABLE acm_module_action 
(	
	id_module_action NUMBER(10,0) NOT NULL, 
	id_module NUMBER(10,0) NOT NULL, 
	lang_key_rotule VARCHAR2(250 CHAR), 
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
--  DDL for Index pk_acm_module_action
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_module_action ON acm_module_action (id_module_action);

--------------------------------------------------------
--  DDL for Index fk_ama_id_module
--------------------------------------------------------
CREATE INDEX fk_ama_id_module ON acm_module_action (id_module);

--------------------------------------------------------
--  Constraints for Table acm_module_action
--------------------------------------------------------
ALTER TABLE acm_module_action ADD CONSTRAINT pk_acm_module_action PRIMARY KEY (id_module_action) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_module_action
--------------------------------------------------------
ALTER TABLE acm_module_action ADD CONSTRAINT fk_ama_id_module FOREIGN KEY (id_module)
	REFERENCES acm_module (id_module) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_module_action;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_module_action BEFORE INSERT ON acm_module_action
FOR EACH ROW
BEGIN
  SELECT sq_acm_module_action.NEXTVAL
    INTO :new.id_module_action
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_module_action ENABLE;