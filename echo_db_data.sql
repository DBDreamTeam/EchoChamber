-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 17, 2017 at 03:35 PM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `echo`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `AlbumID` int(10) NOT NULL,
  `AlbumName` varchar(100) DEFAULT 'My Album',
  `OwnerID` int(11) NOT NULL,
  `Time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Privacy` enum('Friends','Circles','FriendsOfFriends','Public') NOT NULL DEFAULT 'Friends'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`AlbumID`, `AlbumName`, `OwnerID`, `Time`, `Privacy`) VALUES
(1, 'Profile Pictures', 1, '2017-03-17 12:52:47', 'Friends'),
(2, 'Profile Pictures', 2, '2017-03-17 12:53:57', 'Friends'),
(3, 'Profile Pictures', 3, '2017-03-17 12:56:04', 'Friends'),
(4, 'Profile Pictures', 4, '2017-03-17 13:14:32', 'Friends'),
(5, 'Profile Pictures', 5, '2017-03-17 13:16:06', 'Friends'),
(6, 'Profile Pictures', 6, '2017-03-17 13:16:48', 'Friends'),
(7, 'Profile Pictures', 7, '2017-03-17 13:17:38', 'Friends'),
(8, 'Profile Pictures', 8, '2017-03-17 13:18:25', 'Friends'),
(9, 'Profile Pictures', 9, '2017-03-17 13:19:12', 'Friends'),
(10, 'Profile Pictures', 10, '2017-03-17 13:19:47', 'Friends'),
(11, 'Circle Photos', 8, '2017-03-17 13:31:25', 'Circles'),
(12, 'Gardens', 4, '2017-03-17 13:32:32', 'Circles'),
(13, 'Animals', 4, '2017-03-17 13:32:41', 'Friends'),
(14, 'Flowers', 4, '2017-03-17 13:32:54', 'FriendsOfFriends'),
(15, 'Books', 4, '2017-03-17 13:35:25', 'Public'),
(16, 'Circle Photos', 4, '2017-03-17 13:36:56', 'Circles'),
(17, 'Blog Pictures', 4, '2017-03-17 13:52:14', 'Friends');

-- --------------------------------------------------------

--
-- Table structure for table `blog_wall`
--

