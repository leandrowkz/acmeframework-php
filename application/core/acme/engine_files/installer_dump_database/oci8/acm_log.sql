--------------------------------------------------------
--  DDL for Table acm_log
--------------------------------------------------------
CREATE TABLE acm_log 
(	
	id_log NUMBER(10,0) NOT NULL, 
	id_user NUMBER(10,0), 
	table_name VARCHAR2(50 CHAR), 
	action VARCHAR2(50 CHAR), 
	log_description VARCHAR2(2000 CHAR), 
	array_data VARCHAR2(2000 CHAR), 
	user_agent VARCHAR2(2000 CHAR), 
	browser_name VARCHAR2(50 CHAR), 
	browser_version VARCHAR2(50 CHAR), 
	ip_address VARCHAR2(20 CHAR), 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index fk_al_id_user
--------------------------------------------------------
CREATE INDEX fk_al_id_user ON acm_log (id_user);

--------------------------------------------------------
--  DDL for Index pk_acm_log
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_log ON acm_log (id_log);

--------------------------------------------------------
--  Constraints for Table acm_log
--------------------------------------------------------
ALTER TABLE acm_log ADD CONSTRAINT pk_acm_log PRIMARY KEY (id_log) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_log
--------------------------------------------------------
ALTER TABLE acm_log ADD CONSTRAINT fk_al_id_user FOREIGN KEY (id_user)
	REFERENCES acm_user (id_user) ENABLE;

--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_log;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_log BEFORE INSERT ON acm_log
FOR EACH ROW
BEGIN
  SELECT sq_acm_log.NEXTVAL
    INTO :new.id_log
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_log ENABLE;