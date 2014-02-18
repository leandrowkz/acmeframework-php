--------------------------------------------------------
--  DDL for Table acm_log_error
--------------------------------------------------------
CREATE TABLE acm_log_error 
(	
	id_log_error NUMBER(10,0) NOT NULL, 
	error_type VARCHAR2(50 CHAR), 
	header VARCHAR2(2000 CHAR), 
	message VARCHAR2(2000 CHAR), 
	status_code VARCHAR2(10 CHAR), 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_log_error
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_log_error ON acm_log_error (id_log_error);

--------------------------------------------------------
--  Constraints for Table acm_log_error
--------------------------------------------------------
ALTER TABLE acm_log_error ADD CONSTRAINT pk_acm_log_error PRIMARY KEY (id_log_error);

--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_log_error;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_log_error BEFORE INSERT ON acm_log_error
FOR EACH ROW
BEGIN
  SELECT sq_acm_log_error.NEXTVAL
    INTO :new.id_log_error
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_log_error ENABLE;