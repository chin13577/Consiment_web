--------------------------------------------------------
--  Ref Constraints for Table CON_PRODUCT
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."CON_PRODUCT" ADD CONSTRAINT "ADVERTISE" FOREIGN KEY ("SELLER_ID")
	  REFERENCES "SYSTEM"."CON_USER" ("USER_ID") ENABLE;
