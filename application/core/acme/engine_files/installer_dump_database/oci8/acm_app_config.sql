--------------------------------------------------------
--  DDL for Table acm_app_config
--------------------------------------------------------
CREATE TABLE acm_app_config 
(
	id_app_config NUMBER(10) NOT NULL, 
	config VARCHAR2(250) NOT NULL, 
	value VARCHAR2(4000), 
	log_dtt_ins TIMESTAMP (6) DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_app_config
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_app_config ON acm_app_config (id_app_config);

--------------------------------------------------------
--  Constraints for Table pk_acm_app_config
--------------------------------------------------------
ALTER TABLE acm_app_config ADD CONSTRAINT pk_acm_app_config PRIMARY KEY (id_app_config) ENABLE;

--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_app_config;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_app_config BEFORE INSERT ON acm_app_config
FOR EACH ROW
BEGIN
  SELECT sq_acm_app_config.NEXTVAL
    INTO :new.id_app_config
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_app_config ENABLE;