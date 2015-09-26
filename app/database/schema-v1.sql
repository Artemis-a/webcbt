CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `database_version` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `is_admin` int(1) NOT NULL,
  `timezone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateformat_php` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateformat_cal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateformat_js` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_verified` int(1) NOT NULL,
  `email_verified` int(1) NOT NULL,
  `email_token` varchar(255) COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `status` int(1) NOT NULL,
  `last_login` datetime NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `distortions` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO `distortions` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'All-or-nothing / Black and white thinking', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 'Overgeneralization (always, never, etc)', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 'Mental Filter', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 'Discounting the positive', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 'Catastrophizing', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 'Jumping to conclusions - Mind reading', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 'Jumping to conclusions - Fortune telling', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 'Magnifications', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 'Emotional reasoning', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(10, '"Should", "Must" statements', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 'Labeling', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(12, 'Personalization and blame', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

CREATE TABLE IF NOT EXISTS `feelings` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(18) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `symptoms` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(18) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(18) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `color` char(6) NOT NULL,
  `background` char(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `cbts` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(18) NOT NULL,
  `tag_id` bigint(18) DEFAULT NULL,
  `date` datetime NOT NULL,
  `situation` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_resolved` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `cbt_thoughts` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `cbt_id` bigint(18) NOT NULL,
  `thought` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_disputed` int(1) NOT NULL,
  `dispute` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `balanced_thoughts` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cbt_id` (`cbt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100;

CREATE TABLE IF NOT EXISTS `cbt_feelings` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `cbt_id` bigint(18) NOT NULL,
  `feeling_id` bigint(18) NOT NULL,
  `intensity` int(3) NOT NULL,
  `status` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cbt_id` (`cbt_id`),
  KEY `feeling_id` (`feeling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100;

CREATE TABLE IF NOT EXISTS `cbt_symptoms` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `cbt_id` bigint(18) NOT NULL,
  `symptom_id` bigint(18) NOT NULL,
  `intensity` int(3) NOT NULL,
  `status` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cbt_id` (`cbt_id`),
  KEY `symptom_id` (`symptom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100;

CREATE TABLE IF NOT EXISTS `cbt_behaviours` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `cbt_id` bigint(18) NOT NULL,
  `behaviour` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cbt_id` (`cbt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100;

CREATE TABLE IF NOT EXISTS `cbt_thought_distortions` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `cbt_thought_id` bigint(18) NOT NULL,
  `distortion_id` bigint(18) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cbt_thought_id` (`cbt_thought_id`),
  KEY `distortion_id` (`distortion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100;

ALTER TABLE `cbts`
  ADD CONSTRAINT `fk_cbts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cbts_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `cbt_behaviours`
  ADD CONSTRAINT `fk_cbt_behaviours_cbt_id` FOREIGN KEY (`cbt_id`) REFERENCES `cbts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `cbt_feelings`
  ADD CONSTRAINT `fk_cbt_feelings_feeling_id` FOREIGN KEY (`feeling_id`) REFERENCES `feelings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cbt_feelings_cbt_id` FOREIGN KEY (`cbt_id`) REFERENCES `cbts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `cbt_symptoms`
  ADD CONSTRAINT `fk_cbt_symptoms_symptom_id` FOREIGN KEY (`symptom_id`) REFERENCES `symptoms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cbt_symptoms_cbt_id` FOREIGN KEY (`cbt_id`) REFERENCES `cbts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `cbt_thoughts`
  ADD CONSTRAINT `fk_cbt_thoughts_cbt_id` FOREIGN KEY (`cbt_id`) REFERENCES `cbts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `cbt_thought_distortions`
  ADD CONSTRAINT `fk_cbt_thought_distortions_distortion_id` FOREIGN KEY (`distortion_id`) REFERENCES `distortions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cbt_thought_distortions_cbt_thought_id` FOREIGN KEY (`cbt_thought_id`) REFERENCES `cbt_thoughts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `feelings`
  ADD CONSTRAINT `fk_feelings_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `symptoms`
  ADD CONSTRAINT `fk_symptoms_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tags`
  ADD CONSTRAINT `fk_tags_user_id` FOREIGN KEY (`user_id`) REFERENCES `cbts` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
