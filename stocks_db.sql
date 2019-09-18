SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `<database name>`
--

-- --------------------------------------------------------

--
-- Table structure for table `securities`
--

CREATE TABLE IF NOT EXISTS `securities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isin` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `security_code` text NOT NULL,
  `industry` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isin` (`isin`(20))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE IF NOT EXISTS `trades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isin` text NOT NULL,
  `date` date NOT NULL,
  `high` float NOT NULL,
  `low` float NOT NULL,
  `vwap` float NOT NULL,
  `vol` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=254301 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
