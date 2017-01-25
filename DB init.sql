/* Create tables */

CREATE TABLE users(
    'UserID'    INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    'Username'  VARCHAR NOT NULL,
    'Password'  VARCHAR NOT NULL,
    'Birthday'  DATE NOT NULL,
    'PictureID' INTEGER,
    'Privacy'   ENUM('Low', 'Medium', 'High') NOT NULL
);

CREATE TABLE friendships(
    'UserOne'   INTEGER NOT NULL PRIMARY KEY,
    'UserTwo'   INTEGER NOT NULL PRIMARY KEY
);

CREATE TABLE pictures(
    'PictureID' INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    'Time'      DATETIME,
    'Picture'   VARBINARY NOT NULL
);

CREATE TABLE groups(
    'GroupID'   INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    'BlogID'    INTEGER NOT NULL,
    'Name'      VARCHAR NOT NULL,
    'PictureID' INTEGER,
    'Privacy'   ENUM('Low', 'Medium', 'High') NOT NULL
);

CREATE TABLE group_members(
    'GroupID'   INTEGER NOT NULL PRIMARY KEY,
    'UserID'    INTEGER NOT NULL PRIMARY KEY
);

CREATE TABLE blogs(
    'ID'        INTEGER NOT NULL PRIMARY KEY,
    'IsGroup'   BOOLEAN NOT NULL PRIMARY KEY,
    'Name'      VARCHAR NOT NULL,
    'Privacy'   ENUM('Low', 'Medium', 'High') NOT NULL
);

CREATE TABLE posts(
    'ID'        INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    'BlogID'    INTEGER NOT NULL,
    'Time'      DATETIME NOT NULL,
    'Text'      VARCHAR,
    'AlbumID'   INTEGER,
    'Emoji'     VARCHAR /* Not sure how to handle this... */
);

CREATE TABLE albums(
    'AlbumID'   INTEGER NOT NULL PRIMARY KEY,
    'OwnerID'   INTEGER NOT NULL,
    'Time'      DATETIME NOT NULL,
    'Privacy'   ENUM('Low', 'Medium', 'High') NOT NULL
);

CREATE TABLE album_contents(
    'AlbumID'   INTEGER NOT NULL PRIMARY KEY,
    'PictureID' INTEGER NOT NULL PRIMARY KEY
);

CREATE TABLE comments(
    'CommentID' INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    'Time'      DATETIME NOT NULL,
    /* 'Text'      VARCHAR NOT NULL, */
    'PostID'    INTEGER NOT NULL,
    'UserID'    INTEGER NOT NULL,
    'Emoji'     VARCHAR /* Again, not sure how to handle this... */
);

/* Insert dummy data */

INSERT INTO users
    ('UserID', 'Username',       'Password',    'Birthday',   'Privacy')
VALUES
    (1,        'Mabel Chan',     'password123', '1994-01-16', 'High'),
    (2,        'Mairi Ng',       'password123', '1989-05-16', 'Low' ),
    (3,        'Marisa Enhuber', 'password123', '1989-07-06', 'High'),
    (4,        'Zak Walters',    'password123', '1994-05-20', 'High');

INSERT INTO friendships
    ('UserOne', 'UserTwo')
VALUES
    (1,         3),
    (1,         4),
    (3,         4);
