CREATE TABLE `interview_server` (
  `id`          bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id`    bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `ip`          varchar(255)        NOT NULL DEFAULT '',
  `text`        text                    NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `interview_group` (
  `id`          bigint(20)    UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`       varchar(255)           NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `interview_ping` (
  `id`              bigint(20)      UNSIGNED NOT NULL AUTO_INCREMENT,
  `server_id`       bigint(20)      UNSIGNED NOT NULL DEFAULT '0',
  `result`          varchar(255)    NOT NULL DEFAULT '',
  `response_time`   bigint(20)      UNSIGNED NOT NULL DEFAULT '0',
  `date_update`     TIMESTAMP                NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;