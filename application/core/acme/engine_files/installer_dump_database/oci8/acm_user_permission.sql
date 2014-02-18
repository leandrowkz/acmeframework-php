--------------------------------------------------------
--  DDL for Table acm_user_permission
--------------------------------------------------------
CREATE TABLE acm_user_permission 
(	
	id_user_permission NUMBER(10,0) NOT NULL, 
	id_user NUMBER(10,0) NOT NULL, 
	id_module_permission NUMBER(10,0) NOT NULL, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_user_permission
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_user_permission ON acm_user_permission (id_user_permission);

--------------------------------------------------------
--  DDL for fk_aup_id_user
--------------------------------------------------------
CREATE INDEX fk_aup_id_user ON acm_user_permission (id_user);

--------------------------------------------------------
--  DDL for Index fk_aup_id_module_permission
--------------------------------------------------------
CREATE INDEX fk_aup_id_module_permission ON acm_user_permission (id_module_permission);

--------------------------------------------------------
--  Constraints for Table acm_user_permission
--------------------------------------------------------
ALTER TABLE acm_user_permission ADD CONSTRAINT pk_acm_user_permission PRIMARY KEY (id_user_permission) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_user_permission
--------------------------------------------------------
ALTER TABLE acm_user_permission ADD CONSTRAINT fk_aup_id_module_permission FOREIGN KEY (id_module_permission)
	REFERENCES acm_module_permission (id_module_permission) ENABLE;
ALTER TABLE acm_user_permission ADD CONSTRAINT fk_aup_id_user FOREIGN KEY (id_user)
	REFERENCES acm_user (id_user) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_user_permission;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_user_permission BEFORE INSERT ON acm_user_permission
FOR EACH ROW
BEGIN
  SELECT sq_acm_user_permission.NEXTVAL
    INTO :new.id_user_permission
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_user_permission ENABLE;