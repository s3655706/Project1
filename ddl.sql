CREATE TABLE users (
  email VARCHAR2(50) PRIMARY KEY NOT NULL,
  username VARCHAR2(20),
  password VARCHAR2(100) NOT NULL,
  phone VARCHAR2(50),
  age INT,
  gender VARCHAR2(15),
  user_type INT DEFAULT 0,
  area_id INT DEFAULT 0,
  education INT DEFAULT 0,
  description VARCHAR2(50) DEFAULT ''

);

CREATE TABLE posts
(
  id VARCHAR2(100) PRIMARY KEY NOT NULL,
  title VARCHAR2(100),
  content VARCHAR2(1024),
  publish_time DATE,
  area_id INT,
  post_type INT,
  education_type INT,
  user_email VARCHAR2(50)
);
CREATE TABLE comments
(
  id VARCHAR2(100) PRIMARY KEY NOT NULL,
  post_id VARCHAR2(100),
  content VARCHAR2(1024),
  publish_time DATE,
  user_email VARCHAR2(50)
);