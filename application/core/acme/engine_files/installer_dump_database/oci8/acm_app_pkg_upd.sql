--------------------------------------------------------
--  DDL for Table acm_app_pkg_upd
--------------------------------------------------------
CREATE TABLE acm_app_pkg_upd
(	
	id_app_pkg_upd NUMBER(10,0) NOT NULL, 
	version VARCHAR2(20 CHAR) NOT NULL, 
	version_father VARCHAR2(20 CHAR), 
	name VARCHAR2(250 CHAR) NOT NULL, 
	description VARCHAR2(2000 CHAR), 
	path_file VARCHAR2(250 CHAR), 
	dtt_package_available DATE, 
	dtt_package_installed DATE, 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_app_pkg_upd
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_app_pkg_upd ON acm_app_pkg_upd (id_app_pkg_upd);

--------------------------------------------------------
--  Constraints for Table acm_app_pkg_upd
--------------------------------------------------------
ALTER TABLE acm_app_pkg_upd ADD CONSTRAINT pk_acm_app_pkg_upd PRIMARY KEY (id_app_pkg_upd) ENABLE;

--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_app_pkg_upd;

--------------------------------------------------------
--  DDL for Trigger for acm_app_pkg_upd
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_app_pkg_upd BEFORE INSERT ON acm_app_pkg_upd
FOR EACH ROW
BEGIN
  SELECT sq_acm_app_pkg_upd.NEXTVAL
    INTO :new.id_app_pkg_upd
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_app_pkg_upd ENABLE;