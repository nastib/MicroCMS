use micorcms;
drop table if exists t_articles;

create table t_article(
art_id integer not null primary key auto_increment,
art_title varchar(100) not null,
art_content varchar(2000) not null
) engine=innobd character set utf8 collate utf__unicode_ci;