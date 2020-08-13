-- creating database social-media-replication
create database social-media-replication;
/* creating table reg_table */
CREATE TABLE `reg_table`(id integer(20),firstname varchar(255),lastname varchar(255),email varchar(255),password varchar(30));
-- creating table posts
CREATE TABLE `posts` (id integer(20),message varchar(255),date datetime);
-- creating friend_requests table
CREATE TABLE friend_requests (id integer(20),sender_id integer(20),receiver_id integer(20),status enum('not_friends','friends','requested'));