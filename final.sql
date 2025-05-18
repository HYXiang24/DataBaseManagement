-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-06-14 19:39:22
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `final`
--

-- --------------------------------------------------------

--
-- 資料表結構 `comment`
--

CREATE TABLE `comment` (
  `member_ID` int(11) NOT NULL,
  `Movie_name` varchar(20) NOT NULL,
  `time` datetime NOT NULL,
  `context` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `comment`
--

INSERT INTO `comment` (`member_ID`, `Movie_name`, `time`, `context`) VALUES
(1, '天綫寶寶', '2024-06-13 11:21:13', '很好'),
(1, '天綫寶寶', '2024-06-13 11:21:27', '很爛'),
(1, '天綫寶寶', '2024-06-13 11:21:43', '普通'),
(1, '天綫寶寶', '2024-06-13 11:21:57', '還不錯'),
(1, '海綿寶寶', '2024-06-13 19:32:27', 'yyds, 童年的神'),
(1, '黃藝降', '2024-06-13 23:57:28', '你好'),
(1, '黃藝降', '2024-06-14 00:40:39', '測試'),
(1, '黃藝降', '2024-06-14 01:13:28', '測試123'),
(1, '黃藝降', '2024-06-14 11:43:46', '主角真帥'),
(1, '黃藝降', '2024-06-14 13:18:58', '測試'),
(1, '黃藝降', '2024-06-14 13:20:09', '你好'),
(1, '黃藝降', '2024-06-14 18:29:24', '測試評論人'),
(2, '黃藝降', '2024-06-14 18:52:03', '我測試'),
(2, '海綿寶寶', '2024-06-14 18:55:25', 'yyds，沒有之一');

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `ID` int(11) NOT NULL,
  `ID_member` varchar(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `e_mail` varchar(100) DEFAULT NULL,
  `Password` varchar(20) NOT NULL,
  `Phone_number` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `member`
--

INSERT INTO `member` (`ID`, `ID_member`, `Name`, `e_mail`, `Password`, `Phone_number`) VALUES
(1, 'F131123123', '黃奕翔', 'admin', '1114576', '0912131310'),
(2, 'A114514', 'Daniel_Huang', 'feewoi@gg.com', '123', '091212'),
(5, 'F123123123', 'ayaya', 'jay6545@', '123', '09'),
(6, 'F131576160', 'test', 'dfgnmhg', '123', '09');

-- --------------------------------------------------------

--
-- 資料表結構 `movie`
--

CREATE TABLE `movie` (
  `Name` varchar(20) NOT NULL,
  `movie_rating` float DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `release_date` datetime DEFAULT NULL,
  `introduction` varchar(200) DEFAULT NULL,
  `rated` varchar(255) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `movie`
--

INSERT INTO `movie` (`Name`, `movie_rating`, `duration`, `release_date`, `introduction`, `rated`, `image`) VALUES
('2233', NULL, 2233, '2233-02-03 14:03:00', '23333333333333333333333333333333333333333333333333333333333333333', '輔導級', 'image/2233娘.png'),
('天綫寶寶', 3.6, 220, '2014-03-11 00:00:00', '《天線寶寶》有兩個元素：一個是「幻想園地」、一個是「真實紀錄」。「幻想園地」是指《天線寶寶》的主要場景「神奇島」(香港譯名為天線得得園)，島上有許多幻想奇觀，讓孩子有創造力、想像力；四個天線寶寶在神奇島上玩樂，彼此之間有良好的關係，沒有暴力，雖然很多事情都不懂，但是很喜歡學習。天線寶寶們是科技的產物，是幻想的人物，不等同於人類，所以不一定要有父母、兄弟姊妹等人類關係，坐下時會發出「叭」的聲音。 ', '普遍級', 'image\\166262117594.jpg'),
('少年悍將', NULL, 180, '2006-11-11 06:30:00', '在一個名叫雀躍城（Jump City）的美國城市裡，蝙蝠俠的助手羅賓剛離開高譚市，打算出來闖出自己的傳奇。 不料在制伏一名強盜之後，從外太空中飛下了一名外星女孩(俏嬌娃)為了逃離外星霸主特隆加爾的囚禁而到處破壞，試圖敲壞手上的手銬。 在與他戰鬥的途中羅賓遇上了從死亡巡邏隊裡出來的人皮獸以及正巧在附近的鋼骨， 三人在一陣混亂中解開了外星女孩的手銬，但這時一艘外星戰艦也進入地球人可以看到的範圍， 並表', '普遍級', 'image\\Teen_Titans_Go!_To_the_Movies_Poster.jpg'),
('海綿寶寶', 5, 225, '2020-10-30 12:30:00', '劇情場景設定於太平洋中，一座稱為比奇堡的城市。這部動畫除了繪製的卡通場景與人物之外，也會穿插一些真實事件或是人物，例如曾經演出海灘遊俠與霹靂遊俠的大衛·赫索霍夫，他以本人的身份特別出演了幾集。但海綿寶寶的劇情內容基本上與海洋知識無關，甚至誇大到完全不合乎科學與常識，例如海底生火、海底洗澡、海底有湖（酷樂湖）、魚在湖（酷樂湖）裡溺水、海底建築物起火燃燒等。 ', '普遍級', 'image\\22034180709084_749.jpg'),
('黃藝降', 4.22222, 12345, '2024-06-14 21:08:00', '大家好，我是黃藝降。', '保護級', 'image/IMG_4354.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `schedules`
--

CREATE TABLE `schedules` (
  `name` varchar(20) NOT NULL,
  `room` varchar(10) NOT NULL,
  `date` varchar(5) NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `schedules`
--

INSERT INTO `schedules` (`name`, `room`, `date`, `time`) VALUES
('2233', '鑽石廳', '06-15', '00:30:00'),
('黃藝降', '鑽石聽', '06-15', '13:00:00'),
('黃藝降', '鑽石聽', '06-15', '15:00:00'),
('黃藝降', '鑽石聽', '06-16', '13:00:00'),
('黃藝降', '鑽石聽', '06-16', '15:00:00'),
('黃藝降', '鑽石聽', '06-17', '13:00:00'),
('黃藝降', '鑽石廳', '11-11', '01:03:00'),
('黃藝降', '鑽石廳', '12-00', '01:03:00');

-- --------------------------------------------------------

--
-- 資料表結構 `theater`
--

CREATE TABLE `theater` (
  `Name` varchar(20) NOT NULL,
  `seat_ID` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `ticket`
--

CREATE TABLE `ticket` (
  `Movie_name` varchar(50) NOT NULL COMMENT '電影名稱',
  `Name` varchar(20) NOT NULL COMMENT '票卷名稱',
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `ticket`
--

INSERT INTO `ticket` (`Movie_name`, `Name`, `price`) VALUES
('黃藝降', 'VIP票', 300),
('黃藝降', '單身票', 500);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `comment`
--
ALTER TABLE `comment`
  ADD KEY `member_ID` (`member_ID`),
  ADD KEY `Movie_name` (`Movie_name`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`Name`);

--
-- 資料表索引 `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`name`,`date`,`time`);

--
-- 資料表索引 `theater`
--
ALTER TABLE `theater`
  ADD PRIMARY KEY (`Name`,`seat_ID`);

--
-- 資料表索引 `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`Movie_name`,`Name`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member`
--
ALTER TABLE `member`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`member_ID`) REFERENCES `member` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`Movie_name`) REFERENCES `movie` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`name`) REFERENCES `movie` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`Movie_name`) REFERENCES `movie` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
