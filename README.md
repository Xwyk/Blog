# PHP - P5 Openclassrooms - Créez votre premier blog en PHP

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/df302761ee7a4669b0b99f749ea2b610)](https://app.codacy.com/manual/florianleboul/Blog?utm_source=github.com&utm_medium=referral&utm_content=florianleboul/Blog&utm_campaign=Badge_Grade_Dashboard)

## Requirements : 
The above website was developed on the following environment :  
 - php 7.3
 - mysql 8.0
And require
 - php >= 7.0
 - mysql >= 5.6

## Installation :
In this installation guide, I suppose server is configured, with given requirements.
1. Download zip and extract it on your server or clone repository from github :
```
git clone https://github.com/florianleboul/Blog.git
```

2. Create database : 
	- Create database, select it and import above scripts to create tables and default values set
   	- import sql/structures.sql -- Create tables
	- import sql/fixture.sql    -- Create default information set

3. Set database informations
	- Copy config.ini to config.local.ini to set database info
```
; Database parameters
[database]
host     = "<Your SQL server name/ip>"
port     = "<Your SQL server port>"
dbname   = "<Database name, created in step 2>"
username = "<SQL user with Read/Write access to database>"
password = "<SQL user's password>"
```

4. Create admin account : 
	- Admin account is created by importing sql/fixture.sql in step 2 :
		- username : webadm
		- password : password
	- For increase security, change password by :
		- Connect to website with given credentials
		- Go to account section
		- On password section, type your new password two times and click on save
