--------------------------------------------------------
--  DDL for Table acm_app_pkg_upd_err_msg
--------------------------------------------------------
CREATE TABLE acm_app_pkg_upd_err_msg
(	
	id_app_pkg_upd_err_msg NUMBER(10,0) NOT NULL, 
	id_app_pkg_upd NUMBER(10,0) NOT NULL, 
	message VARCHAR2(2000 CHAR), 
	order_ NUMBER(10,0), 
	log_dtt_ins DATE DEFAULT SYSDATE
);

--------------------------------------------------------
--  DDL for Index pk_acm_app_pkg_upd_err_msg
--------------------------------------------------------
CREATE UNIQUE INDEX pk_acm_app_pkg_upd_err_msg ON acm_app_pkg_upd_err_msg (id_app_pkg_upd_err_msg);

--------------------------------------------------------
--  DDL for Index fk_aapuem_id_app_pkg_upd
--------------------------------------------------------
CREATE INDEX fk_aapuem_id_app_pkg_upd ON acm_app_pkg_upd_err_msg (id_app_pkg_upd);

--------------------------------------------------------
--  Constraints for Table acm_app_pkg_upd_err_msg
--------------------------------------------------------
ALTER TABLE acm_app_pkg_upd_err_msg ADD CONSTRAINT pk_acm_app_pkg_upd_err_msg PRIMARY KEY (id_app_pkg_upd_err_msg) ENABLE;

--------------------------------------------------------
--  Ref Constraints for Table acm_app_pkg_upd_err_msg
--------------------------------------------------------
ALTER TABLE acm_app_pkg_upd_err_msg ADD CONSTRAINT fk_aapuem_id_app_pkg_upd FOREIGN KEY (id_app_pkg_upd)
	REFERENCES acm_app_pkg_upd (id_app_pkg_upd) ENABLE;
	
--------------------------------------------------------
--  Sequence for AUTO_INCREMENT
--------------------------------------------------------
CREATE SEQUENCE sq_acm_app_pkg_upd_err_msg;

--------------------------------------------------------
--  DDL for Trigger tgr_acm_app_pkg_upd_err_msg
--------------------------------------------------------
CREATE OR REPLACE TRIGGER tgr_acm_app_pkg_upd_err_msg BEFORE INSERT ON acm_app_pkg_upd_err_msg
FOR EACH ROW
BEGIN
  SELECT sq_acm_app_pkg_upd_err_msg.NEXTVAL
    INTO :new.id_app_pkg_upd_err_msg
    FROM DUAL;
END;
/
ALTER TRIGGER tgr_acm_app_pkg_upd_err_msg ENABLE;