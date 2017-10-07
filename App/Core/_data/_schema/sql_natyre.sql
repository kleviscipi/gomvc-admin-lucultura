CREATE TABLE IF NOT EXISTS natyres(
	id 				serial PRIMARY KEY,
	web_id 			int,
	webwidth 		VARCHAR(10),
	webheight 		VARCHAR(10),
	downloads 		int,
	pageurl 		VARCHAR(255),
	weburl 			text,
	tags			VARCHAR(255),
	created 		timestamp DEFAULT CURRENT_TIMESTAMP,
	modified 		timestamp 
);

CREATE TABLE IF NOT EXISTS videonatyres(
	id 				serial PRIMARY KEY,
	web_id 			int,
	picture_id		int,
	webwidth 		VARCHAR(10),
	webheight 		VARCHAR(10),
	size	 		int,
	downloads 		int,
	pageurl 		VARCHAR(255),
	weburl 			text,
	tags			VARCHAR(255),
	duration 		int,
	created 		timestamp DEFAULT CURRENT_TIMESTAMP,
	modified 		timestamp 
);

CREATE TABLE IF NOT EXISTS cronjobs(
	id 				serial PRIMARY KEY,
	type 			VARCHAR(20),
	actionby		VARCHAR(20),
	duration 		VARCHAR(100),
	records 		VARCHAR(100),
	created 		timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE books (
    id integer NOT NULL,
    google_id character varying(100),
    json_volume character varying(255),
    previewlink text,
    title character varying(255),
    author_id integer,
    author_name character varying(255),
    publisher character varying(255),
    publisherdate character varying(10),
    description text,
    categories text[],
    pages integer,
    rating character varying(10),
    language character varying(3),
    image text
);