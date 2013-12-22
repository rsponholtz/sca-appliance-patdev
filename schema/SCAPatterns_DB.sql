SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `SCAPatterns`
--

-- --------------------------------------------------------

--
-- Table structure for table `Submissions`
--

CREATE TABLE IF NOT EXISTS `Submissions` (
  `PatternID` int(10) unsigned NOT NULL auto_increment COMMENT 'Unique Pattern ID',
  `Title` varchar(60) NOT NULL COMMENT 'The pattern title',
  `Description` mediumtext DEFAULT NULL COMMENT 'A brief description of the pattern',
  `Class` varchar(255) DEFAULT NULL COMMENT 'The pattern class',
  `Category` varchar(255) DEFAULT NULL COMMENT 'The pattern category, which is a subset of Class',
  `Component` varchar(255) DEFAULT NULL COMMENT 'The pattern component, which is a subset of Category',
  `Notes` mediumtext DEFAULT NULL COMMENT 'Issue and development notes',
  `PatternFile` varchar(255) DEFAULT NULL COMMENT 'The pattern filename',
  `PatternType` enum('Bash','Perl','Python','Other') NOT NULL DEFAULT 'Perl' COMMENT 'The programming language in which the pattern is written',
  `Submitted` date DEFAULT NULL COMMENT 'Date pattern request was submitted',
  `Modified` date DEFAULT NULL COMMENT 'The date the submission entry was modified',
  `Released` date DEFAULT NULL COMMENT 'The pattern release date',
  `Submitter` text NOT NULL COMMENT 'The name of the submitter',
  `Owner` text DEFAULT NULL COMMENT 'The owner developing the pattern',
  `PrimaryLink` varchar(255) DEFAULT NULL COMMENT 'The solution tag used as the primary solution link',
  `TID` varchar(512) DEFAULT NULL COMMENT 'The TID number associated with the pattern resolution',
  `BUG` varchar(512) DEFAULT NULL COMMENT 'The BUG number associated with the pattern resolution',
  `URL01` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL02` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL03` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL04` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL05` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL06` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL07` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL08` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL09` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `URL10` varchar(512) DEFAULT NULL COMMENT 'The Tag/URL pair associated with the pattern resulotion',
  `Status` enum('Proposed','Assigned','In-Progress','Complete','Staging','Released','Maintenance','Obsolete','Rejected') NOT NULL DEFAULT 'Proposed' COMMENT 'The current development state of the pattern',
  PRIMARY KEY  (`PatternID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='List of pattern submissions' AUTO_INCREMENT=1 ;


