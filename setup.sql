# build a database
create database treehouse_etl_application;

# build a user dedicated (and limited) to page functions
create user `page_user`@`localhost`
 identified by 'Ug&%Z*9mw3%bFx+r'; # CHANGE THIS PASSWORD

# build a table to log attempted logins
create table `treehouse_etl_application`.`login_attempts` (
	`user_id` int(12) not null,
    `time_attempted` date
);

# build a table to store teams and their keys
# column names retain their label from NHL API source
create table `treehouse_etl_application`.`team_names` (
	`id` int(3) not null,
    `name` varchar(100)
);

# build a table to store player data from the user selected team
# column names retain their label from NHL API source
create table `treehouse_etl_application`.`player_names`(
	`id` int(3) not null,
    `fullName` varchar(200),
    `birthDate` date,
    `captain` bool,
    `link` varchar(50)
);

# grant rights to dedicated user, above, to selected tables
grant select, insert, delete on `treehouse_etl_application`.`team_names` to `page_user`@`localhost`;
grant select, insert, delete on `treehouse_etl_application`.`player_names` to `page_user`@`localhost`;

drop table `treehouse_etl_application`.`player_names`;