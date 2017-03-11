
CREATE TABLE `users` (
  `UserID` int(4) AUTO_INCREMENT NOT NULL,
  `Username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, /* email added */
  `Birthday` date NOT NULL,
  `PictureID` int(11), /* NOT NULL removed */
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `friendships` (
    `UserOne`   int(10) NOT NULL,
    `UserTwo`   int(10) NOT NULL,
    PRIMARY KEY (`UserOne`, `UserTwo`)
);

CREATE TABLE `pictures`(
    `PictureID` int(10) AUTO_INCREMENT NOT NULL,
    `Time`      timestamp(6),
    `Picture`   varchar(200) NOT NULL, 
    `AlbumID`   int(10) NOT NULL, /* AlbumID added */
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
    `GroupID`   int(10) NOT NULL,
    `UserID`    int(10) NOT NULL,
    PRIMARY KEY (`GroupID`, `UserID`)
);

CREATE TABLE `blog_wall`(
    `ID`        int(100) AUTO_INCREMENT NOT NULL,
    `IsGroup`   boolean NOT NULL,
    `OwnerID`   int(100) NOT NULL,
    `Name`      varchar(100) NOT NULL,
    `Privacy`   enum('Friends', 'Circles', 'FriendsOfFriends', 'Public') NOT NULL,
    PRIMARY KEY (`ID`, `IsGroup`)
);

CREATE TABLE `posts`(
    `PostID`    int(10) AUTO_INCREMENT NOT NULL,
    `BlogID`    int(10) NOT NULL,
    `Time`      datetime(6) NOT NULL,
    `text`      varchar(100),
    `AlbumID`   int(10),
    PRIMARY KEY (`PostID`)
);

CREATE TABLE `albums`(
    `AlbumID`   int AUTO_INCREMENT NOT NULL, /* AI added */
    `AlbumName` varchar(100) DEFAULT 'My Album', /* Album name added */
    `OwnerID`   int NOT NULL,
    `Time`      datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, /* default to current timestamp added */
    `Privacy`   enum('Friends', 'Circles', 'FriendsOfFriends', 'Public') NOT NULL DEFAULT 'Friends', /* 'Public' added */
    PRIMARY KEY (`AlbumID`)
);

CREATE TABLE `comments`(
    `CommentID` int(10) AUTO_INCREMENT NOT NULL,
    `Time`      datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, /* added default to current timestamp */
    `Text`      text NOT NULL, /* varchar(6) changed to text */
    `PostID`    int(4) NOT NULL,
    `isPictures`boolean NOT NULL,
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
    `MessageID` int(10) AUTO_INCREMENT NOT NULL, /* added AUTO_INCREMENT */
    `ChatID`    int(10) NOT NULL,
    `UserID`    int(10) NOT NULL,
    `Text`      text(1000) NOT NULL, /* changed length of type to 1000 */
    `Photo`     varchar(200), /* changed data type from longblob to varchar(200) */
    `DateTime`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, /* added DEFAULT CURRENT_TIMESTAMP and removed length */
    PRIMARY KEY (`MessageID`)
);

CREATE TABLE `chat`(
    `ChatID`    int(10) AUTO_INCREMENT NOT NULL, /* auto_increment added */
    `ChatTitle` varchar(100) NOT NULL, /* data type changed to varchar */
    PRIMARY KEY (`ChatID`)
);


CREATE TABLE `chat_members` (
    `ChatID`    int(10) NOT NULL,
    `UserID`    int(10) NOT NULL,
    PRIMARY KEY (`ChatID`, `UserID`)
);
    
CREATE TABLE `friend_requests` (
    `id` INT(10) AUTO_INCREMENT NOT NULL, 
    `user_from` INT(4) NOT NULL, 
    `user_to` INT(4) NOT NULL, 
    PRIMARY KEY(`id`), 
    CONSTRAINT fk_user_from FOREIGN KEY (`user_from`) 
    REFERENCES users(`UserID`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE, 
    CONSTRAINT fk_user_to FOREIGN KEY (`user_to`) 
    REFERENCES users(`UserID`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE 
);
