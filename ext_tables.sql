#
# Table structure for table 'tx_kurzflowplayer_domain_model_administration'
#
CREATE TABLE tx_kurzflowplayer_domain_model_administration
(

    uid              int(11)                          NOT NULL auto_increment,
    pid              int(11)              DEFAULT '0' NOT NULL,

    tstamp           int(11) unsigned     DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned     DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned     DEFAULT '0' NOT NULL,
    deleted          smallint(5) unsigned DEFAULT '0' NOT NULL,
    hidden           smallint(5) unsigned DEFAULT '0' NOT NULL,
    starttime        int(11) unsigned     DEFAULT '0' NOT NULL,
    endtime          int(11) unsigned     DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)              DEFAULT '0' NOT NULL,
    t3ver_id         int(11)              DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)              DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)         DEFAULT ''  NOT NULL,
    t3ver_state      smallint(6)          DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)              DEFAULT '0' NOT NULL,
    t3ver_count      int(11)              DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)              DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)              DEFAULT '0' NOT NULL,

    sys_language_uid int(11)              DEFAULT '0' NOT NULL,
    l10n_parent      int(11)              DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,
    l10n_state       text,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_kurzflowplayer_domain_model_workspace'
#
CREATE TABLE tx_kurzflowplayer_domain_model_workspace
(

    uid              int(11)                          NOT NULL auto_increment,
    pid              int(11)              DEFAULT '0' NOT NULL,

    site_id          varchar(255)         DEFAULT ''  NOT NULL,
    name             varchar(255)         DEFAULT ''  NOT NULL,
    api_key          varchar(255)         DEFAULT ''  NOT NULL,

    tstamp           int(11) unsigned     DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned     DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned     DEFAULT '0' NOT NULL,
    deleted          smallint(5) unsigned DEFAULT '0' NOT NULL,
    hidden           smallint(5) unsigned DEFAULT '0' NOT NULL,
    starttime        int(11) unsigned     DEFAULT '0' NOT NULL,
    endtime          int(11) unsigned     DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)              DEFAULT '0' NOT NULL,
    t3ver_id         int(11)              DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)              DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)         DEFAULT ''  NOT NULL,
    t3ver_state      smallint(6)          DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)              DEFAULT '0' NOT NULL,
    t3ver_count      int(11)              DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)              DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)              DEFAULT '0' NOT NULL,

    sys_language_uid int(11)              DEFAULT '0' NOT NULL,
    l10n_parent      int(11)              DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,
    l10n_state       text,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);

CREATE TABLE sys_file_reference
(
    autopause tinyint     default '0',
    videoloop tinyint     default '0',
    muted     tinyint     default '0',
    width     varchar(60) DEFAULT '',
    height    varchar(60) DEFAULT '',
    player    varchar(255) DEFAULT ''
);

#
# Table structure for table 'tx_kurzflowplayer_domain_model_player'
#
CREATE TABLE tx_kurzflowplayer_domain_model_player
(

    uid              int(11)                          NOT NULL auto_increment,
    pid              int(11)              DEFAULT '0' NOT NULL,

    player_id        varchar(255)         DEFAULT ''  NOT NULL,
    player_name      varchar(255)         DEFAULT ''  NOT NULL,
    workspace        int(11) unsigned     DEFAULT '0',

    tstamp           int(11) unsigned     DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned     DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned     DEFAULT '0' NOT NULL,
    deleted          smallint(5) unsigned DEFAULT '0' NOT NULL,
    hidden           smallint(5) unsigned DEFAULT '0' NOT NULL,
    starttime        int(11) unsigned     DEFAULT '0' NOT NULL,
    endtime          int(11) unsigned     DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)              DEFAULT '0' NOT NULL,
    t3ver_id         int(11)              DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)              DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)         DEFAULT ''  NOT NULL,
    t3ver_state      smallint(6)          DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)              DEFAULT '0' NOT NULL,
    t3ver_count      int(11)              DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)              DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)              DEFAULT '0' NOT NULL,

    sys_language_uid int(11)              DEFAULT '0' NOT NULL,
    l10n_parent      int(11)              DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,
    l10n_state       text,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);


