DROP TABLE IF EXISTS `#__jinc_newsletter`;
CREATE TABLE IF NOT EXISTS `#__jinc_newsletter` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `asset_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(64) NOT NULL,
  `type` int NOT NULL default '1',
  `description` mediumtext,
  `published` tinyint(1) NOT NULL default '0',
  `created` timestamp NOT NULL,
  `lastsent` timestamp NOT NULL,
  `sendername` varchar(255) NOT NULL,
  `senderaddr` varchar(255) NOT NULL,
  `welcome_subject` varchar(255) default '',
  `welcome` mediumtext,
  `welcome_created` mediumtext,
  `disclaimer` mediumtext,
-- Added from JINC 0.4 for public newsletters
  `optin_subject` varchar(255) default '',
  `optin` mediumtext,
  `optinremove_subject` varchar(255) default '',
  `optinremove` mediumtext,
-- Added from JINC 0.5 for template management
  `default_template` int NOT NULL default 0,
-- Added from JINC 0.6 for onSubscription newsletter management
  `on_subscription` TINYINT(1) NOT NULL default 0,
-- Added from JINC 0.7 
  `jcontact_enabled` TINYINT(1) NOT NULL default 0,
  `front_theme` varchar(64) NOT NULL default '',
  `front_max_msg` int NOT NULL default 0,
  `front_type` int NOT NULL default 0,
  `attribs` TEXT,
-- Added from JINC 0.8
  `captcha` int NOT NULL default 0,
  `replyto_name` varchar(255),
  `replyto_addr` varchar(255),
  `notify` TINYINT(1) NOT NULL default 0,
-- Added from JINC 0.9
  `notice_id` int(10) UNSIGNED NOT NULL default 0,
  `input_style` int NOT NULL default 1,
  PRIMARY KEY  (`id`)
);

DROP TABLE IF EXISTS `#__jinc_message`;
CREATE TABLE IF NOT EXISTS `#__jinc_message` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `news_id` int(10) unsigned NOT NULL,
  `subject` varchar(128) NOT NULL,
  `body` mediumtext NOT NULL,
  `plaintext` tinyint(1) NOT NULL default 0,
  `bulkmail` tinyint(1) NOT NULL default 0,
  `datasent` timestamp NOT NULL default 0,
-- Changed from JINC 0.8
  `attachment` TEXT,
  PRIMARY KEY  (`id`)
);

DROP TABLE IF EXISTS `#__jinc_subscriber`;
CREATE TABLE IF NOT EXISTS `#__jinc_subscriber` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `news_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned,
  `datasub` timestamp NULL,
  `email` varchar(127) NOT NULL,
  `random` varchar(32),
  PRIMARY KEY  (`id`)
);

-- Added from JINC 0.5
DROP TABLE IF EXISTS `#__jinc_template`;
CREATE TABLE IF NOT EXISTS `#__jinc_template` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `body` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
);

-- Added from JINC 0.6
DROP TABLE IF EXISTS `#__jinc_stats_event`;
CREATE TABLE IF NOT EXISTS `#__jinc_stats_event` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` int NOT NULL default '0',
  `date` timestamp NOT NULL,
  `news_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
);

-- Added from JINC 0.7
DROP TABLE IF EXISTS `#__jinc_process`;
CREATE TABLE IF NOT EXISTS `#__jinc_process` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `msg_id` int(10) unsigned NOT NULL,
  `status` int(2) unsigned NOT NULL default 0,
  `start_time` timestamp NOT NULL default 0,
  `last_update_time` timestamp NOT NULL,
  `last_subscriber_time` timestamp NOT NULL default 0,
  `last_subscriber_id` int(10) unsigned NOT NULL default 0,
  `sent_messages` int(10) unsigned NOT NULL default 0,
  `sent_success` int(10) unsigned NOT NULL default 0,
  `client_id` varchar(32) default '',
  PRIMARY KEY  (`id`)
);

-- Added from JINC 0.7
DROP TABLE IF EXISTS `#__jinc_attribute`;
CREATE TABLE IF NOT EXISTS `#__jinc_attribute` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` int(10) unsigned NOT NULL default 0,
  `table_name` varchar(64) NOT NULL,
  `name_i18n` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY  (`name`)
);

-- Added from JINC 0.9
CREATE TABLE IF NOT EXISTS `#__jinc_attribute_name` (
    `news_id` int(10) unsigned NOT NULL,
    `id` int(10) unsigned NOT NULL,
    `value` varchar(255),
    PRIMARY KEY  (`news_id`, `id`)
);

REPLACE INTO `#__jinc_attribute` (name, description, type, name_i18n)
    VALUES ('name', 'Subscriber Name', 0, 'COM_JINC_YOUR_NAME');

DROP TABLE IF EXISTS `#__jinc_notice`;
CREATE TABLE IF NOT EXISTS `#__jinc_notice` (
    `id` int(10) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `title` varchar(255) NOT NULL,
    `bdesc` varchar(255) NOT NULL default '',
    `conditions` TEXT,
    `type` int unsigned NOT NULL default 0,
    PRIMARY KEY  (`id`)
);
