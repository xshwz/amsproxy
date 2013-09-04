DROP TABLE IF EXISTS "message";
CREATE TABLE "message" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "sender" text NOT NULL,
  "receiver" text NOT NULL,
  "message" text NOT NULL,
  "time" numeric NOT NULL,
  "state" integer NOT NULL DEFAULT '1',
  FOREIGN KEY ("sender") REFERENCES "student" ("sid"),
  FOREIGN KEY ("receiver") REFERENCES "student" ("sid")
);


DROP TABLE IF EXISTS "setting";
CREATE TABLE "setting" (
  "password" text NOT NULL,
  "crypt_key" text NOT NULL,
  "start_date" numeric NOT NULL,
  "end_date" numeric NOT NULL
);


DROP TABLE IF EXISTS "student";
CREATE TABLE "student" (
  "sid" text NOT NULL,
  "pwd" text NOT NULL,
  "info" text NULL,
  "course" text NULL,
  "score" text NULL,
  "last_login_time" numeric NOT NULL,
  PRIMARY KEY ("sid")
);
