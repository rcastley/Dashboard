CREATE TABLE "tests" (
	"id" integer UNIQUE,
	"type" integer NULL,
	"monitor" integer NULL,
	"name" varchar(255) NULL,
	PRIMARY KEY (id, name)
);

CREATE TABLE "nodes" (
	"id" integer UNIQUE,
	"name" varchar(255) NULL,
	"city" varchar(255) NULL,
	PRIMARY KEY (id, name)
);

CREATE TABLE "summary" (
	"id" integer PRIMARY KEY AUTOINCREMENT,
	"testid" integer NULL,
	"nodeid" integer NULL,
	"timestamp" datetime NULL,
	"total" integer NULL,
	"connect" integer NULL,
	"dns" integer NULL,
	"contentload" integer NULL,
	"load" integer NULL,
	"send" integer NULL,
	"wait" integer NULL,
	"documentcomplete" integer NULL,
	"domload" integer NULL,
	"renderstart" integer NULL,
	"content" integer NULL,
	"headers" integer NULL,
	"totalcontent" integer NULL,
	"totalheaders" integer NULL,
	"connections" integer NULL,
	"hosts" integer NULL,
	"failedrequests" integer NULL,
	"requests" integer NULL,
	"error" integer NULL
);
