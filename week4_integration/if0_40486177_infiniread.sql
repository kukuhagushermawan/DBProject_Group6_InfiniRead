-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql300.infinityfree.com
-- Generation Time: Nov 24, 2025 at 11:08 AM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40486177_infiniread`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `Book_ID` varchar(20) NOT NULL,
  `Category` varchar(20) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `ISBN` varchar(50) NOT NULL,
  `Pages` int(11) NOT NULL,
  `Pub_Year` int(11) NOT NULL,
  `Age_Rating` int(11) NOT NULL,
  `Max_Borrowdays` int(11) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Staff_ID` int(11) NOT NULL,
  `File_URL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`Book_ID`, `Category`, `Title`, `ISBN`, `Pages`, `Pub_Year`, `Age_Rating`, `Max_Borrowdays`, `Stock`, `Staff_ID`, `File_URL`) VALUES
('B001', 'Fiction', 'The Lost Kingdom', '9780000000011', 320, 2011, 12, 14, 7, 3, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B002', 'Fiction', 'Whispers of the Night', '9780000000028', 288, 2014, 13, 7, 5, 7, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B003', 'Fiction', 'The Silent Forest', '9780000000035', 410, 2017, 10, 14, 10, 12, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B004', 'Fiction', 'Crimson Skies', '9780000000042', 372, 2010, 15, 14, 4, 8, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B005', 'Fiction', 'The Forgotten Tale', '9780000000059', 295, 2015, 12, 7, 6, 15, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B006', 'Fiction', 'Shadow of the Moon', '9780000000066', 330, 2012, 10, 14, 8, 21, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B007', 'Fiction', 'The Sapphire Crown', '9780000000073', 410, 2019, 12, 14, 3, 19, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B008', 'Fiction', 'Dreamcatcher Chronicles', '9780000000080', 275, 2018, 9, 7, 9, 5, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B009', 'Fiction', 'The Edge of Eternity', '9780000000097', 350, 2013, 14, 14, 7, 17, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B010', 'Fiction', 'Midnight Echoes', '9780000000103', 290, 2016, 13, 7, 12, 11, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B011', 'Fiction', 'The Golden Path', '9780000000110', 300, 2020, 10, 7, 5, 2, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B012', 'Fiction', 'Stormbound', '9780000000127', 410, 2012, 12, 14, 4, 6, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B013', 'Fiction', 'The Fire Within', '9780000000134', 365, 2018, 15, 14, 8, 25, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B014', 'Fiction', 'Ocean of Stars', '9780000000141', 320, 2019, 9, 14, 6, 14, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B015', 'Fiction', 'Wings of Glass', '9780000000158', 280, 2015, 10, 7, 7, 1, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B016', 'Fiction', 'Tales of the Wanderer', '9780000000165', 340, 2013, 12, 14, 9, 9, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B017', 'Fiction', 'The Ivory Tower', '9780000000172', 398, 2021, 14, 14, 10, 23, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B018', 'Fiction', 'Eternal Voyage', '9780000000189', 450, 2010, 15, 14, 4, 30, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B019', 'Fiction', 'Valley of Mists', '9780000000196', 260, 2014, 9, 7, 8, 4, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B020', 'Fiction', 'The Red Horizon', '9780000000202', 310, 2016, 13, 14, 12, 13, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B021', 'Fiction', 'The Last Ember', '9780000000219', 370, 2017, 14, 14, 6, 26, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B022', 'Fiction', 'Temple of Shadows', '9780000000226', 420, 2021, 15, 14, 7, 10, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B023', 'Fiction', 'Forestborn', '9780000000233', 345, 2015, 12, 14, 5, 20, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B024', 'Fiction', 'The Raven Queen', '9780000000240', 390, 2018, 13, 14, 9, 16, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B025', 'Fiction', 'The Crystal Mirror', '9780000000257', 280, 2013, 10, 7, 8, 3, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B026', 'Fiction', 'The Starfall Prophecy', '9780000000264', 350, 2014, 11, 14, 6, 29, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B027', 'Fiction', 'Midnight Mirage', '9780000000271', 270, 2011, 9, 7, 9, 18, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B028', 'Fiction', 'Harvest of Dreams', '9780000000288', 330, 2020, 12, 14, 12, 7, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B029', 'Fiction', 'Blood of the Ancients', '9780000000295', 410, 2016, 15, 14, 3, 12, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B030', 'Fiction', 'The Glass Serpent', '9780000000301', 300, 2019, 11, 7, 4, 14, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B031', 'Fiction', 'Whisperwind', '9780000000318', 345, 2018, 10, 14, 7, 6, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B032', 'Fiction', 'The Moonlit Throne', '9780000000325', 390, 2022, 12, 14, 8, 28, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B033', 'Fiction', 'Path of the Fallen', '9780000000332', 365, 2017, 13, 14, 6, 22, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B034', 'Fiction', 'The Emerald Curse', '9780000000349', 315, 2015, 12, 14, 7, 8, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B035', 'Fiction', 'The Ashen Gate', '9780000000356', 410, 2014, 14, 14, 5, 9, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B036', 'Fiction', 'The Winter Crown', '9780000000363', 275, 2018, 10, 7, 8, 30, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B037', 'Fiction', 'Legends of the Deep', '9780000000370', 455, 2013, 15, 14, 3, 11, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B038', 'Fiction', 'Shadows in the Snow', '9780000000387', 385, 2016, 12, 14, 6, 27, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B039', 'Fiction', 'Moonfire', '9780000000394', 305, 2020, 11, 14, 10, 24, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B040', 'Fiction', 'The Silent Citadel', '9780000000400', 355, 2021, 13, 14, 4, 5, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B041', 'Fiction', 'The Twin Suns', '9780000000417', 390, 2019, 12, 14, 8, 2, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B042', 'Fiction', 'Blades of Destiny', '9780000000424', 330, 2013, 14, 14, 7, 15, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B043', 'Fiction', 'Chronicles of Artheon', '9780000000431', 410, 2010, 13, 14, 5, 19, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B044', 'Fiction', 'The Untold Story', '9780000000448', 250, 2012, 10, 7, 9, 26, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B045', 'Fiction', 'The Wandering Prince', '9780000000455', 345, 2014, 12, 14, 6, 17, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B046', 'Fiction', 'The Infinity Pearl', '9780000000462', 310, 2015, 12, 14, 10, 13, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B047', 'Fiction', 'The Frozen Dawn', '9780000000479', 430, 2016, 15, 14, 3, 1, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B048', 'Fiction', 'The Whispering Valley', '9780000000486', 320, 2017, 10, 14, 12, 4, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B049', 'Fiction', 'The Obsidian Mask', '9780000000493', 365, 2011, 12, 14, 5, 21, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B050', 'Fiction', 'The Eternal Crest', '9780000000509', 390, 2022, 14, 14, 8, 8, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B051', 'Academic', 'Introduction to Quantum Computing', '9781000000516', 420, 2020, 18, 14, 6, 22, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B052', 'Academic', 'Machine Learning Principles', '9781000000523', 380, 2019, 18, 14, 9, 11, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B053', 'Academic', 'Data Structures & Algorithms', '9781000000530', 350, 2018, 18, 14, 12, 7, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B054', 'Academic', 'AI Ethics and Governance', '9781000000547', 310, 2021, 18, 14, 5, 16, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B055', 'Academic', 'Advanced Calculus', '9781000000554', 500, 2014, 18, 14, 2, 3, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B056', 'Academic', 'Linear Algebra Essentials', '9781000000561', 420, 2016, 18, 14, 10, 14, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B057', 'Academic', 'Physics for Engineering', '9781000000578', 460, 2017, 18, 14, 4, 20, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B058', 'Academic', 'Database Management Systems', '9781000000585', 390, 2019, 18, 14, 6, 9, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B059', 'Academic', 'Statistics for Data Science', '9781000000592', 350, 2015, 18, 14, 12, 4, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B060', 'Academic', 'Compiler Design Concepts', '9781000000608', 410, 2013, 18, 14, 7, 18, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B061', 'Academic', 'Digital Logic Design', '9781000000615', 360, 2012, 18, 14, 8, 1, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B062', 'Academic', 'Operating Systems', '9781000000622', 470, 2014, 18, 14, 5, 28, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B063', 'Academic', 'Computer Networks', '9781000000639', 430, 2016, 18, 14, 4, 6, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B064', 'Academic', 'Artificial Neural Networks', '9781000000646', 410, 2018, 18, 14, 10, 29, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B065', 'Academic', 'Human Computer Interaction', '9781000000653', 340, 2019, 18, 14, 7, 12, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B066', 'Academic', 'Deep Learning Fundamentals', '9781000000660', 500, 2022, 18, 14, 8, 25, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B067', 'Academic', 'Embedded Systems', '9781000000677', 395, 2021, 18, 14, 6, 10, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B068', 'Academic', 'Software Testing & QA', '9781000000684', 375, 2017, 18, 14, 9, 23, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B069', 'Academic', 'Discrete Mathematics', '9781000000691', 450, 2013, 18, 14, 3, 2, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B070', 'Academic', 'Information Security Basics', '9781000000707', 390, 2015, 18, 14, 10, 19, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B071', 'Academic', 'Mathematical Modelling', '9781000000714', 410, 2016, 18, 14, 6, 27, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B072', 'Academic', 'Computational Biology', '9781000000721', 380, 2018, 18, 14, 7, 4, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B073', 'Academic', 'Digital Image Processing', '9781000000738', 500, 2019, 18, 14, 5, 15, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B074', 'Academic', 'Expert Systems & AI', '9781000000745', 360, 2014, 18, 14, 9, 8, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B075', 'Academic', 'Advanced Robotics', '9781000000752', 420, 2020, 18, 14, 4, 30, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B076', 'Academic', 'Research Methods in CS', '9781000000769', 335, 2021, 18, 14, 8, 26, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B077', 'Academic', 'Big Data Analytics', '9781000000776', 480, 2017, 18, 14, 3, 5, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B078', 'Academic', 'Cloud Computing Architecture', '9781000000783', 450, 2016, 18, 14, 9, 13, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B079', 'Academic', 'Computational Statistics', '9781000000790', 360, 2015, 18, 14, 10, 11, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B080', 'Academic', 'Theory of Computation', '9781000000806', 520, 2013, 18, 14, 6, 21, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B081', 'Academic', 'Data Mining Techniques', '9781000000813', 420, 2018, 18, 14, 4, 6, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B082', 'Academic', 'Advanced Linear Models', '9781000000820', 370, 2016, 18, 14, 8, 14, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B083', 'Academic', 'Simulation & Modeling', '9781000000837', 310, 2017, 18, 14, 7, 23, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B084', 'Academic', 'Cybersecurity Defense', '9781000000844', 465, 2019, 18, 14, 5, 9, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B085', 'Academic', 'Natural Language Processing', '9781000000851', 440, 2020, 18, 14, 10, 16, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B086', 'Academic', 'Distributed Systems', '9781000000868', 390, 2012, 18, 14, 6, 28, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B087', 'Academic', 'Image Recognition', '9781000000875', 430, 2021, 18, 14, 8, 30, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B088', 'Academic', 'Pattern Recognition', '9781000000882', 360, 2015, 18, 14, 7, 1, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B089', 'Academic', 'Software Architecture', '9781000000899', 400, 2013, 18, 14, 9, 24, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B090', 'Academic', 'Computer Vision', '9781000000905', 510, 2022, 18, 14, 6, 2, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B091', 'Academic', 'Algorithms in Bioinformatics', '9781000000912', 380, 2017, 18, 14, 5, 18, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B092', 'Academic', 'Digital Signal Processing', '9781000000929', 430, 2014, 18, 14, 7, 12, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B093', 'Academic', 'Advanced Programming', '9781000000936', 390, 2013, 18, 14, 10, 15, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B094', 'Academic', 'Quantum Cryptography', '9781000000943', 420, 2021, 18, 14, 6, 10, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B095', 'Academic', 'Mathematics for Engineers', '9781000000950', 530, 2010, 18, 14, 8, 22, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B096', 'Academic', 'AI for Healthcare', '9781000000967', 450, 2020, 18, 14, 5, 3, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B097', 'Academic', 'Web Development Handbook', '9781000000974', 390, 2018, 18, 14, 9, 19, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B098', 'Academic', 'Computational Geometry', '9781000000981', 410, 2016, 18, 14, 6, 25, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B099', 'Academic', 'Data Ethics', '9781000000998', 340, 2022, 18, 14, 4, 7, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing'),
('B100', 'Academic', 'Research Writing for CS', '9781000001001', 300, 2019, 18, 7, 12, 11, 'https://drive.google.com/file/d/1yvGo1Q1k9S5BC3fd4X497jVLQvBSGMLN/view?usp=sharing');

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE `book_author` (
  `Author` varchar(100) NOT NULL,
  `Book_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_author`
--

INSERT INTO `book_author` (`Author`, `Book_ID`) VALUES
('J.R.R. Tolkien', 'B001'),
('George R.R. Martin', 'B002'),
('Brandon Sanderson', 'B003'),
('Robin Hobb', 'B004'),
('Neil Gaiman', 'B005'),
('Patrick Rothfuss', 'B005'),
('N.K. Jemisin', 'B006'),
('Neil Gaiman', 'B007'),
('Terry Pratchett', 'B007'),
('V.E. Schwab', 'B008'),
('Leigh Bardugo', 'B009'),
('C.S. Lewis', 'B010'),
('Rick Riordan', 'B011'),
('J.K. Rowling', 'B012'),
('Madeline Miller', 'B013'),
('Naomi Novik', 'B014'),
('R.F. Kuang', 'B015'),
('Ken Follett', 'B016'),
('Andrzej Sapkowski', 'B017'),
('Brandon Sanderson', 'B018'),
('Robert Jordan', 'B018'),
('Tamsyn Muir', 'B019'),
('Pierce Brown', 'B020'),
('Amie Kaufman', 'B021'),
('Jay Kristoff', 'B021'),
('Joe Abercrombie', 'B022'),
('Brent Weeks', 'B023'),
('Victoria Aveyard', 'B024'),
('Sarah J. Maas', 'B025'),
('Holly Black', 'B026'),
('Maggie Stiefvater', 'B027'),
('Ernest Cline', 'B028'),
('Suzanne Collins', 'B029'),
('Veronica Roth', 'B030'),
('Marissa Meyer', 'B031'),
('Sabaa Tahir', 'B032'),
('Scott Lynch', 'B033'),
('Brian McClellan', 'B034'),
('Mark Lawrence', 'B035'),
('Seanan McGuire', 'B036'),
('China Miéville', 'B037'),
('Jeff VanderMeer', 'B038'),
('Neal Stephenson', 'B039'),
('William Gibson', 'B039'),
('Anne McCaffrey', 'B040'),
('Diana Gabaldon', 'B041'),
('Raymond E. Feist', 'B042'),
('David Eddings', 'B043'),
('Philip Pullman', 'B044'),
('Tamora Pierce', 'B045'),
('Garth Nix', 'B046'),
('Stephen King', 'B047'),
('Clive Barker', 'B048'),
('H.P. Lovecraft', 'B049'),
('Shirley Jackson', 'B050'),
('Isaac L. Chuang', 'B051'),
('Michael A. Nielsen', 'B051'),
('Christopher M. Bishop', 'B052'),
('Charles E. Leiserson', 'B053'),
('Clifford Stein', 'B053'),
('Thomas H. Cormen', 'B053'),
('Brent Daniel Mittelstadt', 'B054'),
('Luciano Floridi', 'B054'),
('Tom M. Apostol', 'B055'),
('Gilbert Strang', 'B056'),
('David J. Griffiths', 'B057'),
('Abraham Silberschatz', 'B058'),
('Henry F. Korth', 'B058'),
('S. Sudarshan', 'B058'),
('Daniela Witten', 'B059'),
('Gareth James', 'B059'),
('Alfred V. Aho', 'B060'),
('Monica S. Lam', 'B060'),
('M. Morris Mano', 'B061'),
('Andrew S. Tanenbaum', 'B062'),
('Herbert Bos', 'B062'),
('James F. Kurose', 'B063'),
('Keith W. Ross', 'B063'),
('Aaron Courville', 'B064'),
('Ian Goodfellow', 'B064'),
('Yoshua Bengio', 'B064'),
('Alan Dix', 'B065'),
('Robert Tibshirani', 'B066'),
('Trevor Hastie', 'B066'),
('Marilyn Wolf', 'B067'),
('Cem Kaner', 'B068'),
('James Bach', 'B068'),
('Kenneth H. Rosen', 'B069'),
('William Stallings', 'B070'),
('Frank R. Giordano', 'B071'),
('Neil C. Jones', 'B072'),
('Pavel A. Pevzner', 'B072'),
('Rafael C. Gonzalez', 'B073'),
('Richard E. Woods', 'B073'),
('Peter Jackson', 'B074'),
('Bruno Siciliano', 'B075'),
('Lorenzo Sciavicco', 'B075'),
('C.R. Kothari', 'B076'),
('Viktor Mayer-Schönberger', 'B077'),
('Rajkumar Buyya', 'B078'),
('George Casella', 'B079'),
('Roger L. Berger', 'B079'),
('Michael Sipser', 'B080'),
('Jiawei Han', 'B081'),
('Micheline Kamber', 'B081'),
('John A. Nelder', 'B082'),
('Peter McCullagh', 'B082'),
('Averill M. Law', 'B083'),
('Ross J. Anderson', 'B084'),
('Daniel Jurafsky', 'B085'),
('James H. Martin', 'B085'),
('George Coulouris', 'B086'),
('Jean Dollimore', 'B086'),
('Richard Szeliski', 'B087'),
('Christopher D. Manning', 'B088'),
('Hinrich Schütze', 'B088'),
('Len Bass', 'B089'),
('Paul Clements', 'B089'),
('Richard J. Lipton', 'B090'),
('Dan Gusfield', 'B091'),
('Alan V. Oppenheim', 'B092'),
('Ronald W. Schafer', 'B092'),
('Bjarne Stroustrup', 'B093'),
('Gilles Brassard', 'B094'),
('Erwin Kreyszig', 'B095'),
('Regina Barzilay', 'B096'),
('Jon Duckett', 'B097'),
('Mark de Berg', 'B098'),
('Luciano Floridi', 'B099'),
('Justin Zobel', 'B100');

-- --------------------------------------------------------

--
-- Table structure for table `borrowing`
--

CREATE TABLE `borrowing` (
  `Brw_ID` int(11) NOT NULL,
  `Brw_Date` date NOT NULL,
  `Due_Date` date NOT NULL,
  `Return_Date` date DEFAULT NULL,
  `Brw_Status` enum('Borrowed','Returned') NOT NULL,
  `Staff_ID` int(11) NOT NULL,
  `Mem_ID` int(11) NOT NULL,
  `Book_ID` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `borrowing`
--

INSERT INTO `borrowing` (`Brw_ID`, `Brw_Date`, `Due_Date`, `Return_Date`, `Brw_Status`, `Staff_ID`, `Mem_ID`, `Book_ID`) VALUES
(1, '2025-11-22', '2025-12-06', '2025-11-22', 'Returned', 1, 1, 'B055'),
(2, '2025-11-22', '2025-12-06', '2025-11-22', 'Returned', 1, 1, 'B093'),
(3, '2025-11-22', '2025-12-06', NULL, 'Borrowed', 1, 1, 'B054'),
(4, '2025-11-22', '2025-11-29', '2025-11-22', 'Returned', 1, 2, 'B044'),
(5, '2025-11-22', '2025-12-06', '2025-11-23', 'Returned', 1, 1, 'B074'),
(6, '2025-11-22', '2025-12-06', '2025-11-22', 'Returned', 1, 1, 'B079'),
(7, '2025-11-22', '2025-12-06', '2025-11-22', 'Returned', 1, 3, 'B060'),
(8, '2025-11-23', '2025-12-07', '2025-11-23', 'Returned', 1, 1, 'B058'),
(9, '2025-11-24', '2025-12-01', NULL, 'Borrowed', 1, 1, 'B036'),
(10, '2025-11-24', '2025-12-08', NULL, 'Borrowed', 1, 3, 'B055'),
(11, '2025-11-24', '2025-12-01', NULL, 'Borrowed', 1, 7, 'B027');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `City_ID` int(11) NOT NULL,
  `Province_ID` int(11) NOT NULL,
  `City_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`City_ID`, `Province_ID`, `City_Name`) VALUES
