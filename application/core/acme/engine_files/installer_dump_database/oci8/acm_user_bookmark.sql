--------------------------------------------------------
--  DDL for Table acm_user_bookmark
--------------------------------------------------------
CREATE TABLE acm_user_bookmark 
(	
	id_user_bookmark NUMBER(10,0) NOT NULL, 
	id_user NUMBER(10,0) NOT NULL, 
	name VARCHAR2(100 CHAR), 
	link VARCHAR2(2000 CHAR), 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index fk_aub_id_user
--------------------------------------------------------
CREATE INDEX fk_aub_id_user ON acm_user_bookmark (id_user);

--------------------------------------------------------
--  DDL for Index pk_acm_user_bookmark
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_user_bookmark ON acm_user_bookmark (id_user_bookmark);

--------------------------------------------------------
--  Constraints for Table acm_user_bookmark
--------------------------------------------------------
ALTER TABLE acm_user_bookmark ADD CONSTRAINT pk_acm_user_bookmark PRIMARY KEY (id_user_bookmark) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_user_bookmark
--------------------------------------------------------
ALTER TABLE acm_user_bookmark ADD CONSTRAINT fk_aub_id_user FOREIGN KEY (id_user)
	REFERENCES acm_user (id_user) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_user_bookmark;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_user_bookmark BEFORE INSERT ON acm_user_bookmark
FOR EACH ROW
BEGIN
  SELECT sq_acm_user_bookmark.NEXTVAL
    INTO :new.id_user_bookmark
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_user_bookmark ENABLE;