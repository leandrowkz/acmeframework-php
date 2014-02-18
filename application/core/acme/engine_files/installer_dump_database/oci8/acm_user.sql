--------------------------------------------------------
--  DDL for Table acm_user
--------------------------------------------------------
CREATE TABLE acm_user 
(	
	id_user NUMBER(10,0) NOT NULL, 
	id_user_group NUMBER(10,0) NOT NULL, 
	login VARCHAR2(250 CHAR) NOT NULL, 
	password VARCHAR2(2000 CHAR) NOT NULL, 
	name VARCHAR2(250 CHAR), 
	email VARCHAR2(250 CHAR), 
	url_img VARCHAR2(2000 CHAR), 
	url_img_large VARCHAR2(2000 CHAR), 
	observation VARCHAR2(2000 CHAR), 
	dtt_inative DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index fk_au_id_user_group
--------------------------------------------------------
CREATE INDEX fk_au_id_user_group ON acm_user (id_user_group);

--------------------------------------------------------
--  DDL for Index pk_acm_user
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_user ON acm_user (id_user);

--------------------------------------------------------
--  Constraints for Table acm_user
--------------------------------------------------------
ALTER TABLE acm_user ADD CONSTRAINT pk_acm_user PRIMARY KEY (id_user) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_user
--------------------------------------------------------
ALTER TABLE acm_user ADD CONSTRAINT fk_au_id_user_group FOREIGN KEY (id_user_group)
	REFERENCES acm_user_group (id_user_group) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_user;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_user BEFORE INSERT ON acm_user
FOR EACH ROW
BEGIN
  SELECT sq_acm_user.NEXTVAL
    INTO :new.id_user
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_user ENABLE;