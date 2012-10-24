-- phpMyAdmin SQL Dump
-- version 3.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2012 at 09:49 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `utkorea`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` smallint(3) NOT NULL auto_increment,
  `code` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `credit` tinyint(1) NOT NULL,
  `major` tinyint(1) default NULL,
  `semester` tinyint(1) NOT NULL,
  PRIMARY KEY  (`course_id`),
  KEY `major_cont_courses` (`major`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `code`, `title`, `credit`, `major`, `semester`) VALUES
(1, 'ISIP4110', 'Pengantar Sosiologi', 3, 2, 1),
(2, 'MKDU4109', 'Ilmu Sosial dan Budaya Dasar', 3, 2, 1),
(3, 'MKDU4221', 'Pendidikan Agama Islam', 3, 2, 1),
(4, 'MKDU4222', 'Pendidikan Agama Kristen', 3, 2, 1),
(5, 'MKDU4223', 'Pendidikan Agama Katholik', 3, 2, 1),
(6, 'MKDU4224', 'Pendidikan Agama Hindu', 3, 2, 1),
(7, 'MKDU4225', 'Pendidikan Agama Budha', 3, 2, 1),
(8, 'MKDU4226', 'Pendidikan Agama Kong Hu Cu', 3, 2, 1),
(9, 'ISIP4212', 'Pengantar Ilmu politik', 3, 2, 1),
(10, 'MKDU4107', 'Bahasa Inggris I', 3, 2, 1),
(11, 'MKDU4110', 'Bahasa Indonesia', 3, 2, 1),
(12, 'MKDU4111', 'Pendidikan Kewarganegaraan', 3, 2, 1),
(13, 'SKOM4103', 'Hubungan Masyarakat', 3, 2, 2),
(14, 'SKOM4101', 'Pengantar Ilmu Komunikasi', 3, 2, 2),
(15, 'ISIP4111', 'Asas-Asas Manajemen', 3, 2, 2),
(16, 'ISIP4112', 'Pengantar Ilmu Ekonomi', 3, 2, 2),
(17, 'ISIP4131', 'Sistem Hukum Indonesia', 3, 2, 2),
(18, 'ISIP4215', 'Pengantar Statistika Sosial', 3, 2, 2),
(19, 'ISIP4211', 'Logika', 3, 2, 3),
(20, 'SKOM4328', 'Komunikasi Pemasaran', 3, 2, 3),
(21, 'SKOM4314', 'Perencanaan Pesan dan Media', 3, 2, 3),
(22, 'SKOM4439', 'Hukum Media Massa', 3, 2, 3),
(23, 'SKOM4209', 'Bahasa Inggris II', 3, 2, 3),
(24, 'SKOM4432', 'Komunikasi Bisnis', 3, 2, 3),
(25, 'SKOM4330', 'Teknik Mencari dan Menulis Berita', 3, 2, 4),
(26, 'SKOM4321', 'Opini Publik', 3, 2, 4),
(27, 'SKOM4312', 'Public Speaking', 3, 2, 4),
(28, 'SKOM4326', 'Komunikasi Persuasif', 3, 2, 4),
(29, 'SKOM4316', 'Komunikasi Inovasi', 3, 2, 4),
(30, 'SKOM4323', 'Filsafat dan Etika Komunikasi', 3, 2, 4),
(31, 'SKOM4317', 'Psikologi Komunikasi', 3, 2, 5),
(32, 'SKOM4331', 'Cybermedia', 3, 2, 5),
(33, 'SKOM4441', 'Komunikasi Sosial', 3, 2, 5),
(34, 'SKOM4315', 'Komunikasi Massa', 3, 2, 5),
(35, 'SKOM4204', 'Teori Komunikasi', 3, 2, 5),
(36, 'SKOM4205', 'Sosiologi Komunikasi Masa', 3, 2, 5),
(37, 'SKOM4440', 'Produksi Media', 3, 2, 6),
(38, 'SKOM4436', 'Metode Penelitian Komunikasi', 3, 2, 6),
(39, 'SKOM4324', 'Manajemen Media Massa', 3, 2, 6),
(40, 'ISIP4216', 'Metode Penelitian Sosial', 3, 2, 6),
(41, 'SKOM4437', 'Analisis Sistem Informasi', 3, 2, 6),
(42, 'SKOM4207', 'Sistem Komunikasi Indonesia', 3, 2, 6),
(43, 'SKOM4435', 'Komunikasi Internasional', 3, 2, 7),
(44, 'SKOM4206', 'Perencanaan Program Komunikasi', 3, 2, 7),
(45, 'SKOM4313', 'Komunikasi Antar Pribadi', 3, 2, 7),
(46, 'SKOM4332', 'Teknik Hubungan Masyarakat', 3, 2, 7),
(47, 'SKOM4319', 'Komunikasi Politik', 3, 2, 7),
(48, 'SKOM4318', 'Komunikasi Antar Budaya', 3, 2, 7),
(49, 'SKOM4327', 'Manajemen Hubungan Masyarakat', 3, 2, 8),
(50, 'SKOM4322', 'Perkembangan Teknologi Komunikasi', 3, 2, 8),
(51, 'SKOM4434', 'Perbandingan Sistem Komunikasi', 3, 2, 8),
(52, 'SKOM4329', 'Komunikasi Organisasi', 3, 2, 8),
(53, 'SKOM4500', 'Tugas Akhir Program (TAP)', 4, 2, 8),
(54, 'MKDU4110', 'Bahasa Indonesia', 3, 1, 1),
(55, 'MKDU4221', 'Pendidikan Agama Islam', 3, 1, 1),
(56, 'MKDU4222', 'Pendidikan Agama Kristen', 3, 1, 1),
(57, 'MKDU4223', 'Pendidikan Agama Katholik', 3, 1, 1),
(58, 'MKDU4224', 'Pendidikan Agama Hindu', 3, 1, 1),
(59, 'MKDU4225', 'Pendidikan Agama Budha', 3, 1, 1),
(60, 'MKDU4226', 'Pendidikan Agama Kong Hu Cu', 3, 1, 1),
(61, 'ESPA4110', 'Pengantar Ekonomi Makro', 3, 1, 1),
(62, 'EKMA4111', 'Pengantar Bisnis', 3, 1, 1),
(63, 'EKMA4116', 'Manajemen', 3, 1, 1),
(64, 'ESPA4112', 'Matematika Ekonomi I', 3, 1, 1),
(65, 'EKMA4115', 'Pengantar Akuntasi', 3, 1, 2),
(66, 'EKSI4205', 'Bank dan Lembaga Keuangan Non Bank', 3, 1, 2),
(67, 'ESPA4111', 'Pengantar Ekonomi Mikro', 3, 1, 2),
(68, 'ESPA4113', 'Statistika Ekonomi I', 3, 1, 2),
(69, 'EKMA4159', 'Komunikasi Bisnis', 3, 1, 2),
(70, 'EKMA4476', 'Audit SDM', 3, 1, 2),
(71, 'EKMA4213', 'Manajemen Keuangan', 3, 1, 3),
(72, 'EKMA4366', 'Pengembangan SDM', 3, 1, 3),
(73, 'EKMA4371', 'Manajemen Rantai Pasokan', 3, 1, 3),
(74, 'EKMA4475', 'Pemasaran Strategik', 3, 1, 3),
(75, 'EKMA4568', 'Pemasaran Jasa', 3, 1, 3),
(76, 'ESPA4211', 'Teori Ekonomi Mikro I', 3, 1, 3),
(77, 'EKMA4157', 'Organisasi', 3, 1, 4),
(78, 'EKMA4158', 'Perilaku Organisasi', 3, 1, 4),
(79, 'EKMA4215', 'Manajemen Operasi', 3, 1, 4),
(80, 'EKMA4216', 'Manajemen Pemasaran', 3, 1, 4),
(81, 'MKDU4111', 'Manajemen Kewarganegaraan', 3, 1, 4),
(82, 'EKMA4263', 'Manajemen Kinerja', 3, 1, 4),
(83, 'EKMA4214', 'Manajemen Sumber Daya Manusia', 3, 1, 4),
(84, 'EKMA4315', 'Akuntansi Biaya', 3, 1, 5),
(85, 'ADBI4201', 'Bahasa Inggris Niaga', 3, 1, 5),
(86, 'EKMA4212', 'Pengantar Aplikasi Komputer', 3, 1, 5),
(87, 'EKMA4369', 'Manajemen Operasi Jasa', 3, 1, 5),
(88, 'EKMA4567', 'Perilaku Konsumen', 3, 1, 5),
(89, 'EKSI4203', 'Teori Portofolio dan Analisis Indonesia', 3, 1, 5),
(90, 'ESPA4217', 'Ekonomi Moneter I', 3, 1, 5),
(91, 'EKMA4314', 'Akuntasi Manajemen', 3, 1, 6),
(92, 'EKMA4367', 'Hubungan Industrial', 3, 1, 6),
(93, 'EKMA4565', 'Manajemen Perubahan', 3, 1, 6),
(94, 'EKMA4570', 'Penganggaran', 3, 1, 6),
(95, 'EKMA4370', 'Kewirausahaan', 3, 1, 6),
(96, 'ESPA4314', 'Perekonomian Indonesia', 3, 1, 6),
(97, 'ADBI4211', 'Manajemen Risiko dan Asuransi', 3, 1, 7),
(98, 'EKMA4310', 'Hukum Komersial', 3, 1, 7),
(99, 'EKMA4311', 'Studi Kelayakan Bisnis', 3, 1, 7),
(100, 'EKMA4413', 'Riset Operasi', 3, 1, 7),
(101, 'EKMA4478', 'Analisis Kasus Bisnis', 3, 1, 7),
(102, 'ISIP4216', 'Metode Penelitian Sosial', 3, 1, 7),
(103, 'EKMA4265', 'Manajemen Kualitas', 3, 1, 8),
(104, 'EKMA4414', 'Manajemen Strategik', 3, 1, 8),
(105, 'EKMA4434', 'Sistem Informasi Manajemen', 3, 1, 8),
(106, 'EKMA4569', 'Perencanaan Pemasaran', 3, 1, 8),
(107, 'EKMA4500', 'Tugas Akhir Program (TAP)', 4, 1, 8),
(108, 'BING4102', 'Reading I', 3, 3, 1),
(109, 'BING4103', 'Writing I', 3, 3, 1),
(110, 'MKDU4107', 'Bahasa Inggris I', 3, 3, 1),
(111, 'MKDU4110', 'Bahasa Indonesia', 3, 3, 1),
(112, 'MKDU4221', 'Pendidikan Agama Islam', 3, 3, 1),
(113, 'MKDU4222', 'Pendidikan Agama Kristen', 3, 3, 1),
(114, 'MKDU4223', 'Pendidikan Agama Katholik', 3, 3, 1),
(115, 'MKDU4224', 'Pendidikan Agama Hindu', 3, 3, 1),
(116, 'MKDU4225', 'Pendidikan Agama Budha', 3, 3, 1),
(117, 'MKDU4226', 'Pendidikan Agama Kong Hu Cu', 3, 3, 1),
(118, 'PBIS4114', 'Structure I', 3, 3, 1),
(119, 'BING4104', 'Reading II', 3, 3, 2),
(120, 'BING4105', 'Writing II', 3, 3, 2),
(121, 'MKDU4109', 'Ilmu Sosial dan Budaya Dasar', 3, 3, 2),
(122, 'MKDU4111', 'Pendidikan Kewarganegaraan', 3, 3, 2),
(123, 'PBIS4115', 'Structure II', 3, 3, 2),
(124, 'BING4206', 'Reading III', 3, 3, 3),
(125, 'BING4207', 'Writing III', 3, 3, 3),
(126, 'BING4321', 'English for Translation', 3, 3, 3),
(127, 'BING4322', 'Grammar Translation Exercises', 3, 3, 3),
(128, 'PBIS4216', 'Structure III', 3, 3, 3),
(129, 'PBIS4102', 'Cross Cultural Understanding', 3, 3, 3),
(130, 'BING4208', 'Reading IV', 3, 3, 4),
(131, 'BING4209', 'Writing IV', 3, 3, 4),
(132, 'BING4431', 'Translation 1', 3, 3, 4),
(133, 'BING4432', 'Translation 2', 3, 3, 4),
(134, 'PBIS4131', 'Sociolinguistics', 3, 3, 4),
(135, 'ISIP4215', 'Pengantar Statistik Sosial', 3, 3, 4),
(136, 'BING4212', 'Bahasa Indonesia Tatabahasa & Komposisi', 3, 3, 5),
(137, 'BING4213', 'Bahasa Indonesia Merangkum', 3, 3, 5),
(138, 'BING4214', 'Pengantar Linguistik Umum', 3, 3, 5),
(139, 'BING4433', 'Translation 3', 3, 3, 5),
(140, 'BING4434', 'Translation 4', 3, 3, 5),
(141, 'BING4315', 'Morfologi & Sintaksis Bahasa Indonesia', 3, 3, 6),
(142, 'BING4316', 'English Morpoho-Syntax', 3, 3, 6),
(143, 'BING4435', 'Translation 5', 3, 3, 6),
(144, 'BING436', 'Translation 6', 3, 3, 6),
(145, 'BING4324', 'Sejarah Pemikiran Modern', 3, 3, 6),
(146, 'BING4317', 'Semantics', 3, 3, 7),
(147, 'BING4318', 'Teori dan Masalah Penerjemahan', 3, 3, 7),
(148, 'BING4319', 'Penyuntingan Teks Terjemahan', 3, 3, 7),
(149, 'BING4320', 'Analisis Teks dalam Penerjemah', 3, 3, 7),
(150, 'BING4330', 'Penerjemahan Karya Fiksi', 3, 3, 7),
(151, 'BING4437', 'Translation 7', 3, 3, 8),
(152, 'BING4438', 'Translation 8', 3, 3, 8),
(154, 'BING4439', 'Translation 9', 3, 3, 8),
(155, 'BING4440', 'Translation 10', 3, 3, 8),
(156, 'BING4500', 'Tugas Akhir Program (TAP)', 4, 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `history_sms`
--

CREATE TABLE IF NOT EXISTS `history_sms` (
  `history_id` mediumint(8) NOT NULL auto_increment,
  `userid` int(5) NOT NULL,
  `apimsgid` mediumtext NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` varchar(160) NOT NULL,
  `datestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `history_sms`
--

INSERT INTO `history_sms` (`history_id`, `userid`, `apimsgid`, `phone`, `message`, `datestamp`) VALUES
(1, 10105282, '5db8b6e9e231699c3812f871875d18f3', '821086887058', 'Testing', '2012-09-14 17:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `nim` varchar(10) NOT NULL,
  `name` varchar(80) default NULL,
  `major` tinyint(1) default NULL,
  `region` varchar(70) default NULL,
  `phone` varchar(70) default NULL,
  `status` varchar(20) default NULL,
  `payment` varchar(20) default NULL,
  `period` varchar(20) default NULL,
  `email` varchar(50) NOT NULL,
  `birth` varchar(50) default NULL,
  `religion` enum('Islam','Protestan','Katolik','Hindu','Budha') default 'Islam',
  `sex` enum('Pria','Wanita') default 'Pria',
  `employment` varchar(22) default NULL,
  `marital_status` varchar(13) default NULL,
  `education` varchar(14) default NULL,
  `certificate` varchar(48) default NULL,
  `mother_name` varchar(18) default NULL,
  `address` varchar(91) default NULL,
  `photo` varchar(100) default NULL,
  PRIMARY KEY  (`nim`),
  UNIQUE KEY `phone` (`phone`,`nim`),
  KEY `mahasiswa_cons` (`major`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `name`, `major`, `region`, `phone`, `status`, `payment`, `period`, `email`, `birth`, `religion`, `sex`, `employment`, `marital_status`, `education`, `certificate`, `mother_name`, `address`, `photo`) VALUES
('13205962', 'Deni Sugandi ', 3, 'KBRI Seoul', '8210-38020830', 'Aktif', NULL, '4', 'Kang_deni@hotmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16440436', 'Hermansyah', 2, 'Ansan', '821029459122', 'Aktif', NULL, '4', 'andiarman56@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16440554', 'Abdul Rafik', 1, 'Ansan', '821066481889', 'Aktif', NULL, '4', 'abdulrafik23@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16440619', 'Deni Setyawan', 2, 'KBRI Seoul', '821029294637', 'Aktif', NULL, '3', 'adenwilliam52@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16440862', 'Priyanto Widodo', 2, 'Ansan', '821028914092', 'Aktif', NULL, '4', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16440902', 'Miftah Asrori', 1, 'Ansan', '821042198006', 'Aktif', NULL, '4', 'smg193@yahoo.co.uk', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16441871', 'Susilo Utomo', 1, 'Ansan', '821068731918', 'Aktif', NULL, '4', 'tomo_utamakan@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16441936', 'Hendra Mustari', 1, 'Ansan', '821086894408', 'Aktif', NULL, '4', 'endha_sappurede@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16441982', 'Muhamad Sodiq', 3, 'Ansan', '821021328906', 'Aktif', NULL, '4', 'muhamadjune@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16442035', 'Muhammad Abdul Keri', 1, 'Ansan', '821026609108', 'Aktif', NULL, '4', 'fackyou_ok@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16442644', 'Jaenal', 1, 'Ansan', '821031848993', 'Aktif', NULL, '4', 'zaenalaza89@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16442676', 'Muhammad Iksan', 2, 'Ansan', '821043751984', 'Aktif', NULL, '4', 'iksan_doank2000@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16442683', 'Saprianto Yaman', 3, 'Ansan', '821086861932', 'Aktif', NULL, '4', 'hitachi_pares@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444393', 'Ardiansyah Pasadena', 1, 'Ansan', '821086990990', 'Aktif', NULL, '4', 'a.pasadena@me.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444419', 'Nur Risachianti', 3, 'Ansan', '821072175382', 'Aktif', NULL, '4', 'risa_rebel@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444426', 'Eko Wibowo', 1, 'Guro', '821026600509', 'Aktif', NULL, '4', 'wibeko@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444433', 'Surono', 1, 'Guro', '821086958439', 'Aktif', NULL, '4', 'suronoinchon@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444537', 'Wijiyanto', 2, 'Guro', '821026603383', 'Aktif', NULL, '4', 'adek_kecil01@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444544', 'Moh Rois', 1, 'Guro', '821086713027', 'Aktif', NULL, '4', 'mohrois97@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444576', 'Heru Waryono', 1, 'Guro', '821023284485', 'Aktif', NULL, '4', 'dany_sekhu@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444583', 'Refi Pujiatmoko', 1, 'Ansan', '821039432688', 'Aktif', NULL, '4', 'refyboy01gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444609', 'Nasir Almaududi', 1, 'Guro', '821086715159', 'Aktif', NULL, '4', 'nasiralmaududi83@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444623', 'Sri Nuryani', 1, 'Ujiongbu', '821046947306', 'Aktif', NULL, '4', 'cah_ayu8885@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444648', 'Mulyono Awaludin', 1, 'Guro', '821076360199', 'Aktif', NULL, '4', 'mulyono_awaludin@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16444655', 'Nanang Mualim', 2, 'Ansan', '821025951922', 'Aktif', NULL, '4', 'putra_pasoepati@ymail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16509323', 'Sugiharso', 2, 'Busan', '821030402321', 'Aktif', NULL, '4', 'barotoahmad@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16509348', 'Moh. Fitroh Riyadi', 2, 'Daegu', '821027958081', 'Aktif', NULL, '4', 'alkahfi700@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16509402', 'Eko Prasetyo', 1, 'Daejon', '821058168283', 'Aktif', NULL, '4', 'e.prasetyo19@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16509434', 'Supriyono Nontji', 2, 'Busan', '821033444509', 'Aktif', NULL, '4', 'kim.nontji@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16509441', 'Feby Jatmiko', 1, 'Busan', '821030405232', 'Aktif', NULL, '4', 'febyjatmiko@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16509506', 'Ujang Sodikin', 1, 'Ansan', '821092940803', 'Aktif', NULL, '4', 'sodikin_89@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16509552', 'Bin Harun Sitompul', 2, 'KBRI Seoul', '821031772610', 'Aktif', NULL, '4', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16509584', 'Dedy Prasetiyo', 3, 'Daejon', '821035268314', 'Aktif', NULL, '4', 'dedyimnida@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16510303', 'Windhi Marwanto', 1, 'Daegu', '821086924605', 'Aktif', NULL, '4', 'jetwin0750@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16510446', 'Shohibul Kafi', 1, 'Busan', '821058052332', 'Aktif', NULL, '4', 'kelven.dias@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16515302', 'Burhanudin Rabbany', 1, 'Daegu', '821058500767', 'Aktif', NULL, '4', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16515334', 'Ajat Jaenudin', 1, 'Daegu', '821072183899', 'Aktif', NULL, '4', 'Jaenudin.Ajat@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16515404', 'Adris', 3, 'Daegu', '821027049897', 'Tidak Aktif', NULL, '?', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16515452', 'Wasanudin', 1, 'Daegu', '821068730716', 'Aktif', NULL, '4', 'wasanudin@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16515484', 'Sutik', 2, 'Daegu', '821068692838', 'Aktif', NULL, '4', 'koplakjetak@ymail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16515524', 'M. Khoirul Anam', 1, 'Daegu', '821092945054', 'Aktif', NULL, '4', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16515556', 'Sunardi', 1, 'Busan', '821049961186', 'Aktif', NULL, '4', 'sunardi.sragen@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16517123', 'Nurohman', 1, 'Ansan', '821072182360', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518354', 'Tashuri', 1, 'Cheonan', '821086967605', 'Aktif', NULL, '4', 'nkumbang@Yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518361', 'Taufik Muharom', 1, 'Cheonan', '821027350610', 'Aktif', NULL, '4', 'T.Muharom@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518386', 'Trianto', 1, 'Ansan', '821049727891', 'Aktif', NULL, '4', 'ian_putra82@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518401', 'Sriyanto', 2, 'Guro', '821028979921', 'Aktif', NULL, '4', 'riyant_juliyant@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518433', 'Feri Purwanto', 1, 'Ansan', '821028927005', 'Aktif', NULL, '4', 'feri.purwanto7005@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518472', 'Yessi Wahyuni', 1, 'KBRI Seoul', '821086301977', 'Aktif', NULL, '4', 'ateuncie@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518497', 'Muhsin Aditama', 1, 'Cheonan', '821028928980', 'Aktif', NULL, '4', 'adit_tama2002@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518537', 'Chaerul Amin', 1, 'Ansan', '821086908504', 'Pindah', NULL, '4', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16518576', 'Suko wibowo', 2, 'Ujiongbu', '821086939702', 'Aktif', NULL, '4', 'dava_wibowo@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18472396', 'Suratman', 2, 'Ansan', '821049652162', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18472911', 'Kunomo HS', 1, 'Ansan', '821086817472', 'Aktif', NULL, '3', 'daunkunomo23@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18472929', 'Tamrin', 2, 'Daegu', '821086892780', 'Aktif', NULL, '3', 'oppatamrin@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18472982', 'Arif Hanafi', 3, 'Daegu', '821026600612', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473035', 'Bambang Zulparisi', 2, 'Daegu', '821072151137', 'Aktif', NULL, '3', 'zulparisibambang@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473048', 'Yadi Mulya', 2, 'Daegu', '821031455489', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473067', 'Riki bayu hanggara', 1, 'Daegu', '821049638711', 'Aktif', NULL, '3', 'bayuhan_riky@rocketmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473099', 'Feri Irawan ', 1, 'Daegu', '821068747372', 'Aktif', NULL, '3', 'adipathi.kuningan@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473107', 'Evi Triyani', 3, 'Daegu', '821031499995', 'Aktif', NULL, '3', 'evi3yani@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473139', 'Awan Kuswandi', 1, 'Ansan', '821072142157', 'Aktif', NULL, '3', 'awankus22@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473146', 'Agus Muhlasin Bahaji', 1, 'Daegu', '821072260814', 'Aktif', NULL, '3', 'al.muklas68@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473185', 'Suharno', 1, 'Daegu', '821068740304', 'Aktif', NULL, '3', 'suh.arno99@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473192', 'Choirul Huda', 1, 'Daegu', '821056787924', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18473218', 'Indra Cahyono', 1, 'Daegu', '821086906660', 'Aktif', NULL, '3', 'indrakimbab434@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18489051', 'Hendri Setyawan', 2, 'Cheonan', '821086736216', 'Aktif', NULL, '3', 'belalank.kupu2@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18489076', 'Irwan Sangan', 1, 'Busan', '821030628803', 'Aktif', NULL, '3', 'irwansangan88@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18489116', 'Ardianto Wijaya Kusuma', 1, 'Ansan', '821051792555', 'Aktif', NULL, '3', 'wk.ardi@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18489148', 'Nur Solikin', 1, 'Cheonan', '821086977765', 'Aktif', NULL, '3', 'n_solikin@rocketmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18489266', 'Iwan Andrian Febiansah', 1, 'Busan', '821072178898', 'Aktif', NULL, '3', 'atepiwan@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491373', 'Adi Susilo', 2, 'Busan', '821031461101', 'Aktif', NULL, '3', 'densogol@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491406', 'Didik Heri Susilo', 1, 'Ansan', '821072136003', 'Aktif', NULL, '3', 'didik.herisusilo@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491413', 'Muhlisin', 1, 'Ansan', '821030403210', 'Aktif', NULL, '3', 'cecep.muhlisin84@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491484', 'Mahyudin', 2, 'Ansan', '821086941281', 'Aktif', NULL, '3', 'mahyudyn@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491549', 'Asep Wiharja', 2, 'Ansan', '821026852099', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491588', 'Hasim', 2, 'Ansan', '821044320144', 'Aktif', NULL, '3', 'hasimsinau@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491595', 'Moh Jainal Arifin', 2, 'Ansan', '821028920312', 'Aktif', NULL, '3', 'kabul.setiono25@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491642', 'Johan Arif Sampurno', 2, 'Cheonan', '821068622442', 'Aktif', NULL, '3', 'agmon_emoy@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18491674', 'Medina Adlhayany', 3, 'Cheonan', '821034032090', 'Aktif', NULL, '3', 'hak_dina@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492311', 'Sanita NR', 1, 'Ansan', '821065166377', 'Pindah', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492336', 'Eka Edi Siswanto', 1, 'Ansan', '821049668912', 'Aktif', NULL, '3', 'k.lord89@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492343', 'Titin Yulianti', 1, 'Ansan', '821086716487', 'Aktif', NULL, '3', 'Bonexe_cute@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492368', 'Iis Apriyanti', 1, 'Ansan', '821086952519', 'Aktif', NULL, '3', 'iisapriyanti82@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492408', 'Widya Susilo', 1, 'Ansan', '821074168887', 'Aktif', NULL, '3', 'susilowidua@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492422', 'Fuad Hilmi', 1, 'Ansan', '821068745510', 'Aktif', NULL, '3', 'k.lord89@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492447', 'Pramujianto', 1, 'Ansan', '821086928814', 'Aktif', NULL, '3', 'prama@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492461', 'Rendy Sandiana Herlambang', 1, 'Ansan', '821086880779', 'Aktif', NULL, '3', 'rendysandiana@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492479', 'Heri Heryanto', 1, 'Ansan', '821049665444', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492486', 'Weli Wibowo', 1, 'Ansan', '821049970790', 'Aktif', NULL, '3', 'wibowo.weli@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492493', 'Dedi Supriyadi', 1, 'Ansan', '821022632505', 'Aktif', NULL, '3', 'awaybroejul@rocketmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18492565', 'Saiful Ansori', 1, 'Ansan', '821049639117', 'Aktif', NULL, '3', 'johnpenyoet@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18592958', 'Sobaryanto', 1, 'Guro', '821068695957', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18592965', 'Winarno', 3, 'Guro', '821028931477', 'Aktif', NULL, '2', 'win8119@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18592997', 'Ade Sudir Supriyatna', 1, 'Ansan', '821049972712', 'Aktif', NULL, '3', 'ads.nelly@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18593018', 'Ary Fajri', 1, 'Ansan', '821072177661', 'Aktif', NULL, '3', 'aryfajri@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18593057', 'Dewi Maya Syaroh', 3, 'Guro', '821030378230', 'Aktif', NULL, '3', 'maya_cocconeco@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18593089', 'Sujatmiko', 3, 'Busan', '821046955166', 'Aktif', NULL, '3', 'firja.komp@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18593104', 'Moh. Tohari', 1, 'Busan', '821029058086', 'Aktif', NULL, '3', 'putratoha@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18593129', 'Putut Riyoko', 1, 'Guro', '821072182282', 'Aktif', NULL, '3', 'danudiningrat@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18593175', 'Putra Astaman', 2, 'Gwangju', '821049913335', 'Aktif', NULL, '2', 'astamanputra77@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18594485', 'Aris Krisgiarto', 2, 'Ansan', '821027098102', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18594589', 'Apri Widiyosari', 3, 'Ansan', '821086896177', 'Aktif', NULL, '3', 'widiyosari.apri@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18594636', 'Oko Wijanarko', 1, 'Ansan', '821028932692', 'Aktif', NULL, '3', 'okowij@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18594643', 'Surnali', 3, 'Ansan', '821068690619', 'Aktif', NULL, '3', 'ardhanali@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18594675', 'Mujahidin', 3, 'Guro', '821081234291', 'Aktif', NULL, '3', 'didindahlan@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18594708', 'Muhamad Sohibul Munir', 3, 'Ansan', '821025858808', 'Aktif', NULL, '3', 'sohibul_munir@ymail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18595075', 'Yusuf', 1, 'Busan', '821092942034', 'Aktif', NULL, '3', 'yusuf.muhammad.h@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18595122', 'Wartono', 2, 'Busan', '821080504915', 'Tidak Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18595179', 'Muhazir', 3, 'Busan', '821028922320', 'Aktif', NULL, '?', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18595265', 'Yogo Ikhsananto', 3, 'Ansan', '821025128485', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18595344', 'Warsana', 2, 'Busan', '821023584466', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18595369', 'Ahmad Sunardi Hajaryanto', 2, 'Busan', '821086971557', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18689654', 'Humaizi', 3, 'Ansan', '821049522219', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18689661', 'Nursito Aji', 3, 'Guro', '821030373239', 'Aktif', NULL, '3', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18689686', 'Herman', 2, 'Ansan', '821072192161', 'Tidak Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18690018', 'Sofyan', 2, 'Ansan', '821068721765', 'Aktif', NULL, '2', 'sofyanputra3@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881414', 'Heryanto', 3, 'Ansan', '821056081987', 'Aktif', NULL, '2', 'lucky.net499@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881417', 'Walim', 3, 'Daegu', '821086800694', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881421', 'Arum Setyo Sumekar', 3, 'Daegu', '821049676208', 'Aktif', NULL, '2', 'arumsetyosumekar@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881439', 'Indriyarni', 3, 'Daegu', '821049676247', 'Aktif', NULL, '2', 'ayu_cantika1990@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881453', 'Agus Palali', 1, 'Gwangju', '821086933759', 'Aktif', NULL, '2', 'putrabahari76@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881485', 'Asdar Asmara', 3, 'Busan', '821086906590', 'Aktif', NULL, '2', 'asdar.sm85@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881492', 'Heppi Hariyanto', 2, 'Daegu', '821086995889', 'Aktif', NULL, '2', 'heppydays17@windowslive.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881525', 'Nurman Sasono', 2, 'Ansan', '821092946852', 'Aktif', NULL, '2', 'nursaputra@windowslive.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881532', 'Suma jayaningrat', 2, 'Busan', '821086956798', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881564', 'Suryadi', 1, 'Daegu', '821086944205', 'Aktif', NULL, '2', 'yadisurya4@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881611', 'Eliyah', 3, 'Daegu', '821057897449', 'Aktif', NULL, '2', 'eliya7449@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881636', 'Achmad jaelani', 2, 'Busan', '821086882454', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881708', 'Wahidin', 3, 'Daegu', '821031416932', 'Aktif', NULL, '2', 'mybornplace_1341205@ymail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881754', 'Edyanto', 2, 'Busan', '821068739384', 'Aktif', NULL, '2', 'edyanto86@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881761', 'Jamhari', 3, 'Daegu', '821086720288', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881779', 'Hariyanto', 2, 'Gwangju', '821095951479', 'Aktif', NULL, '2', 'hariyanto706@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881786', 'Dian Agung Kurniawan', 1, 'Busan', '821086853811', 'Aktif', NULL, '2', 'dianagungkurniawan@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881793', 'Puguh Dwiyanto', 1, 'Busan', '821049510609', 'Aktif', NULL, '2', 'puguh.dwiyanto@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881801', 'Mohamad Abdul Azis', 3, 'Daegu', '821068707666', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881819', 'Santi Noor', 3, 'Daegu', '821086862140', 'Aktif', NULL, '2', 'santiamisuka@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881826', 'Yuswo Hadi Ramadhan', 1, 'Ansan', '821057866110', 'Cuti', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881858', 'Daryono Basuki', 2, 'Cheonan', '821086965044', 'Aktif', NULL, '2', 'megonoloverz@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881865', 'Hendarsyah', 1, 'Ansan', '821068746005', 'Aktif', NULL, '2', 'hendarsyah21@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881897', 'Aminudin Zukhria Rokhman', 1, 'Ansan', '821027646689', 'Aktif', NULL, '2', 'aminudinzukhriarokhman@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881944', 'Surajiman', 1, 'Ansan', '821058361535', 'Aktif', NULL, '2', 'jiman.80s@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881951', 'Dede Priyono', 1, 'Guro', '821068724342', 'Aktif', NULL, '2', 'nandaqwe@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881969', 'Samustangino', 1, 'Ansan', '821072633771', 'Aktif', NULL, '2', 'samustanginosam@ymail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18881983', 'Siti Nurlaila', 1, 'Guro', '821043153900', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882004', 'Dedi Setiawan', 2, 'Ansan', '821065963111', 'Aktif', NULL, '2', 'dedi.setiawan1985@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882068', 'Wami Mega Hartati', 2, 'Ansan', '821025682412', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882075', 'Harianto', 1, 'Cheonan', '821058361985', 'Aktif', NULL, '2', 'lulunurhayati9@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882108', 'Bahaudin', 2, 'Ansan', '821072187165', 'Aktif', NULL, '2', 'Bahaudin.udin76@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882147', 'Sunu Adityanto Suparno', 3, 'Guro', '821092941121', 'Aktif', NULL, '2', 'sunu0604@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882161', 'Ihin Amaludin', 1, 'Ansan', '821072639567', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882179', 'Farkhan Karima', 1, 'Cheonan', '821030404917', 'Aktif', NULL, '2', 'farkhank@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882193', 'Subur Waluyo', 2, 'Ansan', '821028910208', 'Aktif', NULL, '2', 'sobur.waluyo@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882201', 'Ali Hasroni', 2, 'Ansan', '821031438169', 'Aktif', NULL, '2', 'ragilwae22@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882219', 'Dani Saepudin', 1, 'Ansan', '821030401985', 'Aktif', NULL, '2', 'dani_jitshu@hotmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882226', 'Muh Heru Kaharudin', 3, 'Ujiongbu', '821066751990', 'Aktif', NULL, '2', 'muhherukaharudin@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882233', 'Kurniawan Saleh', 3, 'Guro', '821032819101', 'Aktif', NULL, '2', 'kurnia1saleh@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882258', 'Adcha Ediwibowo', 2, 'Ansan', '821058472220', 'Aktif', NULL, '2', 'aca_w@rocketmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882265', 'Petrus Palembangan', 3, 'Ansan', '821049926234', 'Aktif', NULL, '2', 'palembanganp@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882272', 'Eva Octiani', 1, 'Ansan', '821086940856', 'Aktif', NULL, '2', 'evaoctiani7@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882297', 'Joko Priyono', 1, 'Ujiongbu', '821088688212', 'Aktif', NULL, '2', 'venjonk@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882305', 'Firdaus', 3, 'Cheonan', '821089867628', 'Aktif', NULL, '2', 'daustt@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882312', 'Aris Sugiarto', 3, 'Cheonan', '821072632105', 'Aktif', NULL, '2', 'aries.prakoso@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882337', 'Triyono', 3, 'Ansan', '821068731172', 'Aktif', NULL, '2', 'ghodenz@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882344', 'Budianto', 1, 'Daejon', '821081232050', 'Aktif', NULL, '2', 'budi.84anto@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882383', 'Luluk Rhomanzah', 2, 'Ansan', '821025681815', 'Aktif', NULL, '2', 'luck.koreann@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882409', 'Inggil Supanjiwa', 1, 'KBRI Seoul', '821072199773', 'Aktif', NULL, '2', 'vinct.zou@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882416', 'Kharis Aminudin', 3, 'Guro', '821031413022', 'Aktif', NULL, '2', 'chameedeen@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882423', 'Dipo Asmoro', 1, 'Gwangju', '821049962080', 'Aktif', NULL, '2', 'dipo.asmoro21@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882448', 'Fatikhin', 1, 'Guro', '821031472664', 'Aktif', NULL, '2', 'fatikhin89@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882455', 'Neli Iswati', 2, 'Ansan', '821086800513', 'Aktif', NULL, '2', 'nelly_chaca@yahoo.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882462', 'Romy Roobint Stego', 1, 'Ansan', '821033290609', 'Aktif', NULL, '2', 'restoeboemie29@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882502', 'Dhanet Siswoyo', 2, 'Ansan', '821072175410', 'Aktif', NULL, '2', 'dhanet_siswoyo@ymail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882527', 'Abdul Basir', 1, 'Ansan', '821033411756', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882573', 'Ketut Arbi Amsah', 1, 'Ansan', '827042195128', 'Aktif', NULL, '2', 'arbiamsah@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882598', 'Sulfahidin', 2, 'Ansan', '821072192444', 'Aktif', NULL, '2', 'melemelachuk@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18882606', 'Susana Marlina', 3, 'Ansan', '821057874932', 'Aktif', NULL, '2', 'cucanmaniez@ymail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18883131', 'Mahfudhon', 1, 'Busan', '821072147644', 'Aktif', NULL, '3', 'mahfudz.ilham@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18889294', 'Ahmad Romdlon', 1, 'Cheonan', '821028979336', 'Aktif', NULL, '2', '', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18926072', 'Tofikurokhman', 1, 'Guro', '821086813784', 'Aktif', NULL, '2', 'towexckep@yahoo.co.id', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18926137', 'Yuniarti', 1, 'Cheonan', '821028361487', 'Aktif', NULL, '2', 'manyoen07@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18926255', 'Muh Soleh', 2, 'Ansan', '821031402389', 'Aktif', NULL, '2', 'muhsoleh86@gmail.com', NULL, 'Islam', 'Pria', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE IF NOT EXISTS `major` (
  `major_id` tinyint(1) NOT NULL auto_increment,
  `major` varchar(30) NOT NULL,
  PRIMARY KEY  (`major_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`major_id`, `major`) VALUES
