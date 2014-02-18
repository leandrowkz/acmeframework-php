--------------------------------------------------------
--  DDL for Table acm_module_form
--------------------------------------------------------
CREATE TABLE acm_module_form 
(	
	id_module_form NUMBER(10,0) NOT NULL, 
	id_module NUMBER(10,0) NOT NULL, 
	operation VARCHAR2(45 CHAR), 
	action VARCHAR2(250 CHAR), 
	method VARCHAR2(20 CHAR), 
	enctype VARCHAR2(50 CHAR), 
	dtt_inative DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index fk_amf_id_module
--------------------------------------------------------
CREATE INDEX fk_amf_id_module ON acm_module_form (id_module);

--------------------------------------------------------
--  DDL for Index pk_acm_module_form
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_module_form ON acm_module_form (id_module_form);

--------------------------------------------------------
--  Constraints for Table acm_module_form
--------------------------------------------------------
ALTER TABLE acm_module_form ADD CONSTRAINT pk_acm_module_form PRIMARY KEY (id_module_form) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_module_form
--------------------------------------------------------
ALTER TABLE acm_module_form ADD CONSTRAINT fk_amf_id_module FOREIGN KEY (id_module)
	REFERENCES acm_module (id_module) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_module_form;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_module_form BEFORE INSERT ON acm_module_form
FOR EACH ROW
BEGIN
  SELECT sq_acm_module_form.NEXTVAL
    INTO :new.id_module_form
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_module_form ENABLE;