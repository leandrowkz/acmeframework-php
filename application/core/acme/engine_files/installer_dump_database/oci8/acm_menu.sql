--------------------------------------------------------
--  DDL for Table acm_menu
--------------------------------------------------------
CREATE TABLE acm_menu 
(	
	id_menu NUMBER(10,0) NOT NULL, 
	id_menu_parent NUMBER(10,0), 
	id_user_group NUMBER(10,0) NOT NULL, 
	lang_key_rotule VARCHAR2(250 CHAR), 
	link VARCHAR2(2000 CHAR), 
	target VARCHAR2(50 CHAR), 
	javascript VARCHAR2(2000 CHAR), 
	url_img VARCHAR2(2000 CHAR), 
	description VARCHAR2(2000 CHAR), 
	order_ NUMBER(10,0), 
	dtt_inative DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);


--------------------------------------------------------
--  DDL for Index pk_acm_menu
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_menu ON acm_menu (id_menu);

--------------------------------------------------------
--  DDL for Index fk_am_id_user_group
--------------------------------------------------------
CREATE INDEX fk_am_id_user_group ON acm_menu (id_user_group);

--------------------------------------------------------
--  DDL for Index fk_am_id_menu_parent
--------------------------------------------------------
CREATE INDEX fk_am_id_menu_parent ON acm_menu (id_menu_parent);

--------------------------------------------------------
--  Constraints for Table acm_menu
--------------------------------------------------------
ALTER TABLE acm_menu ADD CONSTRAINT pk_acm_menu PRIMARY KEY (id_menu) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_menu
--------------------------------------------------------
ALTER TABLE acm_menu ADD CONSTRAINT fk_am_id_menu_parent FOREIGN KEY (id_menu_parent)
	REFERENCES acm_menu (id_menu) ENABLE;
ALTER TABLE acm_menu ADD CONSTRAINT fk_am_id_user_group FOREIGN KEY (id_user_group)
	REFERENCES acm_user_group (id_user_group) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_menu;

--------------------------------------------------------
--  DDL for Trigger for AUTO_INCREMENT
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_menu BEFORE INSERT ON acm_menu
FOR EACH ROW
BEGIN
  SELECT sq_acm_menu.NEXTVAL
    INTO :new.id_menu
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_menu ENABLE;