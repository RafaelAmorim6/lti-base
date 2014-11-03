

-- --------------------------------------------------------
--
-- Table structure for table `session`
--
DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
   `id` VARCHAR(127) NOT NULL,
   `data` LONGTEXT,
   `modified` DATETIME NOT NULL,
   `created` DATETIME NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB;


-- --------------------------------------------------------
--
-- Table structure for table `config`
--
DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` VARCHAR(64) NOT NULL DEFAULT '',
  `key` VARCHAR(64) NOT NULL DEFAULT '',
  `value` TEXT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `group` (`group`)
) ENGINE=InnoDB;

INSERT INTO `config` (`group`, `key`, `value`) VALUES
('system', 'system.site.title', 'Tk004'),
('system', 'system.site.email', 'email@example.com'),
('system', 'system.site.description', ''),
('system', 'system.site.keywords', ''),
('system', 'mail.sig', '\nThank You!'),
('system', 'system.maintenanceMode', '0'),
('system', 'system.log.emailLevel', '\\Tk\\Log\\Log::EMAIL'),
('system', 'system.timezone', 'Australia/Victoria'),
('system', 'system.language', 'en_AU'),
('system', 'system.filesystem.ftpEnable', '0'),
('system', 'system.ftp.host', 'localhost'),
('system', 'system.ftp.user', ''),
('system', 'system.ftp.pass', ''),
('system', 'system.ftp.port', '21'),
('system', 'system.ftp.remotePath', ''),
('system', 'system.ftp.retries', '3'),
('system', 'system.ftp.ftpPasv', '0'),
('system', 'system.site.email.support', ''),
('system', 'system.site.email.dev', ''),
('system', 'system.google.apikey', ''),
('system', 'system.site.proxy', ''),
('system', 'system.enableSsl', ''),
('system', 'system.maintenance.enable', ''),
('system', 'system.maintenance.message', '<h2>Down For Maintenance.</h2><p>The site is currently offline for maintenance, please try again soon.</p>'),
('system', 'system.maintenance.access.ip', ''),
('system', 'system.maintenance.access.permission', 'admin');







-- --------------------------------------------------------
--
-- Table structure for table `lti_consumer`
--
CREATE TABLE IF NOT EXISTS `lti_consumer` (
  `consumer_key` varchar(50) NOT NULL,
  `name` varchar(45) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `lti_version` varchar(12) DEFAULT NULL,
  `consumer_name` varchar(255) DEFAULT NULL,
  `consumer_version` varchar(255) DEFAULT NULL,
  `consumer_guid` varchar(255) DEFAULT NULL,
  `css_path` varchar(255) DEFAULT NULL,
  `protected` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `enable_from` datetime DEFAULT NULL,
  `enable_until` datetime DEFAULT NULL,
  `last_access` date DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`consumer_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `lti_context`
--
CREATE TABLE IF NOT EXISTS `lti_context` (
  `consumer_key` varchar(50) NOT NULL,
  `context_id` varchar(50) NOT NULL,
  `lti_context_id` varchar(50) DEFAULT NULL,
  `lti_resource_id` varchar(50) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `settings` text,
  `primary_consumer_key` varchar(50) DEFAULT NULL,
  `primary_context_id` varchar(50) DEFAULT NULL,
  `share_approved` tinyint(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`consumer_key`,`context_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `lti_nonce`
--
CREATE TABLE IF NOT EXISTS `lti_nonce` (
  `consumer_key` varchar(50) NOT NULL,
  `value` varchar(32) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`consumer_key`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `lti_share_key`
--
CREATE TABLE IF NOT EXISTS `lti_share_key` (
  `share_key_id` varchar(32) NOT NULL,
  `primary_consumer_key` varchar(50) NOT NULL,
  `primary_context_id` varchar(50) NOT NULL,
  `auto_approve` tinyint(1) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`share_key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `lti_user`
--
CREATE TABLE IF NOT EXISTS `lti_user` (
  `consumer_key` varchar(50) NOT NULL,
  `context_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `lti_result_sourcedid` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`consumer_key`,`context_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

