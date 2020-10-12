# PHP - P5 Openclassrooms - Créez votre premier blog en PHP

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/df302761ee7a4669b0b99f749ea2b610)](https://app.codacy.com/manual/florianleboul/Blog?utm_source=github.com&utm_medium=referral&utm_content=florianleboul/Blog&utm_campaign=Badge_Grade_Dashboard)

## Requirements : 
The above website was developed on the following environment :  
 - php 7.3
 - mysql 8.0

## Installation :
1. Download zip and extract it on your server or clone repository from github :
```
git clone https://github.com/florianleboul/Blog.git
```
 

2. Create database : 
   	- import sql/structures.sql -- Create database
	- import sql/fiwture.sql    -- (Optional) Create default information set

3. Set database informations
	- Copy config.ini to config.local.ini to set database info
```
; Database parameters
[database]
host     = "<Your SQL server name/ip>"
port     = "<Your SQL server port>"
dbname   = "<Database name | default : blog>"
username = "<SQL user with Read/Write access to database>"
password = "<SQL user's password>"
```

4. Create admin account : 
	- By fixtures.sql : admin/password
	- By database :
 		- Go to website
 		- Click on register
 		- Create account
 		- Edit on database to change your rigths 
