--------------------------------------------------------
--  Ref Constraints for Table CON_PHOTO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."CON_PHOTO" ADD CONSTRAINT "FK_NAME" FOREIGN KEY ("P_ID")
	  REFERENCES "SYSTEM"."CON_PRODUCT" ("P_ID") ON DELETE CASCADE ENABLE;
