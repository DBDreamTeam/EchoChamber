CREATE TABLE `users` (
  `UserID` int(4) NOT NULL,
  `Username` varchar(100)(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(100)(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Birthday` date NOT NULL,
  `PictureID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `friendships` (
    `UserOne`   int(10) NOT NULL,
    `UserTwo`   int(10) NOT NULL,
    PRIMARY KEY (`UserOne`, `UserTwo`)
);

CREATE TABLE `pictures`(
    `PictureID` int(10) AUTO_INCREMENT NOT NULL,
    `Time`      datetime(6),
    `Picture`   varbinary(100) NOT NULL,
    PRIMARY KEY (`PictureID`)
);

CREATE TABLE `groups`(
    `GroupID`   int(10) AUTO_INCREMENT NOT NULL,
    `BlogID`    int(10) NOT NULL,
    `Name`      varchar(100) NOT NULL,
    `PictureID` int(10),
    `Privacy`   enum('Friends', 'Circles', 'FriendsOfFriends') NOT NULL,
    PRIMARY KEY (`GroupID`)
);

CREATE TABLE `group_members`(
    `GroupID`   int(10) NOT NULL PRIMARY KEY,
    `UserID`    int(10) NOT NULL,
    PRIMARY KEY (`GroupID`, `UserID`)
);

CREATE TABLE `blog_wall`(
    `ID`        int(10) NOT NULL,
    `IsGroup`   boolean NOT NULL,
    `Name`      varchar(100) NOT NULL,
    `Privacy`   enum('Friends', 'Circles', 'FriendsOfFriends', 'Public') NOT NULL,
    PRIMARY KEY (`ID`, `IsGroup`)
);

CREATE TABLE `posts`(
    `PostID`    int(10) AUTO_INCREMENT NOT NULL,
    `BlogID`    int(10) NOT NULL,
    `Time`      datetime(20) NOT NULL,
    `text`      varchar(100),
    `AlbumID`   int(10),
    PRIMARY KEY (`PostID`)
);

CREATE TABLE `albums`(
    `AlbumID`   int NOT NULL,
    `OwnerID`   int NOT NULL,
    `Time`      datetime NOT NULL,
    `Privacy`   enum('Friends', 'Circles', 'FriendsOfFriends') NOT NULL,
    PRIMARY KEY (`AlbumID`)
);

CREATE TABLE `comments`(
    `CommentID` int(10) AUTO_INCREMENT NOT NULL,
    `Time`      datetime(6) NOT NULL,
    `Text`      varchar(6) NOT NULL,
    `PostID`    int(4) NOT NULL,
    `UserID`    int(4) NOT NULL,
    PRIMARY KEY (`CommentID`)
);

CREATE TABLE `sentiments`(
    `UserID`    int(10) NOT NULL,
    `Entity`    varchar(10) NOT NULL,
    `Sentiment` DECIMAL(7, 6),
    PRIMARY KEY (`UserID`, `Entity`)
);

CREATE TABLE `message`(
    `MessageID` int(10) NOT NULL,
    `ChatID`    int(10) NOT NULL,
    `UserID`    int(10) NOT NULL,
    `Text`      text(10) NOT NULL,
    `Photo`     longblob,
    `datetime(20)`  datetime(6) NOT NULL,
    PRIMARY KEY (`MessageID`)
);

CREATE TABLE `chat`(
    `ChatID`    int(10) NOT NULL,
    `ChatTitle` text(10) NOT NULL,
    PRIMARY KEY (`ChatID`)
);


CREATE TABLE `chat_members` (
    `ChatID`    int(10) NOT NULL,
    `UserID`    int(10) NOT NULL,
    PRIMARY KEY (`ChatID`, `UserID`)
);
    