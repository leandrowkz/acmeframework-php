--------------------------------------------------------
--  DDL for Table acm_user_group
--------------------------------------------------------
CREATE TABLE acm_user_group 
(	
	id_user_group NUMBER(10,0) NOT NULL, 
	name VARCHAR2(100 CHAR) NOT NULL, 
	description VARCHAR2(2000 CHAR), 
	dtt_inative DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_user_group
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_user_group ON acm_user_group (id_user_group);

--------------------------------------------------------
--  Constraints for Table acm_user_group
--------------------------------------------------------
ALTER TABLE acm_user_group ADD CONSTRAINT pk_acm_user_group PRIMARY KEY (id_user_group) ENABLE;

--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_user_group;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_user_group BEFORE INSERT ON acm_user_group
FOR EACH ROW
BEGIN
  SELECT sq_acm_user_group.NEXTVAL
    INTO :new.id_user_group
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_user_group ENABLE;