CREATE TABLE `blog_wall` (
  `BlogID` int(10) NOT NULL,
  `OwnerID` int(10) NOT NULL,
  `Privacy` enum('Friends','Circles','FriendsOfFriends','Public') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_wall`
--

INSERT INTO `blog_wall` (`BlogID`, `OwnerID`, `Privacy`) VALUES
(4, 4, 'Friends'),
(5, 5, 'Circles'),
(6, 6, 'FriendsOfFriends'),
(7, 7, 'FriendsOfFriends'),
(8, 8, 'Friends'),
(9, 9, 'Public'),
(10, 10, 'Circles');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `ChatID` int(10) NOT NULL,
  `ChatTitle` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chat_members`
--

CREATE TABLE `chat_members` (
  `ChatID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Text` text NOT NULL,
  `PostID` int(10) NOT NULL,
  `isPictures` tinyint(1) NOT NULL,
  `UserID` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `Time`, `Text`, `PostID`, `isPictures`, `UserID`) VALUES
(1, '2017-03-17 14:31:59', 'I like this', 1, 0, 4),
(2, '2017-03-17 14:32:10', 'I like this', 1, 0, 4),
(3, '2017-03-17 14:32:34', 'Love this', 2, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `entity`
--

CREATE TABLE `entity` (
  `EntityID` int(10) NOT NULL,
  `Entity` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entity`
--

INSERT INTO `entity` (`EntityID`, `Entity`) VALUES
(1, 'Cake'),
(2, 'Fashion'),
(3, 'Wigs');

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `UserOne` int(10) NOT NULL,
  `UserTwo` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`UserOne`, `UserTwo`) VALUES
(4, 5),
(4, 6),
(5, 4),
(5, 6),
(6, 4),
(6, 5),
(6, 7),
(7, 6),
(7, 8),
(8, 7),
(8, 9),
(8, 10),
(9, 8),
(9, 10),
(10, 8),
(10, 9);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(10) NOT NULL,
  `user_from` int(10) NOT NULL,
  `user_to` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `GroupID` int(10) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `PictureID` int(10) DEFAULT NULL,
  `Privacy` enum('Friends','Circles','FriendsOfFriends') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`GroupID`, `Name`, `PictureID`, `Privacy`) VALUES
(1, 'The English Crew', 11, 'Friends'),
(2, 'The Two Elizabeths', 21, 'FriendsOfFriends');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `GroupID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`GroupID`, `UserID`) VALUES
(1, 8),
(1, 9),
(1, 10),
(2, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `MessageID` int(10) NOT NULL,
  `ChatID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Text` text NOT NULL,
  `Photo` varchar(200) DEFAULT NULL,
  `DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `PictureID` int(10) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Picture` varchar(200) NOT NULL,
  `AlbumID` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`PictureID`, `Time`, `Picture`, `AlbumID`) VALUES
(1, '2017-03-17 12:52:47', '../public/images/henry-viii.jpg', 1),
(2, '2017-03-17 12:53:57', '../public/images/henry-viii.jpg', 2),
(3, '2017-03-17 12:56:04', '../public/images/henry-viii.jpg', 3),
(4, '2017-03-17 13:14:32', '../public/images/queen-elizabeth-1.jpg', 4),
(5, '2017-03-17 13:16:06', '../public/images/Eliz2BeingCrowned.jpg', 5),
(6, '2017-03-17 13:16:48', '../public/images/marie.jpg', 6),
(7, '2017-03-17 13:17:38', '../public/images/louis-xiv.jpg', 7),
(8, '2017-03-17 13:18:25', '../public/images/Queen_Victoria.jpg', 8),
(9, '2017-03-17 13:19:12', '../public/images/george-I.jpg', 9),
(10, '2017-03-17 13:19:47', '../public/images/george-V.jpg', 10),
(11, '2017-03-17 13:31:25', '../public/images/sky2.jpg', 11),
(12, '2017-03-17 13:33:14', '../public/images/geese.jpg', 13),
(13, '2017-03-17 13:33:52', '../public/images/coralGardens.jpg', 12),
(14, '2017-03-17 13:34:00', '../public/images/thymeWalk.jpg', 12),
(15, '2017-03-17 13:34:16', '../public/images/cats.jpg', 13),
(16, '2017-03-17 13:34:34', '../public/images/orchids3.jpg', 14),
(17, '2017-03-17 13:34:42', '../public/images/pineapple.jpg', 14),
(18, '2017-03-17 13:35:37', '../public/images/talesOfTheCity.jpg', 15),
(19, '2017-03-17 13:35:46', '../public/images/crocodiles.jpg', 15),
(20, '2017-03-17 13:35:53', '../public/images/waterstones.jpg', 15),
(21, '2017-03-17 13:36:56', '../public/images/sky4.jpg', 16),
(22, '2017-03-17 13:52:14', '../public/images/elizabethCrowned.jpg', 17);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(10) NOT NULL,
  `BlogID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` varchar(100) DEFAULT NULL,
  `PictureID` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `BlogID`, `Time`, `text`, `PictureID`) VALUES
(1, 4, '2017-03-17 13:51:30', 'Hello. This is the first post from the first Elizabeth.', NULL),
(2, 4, '2017-03-17 13:52:14', 'Here is a photo of not my coronation.', 22),
(3, 6, '2017-03-17 13:53:19', 'Let them eat cake', NULL),
(4, 7, '2017-03-17 13:53:54', 'The revolution shall die. ', NULL),
(5, 8, '2017-03-17 13:54:26', 'Albert is the best.', NULL),
(6, 9, '2017-03-17 13:54:49', 'I like my wig.', NULL),
(7, 10, '2017-03-17 13:55:33', 'I like his wig.', NULL),
(8, 4, '2017-03-17 14:29:36', 'Great day with Sir Francis Drake today', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sentiments`
--

CREATE TABLE `sentiments` (
  `UserID` int(10) NOT NULL,
  `EntityID` int(10) NOT NULL,
  `Sentiment` enum('positive','neutral','negative') NOT NULL DEFAULT 'neutral'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sentiments`
--

INSERT INTO `sentiments` (`UserID`, `EntityID`, `Sentiment`) VALUES
(0, 1, 'neutral'),
(0, 2, 'neutral'),
(0, 3, 'neutral'),
(4, 0, 'positive'),
(4, 2, 'positive'),
(4, 3, 'positive'),
(5, 1, 'positive'),
(5, 3, 'positive'),
(5, 2, 'positive'),
(6, 2, 'positive'),
(6, 1, 'positive'),
(6, 3, 'positive'),
(7, 1, 'positive'),
(7, 2, 'positive'),
(7, 3, 'positive'),
(8, 3, 'positive'),
(8, 2, 'positive'),
(8, 1, 'negative'),
(9, 2, 'positive'),
(9, 3, 'negative'),
(9, 1, 'negative'),
(10, 2, 'positive'),
(10, 3, 'negative'),
(10, 1, 'negative');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(10) NOT NULL,
  `Username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Birthday` date NOT NULL,
  `PictureID` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Birthday`, `PictureID`) VALUES
(4, 'Elizabeth 1 Tudor', '$2y$10$gCT0EW7ymRC6z.66.R/WA.ycq5iU8urfkWC4CIqUKvuPW0VfUc3US', 'liz1@queen.com', '2017-03-13', 4),
(5, 'Elizabeth 2 Windsor', '$2y$10$RceTOrr6DGdVirlBYJkCYO6O6kiz.NIydGuI7Ye87tUOuH3fEx6Yy', 'liz2@queen.com', '2017-03-19', 5),
(6, 'Marie Antoinette', '$2y$10$Ih7NiC/f7XEYXgh2KChHpelEXsbNfHFUxl5p7MhULOqqquAqzfadi', 'manton@queen.com', '2017-03-07', 6),
(7, 'Louis XIV King', '$2y$10$N5J/VkZXgWE3qs5WqtPKcOxNNZgY2n39tgCOKmx31iIx9jZoF2P9.', 'louis14@king.com', '2017-03-06', 7),
(8, 'Queen Victoria', '$2y$10$2aSeSt3IOiOpFJ/YSd1iEeTCQNeBUpl/DFxMGSUq2orRkyKybES8e', 'victoria@queen.com', '2017-02-27', 8),
(9, 'George I King', '$2y$10$T5mGWfKfPdsFuw90E.wbb.rNzhvdotC8ufBqMvwUOyJVlcOsQilnS', 'george1@king.com', '2017-03-15', 9),
(10, 'George V King', '$2y$10$pNN5UnsS/rUuxbK5z6.5Ze/8JWAedCUo8N/KObD9yGcU9DxqzMW5C', 'george5@king.com', '2017-02-07', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`AlbumID`),
  ADD KEY `fk_UserID` (`OwnerID`);

--
-- Indexes for table `blog_wall`
--
ALTER TABLE `blog_wall`
  ADD PRIMARY KEY (`BlogID`),
  ADD KEY `fk_UserID` (`OwnerID`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`ChatID`);

--
-- Indexes for table `chat_members`
--
ALTER TABLE `chat_members`
  ADD PRIMARY KEY (`ChatID`,`UserID`),
  ADD KEY `fk_UserID` (`UserID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `fk_UserID` (`UserID`),
  ADD KEY `fk_PostID` (`PostID`);

--
-- Indexes for table `entity`
--
ALTER TABLE `entity`
  ADD PRIMARY KEY (`EntityID`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`UserOne`,`UserTwo`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_from` (`user_from`),
  ADD KEY `fk_user_to` (`user_to`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`GroupID`),
  ADD KEY `fk_PictureID` (`PictureID`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`GroupID`,`UserID`),
  ADD KEY `fk_UserID` (`UserID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `fk_UserID` (`UserID`),
  ADD KEY `fk_ChatID` (`ChatID`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`PictureID`),
  ADD KEY `fk_AlbumID` (`AlbumID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `fk_PictureID` (`PictureID`),
  ADD KEY `fk_BlogID` (`BlogID`);

--
-- Indexes for table `sentiments`
--
ALTER TABLE `sentiments`
  ADD PRIMARY KEY (`UserID`,`EntityID`),
  ADD KEY `fk_EntityID` (`EntityID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `AlbumID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `blog_wall`
--
ALTER TABLE `blog_wall`
  MODIFY `BlogID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `ChatID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `entity`
--
ALTER TABLE `entity`
  MODIFY `EntityID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `GroupID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MessageID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `PictureID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;