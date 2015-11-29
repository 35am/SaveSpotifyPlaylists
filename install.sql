-- playlist
CREATE TABLE `playlist` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`date_create` TIMESTAMP NULL DEFAULT NULL,
	`date_update` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
);

-- playlist_song
CREATE TABLE `playlist_song` (
	`id_playlist` INT(11) NOT NULL,
	`id_song` INT(11) NOT NULL,
	`date_create` TIMESTAMP NULL DEFAULT NULL,
	`date_update` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id_playlist`, `id_song`),
	INDEX `FK_playlist_song_song` (`id_song`, `id_playlist`),
	CONSTRAINT `FK_playlist_song_playlist` FOREIGN KEY (`id_playlist`) REFERENCES `playlist` (`id`),
	CONSTRAINT `FK_playlist_song_song` FOREIGN KEY (`id_song`) REFERENCES `song` (`id`)
);

-- song
CREATE TABLE `song` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`singer` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`album` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`spotify_url` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`spotify_id` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`date_create` TIMESTAMP NULL DEFAULT NULL,
	`date_update` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
);

/* *** Triggers : NOT MANDATORY *** */

-- playlist
CREATE TRIGGER `playlist_create` BEFORE INSERT ON `playlist` FOR EACH ROW SET
NEW.date_create = NOW(),
NEW.date_update = NOW();

CREATE TRIGGER `playlist_update` BEFORE UPDATE ON `playlist` FOR EACH ROW SET
NEW.date_update =  NOW(),
NEW.date_create = OLD.date_create;

-- playlist_song
CREATE TRIGGER `playlist_song_create` BEFORE INSERT ON `playlist_song` FOR EACH ROW SET
NEW.date_create = NOW(),
NEW.date_update = NOW();

CREATE TRIGGER `playlist_song_update` BEFORE UPDATE ON `playlist_song` FOR EACH ROW SET
NEW.date_update =  NOW(),
NEW.date_create = OLD.date_create;

-- song
CREATE TRIGGER `song_create` BEFORE INSERT ON `song` FOR EACH ROW SET
NEW.date_create = NOW(),
NEW.date_update = NOW();

CREATE TRIGGER `song_update` BEFORE UPDATE ON `song` FOR EACH ROW SET
NEW.date_update =  NOW(),
NEW.date_create = OLD.date_create;