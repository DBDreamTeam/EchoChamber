/* Create tables */

/*
For privacy:
Low:    Anyone can view
Medium: Friends of friends can view
High:   Only friends can view
*/

CREATE TABLE users(
    'UserID'    INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    'Username'  VARCHAR NOT NULL,
    'Password'  VARCHAR NOT NULL,
    'Birthday'  DATE NOT NULL,
    'PictureID' INTEGER,
    'Privacy'   ENUM('Friends', 'Circles', 'FriendsOfFriends', 'Public') NOT NULL
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
    'Privacy'   ENUM('Friends', 'Circles', 'FriendsOfFriends') NOT NULL
);

CREATE TABLE group_members(
    'GroupID'   INTEGER NOT NULL PRIMARY KEY,
    'UserID'    INTEGER NOT NULL PRIMARY KEY
);

CREATE TABLE blog_wall(
    'ID'        INTEGER NOT NULL PRIMARY KEY,
    'IsGroup'   BOOLEAN NOT NULL PRIMARY KEY,
    'Name'      VARCHAR NOT NULL,
    'Privacy'   ENUM('Friends', 'Circles', 'FriendsOfFriends', 'Public') NOT NULL
);

CREATE TABLE posts(
    'PostID'        INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
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
    'Privacy'   ENUM('Friends', 'Circles', 'FriendsOfFriends') NOT NULL
);

CREATE TABLE comments(
    'CommentID' INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    'Time'      DATETIME NOT NULL,
    'Text'      VARCHAR NOT NULL,
    'PostID'    INTEGER NOT NULL,
    'UserID'    INTEGER NOT NULL,
);

CREATE TABLE sentiments(
    'UserID'    INTEGER NOT NULL PRIMARY KEY,
    'Entity'    VARCHAR NOT NULL PRIMARY KEY,
    'Sentiment' DECIMAL(7, 6)
);

CREATE TABLE message(
    'MessageID' INTEGER NOT NULL PRIMARY KEY,
    'ChatID'    INTEGER NOT NULL,
    'UserID'    INTEGER NOT NULL,
    'Text'      TEXT NOT NULL,
    'Photo'     IMAGE,
    'DateTime'  DATETIME NOT NULL,
);

CREATE TABLE chat(
    'ChatID'    INTEGER NOT NULL PRIMARY KEY,
    'ChatTitle' TEXT NOT NULL,
);


CREATE TABLE chat_members (
    'ChatID'    INTEGER NOT NULL PRIMARY KEY,
    'UserID'    INTEGER NOT NULL PRIMARY KEY,
);
    
    
    

/* Insert dummy data */

INSERT INTO users
    ('UserID', 'Username',       'Password',    'Birthday',   'Privacy')
VALUES
    (1,        'Mabel Chan',     'password123', '1994-01-16', 'Friends'),
    (2,        'Mairi Ng',       'password123', '1989-05-16', 'Friends' ),
    (3,        'Marisa Enhuber', 'password123', '1989-07-06', 'Friends'),
    (4,        'Zak Walters',    'password123', '1994-05-20', 'Public');

INSERT INTO friendships
    ('UserOne', 'UserTwo')
VALUES
    (1,         3),
    (1,         4),
    (3,         4);
