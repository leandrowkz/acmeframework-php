--------------------------------------------------------
--  DDL for Table acm_module_permission
--------------------------------------------------------
CREATE TABLE acm_module_permission 
(	
	id_module_permission NUMBER(10,0) NOT NULL, 
	id_module NUMBER(10,0) NOT NULL, 
	lang_key_rotule VARCHAR2(250 CHAR), 
	permission VARCHAR2(50 CHAR) NOT NULL, 
	description VARCHAR2(2000 CHAR), 
	dtt_inative DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index fk_amp_id_module
--------------------------------------------------------
CREATE INDEX fk_amp_id_module ON acm_module_permission (id_module);

--------------------------------------------------------
--  DDL for Index pk_acm_module_permission
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_module_permission ON acm_module_permission (id_module_permission);

--------------------------------------------------------
--  Constraints for Table acm_module_permission
--------------------------------------------------------
ALTER TABLE acm_module_permission ADD CONSTRAINT pk_acm_module_permission PRIMARY KEY (id_module_permission) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_module_permission
--------------------------------------------------------
ALTER TABLE acm_module_permission ADD CONSTRAINT fk_amp_id_module FOREIGN KEY (id_module)
	REFERENCES acm_module (id_module) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_module_permission;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_module_permission BEFORE INSERT ON acm_module_permission
FOR EACH ROW
BEGIN
  SELECT sq_acm_module_permission.NEXTVAL
    INTO :new.id_module_permission
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_module_permission ENABLE;