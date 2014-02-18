--------------------------------------------------------
--  DDL for Table acm_module_form_field
--------------------------------------------------------
CREATE TABLE acm_module_form_field 
(	
	id_module_form_field NUMBER(10,0) NOT NULL, 
	id_module_form NUMBER(10,0) NOT NULL, 
	table_column VARCHAR2(50 CHAR), 
	type VARCHAR2(50 CHAR), 
	lang_key_label VARCHAR2(100 CHAR), 
	description VARCHAR2(2000 CHAR), 
	id_html VARCHAR2(50 CHAR), 
	class_html VARCHAR2(50 CHAR), 
	maxlength NUMBER(10,0) DEFAULT '50', 
	options_rotules VARCHAR2(2000 CHAR), 
	options_values VARCHAR2(2000 CHAR), 
	options_sql VARCHAR2(2000 CHAR), 
	style VARCHAR2(2000 CHAR), 
	javascript VARCHAR2(2000 CHAR), 
	masks VARCHAR2(100 CHAR), 
	validations VARCHAR2(250 CHAR), 
	order_ NUMBER(10,0) DEFAULT '0', 
	dtt_inative DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);
COMMENT ON COLUMN acm_module_form_field.table_column IS 'Nome da coluna a qual o campo representa na tabela do modulo.';
COMMENT ON COLUMN acm_module_form_field.type IS 'input, textarea, file, checkbox, radio, select.';

--------------------------------------------------------
--  DDL for Index fk_amff_id_module_form
--------------------------------------------------------
CREATE INDEX fk_amff_id_module_form ON acm_module_form_field (id_module_form);

--------------------------------------------------------
--  DDL for Index pk_acm_module_form_field
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_module_form_field ON acm_module_form_field (id_module_form_field);

--------------------------------------------------------
--  Constraints for Table acm_module_form_field
--------------------------------------------------------
ALTER TABLE acm_module_form_field ADD CONSTRAINT pk_acm_module_form_field PRIMARY KEY (id_module_form_field) ENABLE;
  
--------------------------------------------------------
--  Ref Constraints for Table acm_module_form_field
--------------------------------------------------------
ALTER TABLE acm_module_form_field ADD CONSTRAINT fk_amff_id_module_form FOREIGN KEY (id_module_form)
	REFERENCES acm_module_form (id_module_form) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_module_form_field;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_module_form_field BEFORE INSERT ON acm_module_form_field
FOR EACH ROW
BEGIN
  SELECT sq_acm_module_form_field.NEXTVAL
    INTO :new.id_module_form_field
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_module_form_field ENABLE;