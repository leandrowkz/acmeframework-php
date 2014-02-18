--------------------------------------------------------
--  DDL for Table acm_user_config
--------------------------------------------------------
CREATE TABLE acm_user_config 
(	
	id_user_config NUMBER(10,0) NOT NULL, 
	id_user NUMBER(10,0) NOT NULL, 
	lang_default VARCHAR2(10 CHAR) DEFAULT 'pt_BR', 
	url_default VARCHAR2(2000 CHAR), 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_user_config
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_user_config ON acm_user_config (id_user_config);

--------------------------------------------------------
--  DDL for Index fk_auc_id_user
--------------------------------------------------------
CREATE INDEX fk_auc_id_user ON acm_user_config (id_user);

--------------------------------------------------------
--  Constraints for Table acm_user_config
--------------------------------------------------------
ALTER TABLE acm_user_config ADD CONSTRAINT pk_acm_user_config PRIMARY KEY (id_user_config) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_user_config
--------------------------------------------------------
ALTER TABLE acm_user_config ADD CONSTRAINT fk_auc_id_user FOREIGN KEY (id_user)
	REFERENCES acm_user (id_user) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_user_config;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_user_config BEFORE INSERT ON acm_user_config
FOR EACH ROW
BEGIN
  SELECT sq_acm_user_config.NEXTVAL
    INTO :new.id_user_config
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_user_config ENABLE;