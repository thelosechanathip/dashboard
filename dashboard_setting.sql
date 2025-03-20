/*
 Navicat Premium Dump SQL

 Source Server         : 10.10.10.25_3306
 Source Server Type    : MariaDB
 Source Server Version : 100522 (10.5.22-MariaDB-log)
 Source Host           : 10.10.10.25:3306
 Source Schema         : dashboard_setting

 Target Server Type    : MariaDB
 Target Server Version : 100522 (10.5.22-MariaDB-log)
 File Encoding         : 65001

 Date: 20/03/2025 15:48:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for accessibility
-- ----------------------------
DROP TABLE IF EXISTS `accessibility`;
CREATE TABLE `accessibility`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_accessibility_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `sidebar_sub1_menu_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `accessibility_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`, `type_id`, `status_id`, `type_accessibility_id`, `module_id`, `sidebar_sub1_menu_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( สิทธิ์การเข้าถึง )' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for accessibility_log
-- ----------------------------
DROP TABLE IF EXISTS `accessibility_log`;
CREATE TABLE `accessibility_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าถึงสิทธิ์ต่างๆ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for advance_care_plan
-- ----------------------------
DROP TABLE IF EXISTS `advance_care_plan`;
CREATE TABLE `advance_care_plan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acp_vn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `acp_hn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `acp_cid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `acp_fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `detail_of_talking_with_patients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_acp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `acp_staff` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( Advance Care Plan )' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for anc_quality
-- ----------------------------
DROP TABLE IF EXISTS `anc_quality`;
CREATE TABLE `anc_quality`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recorder_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lmp` date NULL DEFAULT NULL,
  `edc` date NULL DEFAULT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `shph` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telephone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `week_12` date NULL DEFAULT NULL,
  `week_15` date NULL DEFAULT NULL,
  `week_18` date NULL DEFAULT NULL,
  `week_19` date NULL DEFAULT NULL,
  `week_20` date NULL DEFAULT NULL,
  `week_21` date NULL DEFAULT NULL,
  `week_26` date NULL DEFAULT NULL,
  `week_27` date NULL DEFAULT NULL,
  `week_30` date NULL DEFAULT NULL,
  `week_31` date NULL DEFAULT NULL,
  `week_34` date NULL DEFAULT NULL,
  `week_35` date NULL DEFAULT NULL,
  `week_36` date NULL DEFAULT NULL,
  `week_37` date NULL DEFAULT NULL,
  `week_38` date NULL DEFAULT NULL,
  `week_39` date NULL DEFAULT NULL,
  `week_40` date NULL DEFAULT NULL,
  `atvt_12` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atvt_15_18` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atvt_19_20` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atvt_21_26` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atvt_27_30` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atvt_31_34` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atvt_35_36` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atvt_37_38` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atvt_39_40` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tt_12` date NULL DEFAULT NULL,
  `tt_15_18` date NULL DEFAULT NULL,
  `tt_19_20` date NULL DEFAULT NULL,
  `tt_21_26` date NULL DEFAULT NULL,
  `tt_27_30` date NULL DEFAULT NULL,
  `tt_31_34` date NULL DEFAULT NULL,
  `tt_35_36` date NULL DEFAULT NULL,
  `tt_37_38` date NULL DEFAULT NULL,
  `tt_39_40` date NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล ANC_Quality' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for anc_quality_log
-- ----------------------------
DROP TABLE IF EXISTS `anc_quality_log`;
CREATE TABLE `anc_quality_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบ ANC_Quality' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for authen_code_log
-- ----------------------------
DROP TABLE IF EXISTS `authen_code_log`;
CREATE TABLE `authen_code_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบ Authen Code' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for er_regist_log
-- ----------------------------
DROP TABLE IF EXISTS `er_regist_log`;
CREATE TABLE `er_regist_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานหน้า ER' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fiscal_year
-- ----------------------------
DROP TABLE IF EXISTS `fiscal_year`;
CREATE TABLE `fiscal_year`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fiscal_year_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( ปีงบประมาณ )' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for health_med_service_log
-- ----------------------------
DROP TABLE IF EXISTS `health_med_service_log`;
CREATE TABLE `health_med_service_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานหน้าแพทย์แผนไทย' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ipt_log
-- ----------------------------
DROP TABLE IF EXISTS `ipt_log`;
CREATE TABLE `ipt_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การใช้งานหน้า admit' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for login_log
-- ----------------------------
DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ipaddress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hostname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การ Login, Logout' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for module
-- ----------------------------
DROP TABLE IF EXISTS `module`;
CREATE TABLE `module`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( Module ) ต่างๆ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for module_log
-- ----------------------------
DROP TABLE IF EXISTS `module_log`;
CREATE TABLE `module_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าถึง Module ต่างๆ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for opdscreen_log
-- ----------------------------
DROP TABLE IF EXISTS `opdscreen_log`;
CREATE TABLE `opdscreen_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานหน้า OPDSCREEN' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ovst_log
-- ----------------------------
DROP TABLE IF EXISTS `ovst_log`;
CREATE TABLE `ovst_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานหน้าการดูคนไข้ทั้งหมด' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for palliative_care_log
-- ----------------------------
DROP TABLE IF EXISTS `palliative_care_log`;
CREATE TABLE `palliative_care_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การใช้งานระบบ Palliative Care' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for physic_log
-- ----------------------------
DROP TABLE IF EXISTS `physic_log`;
CREATE TABLE `physic_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานหน้ากายภาพบำบัด' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for receiving_charts
-- ----------------------------
DROP TABLE IF EXISTS `receiving_charts`;
CREATE TABLE `receiving_charts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `an` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ward` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dch_date` date NOT NULL,
  `doctor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `check_sending_chart` int(11) NULL DEFAULT NULL,
  `check_sending_chart_date_time` date NULL DEFAULT NULL,
  `check_receipt_of_chart` int(11) NULL DEFAULT NULL,
  `check_receipt_of_chart_date_time` date NULL DEFAULT NULL,
  `check_sending_chart_billing_room` int(11) NULL DEFAULT NULL,
  `check_sending_chart_billing_room_date_time` date NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูลของระบบ receiving charts' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for receiving_charts_log
-- ----------------------------
DROP TABLE IF EXISTS `receiving_charts_log`;
CREATE TABLE `receiving_charts_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบ receiving charts' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for refer_in_log
-- ----------------------------
DROP TABLE IF EXISTS `refer_in_log`;
CREATE TABLE `refer_in_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log เข้าใช้งานหน้า Refer In' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for refer_out_log
-- ----------------------------
DROP TABLE IF EXISTS `refer_out_log`;
CREATE TABLE `refer_out_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log เข้าใช้งานหน้า Refer Out' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for repair_notification_system
-- ----------------------------
DROP TABLE IF EXISTS `repair_notification_system`;
CREATE TABLE `repair_notification_system`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `working_type_id` int(11) NOT NULL,
  `name_of_informant` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `signature` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `repair_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`, `working_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( การแจ้งซ่อม )' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_choresterol_log
-- ----------------------------
DROP TABLE IF EXISTS `report_choresterol_log`;
CREATE TABLE `report_choresterol_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ Choresterol' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_cxr_41003_41004_log
-- ----------------------------
DROP TABLE IF EXISTS `report_cxr_41003_41004_log`;
CREATE TABLE `report_cxr_41003_41004_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ CXR' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_fbs_log
-- ----------------------------
DROP TABLE IF EXISTS `report_fbs_log`;
CREATE TABLE `report_fbs_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ FBS' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_mixed_building_log
-- ----------------------------
DROP TABLE IF EXISTS `report_mixed_building_log`;
CREATE TABLE `report_mixed_building_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ Admit ตึกรวม' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_monk_nun_log
-- ----------------------------
DROP TABLE IF EXISTS `report_monk_nun_log`;
CREATE TABLE `report_monk_nun_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ รายชื่อพระและแม่ชี' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_not_choresterol_log
-- ----------------------------
DROP TABLE IF EXISTS `report_not_choresterol_log`;
CREATE TABLE `report_not_choresterol_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ Choresterol' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_patients_utilizing_icd10_codes_log
-- ----------------------------
DROP TABLE IF EXISTS `report_patients_utilizing_icd10_codes_log`;
CREATE TABLE `report_patients_utilizing_icd10_codes_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_patients_with_no_service_history_log
-- ----------------------------
DROP TABLE IF EXISTS `report_patients_with_no_service_history_log`;
CREATE TABLE `report_patients_with_no_service_history_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ Choresterol' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_z237_log
-- ----------------------------
DROP TABLE IF EXISTS `report_z237_log`;
CREATE TABLE `report_z237_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ Z237' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_z242_log
-- ----------------------------
DROP TABLE IF EXISTS `report_z242_log`;
CREATE TABLE `report_z242_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ Z242' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_z251_log
-- ----------------------------
DROP TABLE IF EXISTS `report_z251_log`;
CREATE TABLE `report_z251_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การเข้าใช้งานระบบรายงานในส่วนของ Z251' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sidebar_main_menu
-- ----------------------------
DROP TABLE IF EXISTS `sidebar_main_menu`;
CREATE TABLE `sidebar_main_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sidebar_main_menu_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `link_url_or_route` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูลหลักของ Sidebar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sidebar_sub1_menu
-- ----------------------------
DROP TABLE IF EXISTS `sidebar_sub1_menu`;
CREATE TABLE `sidebar_sub1_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sidebar_main_menu_id` int(11) NOT NULL,
  `sidebar_sub1_menu_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `link_url_or_route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`, `sidebar_main_menu_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูลย่อยของ Sidebar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sidebar_sub1_menu_log
-- ----------------------------
DROP TABLE IF EXISTS `sidebar_sub1_menu_log`;
CREATE TABLE `sidebar_sub1_menu_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `command_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `query_time` float NULL DEFAULT NULL,
  `operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บ Log การใช้งานส่วนของ Sidebar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( เปิดและปิดการใช้งาน )' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for type
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( group, user )' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for type_accessibility
-- ----------------------------
DROP TABLE IF EXISTS `type_accessibility`;
CREATE TABLE `type_accessibility`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_accessibility_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูลการแยกของ( Module, Sidebar )' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for version
-- ----------------------------
DROP TABLE IF EXISTS `version`;
CREATE TABLE `version`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูลการ Update Version' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for version_detail
-- ----------------------------
DROP TABLE IF EXISTS `version_detail`;
CREATE TABLE `version_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_id` int(11) NOT NULL,
  `version_detail_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`, `version_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( การ Update ของ Version นั้นๆ )' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for working_type
-- ----------------------------
DROP TABLE IF EXISTS `working_type`;
CREATE TABLE `working_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `working_type_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'เก็บข้อมูล( ประเภทอุปกรณ์ )' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