(1, 'Manajemen'),
(2, 'Ilmu Komunikasi'),
(3, 'Bahasa Inggris');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` tinyint(3) NOT NULL auto_increment,
  `username` varchar(100) default NULL,
  `name` varchar(35) default NULL,
  `password` varchar(32) default NULL,
  `group_id` tinyint(1) default NULL,
  `major_id` tinyint(1) default NULL,
  `status` varchar(17) default NULL,
  `living` varchar(11) default NULL,
  `region` varchar(12) default NULL,
  `email` varchar(30) default NULL,
  `phone` varchar(13) default NULL,
  `bank` varchar(22) default NULL,
  `account` varchar(53) default NULL,
  `channel` varchar(71) default NULL,
  `subject` varchar(44) default NULL,
  `nip` varchar(21) default NULL,
  `birth` varchar(25) default NULL,
  `affiliation` varchar(31) default NULL,
  `photo` varchar(100) default NULL,
  PRIMARY KEY  (`staff_id`),
  UNIQUE KEY `username` (`username`),
  KEY `major_cons` (`major_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `username`, `name`, `password`, `group_id`, `major_id`, `status`, `living`, `region`, `email`, `phone`, `bank`, `account`, `channel`, `subject`, `nip`, `birth`, `affiliation`, `photo`) VALUES
