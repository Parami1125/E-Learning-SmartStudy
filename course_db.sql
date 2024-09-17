/*
 Navicat Premium Data Transfer

 Source Server         : localmysql
 Source Server Type    : MySQL
 Source Server Version : 80032
 Source Host           : localhost:3306
 Source Schema         : course_db

 Target Server Type    : MySQL
 Target Server Version : 80032
 File Encoding         : 65001

 Date: 01/06/2023 20:35:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bookmark
-- ----------------------------
DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE `bookmark` (
  `user_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bookmark
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------
-- Records of comments
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for contact
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` int NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of contact
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for content
-- ----------------------------
DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `video` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `thumb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'deactive',
  PRIMARY KEY (`id`),
  KEY `id_tutor` (`tutor_id`),
  KEY `playlist_id` (`playlist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of content
-- ----------------------------
BEGIN;
INSERT INTO `content` VALUES ('6UIwhLGvAFlQadWUXUbm', 'TwxEgwfAZn73PcgX52Xl', 'm5EcdqE5OHPqFFmxjvuz', 'Pembelajaran 2', 'Pembelajaran 2', 'B4DeTLzoEbFpPaDWmR2f.mp4', 'M7p8K3s4EarSW7D0YBr8.jpg', '2023-05-31 12:09:36', 'active');
INSERT INTO `content` VALUES ('pAcEEZzgcYnni4HJd4B1', 'TwxEgwfAZn73PcgX52Xl', 'm5EcdqE5OHPqFFmxjvuz', 'Pembelajaran 1', 'Pembelajaran 1', 'dA4tDGhqMGDy9l8axI4W.mp4', 'pustC4ZaTvK8OlvCMSsc.png', '2023-05-31 12:02:13', 'active');
COMMIT;

-- ----------------------------
-- Table structure for grades
-- ----------------------------
DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `module_id` varchar(20) NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `document` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `grade` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_tutor` (`tutor_id`),
  KEY `modul` (`module_id`),
  CONSTRAINT `modul` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of grades
-- ----------------------------
BEGIN;
INSERT INTO `grades` VALUES ('2Nf0oqtZvqVPGHI88Sx2', 'TwxEgwfAZn73PcgX52Xl', '55h3NQ1StlEbe33SglN9', 'euj2Cmz3PNpeKHfEFwoF', 'Assignment 1', 'JEzGrbcew9GRRw11oX6q.pdf', '2023-06-01 19:33:32', 0);
INSERT INTO `grades` VALUES ('NY9QAEtHKYOlSTYzG4IQ', 'TwxEgwfAZn73PcgX52Xl', '55h3NQ1StlEbe33SglN9', 'mivSUHYlYbOQ3GDhDZpZ', 'Assignment 2', 'CWqEH2Rmf8pqBOVjDfm7.pdf', '2023-06-01 19:37:19', 0);
INSERT INTO `grades` VALUES ('zfq0ALkfJlyAwCI6fvkh', 'TwxEgwfAZn73PcgX52Xl', '7e5mp9v2ZktD6KV1frzE', 'euj2Cmz3PNpeKHfEFwoF', 'Laporan Assignment 1', 'JCpVqkMW1eWaNcv0tPdL.pdf', '2023-06-01 19:14:01', 0);
COMMIT;

-- ----------------------------
-- Table structure for likes
-- ----------------------------
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of likes
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for module
-- ----------------------------
DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `pdf` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'deactive',
  `type` varchar(1) NOT NULL COMMENT '1. Modul\n2. Assignment',
  PRIMARY KEY (`id`),
  KEY `id_tutor` (`tutor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of module
-- ----------------------------
BEGIN;
INSERT INTO `module` VALUES ('euj2Cmz3PNpeKHfEFwoF', 'TwxEgwfAZn73PcgX52Xl', 'Kuis Alpro', 'Kuis Alpro Pertemuan 1', 'HTLPxAwSrQ1k6EU8ml8T.pdf', '2023-05-31 12:37:14', 'active', '2');
INSERT INTO `module` VALUES ('mivSUHYlYbOQ3GDhDZpZ', 'TwxEgwfAZn73PcgX52Xl', 'Kuis Alpro 2', 'Kuis Alpro 2', 'wontfzu9altCV83uiHlT.pdf', '2023-05-31 12:46:51', 'active', '2');
INSERT INTO `module` VALUES ('uhYKmlmH1BneoKdeB3Ly', 'TwxEgwfAZn73PcgX52Xl', 'Pembelajaran 1', 'Pembelajaran 1\r\n\r\nPembelajaran 1\r\n\r\nPembelajaran 1', 'WacYEtptVB3YqxSZjIRE.pdf', '2023-06-01 19:03:38', 'active', '1');
COMMIT;

-- ----------------------------
-- Table structure for playlist
-- ----------------------------
DROP TABLE IF EXISTS `playlist`;
CREATE TABLE `playlist` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'deactive',
  PRIMARY KEY (`id`),
  KEY `tutor_id` (`tutor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of playlist
-- ----------------------------
BEGIN;
INSERT INTO `playlist` VALUES ('m5EcdqE5OHPqFFmxjvuz', 'TwxEgwfAZn73PcgX52Xl', 'Alpro', 'Alpro', 'aXja7pKxK8B2e2OZZxVY.png', '2023-05-31 11:49:08', 'active');
COMMIT;

-- ----------------------------
-- Table structure for tutors
-- ----------------------------
DROP TABLE IF EXISTS `tutors`;
CREATE TABLE `tutors` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tutors
-- ----------------------------
BEGIN;
INSERT INTO `tutors` VALUES ('TwxEgwfAZn73PcgX52Xl', 'Rico Martenstyaro', 'Developer', 'ricomarten@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'C8gVGTEDSk8tNb2x6Ui3.jpg');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('55h3NQ1StlEbe33SglN9', 'zaki', 'zaki@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'DXqidrbX66ufmz2ATcfz.png');
INSERT INTO `users` VALUES ('7e5mp9v2ZktD6KV1frzE', 'rico', 'ricomarten@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'LuHlBuK63sr4KNhtBXaH.png');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
