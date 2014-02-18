--------------------------------------------------------
--  DDL for Table acm_user_reset_password
--------------------------------------------------------
CREATE TABLE acm_user_reset_password 
(	
	id_user_reset_password NUMBER(10,0) NOT NULL, 
	id_user NUMBER(10,0) NOT NULL, 
	email VARCHAR2(250 CHAR), 
	key_access VARCHAR2(2000 CHAR) NOT NULL, 
	dtt_updated DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_user_reset_password
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_user_reset_password ON acm_user_reset_password (id_user_reset_password);

--------------------------------------------------------
--  DDL for Index fk_aurp_id_user
--------------------------------------------------------
CREATE INDEX fk_aurp_id_user ON acm_user_reset_password (id_user);

--------------------------------------------------------
--  Constraints for Table acm_user_reset_password
--------------------------------------------------------
ALTER TABLE acm_user_reset_password ADD CONSTRAINT pk_acm_user_reset_password PRIMARY KEY (id_user_reset_password) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_user_reset_password
--------------------------------------------------------
ALTER TABLE acm_user_reset_password ADD CONSTRAINT fk_aurp_id_user FOREIGN KEY (id_user)
	REFERENCES acm_user (id_user) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_user_reset_password;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_user_reset_password BEFORE INSERT ON acm_user_reset_password
FOR EACH ROW
BEGIN
  SELECT sq_acm_user_reset_password.NEXTVAL
    INTO :new.id_user_reset_password
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_user_reset_password ENABLE;