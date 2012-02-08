DROP TABLE IF EXISTS cms_banner;

CREATE TABLE  cms_banner  (
 id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 filename  VARCHAR( 100 ) NOT NULL ,
 count  INT NOT NULL ,
 weight  INT NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cms_edition;

CREATE TABLE  cms_edition  (
 id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 editionname  VARCHAR( 100 ) NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cms_news;

CREATE TABLE  cms_news  (
 id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 subject  VARCHAR( 255 ) NOT NULL ,
 content  TEXT NOT NULL ,
 pubdate  INT NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cms_news_which_edition;

CREATE TABLE  cms_news_which_edition  (
 news_id  INT NOT NULL ,
 edition_id  INT NOT NULL ,
PRIMARY KEY (  news_id  ,  edition_id  ),
FOREIGN KEY cms_news_fk1 (news_id) references cms_news(id),
FOREIGN KEY cms_news_fk2 (edition_id) references cms_edition(id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cms_ads;

CREATE TABLE  cms_ads  (
 id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 title  VARCHAR( 255 ) NOT NULL ,
 content  TEXT NOT NULL ,
 pubdate  INT NOT NULL ,
 approved  BOOL NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cms_ads_which_edition;

CREATE TABLE  cms_ads_which_edition  (
 ads_id  INT NOT NULL ,
 edition_id  INT NOT NULL ,
PRIMARY KEY (  ads_id  ,  edition_id  ),
FOREIGN KEY cms_ads_fk1 (ads_id) references cms_ads(id),
FOREIGN KEY cms_ads_fk2 (edition_id) references cms_edition(id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cms_editorial;

CREATE TABLE  cms_editorial  (
 id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 content  TEXT NOT NULL ,
 current boolean, 
 archivaldate  INT
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cms_user;

CREATE TABLE  cms_user  (
 username VARCHAR(10) PRIMARY KEY ,
 email  VARCHAR(255) NOT NULL ,
 password VARCHAR(255)  NOT NULL,
 access INT NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

-- password is 539admin

INSERT INTO cms_user (username, email, password, access) VALUES
( 'admin' ,  'admin@123.com' ,  '92118e620f95b967da60d445ddbf88bc3c98bdbf', 1);