(1101, 11, 'KABUPATEN SIMEULUE\r'),
(1102, 11, 'KABUPATEN ACEH SINGKIL\r'),
(1103, 11, 'KABUPATEN ACEH SELATAN\r'),
(1104, 11, 'KABUPATEN ACEH TENGGARA\r'),
(1105, 11, 'KABUPATEN ACEH TIMUR\r'),
(1106, 11, 'KABUPATEN ACEH TENGAH\r'),
(1107, 11, 'KABUPATEN ACEH BARAT\r'),
(1108, 11, 'KABUPATEN ACEH BESAR\r'),
(1109, 11, 'KABUPATEN PIDIE\r'),
(1110, 11, 'KABUPATEN BIREUEN\r'),
(1111, 11, 'KABUPATEN ACEH UTARA\r'),
(1112, 11, 'KABUPATEN ACEH BARAT DAYA\r'),
(1113, 11, 'KABUPATEN GAYO LUES\r'),
(1114, 11, 'KABUPATEN ACEH TAMIANG\r'),
(1115, 11, 'KABUPATEN NAGAN RAYA\r'),
(1116, 11, 'KABUPATEN ACEH JAYA\r'),
(1117, 11, 'KABUPATEN BENER MERIAH\r'),
(1118, 11, 'KABUPATEN PIDIE JAYA\r'),
(1171, 11, 'KOTA BANDA ACEH\r'),
(1172, 11, 'KOTA SABANG\r'),
(1173, 11, 'KOTA LANGSA\r'),
(1174, 11, 'KOTA LHOKSEUMAWE\r'),
(1175, 11, 'KOTA SUBULUSSALAM\r'),
(1201, 12, 'KABUPATEN NIAS\r'),
(1202, 12, 'KABUPATEN MANDAILING NATAL\r'),
(1203, 12, 'KABUPATEN TAPANULI SELATAN\r'),
(1204, 12, 'KABUPATEN TAPANULI TENGAH\r'),
(1205, 12, 'KABUPATEN TAPANULI UTARA\r'),
(1206, 12, 'KABUPATEN TOBA SAMOSIR\r'),
(1207, 12, 'KABUPATEN LABUHAN BATU\r'),
(1208, 12, 'KABUPATEN ASAHAN\r'),
(1209, 12, 'KABUPATEN SIMALUNGUN\r'),
(1210, 12, 'KABUPATEN DAIRI\r'),
(1211, 12, 'KABUPATEN KARO\r'),
(1212, 12, 'KABUPATEN DELI SERDANG\r'),
(1213, 12, 'KABUPATEN LANGKAT\r'),
(1214, 12, 'KABUPATEN NIAS SELATAN\r'),
(1215, 12, 'KABUPATEN HUMBANG HASUNDUTAN\r'),
(1216, 12, 'KABUPATEN PAKPAK BHARAT\r'),
(1217, 12, 'KABUPATEN SAMOSIR\r'),
(1218, 12, 'KABUPATEN SERDANG BEDAGAI\r'),
(1219, 12, 'KABUPATEN BATU BARA\r'),
(1220, 12, 'KABUPATEN PADANG LAWAS UTARA\r'),
(1221, 12, 'KABUPATEN PADANG LAWAS\r'),
(1222, 12, 'KABUPATEN LABUHAN BATU SELATAN\r'),
(1223, 12, 'KABUPATEN LABUHAN BATU UTARA\r'),
(1224, 12, 'KABUPATEN NIAS UTARA\r'),
(1225, 12, 'KABUPATEN NIAS BARAT\r'),
(1271, 12, 'KOTA SIBOLGA\r'),
(1272, 12, 'KOTA TANJUNG BALAI\r'),
(1273, 12, 'KOTA PEMATANG SIANTAR\r'),
(1274, 12, 'KOTA TEBING TINGGI\r'),
(1275, 12, 'KOTA MEDAN\r'),
(1276, 12, 'KOTA BINJAI\r'),
(1277, 12, 'KOTA PADANGSIDIMPUAN\r'),
(1278, 12, 'KOTA GUNUNGSITOLI\r'),
(1301, 13, 'KABUPATEN KEPULAUAN MENTAWAI\r'),
(1302, 13, 'KABUPATEN PESISIR SELATAN\r'),
(1303, 13, 'KABUPATEN SOLOK\r'),
(1304, 13, 'KABUPATEN SIJUNJUNG\r'),
(1305, 13, 'KABUPATEN TANAH DATAR\r'),
(1306, 13, 'KABUPATEN PADANG PARIAMAN\r'),
(1307, 13, 'KABUPATEN AGAM\r'),
(1308, 13, 'KABUPATEN LIMA PULUH KOTA\r'),
(1309, 13, 'KABUPATEN PASAMAN\r'),
(1310, 13, 'KABUPATEN SOLOK SELATAN\r'),
(1311, 13, 'KABUPATEN DHARMASRAYA\r'),
(1312, 13, 'KABUPATEN PASAMAN BARAT\r'),
(1371, 13, 'KOTA PADANG\r'),
(1372, 13, 'KOTA SOLOK\r'),
(1373, 13, 'KOTA SAWAH LUNTO\r'),
(1374, 13, 'KOTA PADANG PANJANG\r'),
(1375, 13, 'KOTA BUKITTINGGI\r'),
(1376, 13, 'KOTA PAYAKUMBUH\r'),
(1377, 13, 'KOTA PARIAMAN\r'),
(1401, 14, 'KABUPATEN KUANTAN SINGINGI\r'),
(1402, 14, 'KABUPATEN INDRAGIRI HULU\r'),
(1403, 14, 'KABUPATEN INDRAGIRI HILIR\r'),
(1404, 14, 'KABUPATEN PELALAWAN\r'),
(1405, 14, 'KABUPATEN S I A K\r'),
(1406, 14, 'KABUPATEN KAMPAR\r'),
(1407, 14, 'KABUPATEN ROKAN HULU\r'),
(1408, 14, 'KABUPATEN BENGKALIS\r'),
(1409, 14, 'KABUPATEN ROKAN HILIR\r'),
(1410, 14, 'KABUPATEN KEPULAUAN MERANTI\r'),
(1471, 14, 'KOTA PEKANBARU\r'),
(1473, 14, 'KOTA D U M A I\r'),
(1501, 15, 'KABUPATEN KERINCI\r'),
(1502, 15, 'KABUPATEN MERANGIN\r'),
(1503, 15, 'KABUPATEN SAROLANGUN\r'),
(1504, 15, 'KABUPATEN BATANG HARI\r'),
(1505, 15, 'KABUPATEN MUARO JAMBI\r'),
(1506, 15, 'KABUPATEN TANJUNG JABUNG TIMUR\r'),
(1507, 15, 'KABUPATEN TANJUNG JABUNG BARAT\r'),
(1508, 15, 'KABUPATEN TEBO\r'),
(1509, 15, 'KABUPATEN BUNGO\r'),
(1571, 15, 'KOTA JAMBI\r'),
(1572, 15, 'KOTA SUNGAI PENUH\r'),
(1601, 16, 'KABUPATEN OGAN KOMERING ULU\r'),
(1602, 16, 'KABUPATEN OGAN KOMERING ILIR\r'),
(1603, 16, 'KABUPATEN MUARA ENIM\r'),
(1604, 16, 'KABUPATEN LAHAT\r'),
(1605, 16, 'KABUPATEN MUSI RAWAS\r'),
(1606, 16, 'KABUPATEN MUSI BANYUASIN\r'),
(1607, 16, 'KABUPATEN BANYU ASIN\r'),
(1608, 16, 'KABUPATEN OGAN KOMERING ULU SELATAN\r'),
(1609, 16, 'KABUPATEN OGAN KOMERING ULU TIMUR\r'),
(1610, 16, 'KABUPATEN OGAN ILIR\r'),
(1611, 16, 'KABUPATEN EMPAT LAWANG\r'),
(1612, 16, 'KABUPATEN PENUKAL ABAB LEMATANG ILIR\r'),
(1613, 16, 'KABUPATEN MUSI RAWAS UTARA\r'),
(1671, 16, 'KOTA PALEMBANG\r'),
(1672, 16, 'KOTA PRABUMULIH\r'),
(1673, 16, 'KOTA PAGAR ALAM\r'),
(1674, 16, 'KOTA LUBUKLINGGAU\r'),
(1701, 17, 'KABUPATEN BENGKULU SELATAN\r'),
(1702, 17, 'KABUPATEN REJANG LEBONG\r'),
(1703, 17, 'KABUPATEN BENGKULU UTARA\r'),
(1704, 17, 'KABUPATEN KAUR\r'),
(1705, 17, 'KABUPATEN SELUMA\r'),
(1706, 17, 'KABUPATEN MUKOMUKO\r'),
(1707, 17, 'KABUPATEN LEBONG\r'),
(1708, 17, 'KABUPATEN KEPAHIANG\r'),
(1709, 17, 'KABUPATEN BENGKULU TENGAH\r'),
(1771, 17, 'KOTA BENGKULU\r'),
(1801, 18, 'KABUPATEN LAMPUNG BARAT\r'),
(1802, 18, 'KABUPATEN TANGGAMUS\r'),
(1803, 18, 'KABUPATEN LAMPUNG SELATAN\r'),
(1804, 18, 'KABUPATEN LAMPUNG TIMUR\r'),
(1805, 18, 'KABUPATEN LAMPUNG TENGAH\r'),
(1806, 18, 'KABUPATEN LAMPUNG UTARA\r'),
(1807, 18, 'KABUPATEN WAY KANAN\r'),
(1808, 18, 'KABUPATEN TULANGBAWANG\r'),
(1809, 18, 'KABUPATEN PESAWARAN\r'),
(1810, 18, 'KABUPATEN PRINGSEWU\r'),
(1811, 18, 'KABUPATEN MESUJI\r'),
(1812, 18, 'KABUPATEN TULANG BAWANG BARAT\r'),
(1813, 18, 'KABUPATEN PESISIR BARAT\r'),
(1871, 18, 'KOTA BANDAR LAMPUNG\r'),
(1872, 18, 'KOTA METRO\r'),
(1901, 19, 'KABUPATEN BANGKA\r'),
(1902, 19, 'KABUPATEN BELITUNG\r'),
(1903, 19, 'KABUPATEN BANGKA BARAT\r'),
(1904, 19, 'KABUPATEN BANGKA TENGAH\r'),
(1905, 19, 'KABUPATEN BANGKA SELATAN\r'),
(1906, 19, 'KABUPATEN BELITUNG TIMUR\r'),
(1971, 19, 'KOTA PANGKAL PINANG\r'),
(2101, 21, 'KABUPATEN KARIMUN\r'),
(2102, 21, 'KABUPATEN BINTAN\r'),
(2103, 21, 'KABUPATEN NATUNA\r'),
(2104, 21, 'KABUPATEN LINGGA\r'),
(2105, 21, 'KABUPATEN KEPULAUAN ANAMBAS\r'),
(2171, 21, 'KOTA B A T A M\r'),
(2172, 21, 'KOTA TANJUNG PINANG\r'),
(3101, 31, 'KABUPATEN KEPULAUAN SERIBU\r'),
(3171, 31, 'KOTA JAKARTA SELATAN\r'),
(3172, 31, 'KOTA JAKARTA TIMUR\r'),
(3173, 31, 'KOTA JAKARTA PUSAT\r'),
(3174, 31, 'KOTA JAKARTA BARAT\r'),
(3175, 31, 'KOTA JAKARTA UTARA\r'),
(3201, 32, 'KABUPATEN BOGOR\r'),
(3202, 32, 'KABUPATEN SUKABUMI\r'),
(3203, 32, 'KABUPATEN CIANJUR\r'),
(3204, 32, 'KABUPATEN BANDUNG\r'),
(3205, 32, 'KABUPATEN GARUT\r'),
(3206, 32, 'KABUPATEN TASIKMALAYA\r'),
(3207, 32, 'KABUPATEN CIAMIS\r'),
(3208, 32, 'KABUPATEN KUNINGAN\r'),
(3209, 32, 'KABUPATEN CIREBON\r'),
(3210, 32, 'KABUPATEN MAJALENGKA\r'),
(3211, 32, 'KABUPATEN SUMEDANG\r'),
(3212, 32, 'KABUPATEN INDRAMAYU\r'),
(3213, 32, 'KABUPATEN SUBANG\r'),
(3214, 32, 'KABUPATEN PURWAKARTA\r'),
(3215, 32, 'KABUPATEN KARAWANG\r'),
(3216, 32, 'KABUPATEN BEKASI\r'),
(3217, 32, 'KABUPATEN BANDUNG BARAT\r'),
(3218, 32, 'KABUPATEN PANGANDARAN\r'),
(3271, 32, 'KOTA BOGOR\r'),
(3272, 32, 'KOTA SUKABUMI\r'),
(3273, 32, 'KOTA BANDUNG\r'),
(3274, 32, 'KOTA CIREBON\r'),
(3275, 32, 'KOTA BEKASI\r'),
(3276, 32, 'KOTA DEPOK\r'),
(3277, 32, 'KOTA CIMAHI\r'),
(3278, 32, 'KOTA TASIKMALAYA\r'),
(3279, 32, 'KOTA BANJAR\r'),
(3301, 33, 'KABUPATEN CILACAP\r'),
(3302, 33, 'KABUPATEN BANYUMAS\r'),
(3303, 33, 'KABUPATEN PURBALINGGA\r'),
(3304, 33, 'KABUPATEN BANJARNEGARA\r'),
(3305, 33, 'KABUPATEN KEBUMEN\r'),
(3306, 33, 'KABUPATEN PURWOREJO\r'),
(3307, 33, 'KABUPATEN WONOSOBO\r'),
(3308, 33, 'KABUPATEN MAGELANG\r'),
(3309, 33, 'KABUPATEN BOYOLALI\r'),
(3310, 33, 'KABUPATEN KLATEN\r'),
(3311, 33, 'KABUPATEN SUKOHARJO\r'),
(3312, 33, 'KABUPATEN WONOGIRI\r'),
(3313, 33, 'KABUPATEN KARANGANYAR\r'),
(3314, 33, 'KABUPATEN SRAGEN\r'),
(3315, 33, 'KABUPATEN GROBOGAN\r'),
(3316, 33, 'KABUPATEN BLORA\r'),
(3317, 33, 'KABUPATEN REMBANG\r'),
(3318, 33, 'KABUPATEN PATI\r'),
(3319, 33, 'KABUPATEN KUDUS\r'),
(3320, 33, 'KABUPATEN JEPARA\r'),
(3321, 33, 'KABUPATEN DEMAK\r'),
(3322, 33, 'KABUPATEN SEMARANG\r'),
(3323, 33, 'KABUPATEN TEMANGGUNG\r'),
(3324, 33, 'KABUPATEN KENDAL\r'),
(3325, 33, 'KABUPATEN BATANG\r'),
(3326, 33, 'KABUPATEN PEKALONGAN\r'),
(3327, 33, 'KABUPATEN PEMALANG\r'),
(3328, 33, 'KABUPATEN TEGAL\r'),
(3329, 33, 'KABUPATEN BREBES\r'),
(3371, 33, 'KOTA MAGELANG\r'),
(3372, 33, 'KOTA SURAKARTA\r'),
(3373, 33, 'KOTA SALATIGA\r'),
(3374, 33, 'KOTA SEMARANG\r'),
(3375, 33, 'KOTA PEKALONGAN\r'),
(3376, 33, 'KOTA TEGAL\r'),
(3401, 34, 'KABUPATEN KULON PROGO\r'),
(3402, 34, 'KABUPATEN BANTUL\r'),
(3403, 34, 'KABUPATEN GUNUNG KIDUL\r'),
(3404, 34, 'KABUPATEN SLEMAN\r'),
(3471, 34, 'KOTA YOGYAKARTA\r'),
(3501, 35, 'KABUPATEN PACITAN\r'),
(3502, 35, 'KABUPATEN PONOROGO\r'),
(3503, 35, 'KABUPATEN TRENGGALEK\r'),
(3504, 35, 'KABUPATEN TULUNGAGUNG\r'),
(3505, 35, 'KABUPATEN BLITAR\r'),
(3506, 35, 'KABUPATEN KEDIRI\r'),
(3507, 35, 'KABUPATEN MALANG\r'),
(3508, 35, 'KABUPATEN LUMAJANG\r'),
(3509, 35, 'KABUPATEN JEMBER\r'),
(3510, 35, 'KABUPATEN BANYUWANGI\r'),
(3511, 35, 'KABUPATEN BONDOWOSO\r'),
(3512, 35, 'KABUPATEN SITUBONDO\r'),
(3513, 35, 'KABUPATEN PROBOLINGGO\r'),
(3514, 35, 'KABUPATEN PASURUAN\r'),
(3515, 35, 'KABUPATEN SIDOARJO\r'),
(3516, 35, 'KABUPATEN MOJOKERTO\r'),
(3517, 35, 'KABUPATEN JOMBANG\r'),
(3518, 35, 'KABUPATEN NGANJUK\r'),
(3519, 35, 'KABUPATEN MADIUN\r'),
(3520, 35, 'KABUPATEN MAGETAN\r'),
(3521, 35, 'KABUPATEN NGAWI\r'),
(3522, 35, 'KABUPATEN BOJONEGORO\r'),
(3523, 35, 'KABUPATEN TUBAN\r'),
(3524, 35, 'KABUPATEN LAMONGAN\r'),
(3525, 35, 'KABUPATEN GRESIK\r'),
(3526, 35, 'KABUPATEN BANGKALAN\r'),
(3527, 35, 'KABUPATEN SAMPANG\r'),
(3528, 35, 'KABUPATEN PAMEKASAN\r'),
(3529, 35, 'KABUPATEN SUMENEP\r'),
(3571, 35, 'KOTA KEDIRI\r'),
(3572, 35, 'KOTA BLITAR\r'),
(3573, 35, 'KOTA MALANG\r'),
(3574, 35, 'KOTA PROBOLINGGO\r'),
(3575, 35, 'KOTA PASURUAN\r'),
(3576, 35, 'KOTA MOJOKERTO\r'),
(3577, 35, 'KOTA MADIUN\r'),
(3578, 35, 'KOTA SURABAYA\r'),
(3579, 35, 'KOTA BATU\r'),
(3601, 36, 'KABUPATEN PANDEGLANG\r'),
(3602, 36, 'KABUPATEN LEBAK\r'),
(3603, 36, 'KABUPATEN TANGERANG\r'),
(3604, 36, 'KABUPATEN SERANG\r'),
(3671, 36, 'KOTA TANGERANG\r'),
(3672, 36, 'KOTA CILEGON\r'),
(3673, 36, 'KOTA SERANG\r'),
(3674, 36, 'KOTA TANGERANG SELATAN\r'),
(5101, 51, 'KABUPATEN JEMBRANA\r'),
(5102, 51, 'KABUPATEN TABANAN\r'),
(5103, 51, 'KABUPATEN BADUNG\r'),
(5104, 51, 'KABUPATEN GIANYAR\r'),
(5105, 51, 'KABUPATEN KLUNGKUNG\r'),
(5106, 51, 'KABUPATEN BANGLI\r'),
(5107, 51, 'KABUPATEN KARANG ASEM\r'),
(5108, 51, 'KABUPATEN BULELENG\r'),
(5171, 51, 'KOTA DENPASAR\r'),
(5201, 52, 'KABUPATEN LOMBOK BARAT\r'),
(5202, 52, 'KABUPATEN LOMBOK TENGAH\r'),
(5203, 52, 'KABUPATEN LOMBOK TIMUR\r'),
(5204, 52, 'KABUPATEN SUMBAWA\r'),
(5205, 52, 'KABUPATEN DOMPU\r'),
(5206, 52, 'KABUPATEN BIMA\r'),
(5207, 52, 'KABUPATEN SUMBAWA BARAT\r'),
(5208, 52, 'KABUPATEN LOMBOK UTARA\r'),
(5271, 52, 'KOTA MATARAM\r'),
(5272, 52, 'KOTA BIMA\r'),
(5301, 53, 'KABUPATEN SUMBA BARAT\r'),
(5302, 53, 'KABUPATEN SUMBA TIMUR\r'),
(5303, 53, 'KABUPATEN KUPANG\r'),
(5304, 53, 'KABUPATEN TIMOR TENGAH SELATAN\r'),
(5305, 53, 'KABUPATEN TIMOR TENGAH UTARA\r'),
(5306, 53, 'KABUPATEN BELU\r'),
(5307, 53, 'KABUPATEN ALOR\r'),
(5308, 53, 'KABUPATEN LEMBATA\r'),
(5309, 53, 'KABUPATEN FLORES TIMUR\r'),
(5310, 53, 'KABUPATEN SIKKA\r'),
(5311, 53, 'KABUPATEN ENDE\r'),
(5312, 53, 'KABUPATEN NGADA\r'),
(5313, 53, 'KABUPATEN MANGGARAI\r'),
(5314, 53, 'KABUPATEN ROTE NDAO\r'),
(5315, 53, 'KABUPATEN MANGGARAI BARAT\r'),
(5316, 53, 'KABUPATEN SUMBA TENGAH\r'),
(5317, 53, 'KABUPATEN SUMBA BARAT DAYA\r'),
(5318, 53, 'KABUPATEN NAGEKEO\r'),
(5319, 53, 'KABUPATEN MANGGARAI TIMUR\r'),
(5320, 53, 'KABUPATEN SABU RAIJUA\r'),
(5321, 53, 'KABUPATEN MALAKA\r'),
(5371, 53, 'KOTA KUPANG\r'),
(6101, 61, 'KABUPATEN SAMBAS\r'),
(6102, 61, 'KABUPATEN BENGKAYANG\r'),
(6103, 61, 'KABUPATEN LANDAK\r'),
(6104, 61, 'KABUPATEN MEMPAWAH\r'),
(6105, 61, 'KABUPATEN SANGGAU\r'),
(6106, 61, 'KABUPATEN KETAPANG\r'),
(6107, 61, 'KABUPATEN SINTANG\r'),
(6108, 61, 'KABUPATEN KAPUAS HULU\r'),
(6109, 61, 'KABUPATEN SEKADAU\r'),
(6110, 61, 'KABUPATEN MELAWI\r'),
(6111, 61, 'KABUPATEN KAYONG UTARA\r'),
(6112, 61, 'KABUPATEN KUBU RAYA\r'),
(6171, 61, 'KOTA PONTIANAK\r'),
(6172, 61, 'KOTA SINGKAWANG\r'),
(6201, 62, 'KABUPATEN KOTAWARINGIN BARAT\r'),
(6202, 62, 'KABUPATEN KOTAWARINGIN TIMUR\r'),
(6203, 62, 'KABUPATEN KAPUAS\r'),
(6204, 62, 'KABUPATEN BARITO SELATAN\r'),
(6205, 62, 'KABUPATEN BARITO UTARA\r'),
(6206, 62, 'KABUPATEN SUKAMARA\r'),
(6207, 62, 'KABUPATEN LAMANDAU\r'),
(6208, 62, 'KABUPATEN SERUYAN\r'),
(6209, 62, 'KABUPATEN KATINGAN\r'),
(6210, 62, 'KABUPATEN PULANG PISAU\r'),
(6211, 62, 'KABUPATEN GUNUNG MAS\r'),
(6212, 62, 'KABUPATEN BARITO TIMUR\r'),
(6213, 62, 'KABUPATEN MURUNG RAYA\r'),
(6271, 62, 'KOTA PALANGKA RAYA\r'),
(6301, 63, 'KABUPATEN TANAH LAUT\r'),
(6302, 63, 'KABUPATEN KOTA BARU\r'),
(6303, 63, 'KABUPATEN BANJAR\r'),
(6304, 63, 'KABUPATEN BARITO KUALA\r'),
(6305, 63, 'KABUPATEN TAPIN\r'),
(6306, 63, 'KABUPATEN HULU SUNGAI SELATAN\r'),
(6307, 63, 'KABUPATEN HULU SUNGAI TENGAH\r'),
(6308, 63, 'KABUPATEN HULU SUNGAI UTARA\r'),
(6309, 63, 'KABUPATEN TABALONG\r'),
(6310, 63, 'KABUPATEN TANAH BUMBU\r'),
(6311, 63, 'KABUPATEN BALANGAN\r'),
(6371, 63, 'KOTA BANJARMASIN\r'),
(6372, 63, 'KOTA BANJAR BARU\r'),
(6401, 64, 'KABUPATEN PASER\r'),
(6402, 64, 'KABUPATEN KUTAI BARAT\r'),
(6403, 64, 'KABUPATEN KUTAI KARTANEGARA\r'),
(6404, 64, 'KABUPATEN KUTAI TIMUR\r'),
(6405, 64, 'KABUPATEN BERAU\r'),
(6409, 64, 'KABUPATEN PENAJAM PASER UTARA\r'),
(6411, 64, 'KABUPATEN MAHAKAM HULU\r'),
(6471, 64, 'KOTA BALIKPAPAN\r'),
(6472, 64, 'KOTA SAMARINDA\r'),
(6474, 64, 'KOTA BONTANG\r'),
(6501, 65, 'KABUPATEN MALINAU\r'),
(6502, 65, 'KABUPATEN BULUNGAN\r'),
(6503, 65, 'KABUPATEN TANA TIDUNG\r'),
(6504, 65, 'KABUPATEN NUNUKAN\r'),
(6571, 65, 'KOTA TARAKAN\r'),
(7101, 71, 'KABUPATEN BOLAANG MONGONDOW\r'),
(7102, 71, 'KABUPATEN MINAHASA\r'),
(7103, 71, 'KABUPATEN KEPULAUAN SANGIHE\r'),
(7104, 71, 'KABUPATEN KEPULAUAN TALAUD\r'),
(7105, 71, 'KABUPATEN MINAHASA SELATAN\r'),
(7106, 71, 'KABUPATEN MINAHASA UTARA\r'),
(7107, 71, 'KABUPATEN BOLAANG MONGONDOW UTARA\r'),
(7108, 71, 'KABUPATEN SIAU TAGULANDANG BIARO\r'),
(7109, 71, 'KABUPATEN MINAHASA TENGGARA\r'),
(7110, 71, 'KABUPATEN BOLAANG MONGONDOW SELATAN\r'),
(7111, 71, 'KABUPATEN BOLAANG MONGONDOW TIMUR\r'),
(7171, 71, 'KOTA MANADO\r'),
(7172, 71, 'KOTA BITUNG\r'),
(7173, 71, 'KOTA TOMOHON\r'),
(7174, 71, 'KOTA KOTAMOBAGU\r'),
(7201, 72, 'KABUPATEN BANGGAI KEPULAUAN\r'),
(7202, 72, 'KABUPATEN BANGGAI\r'),
(7203, 72, 'KABUPATEN MOROWALI\r'),
(7204, 72, 'KABUPATEN POSO\r'),
(7205, 72, 'KABUPATEN DONGGALA\r'),
(7206, 72, 'KABUPATEN TOLI-TOLI\r'),
(7207, 72, 'KABUPATEN BUOL\r'),
(7208, 72, 'KABUPATEN PARIGI MOUTONG\r'),
(7209, 72, 'KABUPATEN TOJO UNA-UNA\r'),
(7210, 72, 'KABUPATEN SIGI\r'),
(7211, 72, 'KABUPATEN BANGGAI LAUT\r'),
(7212, 72, 'KABUPATEN MOROWALI UTARA\r'),
(7271, 72, 'KOTA PALU\r'),
(7301, 73, 'KABUPATEN KEPULAUAN SELAYAR\r'),
(7302, 73, 'KABUPATEN BULUKUMBA\r'),
(7303, 73, 'KABUPATEN BANTAENG\r'),
(7304, 73, 'KABUPATEN JENEPONTO\r'),
(7305, 73, 'KABUPATEN TAKALAR\r'),
(7306, 73, 'KABUPATEN GOWA\r'),
(7307, 73, 'KABUPATEN SINJAI\r'),
(7308, 73, 'KABUPATEN MAROS\r'),
(7309, 73, 'KABUPATEN PANGKAJENE DAN KEPULAUAN\r'),
(7310, 73, 'KABUPATEN BARRU\r'),
(7311, 73, 'KABUPATEN BONE\r'),
(7312, 73, 'KABUPATEN SOPPENG\r'),
(7313, 73, 'KABUPATEN WAJO\r'),
(7314, 73, 'KABUPATEN SIDENRENG RAPPANG\r'),
(7315, 73, 'KABUPATEN PINRANG\r'),
(7316, 73, 'KABUPATEN ENREKANG\r'),
(7317, 73, 'KABUPATEN LUWU\r'),
(7318, 73, 'KABUPATEN TANA TORAJA\r'),
(7322, 73, 'KABUPATEN LUWU UTARA\r'),
(7325, 73, 'KABUPATEN LUWU TIMUR\r'),
(7326, 73, 'KABUPATEN TORAJA UTARA\r'),
(7371, 73, 'KOTA MAKASSAR\r'),
(7372, 73, 'KOTA PAREPARE\r'),
(7373, 73, 'KOTA PALOPO\r'),
(7401, 74, 'KABUPATEN BUTON\r'),
(7402, 74, 'KABUPATEN MUNA\r'),
(7403, 74, 'KABUPATEN KONAWE\r'),
(7404, 74, 'KABUPATEN KOLAKA\r'),
(7405, 74, 'KABUPATEN KONAWE SELATAN\r'),
(7406, 74, 'KABUPATEN BOMBANA\r'),
(7407, 74, 'KABUPATEN WAKATOBI\r'),
(7408, 74, 'KABUPATEN KOLAKA UTARA\r'),
(7409, 74, 'KABUPATEN BUTON UTARA\r'),
(7410, 74, 'KABUPATEN KONAWE UTARA\r'),
(7411, 74, 'KABUPATEN KOLAKA TIMUR\r'),
(7412, 74, 'KABUPATEN KONAWE KEPULAUAN\r'),
(7413, 74, 'KABUPATEN MUNA BARAT\r'),
(7414, 74, 'KABUPATEN BUTON TENGAH\r'),
(7415, 74, 'KABUPATEN BUTON SELATAN\r'),
(7471, 74, 'KOTA KENDARI\r'),
(7472, 74, 'KOTA BAUBAU\r'),
(7501, 75, 'KABUPATEN BOALEMO\r'),
(7502, 75, 'KABUPATEN GORONTALO\r'),
(7503, 75, 'KABUPATEN POHUWATO\r'),
(7504, 75, 'KABUPATEN BONE BOLANGO\r'),
(7505, 75, 'KABUPATEN GORONTALO UTARA\r'),
(7571, 75, 'KOTA GORONTALO\r'),
(7601, 76, 'KABUPATEN MAJENE\r'),
(7602, 76, 'KABUPATEN POLEWALI MANDAR\r'),
(7603, 76, 'KABUPATEN MAMASA\r'),
(7604, 76, 'KABUPATEN MAMUJU\r'),
(7605, 76, 'KABUPATEN MAMUJU UTARA\r'),
(7606, 76, 'KABUPATEN MAMUJU TENGAH\r'),
(8101, 81, 'KABUPATEN MALUKU TENGGARA BARAT\r'),
(8102, 81, 'KABUPATEN MALUKU TENGGARA\r'),
(8103, 81, 'KABUPATEN MALUKU TENGAH\r'),
(8104, 81, 'KABUPATEN BURU\r'),
(8105, 81, 'KABUPATEN KEPULAUAN ARU\r'),
(8106, 81, 'KABUPATEN SERAM BAGIAN BARAT\r'),
(8107, 81, 'KABUPATEN SERAM BAGIAN TIMUR\r'),
(8108, 81, 'KABUPATEN MALUKU BARAT DAYA\r'),
(8109, 81, 'KABUPATEN BURU SELATAN\r'),
(8171, 81, 'KOTA AMBON\r'),
(8172, 81, 'KOTA TUAL\r'),
(8201, 82, 'KABUPATEN HALMAHERA BARAT\r'),
(8202, 82, 'KABUPATEN HALMAHERA TENGAH\r'),
(8203, 82, 'KABUPATEN KEPULAUAN SULA\r'),
(8204, 82, 'KABUPATEN HALMAHERA SELATAN\r'),
(8205, 82, 'KABUPATEN HALMAHERA UTARA\r'),
(8206, 82, 'KABUPATEN HALMAHERA TIMUR\r'),
(8207, 82, 'KABUPATEN PULAU MOROTAI\r'),
(8208, 82, 'KABUPATEN PULAU TALIABU\r'),
(8271, 82, 'KOTA TERNATE\r'),
(8272, 82, 'KOTA TIDORE KEPULAUAN\r'),
(9101, 91, 'KABUPATEN FAKFAK\r'),
(9102, 91, 'KABUPATEN KAIMANA\r'),
(9103, 91, 'KABUPATEN TELUK WONDAMA\r'),
(9104, 91, 'KABUPATEN TELUK BINTUNI\r'),
(9105, 91, 'KABUPATEN MANOKWARI\r'),
(9106, 91, 'KABUPATEN SORONG SELATAN\r'),
(9107, 91, 'KABUPATEN SORONG\r'),
(9108, 91, 'KABUPATEN RAJA AMPAT\r'),
(9109, 91, 'KABUPATEN TAMBRAUW\r'),
(9110, 91, 'KABUPATEN MAYBRAT\r'),
(9111, 91, 'KABUPATEN MANOKWARI SELATAN\r'),
(9112, 91, 'KABUPATEN PEGUNUNGAN ARFAK\r'),
(9171, 91, 'KOTA SORONG\r'),
(9401, 94, 'KABUPATEN MERAUKE\r'),
(9402, 94, 'KABUPATEN JAYAWIJAYA\r'),
(9403, 94, 'KABUPATEN JAYAPURA\r'),
(9404, 94, 'KABUPATEN NABIRE\r'),
(9408, 94, 'KABUPATEN KEPULAUAN YAPEN\r'),
(9409, 94, 'KABUPATEN BIAK NUMFOR\r'),
(9410, 94, 'KABUPATEN PANIAI\r'),
(9411, 94, 'KABUPATEN PUNCAK JAYA\r'),
(9412, 94, 'KABUPATEN MIMIKA\r'),
(9413, 94, 'KABUPATEN BOVEN DIGOEL\r'),
(9414, 94, 'KABUPATEN MAPPI\r'),
(9415, 94, 'KABUPATEN ASMAT\r'),
(9416, 94, 'KABUPATEN YAHUKIMO\r'),
(9417, 94, 'KABUPATEN PEGUNUNGAN BINTANG\r'),
(9418, 94, 'KABUPATEN TOLIKARA\r'),
(9419, 94, 'KABUPATEN SARMI\r'),
(9420, 94, 'KABUPATEN KEEROM\r'),
(9426, 94, 'KABUPATEN WAROPEN\r'),
(9427, 94, 'KABUPATEN SUPIORI\r'),
(9428, 94, 'KABUPATEN MAMBERAMO RAYA\r'),
(9429, 94, 'KABUPATEN NDUGA\r'),
(9430, 94, 'KABUPATEN LANNY JAYA\r'),
(9431, 94, 'KABUPATEN MAMBERAMO TENGAH\r'),
(9432, 94, 'KABUPATEN YALIMO\r'),
(9433, 94, 'KABUPATEN PUNCAK\r'),
(9434, 94, 'KABUPATEN DOGIYAI\r'),
(9435, 94, 'KABUPATEN INTAN JAYA\r'),
(9436, 94, 'KABUPATEN DEIYAI\r'),
(9471, 94, 'KOTA JAYAPURA');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Mem_ID` int(11) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `Gender` enum('Man','Woman') NOT NULL,
  `Date_of_Birth` date NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `City_ID` int(11) NOT NULL,
  `Staff_ID` int(11) NOT NULL,
  `Is_Verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Mem_ID`, `Full_Name`, `Gender`, `Date_of_Birth`, `Email`, `Password`, `City_ID`, `Staff_ID`, `Is_Verified`) VALUES
(1, 'Kukuh Agus Hermawan', 'Man', '2006-08-12', 'kukuhagushermawan@mail.ugm.ac.id', '$2y$10$w234tEKx.OC3YD5roRh8J.4f3hDGnZ30q/Qf3BAFkQpiQ4iNdNLe6', 3305, 1, 1),
(2, 'Yuna Mahisa', 'Woman', '2006-09-07', 'random@gmail.com', '$2y$10$CL66/4addlIGItmIm1pf4OhYaqMvVK6qn.RsJNCsypk0Rp8z2h4d2', 3471, 1, 1),
(3, 'Aulia Fathus Tsani', 'Woman', '2006-08-07', 'auliafathus@gmail.com', '$2y$10$sDcyL5U/gzGgBl0LrwXxoeZg5FCeJhtj4jXMgIp060QIGCKEunbmK', 3309, 1, 1),
(4, 'Yang Mulia Renan', 'Woman', '2005-10-29', 'renantheraulia@gmail.com', '$2y$10$vrdPp/vNjBen7CSFkVNBReNC5Vbs0dJ308eMgkRorCxO2SM2fEqmK', 3578, 1, 1),
(5, 'Husna Izzatul Laili', 'Woman', '2008-07-02', 'husnaizza@gmail.com', '$2y$10$iBHI82zEM8BocAm2qI6bo.l78NUpkmdeTTD70RUsFWvLIiiMP57QS', 3309, 1, 1),
(6, 'Farid', 'Man', '2015-01-15', 'Farid@gmail.com', '$2y$10$Q6XzanttNwDu0VBOSeV/iuL9WWFyKyFtv8g0YbDP/hL1arEc0wP.2', 3404, 2, 1),
(7, 'Citra Putri Utari', 'Woman', '2010-11-06', 'citraputri@gmail.com', '$2y$10$cREFcgvab4EZaN2NvN2Yzur2DofQXfn.UiGd5Wp1bFcYOTRT9gyCi', 3322, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `Province_ID` int(11) NOT NULL,
  `Province_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`Province_ID`, `Province_Name`) VALUES
