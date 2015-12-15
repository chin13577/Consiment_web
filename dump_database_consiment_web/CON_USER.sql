--------------------------------------------------------
--  DDL for Table CON_USER
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."CON_USER" 
   (	"USER_ID" VARCHAR2(20 BYTE), 
	"USER_PW" VARCHAR2(20 BYTE), 
	"NAME" VARCHAR2(20 BYTE), 
	"ADDRESS" VARCHAR2(20 BYTE), 
	"EXP" DATE, 
	"USER_PHOTO" VARCHAR2(60 BYTE), 
	"SSN" NUMBER(13,0), 
	"B_ACCOUNT" NUMBER(20,0)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
