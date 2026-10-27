-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 08:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `room_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL,
  `year` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `year`, `semester`, `is_active`, `created_at`) VALUES
(1, '2025-2026', 'First Semester', 1, '2025-12-11 09:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `archives`
--

CREATE TABLE `archives` (
  `id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `archived_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archived_data`)),
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archives`
--

INSERT INTO `archives` (`id`, `year_id`, `archived_data`, `archived_at`) VALUES
(1, 1, '{\"year\":\"2025-2026\",\"semester\":\"First Semester\",\"date_archived\":\"2025-12-11 10:14:32\",\"total_students\":199,\"data\":[{\"name\":\"Room 1\",\"students\":[{\"name\":\"Aballe Waren B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Antapon Aivy E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Ardita Kaye Ann E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Bagaloyos Gwen Stifani R.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Bahay Lyzza C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Bajao Jhon Rey E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Bandies Cherry Ann P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Buntag Nikki S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Caballero Mark Jade P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Cabusao Laurcen Jay D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Cadavez Doielle B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Casilagan John Pau E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Dela Cruz Joenel E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Dela Pina Joan O.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Dumaguing Given Lord P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Dumaguing May May O.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Engoc Jessel S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Ereguero Roy Jr D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Felices Lance Kevin M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Flores Lady Jane V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Leones Sarah Jane S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Lumayno Reymark P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Macascas Jhonard V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Mama Aliana M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Maserin Jayvee D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Ontulan Joshsua M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Pagalaran Jewelyn E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Polinar Junmar M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Pua Elyza P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Sabulbero Micah L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Saripada Nakher M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Sernicula Cristito Jr. C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Solatario Joycel P. \",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Suan Rafael Jr. A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Tampon Alvin M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Tanan Libena A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Tayong Francis Benedict J.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Timagos Khristen Rose G.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Tumala Divine Jee T.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Tumala Gerlie Dave T.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"}]},{\"name\":\"Room 2\",\"students\":[{\"name\":\"Abdulatif Yahya M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Antapon Aidelyn E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Astrologo Jesamin M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Bahala Edelberto M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Balase John Cloyd E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Behante Regie C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Belarmino Rechell Jane V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Bendebel Rollen S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Bucog Judielyn Q.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Cadungog Clifford Kim A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Canete Judy-Ann B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Castillon Rose Annriel Claude S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Catipay Kristy T.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Espinosa Larrah Jean A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Felomino Jissabel S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Jumamoy Dave Chloe S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Labrador Kecy J.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Leunerio Keisel Mae B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Loberanes Dave Angelou J.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Macion Mike D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Macion Samson D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Maghinay Mark Andrei H.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Magumpara James Patrick C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Maratas Jazmine S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Maratas Rhyn D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Maratas Rudy Jr. A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Pacana Arji O.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Pasawilan Cyrell A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Perez Glorelyn C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Perolino Jefferson B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Piloton Bea A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Polo Joan Rose P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Quilinggen John Liam Ed\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Rejes DG Renald M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Ruelo Daisy Mae L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Saberon Ann-Nicole E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Taylaran James R.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Ticmon Martel M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Tumpag Mary Grace L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Villegas Vincent Ann S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"}]},{\"name\":\"Room 3\",\"students\":[{\"name\":\"Aloshi Farah Amor\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Arasad AL-Rashid P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Arsa Morgan I.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Badajos Angel Marie T.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Banawa Arjenn V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Bazar Esnia E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Bernados Baldwin B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Bordado Licel R.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Cabalona John Michael A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Castillo Allan Glien B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Ceniza Lovelyn M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Dela Cruz Justine L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Ebrahim Hamjay P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Enanor Lhea P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Flores Wilrose V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Hubasana Rey L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Lagnas Jessa Mae M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Limpangog Irelle P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Lumar Mark S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Malintang Clifor D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Micong Jasfher Z.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Moaje Sythl M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Onde Luigi C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Padayogdog Charmeni C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Piloton Bea A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Pua Haima S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Rebaja Rona Cris A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Rejes DG Renald M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Salonoy KC Mae L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Sanopao Arjel C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Sauza John Mark E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Segotier Mark Joseph L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Solijon Raven E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Sudaria Mark Sphencer\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Supang Lica Jen C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Suplaag Jay-Ann P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Traya Jean Riz E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Tuzon Meljon\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Villarin Sheila C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Yaon Jemark I.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"}]},{\"name\":\"Room 4\",\"students\":[{\"name\":\"Abalde Jinky B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Alana Jerick A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Alleria Joshua L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Angcot Marierose M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Arcayan Ryan C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Bringas Jherlyn Anne W.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Canete Leianne Christane\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Colanggo Jessamae N.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Cordova Nicole C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Cuizon Archer Kier C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Dejan Dhyna Jane E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Dela Cruz Jeck Van V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Edris Mohammad P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Edullantes Jesus Jr. D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Enca Janisha B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Hermoso Desiree\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Ibrahim Arneah E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Jovelo Jasmine S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Laguna Brent Lester D.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Laguna Mary Ann B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Lapinig Romeo L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Mag-abo Jerric A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Malinao Edrian C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Maurillo Juliana Ara C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Montalban June Ceasar N.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Omac Mark James P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Omas Jay Mark B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Perez Giesan P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Quilisadio Jesson\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Rafanan Reymarth V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Ranoa Maricar S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Rodenas Lolie Rose E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Rudinas Christian Mark B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Santarita Johoney R.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Saquin Judifier Jr. G.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Solatorio Christian Ken A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Titoy Rubi H.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Trimanies Claire Essan P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Urbina Aira Shane P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Villaros Jenepher S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"}]},{\"name\":\"Room 5\",\"students\":[{\"name\":\"Almada Jahedah V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Ambolodto Jharren P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Augusto Mirasol B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Aurigue Abegail L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Bantilan Dena V.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Barril Khem Lourence L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Bastasa Charilou S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Butalid Jorgedan Jr. L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Cadosale Bernald S\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Calagsan Alaiza G.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Calib Zainnah C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Carpela Janith E.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Carumba James Kyle R.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Davin Angelen I.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Dela Cruz Angel Rose S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Delos Angeles May M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Gabica Angeleca S.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Guillero Jenny A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Intong Honey Jean L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Jose Mary Joy L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Ligutom Loury Jean T.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Lumayno Marjie C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Macalisang Honneylyn L.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Madrid Jov A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Maghinay Airah Mae O.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Maquimot Kwhyd Apryl C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Mier Alleah\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Nacilla Annie Rose R.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Obial Renalou T.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Pogtis Jeanne P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Quijano Hana C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Rebotazo Jayford B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Sabuero Lyka Nicole A.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Semenada Roger Jr. C.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"Suan Nicely J.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Suan Wendy Rose P.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Taylaran Bea M.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Villena Shaine Medellete B.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"Yamelo Shella Mae T.\",\"course\":\"ACT\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"}]}]}', '2025-12-11 09:14:32'),
(2, 1, '{\"year\":\"2025-2026\",\"semester\":\"First Semester\",\"date_archived\":\"2025-12-13 23:12:26\",\"total_students\":200,\"data\":[{\"name\":\"Room 1\",\"students\":[{\"name\":\"ABALDE GIZELL KATE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ANDOG PRINCESS DIANNE P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ARINA LHEA JOY P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BADAJOS NESTLE KAYE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BARRERA JHOMMAR M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CADABA JONAS M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CANOY ALFRED ASLEY JR. R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CARTIN JOHN LLOYD L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DUMAN-AG JOHN PAUL O.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ELMA MARIEL Y.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"EMO ARGELYN MAE L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"EWAY RHEALYN S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"EWAY SARAH JANE H.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"EYAO JUNA MAE M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"GAMALANDO RAINER T.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"JUMALON CRISTY LOVE\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LARIBA RONEL B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LASCUNA MARLOU R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MADELO MARK R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MAGSALAY RHEA M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MANGUBAT ANGELICA\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MANIDTO RAYHAM A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MARAASIN JOSHUA B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MIER CHRYSTER JOHN M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MORSUA NEILBERT H.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"PACASUM AMIRAH L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PADAYOGDOG ANALOU C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PADIL MARJELYN P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PILAGO HANNEY MAE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PONTERAS JELAN P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PONTILAR SHIRLENE M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"RILE ALJEAN T.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SARSALEJO CARLITO L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SEGOTIER GIAN CHRIS L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TABANAG MARY GRACE M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TANGUB GLENDYL\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TILLO BOBBY JR. C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TRANQUILLERO ARIANE S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"UBPON PACHRY M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"VILLENA EMERSON JOHN B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"}]},{\"name\":\"Room 2\",\"students\":[{\"name\":\"ALONZO JORDAN C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"AMPANAS GHIYAN D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ARNOCO CHRISTIAN KEN V.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BABAO REYNIE S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BACALING JUVY L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BACULIO JAZEL\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BADAJOS JULLIET D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BULFA JERRY S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CABRALES JUDYLL A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CANTONA ARISTON JOHN A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CARUMBA PRINCESS GAINNE R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CASPE JOVANI S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CASTILLO JAEL BUTCH C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ENANOR CHRISTINE JOY P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ENGLISA SARAH JANE Y.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ESPINOSA RUBY JEAN L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"FELLOGAN GLECERIO III T.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"IBRAHIM ANUAR E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"JUDIT MIZELLE B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"JUMAMOY CRISMIE V.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"KAMID BAIHASNA A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LIPALAM JACK S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MAGDADARO AIRA H.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MAGLANGIT ULYSSES D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MANLIGRO JAY B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MECIAS BEA H.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MILLAN MARIO D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MORANTE JHAZEIL JANE E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MUGAWAN MUAMIR M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MUNOZ MEGUEL G.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"NOQUERA EMYRT B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"NUNEZA EBA J.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PATES RACHEL Q.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"POLO JAMAICCA B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ROLDANJASPHER C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SAGARINO RODERICK G.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TIBOR MARIA DANICA P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TORTOGO JERICK C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"VENTIC REJJANE F.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"YAMELO LEAN C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"}]},{\"name\":\"Room 3\",\"students\":[{\"name\":\"AMIGOS JOANA A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"AMIR NORJADIM B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ANTONIO JASMIEN ROSE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ARDIENTE ANGEL R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BACLADO JOY MIE D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BAHAY JA D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CABILLON EARL JOHN E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CABRALES ABEGAIL\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CALUNSAG GARDSON R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CORDA FELMARK A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CUSTODIO NOVAH MAE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"DABALOS KERBY A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DELA VINTORIA MARY JOY B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"DELOS ANGELES MIVILU M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"DOLDOL ERIC G.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ENCA ALMADEN D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"GEROLAGA ANGEL MAE E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"GONDONG CATHRINA KEY M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"HONTIMARA J-AR B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"INTANG ALJIBRIL M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LADOR WILLIN JAMES C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LAGOY CARL\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LAGUNA KARL ANDREI S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LAGUNAY ARNIEL L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LASCUNIA ROE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MAGAT TRISHA JEAN D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MALAYAN RECHEL F.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MAMA J-ALEN M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MANISAN HOPE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MEJOS ROLLY L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MONSULLER ARLYN C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PARAISO JODIE KLER M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"QUIRANTE ANIE MARIEL C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"RILE ENRIQUE T.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ROXAS RHEY NEIL F.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SANCHEZ ETHEL MAE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SOLATARIO JANICE LYN P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SUAN JEHEN J.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TABAR CARLA FAITH C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"UBAYAN RECEL S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"}]},{\"name\":\"Room 4\",\"students\":[{\"name\":\"ACASIO ANGELINA D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ARCAYAN RACHEL NAICO C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"AVILA JOHN MICHAEL P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BACALING JULITO L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BALASA LOVELY A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BALAYONG MARY JOY\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BALORO GRACE Q.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BONBON KEA GWEN A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CASPE JOVANI S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CASTROMAYOR JAPETH D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DELGADO MARIEL E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"FERRER FRANK S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"GEMINA JAMAICA C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"HUBASANA REMARK L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LADION SHELLA MAY A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LASCUNIA LISA MAE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LUMAYNO REGINE D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MACION JESSEL MAE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ONTULAN JOSHSUA M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"OPORTO LOVELY C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ROBLES DORINA S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SAPUAY JOEPET G.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SELERIO MARK LESTER A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SIMBAJOS JELYN ROSE P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SON SAMUEL B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TAGALA MARVY D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TIBOR CHARIFE V.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TUMAMPO NOVA MAE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"VILLAMERO GOSPEL CHRION A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"YAMELO RAQUEL B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"}]},{\"name\":\"Room 5\",\"students\":[{\"name\":\"AMABAO ANIEJEAN B.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BARRIENTOS ALEN P.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BENDEVIL ANGELICA Q.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CADUNGOG CHAMMY S.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CALAGO DEMREY A.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CASA KARL JEFFREY A.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ENANGKILE FAITH LESLIE E.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"GARCIA JOSEPH L.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"GUIRETAN CHERYL D.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"IGNACIO CEASAR JAMES C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LACSON CHRISTIAN JAY M.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LAUGLAUG DAISY H.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"NILLAS HUJIE V.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"NOBLE, MARY JANE C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PALANGAN LIZA MAE O.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PERATER RUCHELLE C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PIELAGO REY MAR G.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"QUINICOT ROMMER L.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"REVIER JHUNCELLE KENTH C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SABIDO LORENA U.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TIZON ALJIE M.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TIZON ANN MAVEL GRACE M.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"UNTAY MERRY DEVINE  CRIS\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"URBANO JANVER C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"YBANEZ JHON CELSO L.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"}]},{\"name\":\"Room 6\",\"students\":[{\"name\":\"BABAO MAE ANN T.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BALOS CHARIZ B.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BUTASLAC HAYACINTH T.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CAGAANAN ANALISA V.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CANGKE CYRE JANE D.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CANON KENNETH KYLE P.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DECIERDO CHRISTIAN PAUL C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DIGAL DANIELA C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"DOMINISAC JENEROSE M.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"DOMINISAC SANDARA R.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ESPERANZATE CARMINA G.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"GALLEGO REGINE M.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"GAPOL EULEJEAN A.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ILOSORIO EDMER M.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MANISAN ALFRITZ JOY F.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MORALES ROVELYN V.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"NERI IMAE O.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PECAYO ANGELENE M.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"QUIJANO RUTCHAMIE P.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"RIVERA DANNA PAULA C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"RONQUILLO DIANA G.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TEVES JHEANY ROSE C.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"VILLAREAL JUNMAR P.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"VILLEGAS VIVIE ANN S.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"YAMELO RAZEL B.\",\"course\":\"BTVTED\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"}]}]}', '2025-12-13 22:12:26');
INSERT INTO `archives` (`id`, `year_id`, `archived_data`, `archived_at`) VALUES
(3, 1, '{\"year\":\"2025-2026\",\"semester\":\"First Semester\",\"date_archived\":\"2025-12-15 10:28:41\",\"total_students\":174,\"data\":[{\"name\":\"Room 1\",\"students\":[{\"name\":\"ALONZO JORDAN C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"AMIGOS JOANA A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ARCAYAN RACHEL NAICO C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BACULIO JAZEL\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BADAJOS NESTLE KAYE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BALORO GRACE Q.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BULFA JERRY S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CABRALES ABEGAIL\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CALUNSAG GARDSON R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CASPE JOVANI S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CUSTODIO NOVAH MAE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"DELA VINTORIA MARY JOY B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"EMO ARGELYN MAE L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ENCA ALMADEN D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ENGLISA SARAH JANE Y.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ESPINOSA RUBY JEAN L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"FERRER FRANK S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"HONTIMARA J-AR B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"JUDIT MIZELLE B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LADION SHELLA MAY A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LARIBA RONEL B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LASCUNA MARLOU R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MAGAT TRISHA JEAN D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MECIAS BEA H.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MEJOS ROLLY L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MILLAN MARIO D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MONSULLER ARLYN C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MORSUA NEILBERT H.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MUGAWAN MUAMIR M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ONTULAN JOSHSUA M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"PACASUM AMIRAH L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"RILE ALJEAN T.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SEGOTIER GIAN CHRIS L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TANGUB GLENDYL\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TORTOGO JERICK C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TRANQUILLERO ARIANE S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"UBAYAN RECEL S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"VENTIC REJJANE F.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"VILLENA EMERSON JOHN B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"YAMELO RAQUEL B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"}]},{\"name\":\"Room 2\",\"students\":[{\"name\":\"ABALDE GIZELL KATE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"AMIR NORJADIM B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"AMPANAS GHIYAN D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ANTONIO JASMIEN ROSE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ARDIENTE ANGEL R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ARNOCO CHRISTIAN KEN V.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BACALING JULITO L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BADAJOS JULLIET D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BALASA LOVELY A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BALAYONG MARY JOY\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BONBON KEA GWEN A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CABILLON EARL JOHN E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CABRALES JUDYLL A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CANOY ALFRED ASLEY JR. R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CANTONA ARISTON JOHN A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DABALOS KERBY A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DUMAN-AG JOHN PAUL O.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ELMA MARIEL Y.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ENANOR CHRISTINE JOY P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"GEROLAGA ANGEL MAE E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"HUBASANA REMARK L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"INTANG ALJIBRIL M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"JUMALON CRISTY LOVE\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"KAMID BAIHASNA A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LAGOY CARL\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LASCUNIA LISA MAE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LUMAYNO REGINE D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MAMA J-ALEN M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MANIDTO RAYHAM A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MANISAN HOPE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MIER CHRYSTER JOHN M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MORANTE JHAZEIL JANE E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PADAYOGDOG ANALOU C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PATES RACHEL Q.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"RILE ENRIQUE T.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SAGARINO RODERICK G.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SANCHEZ ETHEL MAE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SARSALEJO CARLITO L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TABANAG MARY GRACE M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TAGALA MARVY D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"}]},{\"name\":\"Room 3\",\"students\":[{\"name\":\"ACASIO ANGELINA D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BABAO REYNIE S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BAHAY JA D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BARRERA JHOMMAR M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CARTIN JOHN LLOYD L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CASPE JOVANI S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CASTILLO JAEL BUTCH C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CORDA FELMARK A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DELGADO MARIEL E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"DOLDOL ERIC G.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"EWAY RHEALYN S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"EYAO JUNA MAE M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"GEMINA JAMAICA C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"GONDONG CATHRINA KEY M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"IBRAHIM ANUAR E.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"JUMAMOY CRISMIE V.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"LAGUNAY ARNIEL L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LIPALAM JACK S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MADELO MARK R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MAGDADARO AIRA H.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MAGLANGIT ULYSSES D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MALAYAN RECHEL F.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MANLIGRO JAY B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MUNOZ MEGUEL G.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"OPORTO LOVELY C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PADIL MARJELYN P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PARAISO JODIE KLER M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"POLO JAMAICCA B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PONTILAR SHIRLENE M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ROLDANJASPHER C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ROXAS RHEY NEIL F.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SAPUAY JOEPET G.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SELERIO MARK LESTER A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TABAR CARLA FAITH C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TIBOR CHARIFE V.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TIBOR MARIA DANICA P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"TILLO BOBBY JR. C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TUMAMPO NOVA MAE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"VILLAMERO GOSPEL CHRION A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"YAMELO LEAN C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"}]},{\"name\":\"Room 4\",\"students\":[{\"name\":\"ANDOG PRINCESS DIANNE P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ARINA LHEA JOY P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"AVILA JOHN MICHAEL P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BACALING JUVY L.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BACLADO JOY MIE D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CADABA JONAS M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"CARUMBA PRINCESS GAINNE R.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CASTROMAYOR JAPETH D.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DELOS ANGELES MIVILU M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"EWAY SARAH JANE H.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"FELLOGAN GLECERIO III T.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"GAMALANDO RAINER T.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LADOR WILLIN JAMES C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LAGUNA KARL ANDREI S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"LASCUNIA ROE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"MACION JESSEL MAE C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MAGSALAY RHEA M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MANGUBAT ANGELICA\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"MARAASIN JOSHUA B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"NOQUERA EMYRT B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"NUNEZA EBA J.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PILAGO HANNEY MAE A.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"PONTERAS JELAN P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"QUIRANTE ANIE MARIEL C.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ROBLES DORINA S.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SIMBAJOS JELYN ROSE P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SOLATARIO JANICE LYN P.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SON SAMUEL B.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SUAN JEHEN J.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"UBPON PACHRY M.\",\"course\":\"ACT\",\"year\":\"2\",\"gender\":\"Male\",\"status\":\"Active\"}]},{\"name\":\"Room 5\",\"students\":[{\"name\":\"ACAS SHAILEEN KATE M.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ALINDAHAW REGINE C.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ATANACIO JARED L.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BAGUIO KIM T.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BUCOG OLIVER JR. Q.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"DELA CERNA DAYCEL B.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"FLORES ALVIN V.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"GONOWON RUTHER B.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"REQUINA CHARMEL S.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ROMANILLOS ASHLEY M.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SALAUM JUNDEL C.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"TAGUDIN RINAMAY W.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"VICOY LADY MAE\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"}]},{\"name\":\"Room 6\",\"students\":[{\"name\":\"ALASAAS CHRISTIAN P.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"ARSA SALLY G.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"BAGUIO KEN T.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"BENGIL JOANA CLAIRE G.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"CARILLO MARY JOY C.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"DELA CERNA ANA JANE D.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"HISOLER ALAIZA MAE V.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"RODENAS LOLIE ROSE E.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"SAYRE IAN D.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"},{\"name\":\"SUICO JEANLYN F.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Female\",\"status\":\"Active\"},{\"name\":\"ZAMAN MARK DAVE V.\",\"course\":\"BTVTED\",\"year\":\"1\",\"gender\":\"Male\",\"status\":\"Active\"}]}]}', '2025-12-15 09:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `room_number` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_locked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `year_id`, `room_number`, `name`, `is_locked`, `created_at`) VALUES
(190, 1, 1, 'Room 1', 0, '2026-01-30 05:42:17'),
(191, 1, 2, 'Room 2', 0, '2026-01-30 05:42:17'),
(192, 1, 3, 'Room 3', 0, '2026-01-30 05:42:17'),
(193, 1, 4, 'Room 4', 0, '2026-01-30 05:42:17'),
(194, 1, 5, 'Room 5', 0, '2026-01-30 05:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `room_assignments`
--

CREATE TABLE `room_assignments` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_number` int(11) DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_assignments`
--

INSERT INTO `room_assignments` (`id`, `room_id`, `student_id`, `student_number`, `assigned_at`) VALUES
(4285, 190, 17, 1, '2026-01-30 05:42:17'),
(4286, 190, 116, 2, '2026-01-30 05:42:17'),
(4287, 190, 195, 3, '2026-01-30 05:42:17'),
(4288, 190, 33, 4, '2026-01-30 05:42:17'),
(4289, 190, 183, 5, '2026-01-30 05:42:17'),
(4290, 190, 186, 6, '2026-01-30 05:42:17'),
(4291, 190, 38, 7, '2026-01-30 05:42:17'),
(4292, 190, 5, 8, '2026-01-30 05:42:17'),
(4293, 190, 93, 9, '2026-01-30 05:42:17'),
(4294, 190, 11, 10, '2026-01-30 05:42:17'),
(4295, 190, 78, 11, '2026-01-30 05:42:17'),
(4296, 190, 152, 12, '2026-01-30 05:42:17'),
(4297, 190, 24, 13, '2026-01-30 05:42:17'),
(4298, 190, 31, 14, '2026-01-30 05:42:17'),
(4299, 190, 124, 15, '2026-01-30 05:42:17'),
(4300, 190, 100, 16, '2026-01-30 05:42:17'),
(4301, 190, 153, 17, '2026-01-30 05:42:17'),
(4302, 190, 194, 18, '2026-01-30 05:42:17'),
(4303, 190, 16, 19, '2026-01-30 05:42:17'),
(4304, 190, 193, 20, '2026-01-30 05:42:17'),
(4305, 190, 115, 21, '2026-01-30 05:42:17'),
(4306, 190, 184, 22, '2026-01-30 05:42:17'),
(4307, 190, 53, 23, '2026-01-30 05:42:17'),
(4308, 190, 105, 24, '2026-01-30 05:42:17'),
(4309, 190, 25, 25, '2026-01-30 05:42:17'),
(4310, 190, 128, 26, '2026-01-30 05:42:17'),
(4311, 190, 61, 27, '2026-01-30 05:42:17'),
(4312, 190, 95, 28, '2026-01-30 05:42:17'),
(4313, 190, 123, 29, '2026-01-30 05:42:17'),
(4314, 190, 85, 30, '2026-01-30 05:42:17'),
(4315, 190, 197, 31, '2026-01-30 05:42:17'),
(4316, 190, 27, 32, '2026-01-30 05:42:17'),
(4317, 190, 91, 33, '2026-01-30 05:42:17'),
(4318, 190, 66, 34, '2026-01-30 05:42:17'),
(4319, 190, 34, 35, '2026-01-30 05:42:17'),
(4320, 190, 97, 36, '2026-01-30 05:42:17'),
(4321, 190, 196, 37, '2026-01-30 05:42:17'),
(4322, 190, 30, 38, '2026-01-30 05:42:17'),
(4323, 190, 156, 39, '2026-01-30 05:42:17'),
(4324, 190, 80, 40, '2026-01-30 05:42:17'),
(4325, 191, 110, 1, '2026-01-30 05:42:17'),
(4326, 191, 170, 2, '2026-01-30 05:42:17'),
(4327, 191, 35, 3, '2026-01-30 05:42:17'),
(4328, 191, 162, 4, '2026-01-30 05:42:17'),
(4329, 191, 40, 5, '2026-01-30 05:42:17'),
(4330, 191, 86, 6, '2026-01-30 05:42:17'),
(4331, 191, 12, 7, '2026-01-30 05:42:17'),
(4332, 191, 175, 8, '2026-01-30 05:42:17'),
(4333, 191, 141, 9, '2026-01-30 05:42:17'),
(4334, 191, 7, 10, '2026-01-30 05:42:17'),
(4335, 191, 55, 11, '2026-01-30 05:42:17'),
(4336, 191, 178, 12, '2026-01-30 05:42:17'),
(4337, 191, 9, 13, '2026-01-30 05:42:17'),
(4338, 191, 68, 14, '2026-01-30 05:42:17'),
(4339, 191, 37, 15, '2026-01-30 05:42:17'),
(4340, 191, 172, 16, '2026-01-30 05:42:17'),
(4341, 191, 154, 17, '2026-01-30 05:42:17'),
(4342, 191, 74, 18, '2026-01-30 05:42:17'),
(4343, 191, 112, 19, '2026-01-30 05:42:17'),
(4344, 191, 64, 20, '2026-01-30 05:42:17'),
(4345, 191, 118, 21, '2026-01-30 05:42:17'),
(4346, 191, 188, 22, '2026-01-30 05:42:17'),
(4347, 191, 1, 23, '2026-01-30 05:42:17'),
(4348, 191, 3, 24, '2026-01-30 05:42:17'),
(4349, 191, 142, 25, '2026-01-30 05:42:17'),
(4350, 191, 159, 26, '2026-01-30 05:42:17'),
(4351, 191, 71, 27, '2026-01-30 05:42:17'),
(4352, 191, 84, 28, '2026-01-30 05:42:17'),
(4353, 191, 4, 29, '2026-01-30 05:42:17'),
(4354, 191, 139, 30, '2026-01-30 05:42:17'),
(4355, 191, 73, 31, '2026-01-30 05:42:17'),
(4356, 191, 104, 32, '2026-01-30 05:42:17'),
(4357, 191, 83, 33, '2026-01-30 05:42:17'),
(4358, 191, 88, 34, '2026-01-30 05:42:17'),
(4359, 191, 2, 35, '2026-01-30 05:42:17'),
(4360, 191, 65, 36, '2026-01-30 05:42:17'),
(4361, 191, 98, 37, '2026-01-30 05:42:17'),
(4362, 191, 76, 38, '2026-01-30 05:42:17'),
(4363, 191, 129, 39, '2026-01-30 05:42:17'),
(4364, 191, 44, 40, '2026-01-30 05:42:17'),
(4365, 192, 77, 1, '2026-01-30 05:42:17'),
(4366, 192, 174, 2, '2026-01-30 05:42:17'),
(4367, 192, 119, 3, '2026-01-30 05:42:17'),
(4368, 192, 140, 4, '2026-01-30 05:42:17'),
(4369, 192, 22, 5, '2026-01-30 05:42:17'),
(4370, 192, 107, 6, '2026-01-30 05:42:17'),
(4371, 192, 131, 7, '2026-01-30 05:42:17'),
(4372, 192, 155, 8, '2026-01-30 05:42:17'),
(4373, 192, 47, 9, '2026-01-30 05:42:17'),
(4374, 192, 101, 10, '2026-01-30 05:42:17'),
(4375, 192, 32, 11, '2026-01-30 05:42:17'),
(4376, 192, 42, 12, '2026-01-30 05:42:17'),
(4377, 192, 182, 13, '2026-01-30 05:42:17'),
(4378, 192, 167, 14, '2026-01-30 05:42:17'),
(4379, 192, 192, 15, '2026-01-30 05:42:17'),
(4380, 192, 189, 16, '2026-01-30 05:42:17'),
(4381, 192, 114, 17, '2026-01-30 05:42:17'),
(4382, 192, 179, 18, '2026-01-30 05:42:17'),
(4383, 192, 19, 19, '2026-01-30 05:42:17'),
(4384, 192, 106, 20, '2026-01-30 05:42:17'),
(4385, 192, 136, 21, '2026-01-30 05:42:17'),
(4386, 192, 157, 22, '2026-01-30 05:42:17'),
(4387, 192, 127, 23, '2026-01-30 05:42:17'),
(4388, 192, 26, 24, '2026-01-30 05:42:17'),
(4389, 192, 23, 25, '2026-01-30 05:42:17'),
(4390, 192, 102, 26, '2026-01-30 05:42:17'),
(4391, 192, 57, 27, '2026-01-30 05:42:17'),
(4392, 192, 134, 28, '2026-01-30 05:42:17'),
(4393, 192, 60, 29, '2026-01-30 05:42:17'),
(4394, 192, 29, 30, '2026-01-30 05:42:17'),
(4395, 192, 163, 31, '2026-01-30 05:42:17'),
(4396, 192, 20, 32, '2026-01-30 05:42:17'),
(4397, 192, 138, 33, '2026-01-30 05:42:17'),
(4398, 192, 187, 34, '2026-01-30 05:42:17'),
(4399, 192, 158, 35, '2026-01-30 05:42:17'),
(4400, 192, 143, 36, '2026-01-30 05:42:17'),
(4401, 192, 144, 37, '2026-01-30 05:42:17'),
(4402, 192, 79, 38, '2026-01-30 05:42:17'),
(4403, 192, 46, 39, '2026-01-30 05:42:17'),
(4404, 192, 92, 40, '2026-01-30 05:42:17'),
(4405, 193, 43, 1, '2026-01-30 05:42:17'),
(4406, 193, 150, 2, '2026-01-30 05:42:17'),
(4407, 193, 48, 3, '2026-01-30 05:42:17'),
(4408, 193, 168, 4, '2026-01-30 05:42:17'),
(4409, 193, 36, 5, '2026-01-30 05:42:17'),
(4410, 193, 81, 6, '2026-01-30 05:42:17'),
(4411, 193, 177, 7, '2026-01-30 05:42:17'),
(4412, 193, 173, 8, '2026-01-30 05:42:17'),
(4413, 193, 137, 9, '2026-01-30 05:42:17'),
(4414, 193, 109, 10, '2026-01-30 05:42:17'),
(4415, 193, 54, 11, '2026-01-30 05:42:17'),
(4416, 193, 89, 12, '2026-01-30 05:42:17'),
(4417, 193, 13, 13, '2026-01-30 05:42:17'),
(4418, 193, 108, 14, '2026-01-30 05:42:17'),
(4419, 193, 149, 15, '2026-01-30 05:42:17'),
(4420, 193, 99, 16, '2026-01-30 05:42:17'),
(4421, 193, 96, 17, '2026-01-30 05:42:17'),
(4422, 193, 49, 18, '2026-01-30 05:42:17'),
(4423, 193, 52, 19, '2026-01-30 05:42:17'),
(4424, 193, 135, 20, '2026-01-30 05:42:17'),
(4425, 193, 103, 21, '2026-01-30 05:42:17'),
(4426, 193, 164, 22, '2026-01-30 05:42:17'),
(4427, 193, 130, 23, '2026-01-30 05:42:17'),
(4428, 193, 94, 24, '2026-01-30 05:42:17'),
(4429, 193, 122, 25, '2026-01-30 05:42:17'),
(4430, 193, 126, 26, '2026-01-30 05:42:17'),
(4431, 193, 161, 27, '2026-01-30 05:42:17'),
(4432, 193, 160, 28, '2026-01-30 05:42:17'),
(4433, 193, 50, 29, '2026-01-30 05:42:17'),
(4434, 193, 69, 30, '2026-01-30 05:42:17'),
(4435, 193, 185, 31, '2026-01-30 05:42:17'),
(4436, 193, 120, 32, '2026-01-30 05:42:17'),
(4437, 193, 45, 33, '2026-01-30 05:42:17'),
(4438, 193, 8, 34, '2026-01-30 05:42:17'),
(4439, 193, 39, 35, '2026-01-30 05:42:17'),
(4440, 193, 146, 36, '2026-01-30 05:42:17'),
(4441, 193, 111, 37, '2026-01-30 05:42:17'),
(4442, 193, 87, 38, '2026-01-30 05:42:17'),
(4443, 193, 82, 39, '2026-01-30 05:42:17'),
(4444, 193, 91, 40, '2026-01-30 05:42:17'),
(4445, 194, 169, 1, '2026-01-30 05:42:17'),
(4446, 194, 58, 2, '2026-01-30 05:42:17'),
(4447, 194, 166, 3, '2026-01-30 05:42:17'),
(4448, 194, 90, 4, '2026-01-30 05:42:17'),
(4449, 194, 14, 5, '2026-01-30 05:42:17'),
(4450, 194, 75, 6, '2026-01-30 05:42:17'),
(4451, 194, 176, 7, '2026-01-30 05:42:17'),
(4452, 194, 132, 8, '2026-01-30 05:42:17'),
(4453, 194, 147, 9, '2026-01-30 05:42:17'),
(4454, 194, 63, 10, '2026-01-30 05:42:17'),
(4455, 194, 165, 11, '2026-01-30 05:42:17'),
(4456, 194, 67, 12, '2026-01-30 05:42:17'),
(4457, 194, 10, 13, '2026-01-30 05:42:17'),
(4458, 194, 56, 14, '2026-01-30 05:42:17'),
(4459, 194, 145, 15, '2026-01-30 05:42:17'),
(4460, 194, 28, 16, '2026-01-30 05:42:17'),
(4461, 194, 35, 17, '2026-01-30 05:42:17'),
(4462, 194, 190, 18, '2026-01-30 05:42:17'),
(4463, 194, 181, 19, '2026-01-30 05:42:17'),
(4464, 194, 117, 20, '2026-01-30 05:42:17'),
(4465, 194, 125, 21, '2026-01-30 05:42:17'),
(4466, 194, 113, 22, '2026-01-30 05:42:17'),
(4467, 194, 151, 23, '2026-01-30 05:42:17'),
(4468, 194, 21, 24, '2026-01-30 05:42:17'),
(4469, 194, 191, 25, '2026-01-30 05:42:17'),
(4470, 194, 59, 26, '2026-01-30 05:42:17'),
(4471, 194, 171, 27, '2026-01-30 05:42:17'),
(4472, 194, 15, 28, '2026-01-30 05:42:17'),
(4473, 194, 62, 29, '2026-01-30 05:42:17'),
(4474, 194, 41, 30, '2026-01-30 05:42:17'),
(4475, 194, 148, 31, '2026-01-30 05:42:17'),
(4476, 194, 180, 32, '2026-01-30 05:42:17'),
(4477, 194, 72, 33, '2026-01-30 05:42:17'),
(4478, 194, 121, 34, '2026-01-30 05:42:17'),
(4479, 194, 70, 35, '2026-01-30 05:42:17'),
(4480, 194, 6, 36, '2026-01-30 05:42:17'),
(4481, 194, 18, 37, '2026-01-30 05:42:17'),
(4482, 194, 133, 38, '2026-01-30 05:42:17'),
(4483, 194, 51, 39, '2026-01-30 05:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year_level` varchar(10) NOT NULL,
  `gender` varchar(20) DEFAULT 'N/A',
  `status` enum('Active','Dropped','Graduate') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `course`, `year_level`, `gender`, `status`, `created_at`) VALUES
