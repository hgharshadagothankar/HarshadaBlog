/*
 Navicat MySQL Data Transfer

 Source Server         : SMTP
 Source Server Type    : MySQL
 Source Server Version : 50622
 Source Host           : localhost
 Source Database       : UserManager

 Target Server Type    : MySQL
 Target Server Version : 50622
 File Encoding         : utf-8

 Date: 11/10/2015 23:16:44 PM
*/
use userManager;
SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `UserDetails`
-- ----------------------------
DROP TABLE IF EXISTS `UserDetails`;
CREATE TABLE `UserDetails` (
  `UserID` varchar(120) NOT NULL,
  `UserName` varchar(150) NOT NULL,
  `FirstName` varchar(150) DEFAULT NULL,
  `LastName` varchar(150) DEFAULT NULL,
  `Email` varchar(150) NOT NULL,
  `Password` varchar(1000) DEFAULT NULL,
  `MemberSince` varchar(255) DEFAULT NULL,
  `Active` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserName`,`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `UserDetails`
-- ----------------------------
BEGIN;
INSERT INTO `UserDetails` VALUES ('cyftrb', 'FrodoBaggins', 'Frodo', 'Baggins', 'frodo@localhost.com', 'ce1615712e24b7c7ebf23feab855a75b4a8a852bbcfae9a99911246256a0fe497', '1447091580', '1'), 
('4frvct', 'JohnSmith', 'John', 'Smith', 'js@gmail.com', '6f4e26455b0f9c987a0009f3c5bd12786300b90fa76fb5399c82f2e63ab7121aa', '1445987595', '1'), 
('692g6q', 'PraviinM', 'Praviin', 'Mandhare', 'pravsm@gmail.com', '1e905117d466dc32016cb71e3cb798cea73a942f2221fcbda1b5dc8104c2565ee', '1445961643', '1');
COMMIT;

-- ----------------------------
--  Table structure for `blogcontent`
-- ----------------------------
DROP TABLE IF EXISTS `blogcontent`;
CREATE TABLE `blogcontent` (
  ` uniqueid` int(11) NOT NULL AUTO_INCREMENT,
  `blogid` varchar(50) DEFAULT NULL,
  `blogcontent` longblob,
  PRIMARY KEY (` uniqueid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `blogcontent`
-- ----------------------------
BEGIN;
INSERT INTO `blogcontent` VALUES 
('2', 'h380s0', 0x7468697320697320617765736f6d6520626c6f67207468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f677468697320697320617765736f6d6520626c6f67), 
('3', 'o2hino', 0x6950686f6e6520282fcb8861c9aa666fca8a6e2f204559452d666f686e292069732061206c696e65206f6620736d61727470686f6e65732064657369676e656420616e64206d61726b65746564206279204170706c6520496e632e20546865792072756e204170706c65277320694f53206d6f62696c65206f7065726174696e672073797374656d2e5b31345d205468652066697273742067656e65726174696f6e206950686f6e65207761732072656c6561736564206f6e204a756e652032392c20323030373b20746865206d6f737420726563656e74206950686f6e65206d6f64656c732061726520746865206950686f6e6520367320616e64206950686f6e6520367320506c75732c207768696368207765726520756e7665696c65642061742061207370656369616c206576656e74206f6e2053657074656d62657220392c20323031352e5b31355d0d0a0d0a5468652075);

COMMIT;

-- ----------------------------
--  Table structure for `bloglisting`
-- ----------------------------
DROP TABLE IF EXISTS `bloglisting`;
CREATE TABLE `bloglisting` (
  `uniqueid` int(11) NOT NULL AUTO_INCREMENT,
  `blogid` varchar(50) NOT NULL,
  `title` varchar(1500) DEFAULT NULL,
  `datecreated` int(11) DEFAULT NULL,
  `deleteflag` int(1) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  PRIMARY KEY (`uniqueid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bloglisting`
-- ----------------------------
BEGIN;
INSERT INTO `bloglisting` VALUES ('5', 'xfo8py', 'This is my first blog', null, '0', '1'), 
('6', 'h380s0', 'This is by first blog', '1447088080', '0', '1'),
 ('7', 'o2hino', 'Apple iPhones', '1447090596', '0', '1'), 
 ('8', 'v35dvj', 'PHP', '1447090693', '0', '1'), 
 ('9', 'zu8ls8', 'PHP', '1447090717', '0', '1'), 
 ('10', '3g7gbf', 'MySQL', '1447090829', '0', '1'),
 ('11', 'rrv7nk', 'Instagram', '1447091528', '0', '1'), 
 ('12', '3iek12', 'The Lord Of the Rings', '1447091624', '0', '1'), 
 ('13', 'ur1hj5', 'How i defeated Sauron', '1447091649', '0', '1'), 
 ('14', 'e4yul0', 'Sam Gamgee Helped me', '1447091698', '0', '1'), 
 ('15', '88p15o', 'I love GOLLUM', '1447091723', '0', '1'), 
 ('16', 't3gasw', 'who is gandalf', '1447199633', '0', '1');
COMMIT;

-- ----------------------------
--  Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(60) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_desc` tinytext NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `products`
-- ----------------------------
BEGIN;
INSERT INTO `products` VALUES 
('5', 'XCA75WPZ', 'Adipiscing Corporation', 'neque vitae semper', '44.11'), 
('6', 'WVS19FPC', 'Massa Quisque PC', 'sem molestie sodales. Mauris blandit enim consequat purus. Maecenas', '98.40'), 
('7', 'ACZ15ETB', 'Tempus Institute', 'felis.', '240.82'), 
('8', 'DYX71QPD', 'Vulputate Mauris Sagittis Company', 'non arcu. Vivamus sit amet risus. Donec egestas. Aliquam', '36.43'),
 ('9', 'BXE85KFW', 'Curae; Consulting', 'magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim', '35.15'), 
 ('10', 'ZEO92KVA', 'Suscipit Nonummy Institute', 'mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam', '167.13');
COMMIT;

-- ----------------------------
--  Table structure for `whomadewho`
-- ----------------------------
DROP TABLE IF EXISTS `whomadewho`;
CREATE TABLE `whomadewho` (
  `uniqueid` int(11) NOT NULL AUTO_INCREMENT,
  `blogid` varchar(50) DEFAULT NULL,
  `userid` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`uniqueid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `whomadewho`
-- ----------------------------
BEGIN;
INSERT INTO `whomadewho` VALUES ('2', 'xfo8py', '692g6q'), 
('3', 'h380s0', '692g6q'), ('4', 'o2hino', '692g6q'),
 ('5', 'zu8ls8', '692g6q'), ('6', '3g7gbf', '692g6q'), 
 ('7', 'rrv7nk', '4frvct'),
 ('8', '3iek12', 'cyftrb'), 
 ('9', 'ur1hj5', 'cyftrb'), 
 ('10', 'e4yul0', 'cyftrb'), 
 ('11', '88p15o', 'cyftrb'), 
 ('12', 't3gasw', 'cyftrb');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;







use userManager;
select * from whomadewho;
select * from products;
select * from bloglisting;
select * from blogcontent;
select * from user;
select * from userdetails;

desc bloglisting;

alter table bloglisting
add publish tinyint(1) default 0;
