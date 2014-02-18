--------------------------------------------------------
--  DDL for Table acm_query_report
--------------------------------------------------------
CREATE TABLE acm_query_report 
(	
	id_query_report NUMBER(10,0) NOT NULL, 
	controller_action_executor VARCHAR2(100 CHAR), 
	lang_key_rotule VARCHAR2(250 CHAR) NOT NULL, 
	description VARCHAR2(2000 CHAR), 
	sql VARCHAR2(2000 CHAR), 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_query_report
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_query_report ON acm_query_report (id_query_report);

--------------------------------------------------------
--  Constraints for Table acm_query_report
--------------------------------------------------------
ALTER TABLE acm_query_report ADD CONSTRAINT pk_acm_query_report PRIMARY KEY (id_query_report) ENABLE;

--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_query_report;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_query_report BEFORE INSERT ON acm_query_report
FOR EACH ROW
BEGIN
  SELECT sq_acm_query_report.NEXTVAL
    INTO :new.id_query_report
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_query_report ENABLE;