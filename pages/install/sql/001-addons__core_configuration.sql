CREATE TABLE IF NOT EXISTS `addons__core_configuration` (
  `id`            INT(11)      NOT NULL,
  `addon`         VARCHAR(256) NOT NULL,
  `name`          VARCHAR(256) NOT NULL,
  `value`         VARCHAR(256) NOT NULL,
  `long_name`     VARCHAR(256) NOT NULL,
  `long_details`  LONGTEXT     NOT NULL,
  `preg_replace`  VARCHAR(256) NOT NULL,
  `extra`         TEXT         NOT NULL,
  `extra_details` TEXT         NOT NULL
);

ALTER TABLE `addons__core_configuration`
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `addons__core_configuration`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `addons__core_configuration`
(`id`, `addon`, `name`, `value`, `long_name`, `long_details`, `preg_replace`, `extra`, `extra_details`) VALUES
  (0, '_core', 'Example Name', 'nuttin', 'This is an example name!', 'I\'m just here for the ride!', '', '', '');