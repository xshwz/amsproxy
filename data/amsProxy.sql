DROP TABLE IF EXISTS "message";
CREATE TABLE "message" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "sender" text NOT NULL,
  "receiver" text NOT NULL,
  "message" text NOT NULL,
  "time" numeric NOT NULL, "state" integer NOT NULL DEFAULT '0',
  FOREIGN KEY ("sender") REFERENCES "student" ("sid"),
  FOREIGN KEY ("receiver") REFERENCES "student" ("sid")
);


DROP TABLE IF EXISTS "setting";
CREATE TABLE "setting" (
  "start_date" numeric NOT NULL,
  "end_date" numeric NOT NULL,
  "wechat_auto_reply" integer NOT NULL,
  "wechat_token" text NOT NULL
);

INSERT INTO "setting" ("start_date", "end_date", "wechat_auto_reply", "wechat_token") VALUES ('2014-02-19',	'2014-01-15',	1,	'you-token');

DROP TABLE IF EXISTS "student";
CREATE TABLE "student" (
  "sid" text NOT NULL,
  "archives" text NULL,
  "course" text NULL,
  "score" text NULL,
  "rank_exam" text NULL,
  "exam_arrangement" text NULL,
  "theory_subject" text NULL,
  "last_login_time" numeric NULL,
  "openid_subscribe" text NULL,
  "openid_server" text NULL,
  "is_admin" integer NULL,
  PRIMARY KEY ("sid")
);


DROP TABLE IF EXISTS "wechat_log";
CREATE TABLE "wechat_log" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "message" text NOT NULL,
  "state" integer NOT NULL DEFAULT '0'
);
