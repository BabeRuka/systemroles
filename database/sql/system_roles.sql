/*
 Source Host           : localhost:3306
 Source Schema         : system_roles
 Target Server Type    : MySQL
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for system_classes
-- ----------------------------
DROP TABLE IF EXISTS `system_classes`;
CREATE TABLE `system_classes`  (
  `class_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_filename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `class_namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`class_id`) USING BTREE,
  UNIQUE INDEX `role_name`(`class_name` ASC) USING BTREE,
  UNIQUE INDEX `role_guard_name`(`class_filename` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_classes
-- ----------------------------
 
-- ----------------------------
-- Table structure for system_classes_in
-- ----------------------------
DROP TABLE IF EXISTS `system_classes_in`;
CREATE TABLE `system_classes_in`  (
  `in_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `in_role` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`in_id`) USING BTREE,
  UNIQUE INDEX `in_name_classid_roleid`(`class_id` ASC, `role_id` ASC) USING BTREE,
  INDEX `sci_role_id`(`role_id` ASC) USING BTREE,
  CONSTRAINT `sci_class_id` FOREIGN KEY (`class_id`) REFERENCES `system_classes` (`class_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sci_role_id` FOREIGN KEY (`role_id`) REFERENCES `system_roles` (`role_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_classes_in
-- ----------------------------
 
-- ----------------------------
-- Table structure for system_roles
-- ----------------------------
DROP TABLE IF EXISTS `system_roles`;
CREATE TABLE `system_roles`  (
  `role_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role_lang_name` enum('eng') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'eng',
  `role_role_class` enum('RolesController') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'RolesController',
  `role_sequence` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`) USING BTREE,
  UNIQUE INDEX `role_name`(`role_name` ASC) USING BTREE,
  UNIQUE INDEX `role_guard_name`(`role_guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_roles
-- ----------------------------
INSERT INTO `system_roles` VALUES (1, 'Super Admin', 'super_admin', NULL, 'eng', 'RolesController', 1, '2025-05-27 16:01:33', '2025-05-27 16:01:42');
INSERT INTO `system_roles` VALUES (2, 'Admin', 'admin', NULL, 'eng', 'RolesController', 2, '2025-05-27 16:01:56', '2025-05-27 16:03:01');
INSERT INTO `system_roles` VALUES (3, 'Manager', 'manager', NULL, 'eng', 'RolesController', 3, '2025-05-27 16:05:11', '2025-05-27 17:33:57');
INSERT INTO `system_roles` VALUES (4, 'User', 'user', NULL, 'eng', 'RolesController', 4, '2025-05-27 16:05:25', '2025-05-27 17:34:01');

-- ----------------------------
-- Table structure for system_roles_in
-- ----------------------------
DROP TABLE IF EXISTS `system_roles_in`;
CREATE TABLE `system_roles_in`  (
  `in_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `in_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_role` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '0',
  `in_guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_sequence` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`in_id`) USING BTREE,
  UNIQUE INDEX `in_name_role_id`(`in_name` ASC, `role_id` ASC) USING BTREE,
  UNIQUE INDEX `in_guard_name_role`(`in_guard_name` ASC, `role_id` ASC) USING BTREE,
  INDEX `sri_role_id`(`role_id` ASC) USING BTREE,
  CONSTRAINT `sri_role_id` FOREIGN KEY (`role_id`) REFERENCES `system_roles` (`role_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_roles_in
-- ----------------------------
 
-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles`  (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_role` bigint UNSIGNED NOT NULL,
  `role_admin` int NULL DEFAULT NULL,
  `role_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `user_role`(`user_role` ASC) USING BTREE,
  INDEX `role_type`(`role_type` ASC) USING BTREE,
  INDEX `role_admin`(`role_admin` ASC) USING BTREE,
  CONSTRAINT `ursr_user_role` FOREIGN KEY (`user_role`) REFERENCES `system_roles` (`role_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `uru_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
 
-- ----------------------------
-- Table structure for user_roles_history
-- ----------------------------
DROP TABLE IF EXISTS `user_roles_history`;
CREATE TABLE `user_roles_history`  (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `user_role` bigint UNSIGNED NULL DEFAULT NULL,
  `role_admin` int NULL DEFAULT NULL,
  `role_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`history_id`) USING BTREE,
  INDEX `role_id`(`role_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `user_role`(`user_role` ASC) USING BTREE,
  INDEX `role_admin`(`role_admin` ASC) USING BTREE,
  INDEX `role_type`(`role_type` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_roles_history
-- ----------------------------

-- ----------------------------
-- Table structure for user_roles_in
-- ----------------------------
DROP TABLE IF EXISTS `user_roles_in`;
CREATE TABLE `user_roles_in`  (
  `perm_id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `in_id` bigint UNSIGNED NOT NULL,
  `in_role` int NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`perm_id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `user_role`(`in_id` ASC) USING BTREE,
  INDEX `role_admin`(`in_role` ASC) USING BTREE,
  CONSTRAINT `uri_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `urisri_in_id` FOREIGN KEY (`in_id`) REFERENCES `system_roles_in` (`in_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_roles_in
-- ----------------------------
 
 

-- ----------------------------
-- Triggers structure for table system_roles
-- ----------------------------
DROP TRIGGER IF EXISTS `protect_roles_deletion`;
delimiter ;;
CREATE TRIGGER `protect_roles_deletion` BEFORE DELETE ON `system_roles` FOR EACH ROW BEGIN
  IF old.role_name = 'super_admin' OR old.role_name = 'admin'  THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Admin deletion prevented';
  END IF;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
