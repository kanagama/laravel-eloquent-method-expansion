CREATE TABLE IF NOT EXISTS `prefectures` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '都道府県id',
  `name` varchar(255) NOT NULL COMMENT '都道府県名',
  `created_at` datetime(6) NOT NULL COMMENT '登録日時',
  `updated_at` datetime(6) NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '市区町村id',
  `prefecture_id` int unsigned NOT NULL COMMENT '都道府県id',
  `name` varchar(255) NOT NULL COMMENT '市区町村名',
  `created_at` datetime(6) NOT NULL COMMENT '登録日時',
  `updated_at` datetime(6) NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `cities_ifbx_1` (`prefecture_id`),
  CONSTRAINT `cities_ifbx_1` FOREIGN KEY (`prefecture_id`) REFERENCES `prefectures` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
);
