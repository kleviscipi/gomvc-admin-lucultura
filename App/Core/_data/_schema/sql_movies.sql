CREATE TABLE IF NOT EXISTS actors(
	id 				serial PRIMARY KEY,
	idm_id 			VARCHAR(30) NOT NULL,
	description 	text,
	ocupation 		TEXT[],
	name 			VARCHAR(100),
	image 			text,
	created 		timestamp DEFAULT CURRENT_TIMESTAMP,
	modified 		timestamp 
);

CREATE TABLE IF NOT EXISTS actormedia(
	id 			serial PRIMARY KEY,
	link 		text,
	idm_id 		VARCHAR(20),
	created 	timestamp DEFAULT CURRENT_TIMESTAMP,
	modified 	timestamp 
);
CREATE TABLE IF NOT EXISTS trailers(
	id 			serial PRIMARY KEY,
	link 		text,
	idm_movie 	VARCHAR(255),
	created 	timestamp DEFAULT CURRENT_TIMESTAMP,
	modified 	timestamp 
);

CREATE TABLE IF NOT EXISTS movies(

	id 			serial PRIMARY KEY,
	idm_id 		VARCHAR(20),
	idm_actor 	VARCHAR(20),
	info 		VARCHAR(255),
	title 		VARCHAR(255),
	year 		VARCHAR(20),
	description TEXT,
	casts 		TEXT[],
	direction 	TEXT[],
	duration 	VARCHAR(60),
	genres 		TEXT[],
	image 		TEXT,
	texts		TEXT,
	rating		VARCHAR(100),
	released 	VARCHAR(20),
	writers 	TEXT[],
	created 		timestamp DEFAULT CURRENT_TIMESTAMP,
	modified 		timestamp 
);

ALTER TABLE movies ADD column onsite bool default false;
ALTER TABLE movies ADD column onheadersite bool default false;
ALTER TABLE movies ADD column viewss int default 0;

CREATE TABLE IF NOT EXISTS moviecompanies(
	id 			serial PRIMARY KEY,
	idm_id 		VARCHAR(20),
	name 		VARCHAR(100),
	created 	timestamp DEFAULT CURRENT_TIMESTAMP,
	modified 	timestamp 
);

CREATE TABLE IF NOT EXISTS imgheadermovie(
	id 			serial PRIMARY KEY,
	id_movie 	int,
	pathimg 	VARCHAR(100),
	created 	timestamp DEFAULT CURRENT_TIMESTAMP,
	modified 	timestamp 
);
