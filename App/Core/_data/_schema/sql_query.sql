CREATE DATABASE gomvc ENCODING 'UTF-8';
CREATE USER gomvc WITH PASSWORD 'plplpl';
GRANT ALL PRIVILEGES ON DATABASE gomvc TO gomvc;

CREATE TABLE  IF NOT EXISTS persons(id serial PRIMARY KEY,name VARCHAR(10), subname VARCHAR(10)); 

INSERT INTO persons (name,subname)VALUES('KLEVIS','CIPI'),('KLEVIS','CIPI'),('KLEVIS','CIPI');

CREATE TABLE IF NOT EXISTS users(
	id 				serial PRIMARY KEY,
	name 			VARCHAR(30) NOT NULL,
	subname 		VARCHAR(30) NOT NULL,
	email 			VARCHAR(64) UNIQUE NOT NULL,
	username 		VARCHAR(30) UNIQUE NOT NULL,
	password 		VARCHAR(255) NOT NULL,
	token    		VARCHAR(255),
	tokenpassword   VARCHAR(255),
	role_id  		smallint,
	created 		timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS role(
	id serial PRIMARY KEY,
	name VARCHAR(20) NOT NULL,
	status BOOL NOT NULL DEFAULT false
);
ALTER TABLE role ADD column superuser BOOL NOT NULL default false;


CREATE TABLE IF NOT EXISTS permisions(
	id serial PRIMARY KEY,
	controller 	VARCHAR(20) NOT NULL,
	method 		VARCHAR(20) NOT NULL,
	param1 		VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS role_permisions(
	id serial PRIMARY KEY,
	role_id int NOT NULL,
	permision_id int NOT NULL,
	permited bool default false,
	FOREIGN KEY (role_id) REFERENCES role(id),
	FOREIGN KEY (permision_id) REFERENCES permisions(id)
);

CREATE TABLE IF NOT EXISTS user_permisions(
	id serial PRIMARY KEY,
	permision_id int NOT NULL,
	user_id int NOT NULL,
	role_id int NOT NULL,
	permited bool default false,
	FOREIGN KEY (permision_id) REFERENCES permisions(id),
	FOREIGN KEY (user_id) REFERENCES users(id)  
);
 ALTER TABLE permisions ADD column sublink  BOOL NOT NULL default false;

CREATE TABLE IF NOT EXISTS actions(
	id serial PRIMARY KEY,
	action 			VARCHAR(20),
	controller 		VARCHAR(20),
	description 	VARCHAR(255),
	user_id 		int,
	counts			int,
	forsuperuser 	bool default true,
	status 			bool default false,
	created 		timestamp DEFAULT CURRENT_TIMESTAMP
);
-- status true is readed false is unreaded

CREATE TABLE IF NOT EXISTS magicpermissions(
	id serial PRIMARY KEY,
	action 			VARCHAR(20),
	user_id 		VARCHAR(20),
);


CREATE TABLE IF NOT EXISTS access(
	id serial PRIMARY KEY,
	action 		BOOL default false,
	ip 			VARCHAR(100),
	username 	VARCHAR(100),
	email 		VARCHAR(100),
	user_id 	VARCHAR(100),
	created 	timestamp DEFAULT CURRENT_TIMESTAMP
);
-- if true login if false logout

CREATE TABLE IF NOT EXISTS visits(
	id serial PRIMARY KEY,
	state 		BOOL default false,
	ip 			VARCHAR(100),
	broswer 	VARCHAR(200),
	created 	timestamp DEFAULT CURRENT_TIMESTAMP
);