(1, 'adhi', 'Adhi Setyo Santoso, S.T.', '1d939c7fa8bb99056c52b9ce98789a85', NULL, 2, 'Aktif', 'Seoul', 'Utara', 'adhi_s_323@yahoo.com', '821027871405 ', 'Woori', '1002-145-667008', '', 'Komunikasi Pemasaran', '', 'Bandung/04-05-1987', 'KAIST', NULL),
(2, 'aimelani', 'Ai Melani, S.T.', '969c7ec7950ba39c5c9dad5e8af4087f', NULL, 3, 'Aktif', 'Daejeon', 'Selatan', 'ai2345@yahoo.com', '821044902505 ', 'WooriBank', '1002836186646', 'http://www.ustream.tv/channel/ai-melani', 'Pendidikan Kewarganegaraan, Structure II', '', '25-05-1978', 'KAIST', NULL),
(3, 'akhmad', 'Akhmad Viko Zakhary Santosa, S.Hut', '0b144403255df56ca97dc83c2d5ebf9d', NULL, 1, 'Aktif', 'Seoul', 'Utara', 'viko@ymail.com', '821063411780 ', 'Shinhan', '110-317-597154', ' http://www.ustream.tv/channel/vikozakhary', 'Pengantar Ekonomi Mikro, Organisasi', '', 'Bandung/19-01-1987', 'Seoul National University (SNU)', NULL),
(4, 'andrieanto', 'Andrieanto Nurochman', 'bbe7fe4223a9cf3d5f9b2c54a5b23948', NULL, 1, 'Aktif', 'Gyeongsan', 'Selatan', 'andrienurr@gmail.com', '821034998998 ', '', '', '', 'Pengantar Akuntansi, Manajemen Operasi', '', 'Tangerang/02-04-1986', 'Yeungnam University', NULL),
(5, 'andy', 'Andy Tirta, M. Sc.', 'afca855fe2aafe9802539aea85e90a55', NULL, 1, 'Aktif', 'Seoul', 'Selatan', 'sdmstrategis@yahoo.com', '821049970403 ', 'Daegu Bank', '080-13-226-720', ' http://www.ustream.tv/channel/andy-sosiologi', 'Organisasi', '', 'Jakarta/12-04-1985', 'Yeungnam University', NULL),
(6, 'aulia', 'Aulia Djunaedi', '4f294356f6a085c3bd1a41ea3ab91dc2', NULL, 3, 'Aktif', 'Daejeon', 'Utara', 'oliayippie@yahoo.com', '821056958885 ', '', '418 12 164786', 'www.ustream.tv/channel/AuliaDjunaedi1979', 'Sociolinguistics, Reading III', '', '', 'KAIST', NULL),
(7, 'awlia', 'Awlia Kharis Prasidhi, S.T.', '16c44d83692fd78df4e95c11d06499b8', NULL, 2, 'Aktif', 'Daejeon', 'Selatan', 'prasidhi89@gmail.com', '821030371670 ', 'Woori', '1002-044-767519', '', 'Pengantar Ilmu Komunikasi', '', 'Yogyakarta/19-01-1989', 'KAIST', NULL),
(8, 'chairul', 'Chairul Hudaya, ST, M.Eng', '7048f7a2e60bba315b9f9fd1768be321', 4, 2, 'Aktif', 'Seoul', 'Utara', 'c.hudaya@nuklir.info', '821022950413', 'Woori Bank', '1002-444-573051', 'http://www.ustream.tv/channel/statsos', 'Teknik Mencari dan Menulis Berita', '', 'Bandar Harapan/02-05-1984', 'KIST', NULL),
(9, 'dyas', 'Dyastriningrum Subandiati', '90efc5d7ad3915c414dda0bac3df9346', NULL, 3, 'Aktif', 'Seoul', 'Utara', 'dyastri2005@yahoo.com', '821058170807 ', 'Woori Bank', '1002-440-188030', 'http://www.ustream.tv/channel/dyas-triningrum-english', 'Cross Cultural Understanding', '', '08-07-19xx', 'Pukyong National University', NULL),
(10, 'ebeth', 'Elizabeth Valentin', '78aab38f2b2d2320db3933aaaaf754dc', NULL, 3, 'Aktif', 'Daejeon', 'Utara', 'elizabeth.valentin@kaist.ac.kr', '821072138901 ', 'Woori Bank', '1002-445-658575', '', 'Structure II', '', 'Jakarta/21-01-1989', 'KAIST', NULL),
(11, 'fadia', 'Fadia Dewanda, S.T.', '69b54f79cf30fe73e1ec18ae6b2a594e', NULL, 1, 'Aktif', 'Daejeon', 'Selatan', 'fadia.dewanda@gmail.com', '821030371631 ', 'Woori Bank', '1002-144-791880', '', 'Statistika Ekonomi I', '', 'Bogor/07-12-1988', 'KAIST', NULL),
(12, 'frida', 'Frida Ferdani Putri', 'd0a2c8a6462bba82f2d2a5b921aad282', NULL, 3, 'Aktif', 'Seoul', 'Utara', 'fridaferdaniputri@gmail.com', '821077512310 ', '', '', '', 'Writing II', '', 'Bandung/10-05-1985', 'Korea University', NULL),
(13, 'hardian', 'Hardian Reza Dharmayanda, Ph.D.', 'd20bee7083d1ce934fb435fbe7cc0689', NULL, 1, 'Aktif', 'Changwon', 'Selatan', 'hr.dharmayanda@lge.com', '821057151983 ', '', '110-314-132164', 'http://www.ustream.tv/channel/hardian-reza', 'Manajemen Keuangan, Pengantar Ekonomi Mikro', '', 'Sorong/20-01-1983', 'LG Electronics', NULL),
(14, 'aswantara', 'I Komang Adi Aswantara', '6f3aad5c9982bee4d246c0666d0f1cfe', NULL, 1, 'Aktif', 'Daejeon', 'Utara', 'adi.aswantara@gmail.com', '821068698606 ', '', '', '', 'Pengantar Akuntansi', '', 'Singaraja/03-06-1986', 'KAIST', NULL),
(15, 'irene', 'Irene Margaret', '52ac0ada7aa1bc60ae5d4492cbae2fca', NULL, 2, 'Aktif', 'Seoul', 'Utara', 'irene.margaret@gmail.com', '821021353727 ', 'Shinhan Bank', '110-357-885102', '', 'Pengantar Statistika Sosial', '', 'Jakarta/ 29-05-1983', 'Seoul National University (SNU)', NULL),
(16, 'joko', 'Joko Hariyono', '160496cb98fe85e3205a781c2f6627ce', NULL, 2, 'Aktif', 'Busan', 'Selatan', 'mtcjogja@gmail.com', '821021334662 ', 'Kyong Nam Bank', '689-21-0220344', '', 'Komunikasi Bisnis, Perencanaan Pesan & Media', '', 'Jember/23-09-1976', 'Ulsan University', NULL),
(17, 'maya', 'Maya Widiarini', 'b5574300aca3b9c17edaff755821e4b9', NULL, 2, 'Aktif', 'Namyangju', 'Utara', 'maya.widiarini@gmail.com', '', 'Kookmin Bank', '283501-04-329262', '', 'Perencanaan Pesan dan Media, Opini Publik', '', 'Blora/20-05-1989', 'Kyung Hee University', NULL),
(18, 'harist', 'Muhammad Harist Murdani, S.T.', '29b4cd85fc1b1d9f17e79ff0a9c62f2a', NULL, 2, 'Aktif', 'Busan', 'Selatan', 'hariste@gmail.com', '821058114472 ', 'Hana Bank', '880-910367-40107', '', 'Pengantar Statistika Sosial', '', 'Surabaya/31-07-1985', 'Pusan National University', NULL),
(19, 'noka', 'Noka Prihasto', '2b25b738c5a0af977d3b6c19015a2127', NULL, 2, 'Aktif', 'Changwon', 'Selatan', 'nprihasto@gmail.com', '010 3438 5669', '', '620-181874-990', 'http://www.ustream.tv/channel/noka-prihasto', 'Komunikasi Pemasaran, Hubungan Masyarakat', '', 'Bandung/17-01-1980', 'Kyungnam University', NULL),
(20, 'ratih', 'Ratih Dian Saraswati', 'cf81b8397aadf91ebe15ef955e3f55f7', NULL, 2, 'Aktif', 'Seoul', 'Utara', 'ratih87@gmail.com', '821086885252 ', 'Shinhan Bank', '110-344-042772', '', 'Hubungan Masyarakat', '', 'Semarang/17-05-1987', 'Dongguk University', NULL),
(21, 'anis', 'Rengganis Banitya Rachmat, S.T.', '16de59328c9ef358f2be18fd2b689e41', 6, 1, 'Aktif', 'Seoul', 'Utara', 'rengganis.rachmat@gmail.com', '821031487400 ', 'Hana', '391-910716-33407', '', 'Manajemen Operasi, Manajemen Keuangan', '', 'Bogor/30-05-1984', 'Korea University', NULL),
(22, 'richo', 'Richo Satria Hutama Putra', 'b8e71d8828dd77f49b014b90b8f76cf4', NULL, 3, 'Aktif', 'Namyangju', 'Utara', 'sejong_thegreat@yahoo.com', '821077494772 ', 'Kookmin Bank', '283501-04-328533', '', 'Writing III, Pendidikan Kewarganegaraan', '', 'Tulungagung/20-01-1988', 'Kyung Hee University', NULL),
(23, 'rimaniar', 'Rimaniar Dwita', '514068b7cde52bb2dd98ecabd0df1d7e', NULL, 2, 'Aktif', 'Seoul', 'Utara', 'gwenia.psi04@gmail.com', '821049536616 ', 'Woori Bank', '1002-645-866489 (1002-738-723625) a.n. Ricky Tamarany', '', 'Pengantar Ilmu Komunikasi, Komunikasi Bisnis', '', 'Yogyakarta/28-11-1986', 'KIST', NULL),
(24, 'vina', 'Vina Sari Yosephine', '7f47be7c62db9cef589ec0f87342f554', NULL, 3, 'Aktif', 'Daejeon', 'Utara', 'vinasariyosephine@yahoo.com', '821068732097 ', '', '', '', 'Pengantar Statistika Sosial', '', 'Bandung/20-10-1983', 'KAIST', NULL),
(25, 'wahyudi', 'Wahyudi Wibowo', '80a8c4b2ad8989acf3096a4c7b66e5c1', NULL, 1, 'Aktif', 'Busan', 'Selatan', 'yudiwbw@yahoo.com', '821057861504 ', '', '289-12-035776-1', 'http://www.ustream.tv/channel/http-www-ustream-tv-channel-wahyudiwibowo', 'Pemasaran Jasa, Pemasaran Strategik', '', 'Surabaya/15-04-1974', 'Kyungsung University', NULL),
(26, 'waode', 'Waode Diah Anjani, S.E.', '93e16c93026cbe5040ecae74697fa04b', NULL, 1, 'Aktif', 'Seoul', 'Utara', 'diah.feui@gmail.com', '821028275288 ', 'Woori Bank', '1002143541977', 'http://www.ustream.tv/channel/diahanjani', 'Pemasaran Jasa, Pemasaran Strategik', '', 'Jakarta/05-02-1988', 'KDI School ', NULL),
(27, 'yonny', 'Yonny Septian Izmantoko', '9f49590fa2fac7e1e48722e47d8d0bd9', NULL, 3, 'Aktif', 'Gimhae', 'Selatan', 'yonny.septian@ymail.com', '821086720815 ', 'Woori Bank', '1002-944-829318', '', 'Writing II', '', 'Semarang/17-09-1989', 'Inje University', NULL),
(28, 'zulfikar', 'Zulfikar Yurnaidi, S.T.', '5d38dadba7fd2db3958eaf46b4a801e6', NULL, 1, 'Aktif', 'Suwon', 'Utara', 'viczhoel@yahoo.com', '821025187330 ', 'SC ', '63220504789', 'http://www.ustream.tv/channel/tutor-fikar', 'Statistika Ekonomi I', '', 'Kebumen/02-04-1987', 'Ajou University', NULL),
(29, 'andri', 'Andri Fachrur Rozie', NULL, 7, NULL, NULL, NULL, NULL, '4r53n1c@gmail.com', '821086887058', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'hadi', 'Hadi Teguh Yudistira\r\n', NULL, 1, NULL, NULL, NULL, NULL, 'hadi.yudistira@gmail.com', '821068758448', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'maya_widiarini', 'Maya Widiarini', NULL, 2, NULL, NULL, NULL, NULL, 'maya.widiarini@gmail.com', '821058062088', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'dian_silvia', 'Dian Silvia A.S', NULL, 3, NULL, NULL, NULL, NULL, 'diansilvia.as@gmail.com', '821055968452', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'octavia', 'Octavia Mantik', NULL, 3, NULL, NULL, NULL, NULL, 'octaviamantik@gmail.com', '821080500520', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'roy', 'Roy Simonangkir', NULL, 5, NULL, NULL, NULL, NULL, 'roy.bvbs@gmail.com', '821028977194', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'gina', 'Gina Anindyajati', NULL, 6, NULL, NULL, NULL, NULL, 'gina_anindyajati@gmail.com', '821057880627', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'dian', 'Dian Kharismadewi', NULL, 6, NULL, NULL, NULL, NULL, 'abo_smile@yahoo.com', '821086833180', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'teguh', 'Teguh Syahmar Irshadi', NULL, 7, NULL, NULL, NULL, NULL, 'teguh.syahmar@gmail.com', '821072240158', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_group`
--

CREATE TABLE IF NOT EXISTS `staff_group` (
  `staffgroup_id` tinyint(1) NOT NULL auto_increment,
  `group` varchar(20) default NULL,
  PRIMARY KEY  (`staffgroup_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `staff_group`
--

INSERT INTO `staff_group` (`staffgroup_id`, `group`) VALUES
(1, 'Koordinator Umum'),
(2, 'Sekretaris'),
(3, 'Bendahara'),
(4, 'Humas'),
(5, 'Koordinator Tutor'),
(6, 'Kemahasiswaan'),
(7, 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `utsessions`
--

CREATE TABLE IF NOT EXISTS `utsessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(45) NOT NULL default '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utsessions`
--

INSERT INTO `utsessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('b5e1b0b40785e599f72d92b7e3182e2a', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.92 Safari/537.4', 1349856663, 'a:3:{s:9:"user_data";s:0:"";s:8:"username";s:7:"chairul";s:9:"logged_in";b:1;}');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `major_cont_courses` FOREIGN KEY (`major`) REFERENCES `major` (`major_id`);

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_cons` FOREIGN KEY (`major`) REFERENCES `major` (`major_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `major_cons` FOREIGN KEY (`major_id`) REFERENCES `major` (`major_id`);
