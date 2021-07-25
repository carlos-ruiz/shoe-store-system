# init.sql

create database controlbom;
use controlbom;
source /db/database.sql;

create user appuser identified by "appuserPasswd";
grant all privileges on controlbom.* to appuser@'%';