-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 192.168.1.202
-- Generation Time: Mar 18, 2019 at 04:42 AM
-- Server version: 5.7.18-log
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `begood`
--

-- --------------------------------------------------------

--
-- Table structure for table `cafe`
--

CREATE TABLE `cafe` (
  `ID` int(11) PRIMARY KEY NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `postalcode` varchar(10) NOT NULL,
  `url_slug` varchar(255) NOT NULL,
  `latitude` varchar(12) NOT NULL,
  `longitude` varchar(12) NOT NULL,
  `phoneno` varchar(15) NOT NULL,
  `image` varchar(255) NOT NULL,
  `website` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cafe`
--

INSERT INTO `cafe` (`ID`, `name`, `address`, `city`, `state`, `postalcode`, `url_slug`, `latitude`, `longitude`, `phoneno`, `image`, `website`, `email`, `verified`) VALUES
(2, 'Narola cafe', '133 Darlington Rd..', 'Miramar', 'undefined', '6022', 'narola-cafe-darlington-rd', '-41.3066961', '174.8257898', '9898989898', 'c9c04135-0fc5-4578-963e-a8886fa0acf2_5.jpg', 'http://www.narolainfotech.com', 'demo.narolainfotech@gmail.com', 1),
(3, 'Cafe Coffee Night', '4b Portage Rd, New Lynn', 'Auckland', '', '0600', 'cafe-coffee-night-b-portage-rd-new-lynn', '-36.904060', '174.689520', '9898989898', 'freelance-india.jpg', 'www.ccn.com', 'lp@narola.email', 1),
(4, 'Roost', '13 Crummer Road, Grey Lynn, Auckland, New Zealand, 13', 'Auckland', 'undefined', '1021', 'roost-crummer-road-grey-lynn-auckland-new-zealand', '-36.8593902', '174.7496711', '0212221112', 'IMG_20190113_183831_225.jpg', 'Www.ifortify.co.nz', 'brad@ifortify.co.nz', 1),
(6, 'Antony24', '13 Crummer Road, Grey Lynn', 'Auckland', 'undefined', '1021', 'antony24-crummer-road-grey-lynn', '', '', '9898989898', '4490df0b-7c2f-4892-a809-ca16ebd97fc1_4.jpg', 'www.antony24.com', 'demo.narolainfotech@gmail.com', 1),
(7, 'Test cafe 1', 'adajan', 'Surat', 'undefined', '395009', 'test-cafe-1-adajan', '', '', '9898989', 'slideshow_3.jpg', 'www.testcafe.com', 'dhb@narola.email', 1),
(8, 'Test cafe 4', 'Rander', 'Surat', 'undefined', '395009', 'test-cafe-4-rander', '', '', '9898989978', 'Dhvani.jpg', 'www.testcafe4.com', 'rs@narola.email', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cup_scan`
--

CREATE TABLE `cup_scan` (
  `ID` int(11) PRIMARY KEY NOT NULL,
  `userid` int(11) NOT NULL,
  `cafeid` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `cup_state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) PRIMARY KEY NOT NULL,
  `name` varchar(55) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`) VALUES
(1, 'content_ourstory', '<p style="text-align:center"><span style="font-size:36px"><span style="font-family:Times New Roman,Times,serif">Our Story</span></span></p>\r\n\r\n<p style="text-align:center"><span style="font-size:16px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vel quam quis risus mollis posuere eget sit amet turpis. Nunc tristique lacinia sodales. Praesent vestibulum nunc eget gravida semper. Morbi fermentum tortor eu interdum efficitur. Donec elementum, enim eget laoreet lacinia, magna libero tempor tellus, id suscipit enim magna vitae ex. Suspendisse iaculis odio libero, ut finibus augue luctus in. Quisque blandit scelerisque blandit.</span></p>\r\n\r\n<p style="text-align:center"><span style="font-size:16px">Duis semper sodales lectus, quis condimentum velit tempus a. Morbi consequat justo ut accumsan elementum. Morbi tempor ut mi a commodo. Ut turpis nulla, dapibus eget arcu vitae, dictum dictum purus. Pellentesque efficitur massa sed libero vehicula consectetur in vel ex. Quisque pharetra at leo a aliquet. Maecenas et erat ut massa suscipit iaculis a quis nibh. Duis euismod, magna ut vestibulum elementum, ante mauris tincidunt ante, vitae rutrum est risus a augue.</span></p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n'),
(11, 'stampsound', '1549867464_single_scan.wav'),
(12, 'freesound', '1552452483_10scan.wav');

-- --------------------------------------------------------

--
-- Table structure for table `stamp_key`
--

CREATE TABLE `stamp_key` (
  `ID` int(11) PRIMARY KEY NOT NULL,
  `cafe_id` int(11) NOT NULL,
  `app_key` varchar(255) NOT NULL,
  `app_secret` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stamp_key`
--

INSERT INTO `stamp_key` (`ID`, `cafe_id`, `app_key`, `app_secret`) VALUES
(1, 2, '606a1d4f4ba846bf793c', '16f6c6604b55cd3da8b3a62c0e0fecc8dcd12770'),
(2, 3, 'AT2UExBVyNM43ExrtdgqvN5b8pTBT4Gb7e', 'GHFGNJGHJGJGH7567GHFGH656FGHGHJGHJ758U76YUJGHJ'),
(3, 6, '606a1d4f4ba846bf793c', '16f6c6604b55cd3da8b3a62c0e0fecc8dcd12770'),
(4, 4, '606a1d4f4ba846bf793cq', '16f6c6604b55cd3da8b3a62c0e0fecc8dcd12770'),
(5, 7, 'DFGDGDFGDFHFG', 'HFGHFHFHFGH45765756Y56756GHFGH'),
(6, 8, 'GGFDFGDFG', 'GHFGHFGHFG568678678768YUYJHJI76897IUI');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) PRIMARY KEY NOT NULL,
  `user` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `is_master` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `key` varchar(255) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `oauth_provider` varchar(30) NOT NULL,
  `oauth_uid` varchar(55) NOT NULL,
  `profile_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `user`, `password`, `email`, `user_type`, `is_master`, `created`, `is_active`, `key`, `verified`, `oauth_provider`, `oauth_uid`, `profile_link`) VALUES
(1, 'brad', 'cdb53249612854e3b173de52d955901e', 'brad@opespartners.co.nz', 'admin', 1, '2018-12-18 16:46:43', 1, '', 1, '', '', ''),
(32, 'Bradleyparsonson@gmail.co', '91b325d70b297dab52ca2560cff76833', 'Bradleyparsonson@gmail.com', 'user', 0, '2018-12-23 10:47:38', 1, '', 1, '', '', ''),
(33, 'demo.narolainfotech@gmail', '', 'demo.narolainfotech@gmail.com', 'user', 0, '2018-12-24 10:25:49', 1, '', 1, '', '', ''),
(35, 'markinsta11', '', 'markinsta11@instagram.com', 'user', 0, '2018-12-25 12:24:48', 1, '', 1, 'Instagram', '4527605852', 'https://www.instagram.com/markinsta11'),
(60, 'brad@miuwi.com', '', 'brad@miuwi.com', 'user', 0, '2019-01-22 07:40:26', 1, 'c44d777dc2fcfadf162c7d97ea320eca', 1, 'GooglePlus', '114740449006921953568', 'https://plus.google.com/114740449006921953568'),
(68, 'lp@narola.email', '9303527fd1071201053cdea0d682605f', 'lp@narola.email', 'user', 0, '2019-01-22 12:26:12', 1, '1d6b73be58006c1ecbc290a48db3963a', 1, '', '', ''),
(69, 'shd.narola@gmail.com', 'a8b4fab1bed511ab6850908c72c547c9', 'shd.narola@gmail.com', 'user', 0, '2019-01-23 15:32:00', 1, '4b1c5499c1c1a24e268cd0dec619af21', 0, '', '', ''),
(70, 'Brad@ifortify.co.nz', 'a00ecf178023b6fd9263c801fbf6abb6', 'Brad@ifortify.co.nz', 'user', 0, '2019-01-31 02:23:24', 1, '3d254f7a87d81ec8e96ced382cac4621', 1, '', '', ''),
(71, 'psalzinger@gmail.com', 'f6c7e8f8cb7ad5f31bd404a99a9c8ba0', 'psalzinger@gmail.com', 'user', 0, '2019-02-09 22:17:40', 1, '', 1, '', '', ''),
(72, 'sheradyn@snowshoestamp.co', '40a1d12c71b79089fa3b641cbb16f92a', 'sheradyn@snowshoestamp.com', 'user', 0, '2019-02-11 20:51:28', 1, '80dbf96eb193a0c23f59145850828f3f', 1, '', '', ''),
(73, 'demo.narola', '', 'demo.narola@instagram.com', 'user', 0, '2019-02-14 11:02:23', 1, '', 1, 'Instagram', '1620209611', 'https://www.instagram.com/demo.narola'),
(77, 'sha@narola.email', 'a8b4fab1bed511ab6850908c72c547c9', 'sha@narola.email', 'user', 0, '2019-02-25 12:37:32', 1, '', 1, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `ID` int(11) PRIMARY KEY NOT NULL,
  `userid` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `phoneno` varchar(15) NOT NULL,
  `user_avtar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`ID`, `userid`, `firstname`, `lastname`, `phoneno`, `user_avtar`) VALUES
(21, 33, 'demo', 'narolainfotech', '', 'https://lh5.googleusercontent.com/-6Gnyf54DFZI/AAAAAAAAAAI/AAAAAAAARfY/d3A2Pz9woS0/photo.jpg'),
(23, 35, '', '', '', 'https://scontent.cdninstagram.com/vp/61f139b8660b9fd0277175e5b138950a/5CA20F88/t51.2885-19/s150x150/16583444_452670671743996_7580258119389806592_a.jpg?_nc_ht=scontent.cdninstagram.com'),
(49, 60, '', '', '', ''),
(57, 68, 'Lucky', 'Parmar', '8460811988', 'https://begood.herokuapp.com/uploads/avatara3f390d88e4c41f2747bfa2f1b5f87db.png'),
(58, 69, '', '', '', ''),
(59, 70, 'Bradley', 'Parsonson', '0212221112', 'https://begood.herokuapp.com/uploads/avatar7cbbc409ec990f19c78c75bd1e06f215.jpg'),
(60, 71, '', '', '', ''),
(61, 72, '', '', '', ''),
(62, 73, '', '', '', ''),
(63, 73, 'TG', '', '', 'https://scontent.cdninstagram.com/vp/61ae42ae4aac0dbfab223673fcffdf65/5CE9868E/t51.2885-19/s150x150/28428779_1750873768339106_3109985123248898048_n.jpg?_nc_ht=scontent.cdninstagram.com'),
(66, 32, 'Bradley', 'Parsonson', '0212221112', 'https://begood.herokuapp.com/uploads/avatar6364d3f0f495b6ab9dcf8d3b5c6e0b01.jpg'),
(68, 77, 'Shambhu', 'Chauhan', '9898989898', 'https://begood.herokuapp.com/begood/uploads/avatar28dd2c7955ce926456240b2ff0100bde.png');

--
-- Indexes for dumped tables
--



--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cafe`
--
ALTER TABLE `cafe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cup_scan`
--
ALTER TABLE `cup_scan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `stamp_key`
--
ALTER TABLE `stamp_key`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cup_scan`
--
ALTER TABLE `cup_scan`
  ADD CONSTRAINT `cup_scan_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `cup_scan_ibfk_2` FOREIGN KEY (`cafeid`) REFERENCES `cafe` (`ID`);

--
-- Constraints for table `stamp_key`
--
ALTER TABLE `stamp_key`
  ADD CONSTRAINT `stamp_key_ibfk_1` FOREIGN KEY (`cafe_id`) REFERENCES `cafe` (`ID`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Indexes for table `cup_scan`
--
ALTER TABLE `cup_scan`
  ADD KEY `userid` (`userid`),
  ADD KEY `cafeid` (`cafeid`);


--
-- Indexes for table `stamp_key`
--
ALTER TABLE `stamp_key`
  ADD KEY `cafe_id` (`cafe_id`);


--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD KEY `userid` (`userid`);
