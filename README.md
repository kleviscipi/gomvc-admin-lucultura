## Mvc simple framework project.


[![Screenshot_from_2017-10-07_19-12-07.png](https://s20.postimg.org/o45ch16wt/Screenshot_from_2017-10-07_19-12-07.png)](https://postimg.org/image/6qv226bll/)



This is simple project mvc with tow routes:

src
	--controller
	--model
	--view

srcApi
	--Apicontroller
	--Apimodel

On this project:

* Dashboard Admin
* Permission => create user and add permissions of routes.
* Create controller,model,view from terminal.
* User with a specific role
* User can modify the the personal data and password
* User can add single or multiple movies from IMDB
* User can add single or multiple books from google
* Super user can change role delete or insert role, can add permissions or delete them,
* This project support multilingual site now(it/en).
* Notifications, if a user do an action , a notice is added to super user.
* Super user ca added just one time, if you want to change, tou do that manualy ti db.
* For now is suported the postgres.
* Multiple tenmplate

Note:: Now is used the matrix dashboard template you can not use for comercial scope  --> http://themedesigner.in/demo/matrix-admin/index.html.


Note:: This project is created just for begginers and i hope this project can help someone to understand the mvc and logic of permissions.

## Setup

`git clone https://github.com/kleviscipi/gomvc-admin-lucultura.git`

after clone the repository go inside project

`/App/Core/_data/nginx`

and see the example of nginx file.

Create  local domain `http://gomvc-admin.local` on `/etc/hosts` .
Note:: for this project is used the composer if you dont have the composer installed on your computer you can take from website `https://getcomposer.org/download/`

After install if you don seethe rotes, can generate with command 'composer dump-autoload -a'. but before must cerate the db
```SQL
CREATE DATABASE gomvc ENCODING 'UTF-8';
CREATE USER gomvc WITH PASSWORD 'plplpl';
GRANT ALL PRIVILEGES ON DATABASE gomvc TO gomvc;
```

and go to  `App/Core/_data/_schema/sql_query.sql` ,`sql_natyre.sql` , `sql_movies.sql` , `keys.sql` install all tables.
For all data install the dump   `App/Core/_data/_schema/gomvcdump.sql` where is included , users, roles ect ect;

Command for dump postgres

```SQL

  pg_dump --host=localhost --username=gomvc gomvc > gomvc-admin-lucultura/App/Core/_data/_schema/gomvcdump.sql

```

## Login
go to url `http://gomvc-admin.local/Admin/login`
``
Username: cipiklevis@gmail.com
Password: plplpl
``

## Generate files from terminal.

go to `App/Core/_data/bin` from terminal

the file for creating is `GoCreateFiles.php`

the comand is:  `php GoCreateFiles.php <nameofcontroller> <nameoftable>`

Note: with command you have created alle files

`App/languages/en/<nameofcontroller>`
`App/languages/it/<nameofcontroller>`
`App/Src/Controllers/<nameofcontroller>`
`App/Src/Models/<nameofcontroller>`
`App/Src/Views/<nameofcontroller>/` Index,Add,View

`App/SrcApi/ApiControllers/<nameofcontroller>`
`App/SrcApi/ApiModels/<nameofcontroller>`

Note: Before generate files  , create the table on db and after generate files go to `/Permissions/Index` and add the name of controller.

Thank You!
