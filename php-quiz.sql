-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2021 at 11:00 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php-quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(250) NOT NULL,
  `language-HexColor` varchar(7) NOT NULL,
  `text-HexColor` varchar(7) NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `language`, `language-HexColor`, `text-HexColor`, `status`) VALUES
(1, 'HTML', '#f26525', '#fff', 'enabled'),
(2, 'CSS', '#24abe2', '#fff', 'enabled'),
(3, 'JS', '#f0da50', '#000', 'enabled'),
(4, 'PHP', '#5f83bb', '#000', 'enabled'),
(5, 'SQL', '#e0e1e3', '#e0963b', 'enabled'),
(6, 'JAVA', '#f99823', '#fff', 'disabled'),
(7, 'C++', '#076390', '#fff', 'disabled'),
(8, 'C#', '#652e93', '#fff', 'disabled');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(250) NOT NULL,
  `option1` varchar(250) NOT NULL,
  `option2` varchar(250) NOT NULL,
  `option3` varchar(250) NOT NULL,
  `option4` varchar(250) NOT NULL,
  `answer` varchar(250) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `category_id`) VALUES
(1, 'Ի՞նչ է HTML-ը', 'Ծրագրավորման լեզու', 'Սքրիփթային լեզու', 'Նշագրման լեզու', 'HyperText գրադարան', 'Նշագրման լեզու', 1),
(2, 'Ո՞ր հիմնական մասերից է բաղկացած HTML ֆայլը', 'Eyes-ից և Mouth-ից', 'Header-ից և Footer-ից', 'Head-ից և Body-ից', 'Hands-ից and Feet-ից', 'Head-ից և Body-ից', 1),
(3, 'Ի՞նչ է պարունակում href հատկանիշը', 'Արդյոք նոր էջը պետք է բացվի նույն կամ նոր պատուհանում', 'Փոխանցվող էջի URL-ը', 'Փոխանցվող վեբ էջի անվանումը', 'Վեբ էջի անվանումը', 'Փոխանցվող էջի URL-ը', 1),
(4, 'Ընտրեք ճիշտ HTML թեգը ամենամեծ վերնագրի համար', '<head>', '<heading>', '<h1>', '<h6>', '<h1>', 1),
(5, '\nՈ՞րն է CSS-ի ճիշտ շարահյուսությունը բոլոր տարրերը p տարրերը թավ դարձնելու համար', 'p{font-weight: bold;}', 'p{text-size: bold;}', '<p style="font-size:bold">', '<p style="text-size:bold">', 'p{font-weight: bold;}', 2),
(6, 'Ինչպե՞ս անել, որ ցուցակը չցուցադրի կետերը', 'list: none', 'bulletpoints: none', 'list-style-type: none', 'list-style-type: no-bullet', 'list-style-type: none', 2),
(7, 'Background-clip հատկության մեջ ո՞ր արժեքն է թույլ տալիս ստեղծել թափանցիկ եզրագծեր', 'margin-box', 'border-box', 'padding-box', 'none', 'padding-box', 2),
(8, 'Ինչպե՞ս տպել «JavaScript-ը հիանալի է»: console-ում', 'console.log("JavaScript-ը հիանալի է")', 'console.write("JavaScript-ը հիանալի է")', 'document.write("JavaScript-ը հիանալի է")', 'debug.log("JavaScript-ը հիանալի է")', 'console.log("JavaScript-ը հիանալի է")', 3),
(9, 'Ո՞րն է այս կոդի արդյունքը.\n<br>\n// x = 8;\n<br>\nx = 2\n<br>\n// x = 3\n<br>\nconsole.log(x);', '3', '8', '2', '0', '2', 3),
(10, 'Ո՞րն է հետևյալ արտահայտության արդյունքը.\r\n<br>\r\nfunction multNumbers(a,b){\r\n    var c = a * b;\r\n}\r\nmultNumbers(2,6);', 'ոչինչ', '12', '24', '5', '12', 3),
(11, 'Հետևյալներից ո՞րն է ճիշտ շարահյուսությունը', 'echo "(<p> Hello.</p>);', 'echo (<p> ''Hello''</p>);', 'echo "<p>''Hello''</p>)";', 'echo "<p> Hello.</p>";', 'echo "<p> Hello.</p>";', 4),
(12, 'Ո՞ր նշանն է համապատասխանում տրամաբանական OR օպերատորին', '^', '|', '||', '&&', '||', 4),
(13, 'Որքա՞ն է $b-ի արժեքը<br>$a=2; $b=$a++;', '4', '2', '3', '5', '2', 4),
(14, 'Տվյալների բազան բաղկացած է', 'Սյուններից', 'Տողերից', 'Աղյուսակներից', 'Սյուներից և աղյուսակներից', 'Աղյուսակներից', 5),
(15, 'Ինչու՞ օգտագործել հիմնական բանալիները:', 'Դա SQL ստանդարտ է', 'Տողերից յուրաքանչյուրը ինդենտիֆիկացնելու համար', 'Պարզապես հաճույքի համար', 'Տող ստեղծելու համար', 'Տողերից յուրաքանչյուրը ինդենտիֆիկացնելու համար', 5),
(16, 'Ո՞ր ընտրությունն է աղյուսակի անվանումը փոխելու ճիշտ հրամանը', 'RENAME', 'CHANGE NAME', 'SELECT', 'MODIFY', 'RENAME', 5),
(17, 'Ինչպե՞ս է կոչվում գումարը հաշվարկելու ֆունկցիան:', 'SUM', 'AVG', 'SQRT', 'AGGR', 'SUM', 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