(11, 'ACEH\r'),
(12, 'SUMATERA UTARA\r'),
(13, 'SUMATERA BARAT\r'),
(14, 'RIAU\r'),
(15, 'JAMBI\r'),
(16, 'SUMATERA SELATAN\r'),
(17, 'BENGKULU\r'),
(18, 'LAMPUNG\r'),
(19, 'KEPULAUAN BANGKA BELITUNG\r'),
(21, 'KEPULAUAN RIAU\r'),
(31, 'DKI JAKARTA\r'),
(32, 'JAWA BARAT\r'),
(33, 'JAWA TENGAH\r'),
(34, 'DI YOGYAKARTA\r'),
(35, 'JAWA TIMUR\r'),
(36, 'BANTEN\r'),
(51, 'BALI\r'),
(52, 'NUSA TENGGARA BARAT\r'),
(53, 'NUSA TENGGARA TIMUR\r'),
(61, 'KALIMANTAN BARAT\r'),
(62, 'KALIMANTAN TENGAH\r'),
(63, 'KALIMANTAN SELATAN\r'),
(64, 'KALIMANTAN TIMUR\r'),
(65, 'KALIMANTAN UTARA\r'),
(71, 'SULAWESI UTARA\r'),
(72, 'SULAWESI TENGAH\r'),
(73, 'SULAWESI SELATAN\r'),
(74, 'SULAWESI TENGGARA\r'),
(75, 'GORONTALO\r'),
(76, 'SULAWESI BARAT\r'),
(81, 'MALUKU\r'),
(82, 'MALUKU UTARA\r'),
(91, 'PAPUA BARAT\r'),
(94, 'PAPUA\r');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` int(11) NOT NULL,
  `Staff_Name` varchar(100) NOT NULL,
  `Position` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL DEFAULT 'masuk123'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_ID`, `Staff_Name`, `Position`, `Email`, `Password`) VALUES
