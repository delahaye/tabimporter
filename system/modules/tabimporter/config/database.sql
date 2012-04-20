-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_tabimporter_jobs`
-- 

CREATE TABLE `tl_tabimporter_jobs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `keepVersions` int(10) unsigned NOT NULL default '3',
  `token` varchar(255) NOT NULL default '',
  `lastrun` int(10) unsigned NOT NULL default '0',
  `status` longtext NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_tabimporter_steps`
-- 

CREATE TABLE `tl_tabimporter_steps` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `published` char(1) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `abortOnError` char(1) NOT NULL default '',
  `action` varchar(32) NOT NULL default '',
  `tableimport` int(10) unsigned NOT NULL default '0',
  `sqlData` text NULL,
  `hook` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_tabimporter_tables`
-- 

CREATE TABLE `tl_tabimporter_tables` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `abortOnError` char(1) NOT NULL default '',
  `targetTable` varchar(255) NOT NULL default '',
  `fieldsTarget` text NULL,
  `sourceType` varchar(32) NOT NULL default '',
  `sourceTable` varchar(255) NOT NULL default '',
  `useTmpTable` char(1) NOT NULL default '',
  `sourceFile` varchar(255) NOT NULL default '',
  `fieldCount` int(10) unsigned NOT NULL default '0',
  `hasFieldnames` char(1) NOT NULL default '',
  `fieldDelimiter` varchar(255) NOT NULL default '',
  `fieldsSource` text NULL,
  `uniqueSource` varchar(255) NOT NULL default '',
  `uniqueTarget` varchar(255) NOT NULL default '',
  `deleteOnStart` blob NULL,
  `deleteOnKey` char(1) NOT NULL default '',
  `deleteKeyField` varchar(255) NOT NULL default '',
  `deleteKeyValue` varchar(255) NOT NULL default '',
  `allowInsert` char(1) NOT NULL default '',
  `allowUpdate` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_tabimporter_fields`
-- 

CREATE TABLE `tl_tabimporter_fields` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `published` char(1) NOT NULL default '',
  `fieldname` varchar(255) NOT NULL default '',
  `allowInsert` char(1) NOT NULL default '',
  `typeInsert` varchar(255) NOT NULL default '',
  `fieldInsert` varchar(255) NOT NULL default '',
  `modeInsert` varchar(32) NOT NULL default '',
  `fixInsert` varchar(255) NOT NULL default '',
  `sqlInsert` text NULL,
  `hookInsert` varchar(255) NOT NULL default '',
  `tagTypeSourceInsert` varchar(32) NOT NULL default '',
  `sourceDelimiterInsert` varchar(255) NOT NULL default '',
  `tagTypeTargetInsert` varchar(32) NOT NULL default '',
  `targetDelimiterInsert` varchar(255) NOT NULL default '',
  `allowUpdate` char(1) NOT NULL default '',
  `typeUpdate` varchar(255) NOT NULL default '',
  `fieldUpdate` varchar(255) NOT NULL default '',
  `modeUpdate` varchar(32) NOT NULL default '',
  `addDelimiter` varchar(255) NOT NULL default '',
  `tagMode` varchar(32) NOT NULL default '',
  `tagTypeSourceUpdate` varchar(32) NOT NULL default '',
  `sourceDelimiterUpdate` varchar(255) NOT NULL default '',
  `tagTypeTargetUpdate` varchar(32) NOT NULL default '',
  `targetDelimiterUpdate` varchar(255) NOT NULL default '',
  `fixUpdate` varchar(255) NOT NULL default '',
  `sqlUpdate` text NULL,
  `hookUpdate` varchar(255) NOT NULL default '',
  `initialValue` varchar(32) NOT NULL default '',
  `start` int(10) unsigned NOT NULL default '0',
  `step` int(10) unsigned NOT NULL default '0',
  `fillCharInsert` char(1) NOT NULL default '',
  `fieldLengthInsert` int(10) unsigned NOT NULL default '0',
  `expandStringInsert` char(255) NOT NULL default '',
  `expandSideInsert` varchar(32) NOT NULL default '',
  `dateValInsert` int(10) unsigned NOT NULL default '0',
  `timeValInsert` varchar(8) NOT NULL default '00:00:00',
  `dateFormatInsert` char(255) NOT NULL default '',
  `fillCharUpdate` char(1) NOT NULL default '',
  `fieldLengthUpdate` int(10) unsigned NOT NULL default '0',
  `expandStringUpdate` char(255) NOT NULL default '',
  `expandSideUpdate` varchar(32) NOT NULL default '',
  `dateValUpdate` int(10) unsigned NOT NULL default '0',
  `timeValUpdate` varchar(8) NOT NULL default '00:00:00',
  `dateFormatUpdate` char(255) NOT NULL default '',
  `tstampUpInsert` varchar(64) NOT NULL default '0',
  `tstampUpUpdate` varchar(64) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_tabimporter_runs`
-- 

CREATE TABLE `tl_tabimporter_runs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `job` varchar(255) NOT NULL default '',
  `begin` int(10) unsigned NOT NULL default '0',
  `end` int(10) unsigned NOT NULL default '0',
  `status` varchar(255) NOT NULL default '',
  `user` int(10) unsigned NOT NULL default '0',
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_tabimporter_runsteps`
-- 

CREATE TABLE `tl_tabimporter_runsteps` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `step` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  `details` text NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;