(1, 'ABALDE JINKY B.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(2, 'ABDULATIF YAHYA M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(3, 'ALLERIA JOSHUA L.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(4, 'ALOSHI FARAH AMOR', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(5, 'AMBOLODTO JHARREN P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(6, 'ANGCOT MARIEROSE M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(7, 'ARASAD AL-RASHID P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(8, 'ARCAYAN RYAN C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(9, 'AUGUSTO MIRASOL B.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(10, 'BAGALOYOS GWEN STIFANI R.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(11, 'BALASE JOHN CLOYD E.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(12, 'BUNTAG NIKKI S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(13, 'CARPELA JANITH E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(14, 'CATIPAY KRISTY T.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(15, 'DAVIN ANGELEN I.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(16, 'DEJAN DHYNA JANE E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(17, 'ESPINOSA LARRAH JEAN A.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(18, 'GABICA ANGELECA S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(19, 'HERMOSO DESIREE', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(20, 'HUBASANA REY L.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(21, 'INTONG HONEY JEAN L.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(22, 'LAGNAS JESSA MAE M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(23, 'LEUNERIO KEISEL MAE B.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(24, 'LIGUTOM LOURY JEAN T.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(25, 'MACALISANG HONNEYLYN L.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(26, 'MAG-ABO JERRIC A.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(27, 'MAGUMPARA JAMES PATRICK C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(28, 'MALINAO EDRIAN C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(29, 'MALINTANG CLIFOR D.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(30, 'MAQUIMOT KWHYD APRYL C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(31, 'MASERIN JAYVEE D.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(32, 'MOAJE SYTHL M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(33, 'PACANA ARJI O.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(34, 'PAGALARAN JEWELYN E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(35, 'PILOTON BEA A.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(36, 'POGTIS JEANNE P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(37, 'QUIJANO HANA C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(38, 'RANOA MARICAR S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(39, 'REBAJA RONA CRIS A.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(40, 'SABUERO LYKA NICOLE A.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(41, 'SANTARITA JOHONEY R.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(42, 'SERNICULA CRISTITO JR. C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(43, 'SOLATARIO JOYCEL P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(44, 'SUDARIA MARK SPHENCER', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(45, 'TANAN LIBENA A.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(46, 'TRIMANIES CLAIRE ESSAN P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(47, 'TUMALA GERLIE DAVE T.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(48, 'TUMALA DIVINE JEE T.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(49, 'ABALLE WAREN B.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(50, 'ANTAPON AIDELYN E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(51, 'ANTAPON AIVY E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(52, 'BADAJOS ANGEL MARIE T.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(53, 'BAHAY LYZZA C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(54, 'BANAWA ARJENN V.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(55, 'BANDIES CHERRY ANN P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(56, 'BARRIL KHEM LOURENCE L.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(57, 'BASTASA CHARILOU S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(58, 'BEHANTE REGIE C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(59, 'BELARMINO RECHELL JANE V.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(60, 'BORDADO LICEL R.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(61, 'BUCOG JUDIELYN Q.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(62, 'CANETE JUDY-ANN B.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(63, 'CARUMBA JAMES KYLE R.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(64, 'CASILAGAN JOHN PAU E.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(65, 'CASTILLO ALLAN GLIEN B.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(66, 'CUIZON ARCHER KIER C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(67, 'DELA CRUZ JUSTINE L.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(68, 'EBRAHIM HAMJAY P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(69, 'EDULLANTES JESUS JR. D.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(70, 'ENANOR LHEA P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(71, 'FLORES LADY JANE V.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(72, 'IBRAHIM ARNEAH E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(73, 'JOSE MARY JOY L.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(74, 'JUMAMOY DAVE CHLOE S.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(75, 'LABRADOR KECY J.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(76, 'LAPINIG ROMEO L.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(77, 'LEONES SARAH JANE S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(78, 'LIMPANGOG IRELLE P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(79, 'LUMAR MARK S.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(80, 'MACION SAMSON D.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(81, 'MARATAS RUDY JR. A.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(82, 'MARATAS RHYN D.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(83, 'MARATAS JAZMINE S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(84, 'OMAS JAY MARK B.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(85, 'ONTULAN JOSHSUA M.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(86, 'PASAWILAN CYRELL A.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(87, 'PEREZ GIESAN P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(88, 'PEROLINO JEFFERSON B.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(89, 'POLINAR JUNMAR M.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(90, 'REBOTAZO JAYFORD B.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(91, 'REJES DG RENALD M.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(92, 'RUDINAS CHRISTIAN MARK B.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(93, 'SABULBERO MICAH L.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(94, 'SAQUIN JUDIFIER JR. G.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(95, 'SOLATORIO CHRISTIAN KEN A.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(96, 'TAYLARAN BEA M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(97, 'TAYLARAN JAMES R.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(98, 'VILLARIN SHEILA C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(99, 'VILLEGAS VINCENT ANN S.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(100, 'YAON JEMARK I.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(101, 'ALANA JERICK A.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(102, 'BAHALA EDELBERTO M.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(103, 'BANTILAN DENA V.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(104, 'BERNADOS BALDWIN B.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(105, 'BUTALID JORGEDAN JR. L.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(106, 'CABALLERO MARK JADE P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(107, 'CABALONA JOHN MICHAEL A.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(108, 'CADAVEZ DOIELLE B.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(109, 'CADOSALE BERNALD S', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(110, 'CALAGSAN ALAIZA G.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(111, 'CALIB ZAINNAH C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(112, 'CANETE LEIANNE CHRISTANE', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(113, 'CASTILLON ROSE ANNRIEL CLAUDE S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(114, 'CENIZA LOVELYN M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(115, 'COLANGGO JESSAMAE N.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(116, 'DELA CRUZ JOENEL E.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(117, 'DELA CRUZ ANGEL ROSE S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(118, 'DELA PINA JOAN O.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(119, 'DELOS ANGELES MAY M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(120, 'EDRIS MOHAMMAD P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(121, 'FLORES WILROSE V.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(122, 'GUILLERO JENNY A.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(123, 'JOVELO JASMINE S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(124, 'LUMAYNO MARJIE C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(125, 'MADRID JOV A.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(126, 'MAGHINAY MARK ANDREI H.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(127, 'MAURILLO JULIANA ARA C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(128, 'MICONG JASFHER Z.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(129, 'MIER ALLEAH', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(130, 'NACILLA ANNIE ROSE R.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(131, 'OBIAL RENALOU T.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(132, 'OMAC MARK JAMES P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(133, 'POLO JOAN ROSE P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(134, 'QUILINGGEN JOHN LIAM ED', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(135, 'QUILISADIO JESSON', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(136, 'RUELO DAISY MAE L.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(137, 'SABERON ANN-NICOLE E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(138, 'SALONOY KC MAE L.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(139, 'SAUZA JOHN MARK E.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(140, 'SUAN RAFAEL JR. A.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(141, 'SUAN NICELY J.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(142, 'SUPANG LICA JEN C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(143, 'TAYONG FRANCIS BENEDICT J.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(144, 'TIMAGOS KHRISTEN ROSE G.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(145, 'TITOY RUBI H.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(146, 'TUZON MELJON', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(147, 'URBINA AIRA SHANE P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(148, 'VILLENA SHAINE MEDELLETE B.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(149, 'YAMELO SHELLA MAE T.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(150, 'ALMADA JAHEDAH V.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(151, 'ARDITA KAYE ANN E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(152, 'ARSA MORGAN I.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(153, 'ASTROLOGO JESAMIN M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(154, 'AURIGUE ABEGAIL L.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(155, 'BAJAO JHON REY E.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(156, 'BAZAR ESNIA E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(157, 'BENDEBEL ROLLEN S.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(158, 'BRINGAS JHERLYN ANNE W.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(159, 'CABUSAO LAURCEN JAY D.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(160, 'CADUNGOG CLIFFORD KIM A.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(161, 'CORDOVA NICOLE C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(162, 'DELA CRUZ JECK VAN V.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(163, 'DUMAGUING MAY MAY O.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(164, 'DUMAGUING GIVEN LORD P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(165, 'ENCA JANISHA B.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(166, 'ENGOC JESSEL S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(167, 'EREGUERO ROY JR D.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(168, 'FELICES LANCE KEVIN M.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(169, 'FELOMINO JISSABEL S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(170, 'LAGUNA BRENT LESTER D.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(171, 'LAGUNA MARY ANN B.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(172, 'LOBERANES DAVE ANGELOU J.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(173, 'LUMAYNO REYMARK P.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(174, 'MACASCAS JHONARD V.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(175, 'MACION MIKE D.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(176, 'MAGHINAY AIRAH MAE O.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(177, 'MAMA ALIANA M.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(178, 'MONTALBAN JUNE CEASAR N.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(179, 'ONDE LUIGI C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(180, 'PADAYOGDOG CHARMENI C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(181, 'PEREZ GLORELYN C.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(182, 'PUA ELYZA P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(183, 'PUA HAIMA S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(184, 'RAFANAN REYMARTH V.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(185, 'RODENAS LOLIE ROSE E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(186, 'SANOPAO ARJEL C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(187, 'SARIPADA NAKHER M.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(188, 'SEGOTIER MARK JOSEPH L.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(189, 'SEMENADA ROGER JR. C.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(190, 'SOLIJON RAVEN E.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(191, 'SUAN WENDY ROSE P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(192, 'SUPLAAG JAY-ANN P.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(193, 'TAMPON ALVIN M.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(194, 'TICMON MARTEL M.', 'ACT', '1', 'Male', 'Active', '2025-12-11 09:13:34'),
(195, 'TRAYA JEAN RIZ E.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(196, 'TUMPAG MARY GRACE L.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(197, 'VILLAROS JENEPHER S.', 'ACT', '1', 'Female', 'Active', '2025-12-11 09:13:34'),
(198, 'AVILA JOHN MICHAEL P.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(199, 'BAHAY JA D.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(200, 'CARTIN JOHN LLOYD L.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(201, 'CASTILLO JAEL BUTCH C.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(202, 'CASTROMAYOR JAPETH D.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(203, 'DUMAN-AG JOHN PAUL O.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(204, 'GAMALANDO RAINER T.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(205, 'HUBASANA REMARK L.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(206, 'IBRAHIM ANUAR E.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(207, 'LARIBA RONEL B.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(208, 'LASCUNA MARLOU R.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(209, 'LASCUNIA ROE C.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(210, 'MAGLANGIT ULYSSES D.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(211, 'MANLIGRO JAY B.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(212, 'MIER CHRYSTER JOHN M.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(213, 'MILLAN MARIO D.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(214, 'MORSUA NEILBERT H.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(215, 'MUGAWAN MUAMIR M.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(216, 'MUNOZ MEGUEL G.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(217, 'ROLDANJASPHER C.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(218, 'SEGOTIER GIAN CHRIS L.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(219, 'SON SAMUEL B.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(220, 'TAGALA MARVY D.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(221, 'TILLO BOBBY JR. C.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(222, 'UBPON PACHRY M.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(223, 'ACASIO ANGELINA D.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(224, 'BACLADO JOY MIE D.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(225, 'BALORO GRACE Q.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(226, 'BONBON KEA GWEN A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(227, 'CUSTODIO NOVAH MAE C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(228, 'ELMA MARIEL Y.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(229, 'ENGLISA SARAH JANE Y.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(230, 'EWAY SARAH JANE H.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(231, 'LASCUNIA LISA MAE C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(232, 'LUMAYNO REGINE D.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(233, 'MACION JESSEL MAE C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(234, 'MAGDADARO AIRA H.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(235, 'MORANTE JHAZEIL JANE E.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(236, 'NUNEZA EBA J.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(237, 'OPORTO LOVELY C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(238, 'PATES RACHEL Q.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(239, 'PILAGO HANNEY MAE A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(240, 'PONTILAR SHIRLENE M.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(241, 'QUIRANTE ANIE MARIEL C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(242, 'SANCHEZ ETHEL MAE A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(243, 'TRANQUILLERO ARIANE S.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(244, 'UBAYAN RECEL S.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(245, 'VENTIC REJJANE F.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(246, 'VILLAMERO GOSPEL CHRION A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(247, 'ALONZO JORDAN C.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(248, 'AMIR NORJADIM B.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(249, 'AMPANAS GHIYAN D.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(250, 'ARCAYAN RACHEL NAICO C.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(251, 'BABAO REYNIE S.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(252, 'BULFA JERRY S.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(253, 'CASPE JOVANI S.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(254, 'CORDA FELMARK A.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(255, 'FELLOGAN GLECERIO III T.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(256, 'FERRER FRANK S.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(257, 'INTANG ALJIBRIL M.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(258, 'LAGUNAY ARNIEL L.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(259, 'MADELO MARK R.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(260, 'MANIDTO RAYHAM A.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(261, 'MARAASIN JOSHUA B.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(262, 'NOQUERA EMYRT B.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(263, 'ONTULAN JOSHSUA M.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(264, 'RILE ALJEAN T.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(265, 'RILE ENRIQUE T.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(266, 'SAGARINO RODERICK G.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(267, 'SARSALEJO CARLITO L.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(268, 'SELERIO MARK LESTER A.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(269, 'TANGUB GLENDYL', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(270, 'ARDIENTE ANGEL R.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(271, 'ANTONIO JASMIEN ROSE A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(272, 'ARINA LHEA JOY P.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(273, 'BADAJOS JULLIET D.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(274, 'CABRALES ABEGAIL', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(275, 'CARUMBA PRINCESS GAINNE R.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(276, 'DELA VINTORIA MARY JOY B.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(277, 'DELOS ANGELES MIVILU M.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(278, 'ENANOR CHRISTINE JOY P.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(279, 'ESPINOSA RUBY JEAN L.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(280, 'EWAY RHEALYN S.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(281, 'EYAO JUNA MAE M.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(282, 'GEMINA JAMAICA C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(283, 'JUMAMOY CRISMIE V.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(284, 'LADION SHELLA MAY A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(285, 'MAGAT TRISHA JEAN D.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(286, 'MAGSALAY RHEA M.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(287, 'MALAYAN RECHEL F.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(288, 'MANGUBAT ANGELICA', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(289, 'MECIAS BEA H.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(290, 'MONSULLER ARLYN C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(291, 'PADAYOGDOG ANALOU C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(292, 'PADIL MARJELYN P.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(293, 'SIMBAJOS JELYN ROSE P.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(294, 'SOLATARIO JANICE LYN P.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(295, 'SUAN JEHEN J.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(296, 'TABAR CARLA FAITH C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:22'),
(297, 'ARNOCO CHRISTIAN KEN V.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(298, 'BACALING JULITO L.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(299, 'BARRERA JHOMMAR M.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(300, 'CABILLON EARL JOHN E.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(301, 'CADABA JONAS M.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(302, 'CALUNSAG GARDSON R.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(303, 'CANOY ALFRED ASLEY JR. R.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(304, 'CANTONA ARISTON JOHN A.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(305, 'DABALOS KERBY A.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(306, 'DOLDOL ERIC G.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(307, 'ENCA ALMADEN D.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(308, 'HONTIMARA J-AR B.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(309, 'LADOR WILLIN JAMES C.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(310, 'LAGOY CARL', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(311, 'LAGUNA KARL ANDREI S.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(312, 'LIPALAM JACK S.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(313, 'MAMA J-ALEN M.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(314, 'MANISAN HOPE A.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(315, 'MEJOS ROLLY L.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(316, 'ROXAS RHEY NEIL F.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(317, 'SAPUAY JOEPET G.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(318, 'TORTOGO JERICK C.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(319, 'VILLENA EMERSON JOHN B.', 'ACT', '2', 'Male', 'Active', '2025-12-11 09:16:22'),
(320, 'AMIGOS JOANA A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(321, 'ABALDE GIZELL KATE C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(322, 'ANDOG PRINCESS DIANNE P.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(323, 'BACALING JUVY L.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(324, 'BACULIO JAZEL', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(325, 'BADAJOS NESTLE KAYE C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(326, 'BALASA LOVELY A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(327, 'BALAYONG MARY JOY', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(328, 'CABRALES JUDYLL A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(329, 'DELGADO MARIEL E.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(330, 'EMO ARGELYN MAE L.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(331, 'GEROLAGA ANGEL MAE E.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(332, 'GONDONG CATHRINA KEY M.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(333, 'JUDIT MIZELLE B.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(334, 'JUMALON CRISTY LOVE', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(335, 'KAMID BAIHASNA A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(336, 'PACASUM AMIRAH L.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(337, 'PARAISO JODIE KLER M.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(338, 'POLO JAMAICCA B.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(339, 'PONTERAS JELAN P.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(340, 'ROBLES DORINA S.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(341, 'TABANAG MARY GRACE M.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(342, 'TIBOR MARIA DANICA P.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(343, 'TIBOR CHARIFE V.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(344, 'TUMAMPO NOVA MAE A.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(345, 'YAMELO RAQUEL B.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(346, 'YAMELO LEAN C.', 'ACT', '2', 'Female', 'Active', '2025-12-11 09:16:23'),
(347, 'Sample', 'Sample', '1', 'Male', 'Active', '2025-12-11 09:26:00'),
(348, 'Sample1', 'Sample1', '1', 'Female', 'Active', '2025-12-11 09:28:23'),
(349, 'AMABAO ANIEJEAN B.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(350, 'BABAO MAE ANN T.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(351, 'BALOS CHARIZ B.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(352, 'BARRIENTOS ALEN P.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(353, 'BENDEVIL ANGELICA Q.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(354, 'BUTASLAC HAYACINTH T.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(355, 'CADUNGOG CHAMMY S.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(356, 'CAGAANAN ANALISA V.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(357, 'CALAGO DEMREY A.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(358, 'CANGKE CYRE JANE D.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(359, 'CANON KENNETH KYLE P.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(360, 'CASA KARL JEFFREY A.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(361, 'DECIERDO CHRISTIAN PAUL C.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(362, 'DIGAL DANIELA C.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(363, 'DOMINISAC JENEROSE M.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(364, 'DOMINISAC SANDARA R.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(365, 'ENANGKILE FAITH LESLIE E.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(366, 'ESPERANZATE CARMINA G.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(367, 'GALLEGO REGINE M.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(368, 'GAPOL EULEJEAN A.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(369, 'GARCIA JOSEPH L.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(370, 'GUIRETAN CHERYL D.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(371, 'IGNACIO CEASAR JAMES C.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(372, 'ILOSORIO EDMER M.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(373, 'LACSON CHRISTIAN JAY M.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(374, 'LAUGLAUG DAISY H.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(375, 'MANISAN ALFRITZ JOY F.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(376, 'MORALES ROVELYN V.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(377, 'NERI IMAE O.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(378, 'NILLAS HUJIE V.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(379, 'NOBLE, MARY JANE C.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(380, 'PALANGAN LIZA MAE O.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(381, 'PECAYO ANGELENE M.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(382, 'PERATER RUCHELLE C.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(383, 'PIELAGO REY MAR G.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(384, 'QUIJANO RUTCHAMIE P.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(385, 'QUINICOT ROMMER L.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(386, 'RIVERA DANNA PAULA C.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(387, 'REVIER JHUNCELLE KENTH C.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(388, 'RONQUILLO DIANA G.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(389, 'SABIDO LORENA U.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(390, 'TEVES JHEANY ROSE C.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(391, 'TIZON ALJIE M.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(392, 'TIZON ANN MAVEL GRACE M.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(393, 'UNTAY MERRY DEVINE  CRIS', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(394, 'URBANO JANVER C.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(395, 'VILLAREAL JUNMAR P.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(396, 'VILLEGAS VIVIE ANN S.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(397, 'YAMELO RAZEL B.', 'BTVTED', '2', 'Female', 'Active', '2025-12-11 09:29:10'),
(398, 'YBANEZ JHON CELSO L.', 'BTVTED', '2', 'Male', 'Active', '2025-12-11 09:29:10'),
(399, 'ACAS SHAILEEN KATE M.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(400, 'ALASAAS CHRISTIAN P.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(401, 'ALINDAHAW REGINE C.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(402, 'ARSA SALLY G.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(403, 'ATANACIO JARED L.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(404, 'BAGUIO KIM T.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(405, 'BAGUIO KEN T.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(406, 'BENGIL JOANA CLAIRE G.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(407, 'BUCOG OLIVER JR. Q.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(408, 'CARILLO MARY JOY C.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(409, 'DELA CERNA ANA JANE D.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(410, 'DELA CERNA DAYCEL B.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(411, 'FLORES ALVIN V.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(412, 'GONOWON RUTHER B.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(413, 'HISOLER ALAIZA MAE V.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(414, 'REQUINA CHARMEL S.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(415, 'RODENAS LOLIE ROSE E.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(416, 'ROMANILLOS ASHLEY M.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(417, 'SALAUM JUNDEL C.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(418, 'SAYRE IAN D.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(419, 'SUICO JEANLYN F.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(420, 'TAGUDIN RINAMAY W.', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(421, 'VICOY LADY MAE', 'BTVTED', '1', 'Female', 'Active', '2025-12-11 09:31:46'),
(422, 'ZAMAN MARK DAVE V.', 'BTVTED', '1', 'Male', 'Active', '2025-12-11 09:31:46'),
(423, 'HIDALGO ACHEL KAYE L.', 'BSA', '3', 'Female', 'Active', '2025-12-11 09:52:54'),
(424, 'SAMPLE', 'BSIS', '2', 'Male', 'Active', '2025-12-15 09:29:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `year_id` (`year_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `year_id` (`year_id`);

--
-- Indexes for table `room_assignments`
--
ALTER TABLE `room_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `archives`
--
ALTER TABLE `archives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `room_assignments`
--
ALTER TABLE `room_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4484;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archives`
--
ALTER TABLE `archives`
  ADD CONSTRAINT `archives_ibfk_1` FOREIGN KEY (`year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_assignments`
--
ALTER TABLE `room_assignments`
  ADD CONSTRAINT `room_assignments_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_assignments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
