-- // postgres
CREATE TABLE IF NOT EXISTS gokeys(id serial PRIMARY KEY,thatkey text,type varchar(20));

INSERT INTO gokeys(thatkey,type)VALUES('weiufo0urefm9034!@#@&*&#$#$68691898*@!plob0215','api');
INSERT INTO gokeys(thatkey,type)VALUES('weiufo0ure5gp!@#@&*&#$#$68691898*@!plob0215','site');
INSERT INTO gokeys(thatkey,type)VALUES('ifhiml58*woiu23423wg11*&6r4we$$#@@~#@$@#fik','password');


-- // mysql 
CREATE TABLE IF NOT EXISTS gokeys(id INT AUTO_INCREMENT PRIMARY KEY,thatkey text,type varchar(20));

INSERT INTO gokeys(thatkey,type)VALUES('weiufo0urefm9034!@#@&*&#$#$68691898*@!plob0215','api');
INSERT INTO gokeys(thatkey,type)VALUES('weiufo0ure5gp!@#@&*&#$#$68691898*@!plob0215','site');
INSERT INTO gokeys(thatkey,type)VALUES('ifhiml58*woiu23423wg11*&6r4we$$#@@~#@$@#fik','password');
