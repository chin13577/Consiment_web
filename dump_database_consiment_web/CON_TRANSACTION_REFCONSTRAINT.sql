--------------------------------------------------------
--  Ref Constraints for Table CON_TRANSACTION
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."CON_TRANSACTION" ADD CONSTRAINT "BUY" FOREIGN KEY ("BUYER_ID")
	  REFERENCES "SYSTEM"."CON_USER" ("USER_ID") ENABLE;
  ALTER TABLE "SYSTEM"."CON_TRANSACTION" ADD CONSTRAINT "SELL" FOREIGN KEY ("SELLER_ID")
	  REFERENCES "SYSTEM"."CON_USER" ("USER_ID") ENABLE;