(1, 'Admin InfiniRead', 'Administrator', 'admin@infiniread.test', 'masuk123'),
(2, 'Andi Adinata', 'Librarian', 'petugas1@infiniread.test', 'masuk123'),
(3, 'Siti Nurhaliza', 'Librarian', 'petugas2@infiniread.test', 'masuk123'),
(4, 'Budi Santoso', 'Librarian', 'petugas3@infiniread.test', 'masuk123'),
(5, 'Rina Kartika', 'Librarian', 'petugas4@infiniread.test', 'masuk123'),
(6, 'Dwi Pratama', 'Librarian', 'petugas5@infiniread.test', 'masuk123'),
(7, 'Nadia Putri', 'Librarian', 'petugas6@infiniread.test', 'masuk123'),
(8, 'Rizky Hidayat', 'Librarian', 'petugas7@infiniread.test', 'masuk123'),
(9, 'Agus Setiawan', 'Librarian', 'petugas8@infiniread.test', 'masuk123'),
(10, 'Maya Lestari', 'Librarian', 'petugas9@infiniread.test', 'masuk123'),
(11, 'Hendra Wijaya', 'Librarian', 'petugas10@infiniread.test', 'masuk123'),
(12, 'Dian Puspitasari', 'Librarian', 'petugas11@infiniread.test', 'masuk123'),
(13, 'Fajar Ramadhan', 'Librarian', 'petugas12@infiniread.test', 'masuk123'),
(14, 'Intan Paramitha', 'Librarian', 'petugas13@infiniread.test', 'masuk123'),
(15, 'Yoga Kurniawan', 'Librarian', 'petugas14@infiniread.test', 'masuk123'),
(16, 'Lukman Hakim', 'Librarian', 'petugas15@infiniread.test', 'masuk123'),
(17, 'Ayu Wulandari', 'Librarian', 'petugas16@infiniread.test', 'masuk123'),
(18, 'Rama Pratama', 'Librarian', 'petugas17@infiniread.test', 'masuk123'),
(19, 'Salsa Aprilia', 'Librarian', 'petugas18@infiniread.test', 'masuk123'),
(20, 'Galih Nugroho', 'Librarian', 'petugas19@infiniread.test', 'masuk123'),
(21, 'Farah Nabila', 'Librarian', 'petugas20@infiniread.test', 'masuk123'),
(22, 'Rafiansyah Putra', 'Librarian', 'petugas21@infiniread.test', 'masuk123'),
(23, 'Dinda Maharani', 'Librarian', 'petugas22@infiniread.test', 'masuk123'),
(24, 'Alvin Prakoso', 'Librarian', 'petugas23@infiniread.test', 'masuk123'),
(25, 'Citra Anggraini', 'Librarian', 'petugas24@infiniread.test', 'masuk123'),
(26, 'Reza Firmansyah', 'Librarian', 'petugas25@infiniread.test', 'masuk123'),
(27, 'Laila Salsabila', 'Librarian', 'petugas26@infiniread.test', 'masuk123'),
(28, 'Hilmi Fauzan', 'Librarian', 'petugas27@infiniread.test', 'masuk123'),
(29, 'Novi Andriani', 'Librarian', 'petugas28@infiniread.test', 'masuk123'),
(30, 'Yusuf Maulana', 'Librarian', 'petugas29@infiniread.test', 'masuk123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`Book_ID`),
  ADD KEY `fk_book_staff` (`Staff_ID`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`Author`,`Book_ID`),
  ADD KEY `fk_bookauthor_book` (`Book_ID`);

--
-- Indexes for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD PRIMARY KEY (`Brw_ID`),
  ADD KEY `fk_borrow_staff` (`Staff_ID`),
  ADD KEY `fk_borrow_member` (`Mem_ID`),
  ADD KEY `fk_borrow_book` (`Book_ID`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`City_ID`),
  ADD KEY `Province_ID` (`Province_ID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Mem_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `fk_member_city` (`City_ID`),
  ADD KEY `fk_member_staff` (`Staff_ID`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`Province_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrowing`
--
ALTER TABLE `borrowing`
  MODIFY `Brw_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `Mem_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `fk_book_staff` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `fk_bookauthor_book` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`Province_ID`) REFERENCES `province` (`Province_ID`);

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `fk_member_city` FOREIGN KEY (`City_ID`) REFERENCES `city` (`City_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_member_staff` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
