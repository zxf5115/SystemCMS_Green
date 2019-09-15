/*
 Navicat MySQL Data Transfer

 Source Server         : 本地环境
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : qingyun

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 15/09/2019 21:46:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for about
-- ----------------------------
DROP TABLE IF EXISTS `about`;
CREATE TABLE `about`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `title` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '标签描述',
  `display` tinyint(1) NULL DEFAULT 0 COMMENT '是否显示 默认不显示',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '作者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '关于信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of about
-- ----------------------------
INSERT INTO `about` VALUES (1, '关于1', '<p><p>        环球网快讯 记者 赵衍龙】韩联社3月6日报道，韩国亲信门独检组6日公布最终调查结果，认定总统朴槿惠与亲信门核心涉案人崔顺实合谋从三星集团收受贿赂430亿韩元(约合人民币2.56亿元)。</p><p class=\\\\\\\"text\\\\\\\" style=\\\\\\\"TEXT-INDENT:2em\\\\\\\">独检组表示，2015年朴槿惠大力支持三星物产与第一毛织合并，三星以此为代价向崔顺实及其掌控的Mir和K体育财团提供巨额资金。</p><p>独检组还表示，崔顺实曾多次为朴槿惠安排“注射阿姨”(对上门注射针剂的女性的通俗叫法)等非正式诊疗，青瓦台医疗系统实则处于“崩溃”状态。</p><p></p></p>', 1, 1, 1488791991, 'admin');

-- ----------------------------
-- Table structure for action
-- ----------------------------
DROP TABLE IF EXISTS `action`;
CREATE TABLE `action`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '行为规则',
  `log` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '日志规则',
  `type` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 71 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统行为表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of action
-- ----------------------------
INSERT INTO `action` VALUES (1, 'login', '用户登录', '登录系统', 'table:member_extend|field:handle|condition:uid={$self}|rule:handle+1', '[user|get_nickname]在[time|time_format]登录了后台', 1, 1433138050, 0, 1436944128, 'admin');
INSERT INTO `action` VALUES (2, 'logout', '用户退出', '退出系统', '', '[user|get_nickname]在[time|time_format]退出了后台', 2, 1433138050, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (3, 'backups', '备份数据库', '备份数据库', '', '[user|get_nickname]在[time|time_format]备份了数据库', 1, 1437016689, 1, 1437016689, 'admin');
INSERT INTO `action` VALUES (4, 'undo', '还原数据库', '还原数据库', '', '[user|get_nickname]在[time|time_format]还原了数据库', 1, 1437016689, 1, 1437016689, 'admin');
INSERT INTO `action` VALUES (5, 'cache', '清理缓存', '清理缓存', '', '[user|get_nickname]在[time|time_format]清理了缓存', 1, 1437016689, 1, 1437016689, 'admin');
INSERT INTO `action` VALUES (6, 'add_role', '新增角色', '新增角色', '', '[user|get_nickname]在[time|time_format]新增了角色', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (7, 'update_role', '更新角色', '更新角色', '', '[user|get_nickname]在[time|time_format]更新了角色', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (8, 'resume_role', '启用角色', '启用角色', '', '[user|get_nickname]在[time|time_format]启用了角色', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (9, 'forbid_role', '禁用角色', '禁用角色', '', '[user|get_nickname]在[time|time_format]禁用了角色', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (10, 'delete_role', '删除角色', '删除角色', '', '[user|get_nickname]在[time|time_format]删除了角色', 1, 1383296301, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (11, 'add_user', '新增用户', '新增用户', '', '[user|get_nickname]在[time|time_format]新增了用户', 1, 1436944178, 0, 1436944128, 'admin');
INSERT INTO `action` VALUES (12, 'update_user', '更新用户', '更新用户', '', '[user|get_nickname]在[time|time_format]更新了用户', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (13, 'resume_user', '启用用户', '启用用户', '', '[user|get_nickname]在[time|time_format]启用了用户', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (14, 'forbid_user', '禁用用户', '禁用用户', '', '[user|get_nickname]在[time|time_format]禁用了用户', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (15, 'delete_user', '删除用户', '删除用户', '', '[user|get_nickname]在[time|time_format]删除了用户', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (16, 'update_password', '更新用户密码', '更新用户密码', '', '[user|get_nickname]在[time|time_format]更新了用户密码', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (17, 'authorize_user', '授权用户', '授权用户', '', '[user|get_nickname]在[time|time_format]授权了用户', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (18, 'add_menu', '新增菜单', '新增菜单', '', '[user|get_nickname]在[time|time_format]新增了菜单', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (19, 'update_menu', '更新菜单', '更新菜单', '', '[user|get_nickname]在[time|time_format]更新了菜单', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (20, 'resume_menu', '启用菜单', '启用菜单', '', '[user|get_nickname]在[time|time_format]启用了菜单', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (21, 'forbid_menu', '禁用菜单', '禁用菜单', '', '[user|get_nickname]在[time|time_format]禁用了菜单', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (22, 'delete_menu', '删除菜单', '删除菜单', '', '[user|get_nickname]在[time|time_format]删除了菜单', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (23, 'add_channel', '新增导航', '新增导航', '', '[user|get_nickname]在[time|time_format]新增了导航', 1, 1383296301, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (24, 'update_channel', '更新导航', '更新导航', '', '[user|get_nickname]在[time|time_format]更新了导航', 1, 1383296301, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (25, 'resume_channel', '启用导航', '启用导航', '', '[user|get_nickname]在[time|time_format]启用了导航', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (26, 'forbid_channel', '禁用导航', '禁用导航', '', '[user|get_nickname]在[time|time_format]禁用了导航', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (27, 'delete_channel', '删除导航', '删除导航', '', '[user|get_nickname]在[time|time_format]删除了导航', 1, 1383296301, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (28, 'add_config', '新增配置', '新增配置', '', '[user|get_nickname]在[time|time_format]新增了配置', 1, 1437016665, 1, 1437016665, 'admin');
INSERT INTO `action` VALUES (29, 'update_config', '更新配置', '更新配置', '', '[user|get_nickname]在[time|time_format]更新了配置', 1, 1437016646, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (30, 'resume_config', '启用配置', '启用配置', '', '[user|get_nickname]在[time|time_format]启用了配置', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (31, 'forbid_config', '禁用配置', '禁用配置', '', '[user|get_nickname]在[time|time_format]禁用了配置', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (32, 'delete_config', '删除配置', '删除配置', '', '[user|get_nickname]在[time|time_format]删除了配置', 1, 1437016689, 1, 1437016689, 'admin');
INSERT INTO `action` VALUES (33, 'add_link', '新增友情链接', '新增友情链接', '', '[user|get_nickname]在[time|time_format]新增了友情链接', 1, 1437016665, 1, 1437016665, 'admin');
INSERT INTO `action` VALUES (34, 'update_link', '更新友情链接', '更新友情链接', '', '[user|get_nickname]在[time|time_format]更新了友情链接', 1, 1437016646, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (35, 'resume_link', '启用友情链接', '启用友情链接', '', '[user|get_nickname]在[time|time_format]启用了友情链接', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (36, 'forbid_link', '禁用友情链接', '禁用友情链接', '', '[user|get_nickname]在[time|time_format]禁用了友情链接', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (37, 'delete_link', '删除友情链接', '删除友情链接', '', '[user|get_nickname]在[time|time_format]删除了友情链接', 1, 1437016689, 1, 1437016689, 'admin');
INSERT INTO `action` VALUES (38, 'add_action', '新增行为', '新增行为', '', '[user|get_nickname]在[time|time_format]新增了行为', 1, 1437016665, 1, 1437016665, 'admin');
INSERT INTO `action` VALUES (39, 'update_action', '更新行为', '更新行为', '', '[user|get_nickname]在[time|time_format]更新了行为', 1, 1437016646, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (40, 'resume_action', '启用行为', '启用行为', '', '[user|get_nickname]在[time|time_format]启用了行为', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (41, 'forbid_action', '禁用行为', '禁用行为', '', '[user|get_nickname]在[time|time_format]禁用了行为', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (42, 'delete_action', '删除行为', '删除行为', '', '[user|get_nickname]在[time|time_format]删除了行为', 1, 1437016689, 1, 1437016689, 'admin');
INSERT INTO `action` VALUES (43, 'delete_log', '删除日志', '删除日志', '', '[user|get_nickname]在[time|time_format]删除了日志', 1, 1437016689, 1, 1437016689, 'admin');
INSERT INTO `action` VALUES (44, 'clear_log', '清空日志', '清空日志', '', '[user|get_nickname]在[time|time_format]删除了日志', 1, 1437016689, 1, 1437016689, 'admin');
INSERT INTO `action` VALUES (45, 'add_seo', '新增SEO', '新增SEO', '', '[user|get_nickname]在[time|time_format]新增了SEO', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (46, 'update_seo', '更新SEO', '更新SEO', '', '[user|get_nickname]在[time|time_format]更新了SEO', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (47, 'resume_tseo', '启用SEO', '启用SEO', '', '[user|get_nickname]在[time|time_format]启用了SEO', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (48, 'forbid_seo', '禁用SEO', '禁用SEO', '', '[user|get_nickname]在[time|time_format]禁用了SEO', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (49, 'delete_seo', '删除SEO', '删除SEO', '', '[user|get_nickname]在[time|time_format]删除了SEO', 1, 1383296301, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (50, 'add_category', '新增分类', '新增分类', '', '[user|get_nickname]在[time|time_format]新增了分类', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (51, 'update_category', '更新分类', '更新分类', '', '[user|get_nickname]在[time|time_format]更新了分类', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (52, 'resume_category', '启用分类', '启用分类', '', '[user|get_nickname]在[time|time_format]启用了分类', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (53, 'forbid_category', '禁用分类', '禁用分类', '', '[user|get_nickname]在[time|time_format]禁用了分类', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (54, 'delete_category', '删除分类', '删除分类', '', '[user|get_nickname]在[time|time_format]删除了分类', 1, 1383296301, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (55, 'add_label', '新增标签', '新增分类', '', '[user|get_nickname]在[time|time_format]新增了标签', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (56, 'update_label', '更新标签', '更新分类', '', '[user|get_nickname]在[time|time_format]更新了标签', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (57, 'resume_label', '启用标签', '启用分类', '', '[user|get_nickname]在[time|time_format]启用了标签', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (58, 'forbid_label', '禁用标签', '禁用分类', '', '[user|get_nickname]在[time|time_format]禁用了标签', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (59, 'sequence_label', '调整标签顺序', '调整标签顺序', '', '[user|get_nickname]在[time|time_format]调整了标签顺序', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (60, 'delete_label', '删除标签', '删除标签', '', '[user|get_nickname]在[time|time_format]删除了标签', 1, 1383296301, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (61, 'add_recommend', '新增推广', '新增推广', '', '[user|get_nickname]在[time|time_format]新增了推广', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (62, 'update_recommend', '更新推广', '更新推广', '', '[user|get_nickname]在[time|time_format]更新了推广', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (63, 'resume_recommend', '启用推广', '启用推广', '', '[user|get_nickname]在[time|time_format]启用了推广', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (64, 'forbid_recommend', '禁用推广', '禁用推广', '', '[user|get_nickname]在[time|time_format]禁用了推广', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (65, 'delete_recommend', '删除推广', '删除推广', '', '[user|get_nickname]在[time|time_format]删除了推广', 1, 1383296301, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (66, 'add_publicity', '新增广告', '新增广告', '', '[user|get_nickname]在[time|time_format]新增了广告', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (67, 'update_publicity', '更新广告', '更新广告', '', '[user|get_nickname]在[time|time_format]更新了广告', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (68, 'resume_publicity', '启用广告', '启用广告', '', '[user|get_nickname]在[time|time_format]启用了广告', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (69, 'forbid_publicity', '禁用广告', '禁用广告', '', '[user|get_nickname]在[time|time_format]禁用了广告', 1, 1436944178, 1, 1436944128, 'admin');
INSERT INTO `action` VALUES (70, 'delete_publicity', '删除广告', '删除广告', '', '[user|get_nickname]在[time|time_format]删除了广告', 1, 1383296301, 1, 1436944128, 'admin');

-- ----------------------------
-- Table structure for active
-- ----------------------------
DROP TABLE IF EXISTS `active`;
CREATE TABLE `active`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '活跃类型',
  `uid` int(11) NULL DEFAULT NULL COMMENT '用户编号',
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '用户行为',
  `ip_address` int(12) NULL DEFAULT NULL COMMENT 'IP地址',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '活跃信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of active
-- ----------------------------
INSERT INTO `active` VALUES (1, 3, 123586984, '2', NULL, 1453852831);
INSERT INTO `active` VALUES (2, 3, 123588829, '3', NULL, 1453852831);
INSERT INTO `active` VALUES (3, 3, 123588829, '2', NULL, 1453852831);
INSERT INTO `active` VALUES (4, 3, 123588829, '2', NULL, 1453852831);
INSERT INTO `active` VALUES (5, 3, 123588829, '2', NULL, 1453852831);
INSERT INTO `active` VALUES (6, 1, 123589394, '2', NULL, 1453852831);
INSERT INTO `active` VALUES (7, 1, 123589056, '2', NULL, 1453852831);
INSERT INTO `active` VALUES (8, 1, 123589051, '2', NULL, 1453852831);

-- ----------------------------
-- Table structure for addons
-- ----------------------------
DROP TABLE IF EXISTS `addons`;
CREATE TABLE `addons`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '插件描述',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '配置',
  `author` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '作者',
  `version` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '版本号',
  `has_adminlist` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否有后台列表',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 112 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '插件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of addons
-- ----------------------------
INSERT INTO `addons` VALUES (15, 'EditorForAdmin', '后台编辑器', '用于增强整站长文本的输入和显示', '{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"600px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.1', 0, NULL, 1, NULL, NULL);
INSERT INTO `addons` VALUES (4, 'SystemInfo', '系统环境信息', '用于显示一些服务器的信息', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', 0, NULL, 1, NULL, NULL);
INSERT INTO `addons` VALUES (107, 'Water', '图片水印', '用于为上传的图片添加水印', '{\"switch\":\"1\",\"water\":\"\",\"position\":\"9\"}', 'xjw129xjt', '0.1', 0, NULL, 1, NULL, NULL);
INSERT INTO `addons` VALUES (68, 'ImageSlider', '图片轮播', '图片轮播，需要先通过 http://www.onethink.cn/topic/2153.html 的方法，让配置支持多图片上传', '{\"second\":\"3000\",\"direction\":\"horizontal\",\"imgWidth\":\"760\",\"imgHeight\":\"350\",\"url\":\"111111111111\",\"images\":\"\"}', 'birdy', '0.1', 0, NULL, 1, NULL, NULL);
INSERT INTO `addons` VALUES (70, 'SuperLinks', '合作单位', '合作单位', '{\"random\":\"1\"}', '苏南 newsn.net', '0.1', 1, NULL, 1, NULL, NULL);
INSERT INTO `addons` VALUES (95, 'AliPlay', '支付宝', '支付宝插件,后台配置支持变量。如：价格：$GOODS[\"price\"].但是配置的变量要和数据库商品信息一致。', '{\"pay_type\":\"1\",\"codelogin\":\"1\",\"PARTNER\":\"\",\"KEY\":\"\",\"SELLER_EMAIL\":\"\",\"NOTIFY_URL\":\"\",\"RETURN_URL\":\"\",\"out_trade_no\":\"$order[\'id\']\",\"subject\":\"\\u8d26\\u6237\\u5145\\u503c\",\"price\":\"$order[\'amount\']\",\"logistics_fee\":\"0\",\"logistics_type\":\"EXPRESS\",\"logistics_payment\":\"SELLER_PAY\",\"body\":\"\\u901a\\u8fc7\\u652f\\u4ed8\\u5b9d\\u5bf9\\u7ad9\\u5185\\u8d26\\u6237\\u8fdb\\u884c\\u5145\\u503c\\u3002\",\"show_url\":\"\",\"receive_name\":\"\",\"receive_address\":\"\",\"receive_zip\":\"\",\"receive_mobile\":\"\",\"receive_phone\":\"\"}', 'Marvin(柳英伟)', '2.0', 0, NULL, 1, NULL, NULL);
INSERT INTO `addons` VALUES (96, 'Recharge', '充值中心插件', '用于显示充值中心顶部菜单栏入口的插件', 'null', '嘉兴想天信息科技有限公司', '0.1', 0, NULL, 1, NULL, NULL);

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '分类类型 1.游记 2.随笔 ',
  `pid` int(11) NULL DEFAULT 0 COMMENT '父级编号',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类标题',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类描述',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '作者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (1, 1, 0, '东北三省', '', 1, 1465875494, 'admin');
INSERT INTO `category` VALUES (2, 1, 1, '黑龙江省', '', 1, 1465875520, 'admin');
INSERT INTO `category` VALUES (3, 2, 0, 'PHP', '', 1, 1476336575, 'admin');
INSERT INTO `category` VALUES (4, 2, 0, 'MYSQL', '', 1, 1476336614, 'admin');

-- ----------------------------
-- Table structure for category_relevance
-- ----------------------------
DROP TABLE IF EXISTS `category_relevance`;
CREATE TABLE `category_relevance`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '分类类型 1.游记 2.随笔',
  `oid` int(11) NOT NULL COMMENT '对象编号',
  `cid` int(11) NOT NULL COMMENT '分类编号',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类关联信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of category_relevance
-- ----------------------------
INSERT INTO `category_relevance` VALUES (35, 2, 2, 4, 1);
INSERT INTO `category_relevance` VALUES (36, 2, 2, 3, 1);
INSERT INTO `category_relevance` VALUES (38, 2, 4, 3, 1);
INSERT INTO `category_relevance` VALUES (41, 1, 2, 2, 1);
INSERT INTO `category_relevance` VALUES (43, 1, 1, 2, 1);
INSERT INTO `category_relevance` VALUES (44, 1, 1, 1, 1);
INSERT INTO `category_relevance` VALUES (47, 1, 3, 1, 1);
INSERT INTO `category_relevance` VALUES (48, 1, 4, 2, 1);
INSERT INTO `category_relevance` VALUES (49, 2, 12, 4, 1);
INSERT INTO `category_relevance` VALUES (50, 2, 13, 4, 1);
INSERT INTO `category_relevance` VALUES (51, 2, 14, 4, 1);

-- ----------------------------
-- Table structure for channel
-- ----------------------------
DROP TABLE IF EXISTS `channel`;
CREATE TABLE `channel`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '频道ID',
  `pid` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '上级频道ID',
  `title` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '频道标题',
  `url` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '频道连接',
  `sort` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '导航排序',
  `target` tinyint(2) UNSIGNED NULL DEFAULT 0 COMMENT '新窗口打开',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '前台菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of channel
-- ----------------------------
INSERT INTO `channel` VALUES (1, 0, '首页', 'Index/index', 1, 0, 1488522263, 1, 1488522263, 'admin');
INSERT INTO `channel` VALUES (2, 0, '项目', 'Item/index', 2, 0, 1488522263, 1, 1488522263, 'admin');
INSERT INTO `channel` VALUES (3, 0, '随笔', 'Note/index', 3, 0, 1488522263, 1, 1488522263, 'admin');
INSERT INTO `channel` VALUES (4, 0, '服务', 'Service/index', 4, 0, 1488522263, 1, 1488522263, 'admin');
INSERT INTO `channel` VALUES (5, 0, '关于', 'About/index', 5, 0, 1488522263, 1, 1488522263, 'admin');
INSERT INTO `channel` VALUES (6, 0, '联系', 'Contact/index', 6, 0, 1488522263, 1, 1488522263, 'admin');
INSERT INTO `channel` VALUES (7, 5, '人物', 'About/person', 5, 0, 1488522263, 1, 1488522263, 'admin');
INSERT INTO `channel` VALUES (8, 3, '随笔详情', 'Note/detail', 5, 0, 1488522263, 1, 1488522263, 'admin');

-- ----------------------------
-- Table structure for city
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '城市',
  `pid` int(11) NULL DEFAULT NULL COMMENT '省份编号',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1479 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '城市信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES (600, '美国', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (601, '日本', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (602, '英国', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (603, '法国', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (604, '德国', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (605, '加拿大', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (606, '澳大利亚', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (607, '俄罗斯', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (608, '新西兰', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (609, '意大利', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (610, '韩国', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (611, '比利时', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (612, '瑞士', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (613, '新加坡', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (614, '墨西哥', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (615, '荷兰', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (616, '巴西', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (617, '印度', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (618, '爱尔兰', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (619, '马来西亚', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (620, '丹麦', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (621, '南非', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (622, '西班牙', 1, 0, 1, NULL);
INSERT INTO `city` VALUES (1000, '东城区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1001, '西城区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1002, '崇文区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1003, '宣武区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1004, '朝阳区 ', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1005, '丰台区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1006, '石景山区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1007, '海淀区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1008, '门头沟区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1009, '房山区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1010, '通州区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1011, '顺义区 ', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1012, '昌平区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1013, '大兴区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1014, '怀柔区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1015, '平谷区', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1016, '密云县', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1017, '延庆县', 10, 0, 1, NULL);
INSERT INTO `city` VALUES (1018, '黄浦区 ', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1019, '卢湾区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1020, '徐汇区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1021, '长宁区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1022, '静安区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1023, '普陀区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1024, '闸北区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1025, '虹口区 ', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1026, '杨浦区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1027, '闵行区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1028, '宝山区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1029, '嘉定区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1030, '浦东新区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1031, '金山区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1032, '松江区 ', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1033, '青浦区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1034, '南汇区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1035, '奉贤区', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1036, '崇明县', 11, 0, 1, NULL);
INSERT INTO `city` VALUES (1037, '和平区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1038, '河东区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1039, '河西区 ', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1040, '南开区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1041, '河北区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1042, '红桥区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1043, '塘沽区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1044, '汉沽区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1045, '大港区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1046, '东丽区 ', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1047, '西青区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1048, '津南区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1049, '北辰区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1050, '武清区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1051, '宝坻区', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1052, '宁河县', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1053, '静海县 ', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1054, '蓟县', 12, 0, 1, NULL);
INSERT INTO `city` VALUES (1055, '万州区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1056, '涪陵区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1057, '渝中区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1058, '大渡口区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1059, '江北区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1060, '沙坪坝区 ', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1061, '九龙坡区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1062, '南岸区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1063, '北碚区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1064, '万盛区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1065, '双桥区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1066, '渝北区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1067, '巴南区 ', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1068, '黔江区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1069, '长寿区', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1070, '綦江县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1071, '潼南县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1072, '铜梁县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1073, '大足县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1074, '荣昌县 ', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1075, '璧山县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1076, '梁平县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1077, '城口县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1078, '丰都县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1079, '垫江县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1080, '武隆县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1081, '忠县 ', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1082, '开县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1083, '云阳县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1084, '奉节县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1085, '巫山县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1086, '巫溪县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1087, '石柱土家族自治县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1088, ' 秀山土家族苗族自治县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1089, '酉阳土家族苗族自治县', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1090, '彭水苗族土家族自治县 ', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1091, '江津市', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1092, '合川市', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1093, '永川市', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1094, '南川市', 13, 0, 1, NULL);
INSERT INTO `city` VALUES (1095, '石家庄', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1096, '唐山', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1097, '秦皇岛 ', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1098, '邯郸', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1099, '邢台', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1100, '保定', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1101, '张家口', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1102, '承德', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1103, '沧州', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1104, '廊坊 ', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1105, '衡水', 14, 0, 1, NULL);
INSERT INTO `city` VALUES (1106, '太原', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1107, '大同', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1108, '阳泉', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1109, '长治', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1110, '晋城', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1111, '朔州 ', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1112, '晋中', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1113, '运城', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1114, '忻州', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1115, '临汾', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1116, '吕梁', 15, 0, 1, NULL);
INSERT INTO `city` VALUES (1117, '呼和浩特', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1118, '包头 ', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1119, '乌海', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1120, '赤峰', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1121, '通辽', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1122, '鄂尔多斯', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1123, '呼伦贝尔', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1124, '乌兰察布', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1125, '锡林郭勒盟', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1126, '巴彦淖尔', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1127, '阿拉善盟', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1128, '兴安盟 ', 16, 0, 1, NULL);
INSERT INTO `city` VALUES (1129, '沈阳', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1130, '大连', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1131, '鞍山', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1132, '抚顺', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1133, '本溪', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1134, '丹东', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1135, '锦州 ', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1136, '葫芦岛', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1137, '营口', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1138, '盘锦', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1139, '阜新', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1140, '辽阳', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1141, '铁岭', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1142, '朝阳 ', 17, 0, 1, NULL);
INSERT INTO `city` VALUES (1143, '长春', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1144, '吉林', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1145, '四平', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1146, '辽源', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1147, '通化', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1148, '白山', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1149, '松原 ', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1150, '白城', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1151, '延边朝鲜', 18, 0, 1, NULL);
INSERT INTO `city` VALUES (1152, '哈尔滨', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1153, '齐齐哈尔', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1154, '鹤岗', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1155, '双鸭山', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1156, '鸡西 ', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1157, '大庆', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1158, '伊春', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1159, '牡丹江', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1160, '佳木斯', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1161, '七台河', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1162, '黑河', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1163, '绥化 ', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1164, '大兴安岭', 19, 0, 1, NULL);
INSERT INTO `city` VALUES (1165, '南京', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1166, '无锡', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1167, '徐州', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1168, '常州', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1169, '苏州', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1170, '南通 ', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1171, '连云港', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1172, '淮安', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1173, '盐城', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1174, '扬州', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1175, '镇江', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1176, '泰州', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1177, '宿迁 ', 20, 0, 1, NULL);
INSERT INTO `city` VALUES (1178, '杭州', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1179, '宁波', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1180, '温州', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1181, '嘉兴', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1182, '湖州', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1183, '绍兴', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1184, '金华 ', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1185, '衢州', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1186, '舟山', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1187, '台州', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1188, '丽水', 21, 0, 1, NULL);
INSERT INTO `city` VALUES (1189, '合肥', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1190, '芜湖', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1191, '蚌埠 ', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1192, '淮南', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1193, '马鞍山', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1194, '淮北', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1195, '铜陵', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1196, '安庆', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1197, '黄山', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1198, '滁州 ', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1199, '阜阳', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1200, '宿州', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1201, '巢湖', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1202, '六安', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1203, '亳州', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1204, '池州', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1205, '宣城 ', 22, 0, 1, NULL);
INSERT INTO `city` VALUES (1206, '福州', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1207, '厦门', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1208, '莆田', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1209, '三明', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1210, '泉州', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1211, '漳州', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1212, '南平 ', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1213, '龙岩', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1214, '宁德', 23, 0, 1, NULL);
INSERT INTO `city` VALUES (1215, '南昌', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1216, '景德镇', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1217, '萍乡', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1218, '新余', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1219, '九江 ', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1220, '鹰潭', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1221, '赣州', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1222, '吉安', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1223, '宜春', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1224, '抚州', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1225, '上饶', 24, 0, 1, NULL);
INSERT INTO `city` VALUES (1226, '济南 ', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1227, '青岛', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1228, '淄博', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1229, '枣庄', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1230, '东营', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1231, '潍坊', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1232, '烟台', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1233, '威海 ', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1234, '济宁', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1235, '泰安', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1236, '日照', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1237, '莱芜', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1238, '德州', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1239, '临沂', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1240, '聊城 ', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1241, '滨州', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1242, '菏泽', 25, 0, 1, NULL);
INSERT INTO `city` VALUES (1243, '郑州', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1244, '开封', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1245, '洛阳', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1246, '平顶山', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1247, '焦作 ', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1248, '鹤壁', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1249, '新乡', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1250, '安阳', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1251, '濮阳', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1252, '许昌', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1253, '漯河', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1254, '三门峡 ', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1255, '南阳', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1256, '商丘', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1257, '信阳', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1258, '周口', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1259, '驻马店', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1260, '济源', 26, 0, 1, NULL);
INSERT INTO `city` VALUES (1261, '武汉 ', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1262, '黄石', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1263, '襄樊', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1264, '十堰', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1265, '荆州', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1266, '宜昌', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1267, '荆门', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1268, '鄂州 ', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1269, '孝感', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1270, '黄冈', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1271, '咸宁', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1272, '随州', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1273, '仙桃', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1274, '天门', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1275, '潜江 ', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1276, '神农架', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1277, '恩施土家', 27, 0, 1, NULL);
INSERT INTO `city` VALUES (1278, '长沙', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1279, '株洲', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1280, '湘潭', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1281, '衡阳', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1282, '邵阳 ', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1283, '岳阳', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1284, '常德', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1285, '张家界', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1286, '益阳', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1287, '郴州', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1288, '怀化', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1289, '娄底 ', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1290, '湘西土家', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1291, '永州', 28, 0, 1, NULL);
INSERT INTO `city` VALUES (1292, '广州', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1293, '深圳', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1294, '珠海', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1295, '汕头', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1296, '韶关 ', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1297, '佛山', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1298, '江门', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1299, '湛江', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1300, '茂名', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1301, '肇庆', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1302, '惠州', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1303, '梅州 ', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1304, '汕尾', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1305, '河源', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1306, '阳江', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1307, '清远', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1308, '东莞', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1309, '中山', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1310, '潮州 ', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1311, '揭阳', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1312, '云浮', 29, 0, 1, NULL);
INSERT INTO `city` VALUES (1313, '南宁', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1314, '柳州', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1315, '桂林', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1316, '梧州', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1317, '北海 ', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1318, '防城港', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1319, '钦州', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1320, '贵港', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1321, '玉林', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1322, '百色', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1323, '贺州', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1324, '河池 ', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1325, '来宾', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1326, '崇左', 30, 0, 1, NULL);
INSERT INTO `city` VALUES (1327, '海口', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1328, '三亚', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1329, '五指山', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1330, '琼海', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1331, '儋州 ', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1332, '文昌', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1333, '万宁', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1334, '东方', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1335, '澄迈', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1336, '定安', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1337, '屯昌', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1338, '临高 ', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1339, '白沙黎族', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1340, '江黎族自', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1341, '乐东黎族 ', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1342, '陵水黎族', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1343, '保亭黎族', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1344, '琼中黎族 ', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1345, '西沙群岛', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1346, '南沙群岛', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1347, '中沙群岛 ', 31, 0, 1, NULL);
INSERT INTO `city` VALUES (1348, '成都', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1349, '自贡', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1350, '攀枝花', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1351, '泸州', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1352, '德阳', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1353, '绵阳', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1354, '广元 ', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1355, '遂宁', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1356, '内江', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1357, '乐山', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1358, '南充', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1359, '宜宾', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1360, '广安', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1361, '达州 ', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1362, '眉山', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1363, '雅安', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1364, '巴中', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1365, '资阳', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1366, '阿坝藏族', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1367, '甘孜藏族', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1368, '凉山彝族 ', 32, 0, 1, NULL);
INSERT INTO `city` VALUES (1369, '贵阳', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1370, '六盘水', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1371, '遵义', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1372, '安顺', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1373, '铜仁', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1374, '毕节', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1375, '黔西南布 ', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1376, '黔东南苗', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1377, '黔南布依', 33, 0, 1, NULL);
INSERT INTO `city` VALUES (1378, '昆明', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1379, '曲靖', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1380, '玉溪', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1381, '保山', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1382, '昭通 ', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1383, '丽江', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1384, '思茅', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1385, '临沧', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1386, '文山壮族', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1387, '红河哈尼', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1388, '西双版纳', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1389, '楚雄彝族', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1390, '大理白族', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1391, '德宏傣族', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1392, '怒江傈傈 ', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1393, '迪庆藏族', 34, 0, 1, NULL);
INSERT INTO `city` VALUES (1394, '拉萨', 35, 0, 1, NULL);
INSERT INTO `city` VALUES (1395, '那曲', 35, 0, 1, NULL);
INSERT INTO `city` VALUES (1396, '昌都', 35, 0, 1, NULL);
INSERT INTO `city` VALUES (1397, '山南', 35, 0, 1, NULL);
INSERT INTO `city` VALUES (1398, '日喀则', 35, 0, 1, NULL);
INSERT INTO `city` VALUES (1399, '阿里 ', 35, 0, 1, NULL);
INSERT INTO `city` VALUES (1400, '林芝', 35, 0, 1, NULL);
INSERT INTO `city` VALUES (1401, '西安', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1402, '铜川', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1403, '宝鸡', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1404, '咸阳', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1405, '渭南', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1406, '延安 ', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1407, '汉中', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1408, '榆林', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1409, '安康', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1410, '商洛', 36, 0, 1, NULL);
INSERT INTO `city` VALUES (1411, '兰州', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1412, '金昌', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1413, '白银 ', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1414, '天水', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1415, '嘉峪关', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1416, '武威', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1417, '张掖', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1418, '平凉', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1419, '酒泉', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1420, '庆阳 ', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1421, '定西', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1422, '陇南', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1423, '临夏回族', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1424, '甘南藏族', 37, 0, 1, NULL);
INSERT INTO `city` VALUES (1425, '西宁', 38, 0, 1, NULL);
INSERT INTO `city` VALUES (1426, '海东', 38, 0, 1, NULL);
INSERT INTO `city` VALUES (1427, '海北藏族 ', 38, 0, 1, NULL);
INSERT INTO `city` VALUES (1428, '黄南藏族', 38, 0, 1, NULL);
INSERT INTO `city` VALUES (1429, '海南藏族', 38, 0, 1, NULL);
INSERT INTO `city` VALUES (1430, '果洛藏族 ', 38, 0, 1, NULL);
INSERT INTO `city` VALUES (1431, '玉树藏族', 38, 0, 1, NULL);
INSERT INTO `city` VALUES (1432, '海西蒙古', 38, 0, 1, NULL);
INSERT INTO `city` VALUES (1433, '银川', 39, 0, 1, NULL);
INSERT INTO `city` VALUES (1434, '石嘴山', 39, 0, 1, NULL);
INSERT INTO `city` VALUES (1435, '吴忠', 39, 0, 1, NULL);
INSERT INTO `city` VALUES (1436, '固原', 39, 0, 1, NULL);
INSERT INTO `city` VALUES (1437, '中卫 ', 39, 0, 1, NULL);
INSERT INTO `city` VALUES (1438, '乌鲁木齐', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1439, '克拉玛依', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1440, '石河子', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1441, '阿拉尔', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1442, '图木舒克', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1443, '五家渠', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1444, '吐鲁番 ', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1445, '哈密', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1446, '和田', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1447, '阿克苏', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1448, '喀什', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1449, '克孜勒苏', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1450, '巴音郭楞', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1451, '昌吉回族 ', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1452, '博尔塔拉', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1453, '伊犁哈萨', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1454, '塔城', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1455, '阿勒泰', 40, 0, 1, NULL);
INSERT INTO `city` VALUES (1456, '台北', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1457, '高雄', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1458, '基隆 ', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1459, '台中', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1460, '台南', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1461, '新竹', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1462, '嘉义', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1463, '台北县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1464, '宜兰县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1465, '新竹县 ', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1466, '桃园县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1467, '苗栗县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1468, '台中县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1469, '彰化县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1470, '南投县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1471, '嘉义县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1472, '云林县 ', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1473, '台南县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1474, '高雄县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1475, '屏东县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1476, '台东县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1477, '花莲县', 43, 0, 1, NULL);
INSERT INTO `city` VALUES (1478, '澎湖县', 43, 0, 1, NULL);

-- ----------------------------
-- Table structure for client
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `oid` int(11) NOT NULL COMMENT '关于标题编号',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人们名称',
  `picture` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人物图片地址',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '客户信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of client
-- ----------------------------
INSERT INTO `client` VALUES (1, 1, '百度科技', '/Uploads/Picture/2016-10-12/57fdde72cb386.jpg', 'www.baidu.com', 1, 1489134495, 'admin');
INSERT INTO `client` VALUES (2, 1, '小米科技', '/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg', 'www.baidu.com', 1, 1489134535, 'admin');
INSERT INTO `client` VALUES (3, 1, '360', '/Uploads/Download/2015-08-26/55dd7baf79dd8.jpg', 'www.baidu.com', 1, 1489134551, 'admin');
INSERT INTO `client` VALUES (4, 1, '微软科技', '/Uploads/Download/2015-08-26/55dd7baf79dd8.jpg', 'www.baidu.com', 1, 1489134581, 'admin');
INSERT INTO `client` VALUES (5, 1, '阿里巴巴', '/Uploads/Picture/2017-03-10/58c26427773ba.jpg', 'www.baidu.com', 1, 1489134642, 'admin');

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配置类型',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配置分组',
  `extra` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置说明',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置值',
  `sort` smallint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_name`(`name`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `group`(`group`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES (1, 'WEB_SITE_TITLE', 1, '网站标题', 1, '', '网站标题前台显示标题', '协呈服务', 1, 1439367187, 1, NULL, NULL);
INSERT INTO `config` VALUES (2, 'WEB_SITE_DESCRIPTION', 2, '网站描述', 1, '', '网站搜索引擎描述', '面世', 5, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (3, 'WEB_SITE_KEYWORD', 2, '网站关键字', 1, '', '网站搜索引擎关键字', '协呈服务', 17, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (4, 'WEB_SITE_CLOSE', 4, '关闭站点', 1, '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1', 6, 1445242986, 1, NULL, NULL);
INSERT INTO `config` VALUES (5, 'CONFIG_TYPE_LIST', 3, '配置类型列表', 4, '', '主要用于数据解析和页面表单的生成', '0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举', 8, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (6, 'WEB_SITE_ICP', 1, '网站备案号', 1, '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '© Copyright © 2003-2013 协呈服务 版权所有 滇ICP备2222222222号 ', 19, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (7, 'DOCUMENT_POSITION', 3, '文档推荐位', 2, '', '文档推荐位，推荐到多个位置KEY值相加即可', '1:列表页推荐\r\n2:频道页推荐\r\n4:网站首页推荐', 9, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (8, 'DOCUMENT_DISPLAY', 3, '文档可见性', 2, '', '文章可见性仅影响前台显示，后台不收影响', '0:所有人可见\r\n1:仅注册会员可见\r\n2:仅管理员可见', 12, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (9, 'COLOR_STYLE', 4, '后台色系', 1, 'default_color:默认\r\nblue_color:紫罗兰', '后台颜色风格', 'default_color', 21, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (10, 'CONFIG_GROUP_LIST', 3, '配置分组', 4, '', '配置分组', '1:基本配置\r\n2:内容配置\r\n3:用户配置\r\n4:系统配置', 13, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (11, 'HOOKS_TYPE', 3, '钩子的类型', 4, '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '1:视图\r\n2:控制器', 15, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (12, 'AUTH_CONFIG', 3, 'Auth配置', 4, '', '自定义Auth.class.php类配置', 'AUTH_ON:1\r\nAUTH_TYPE:2', 18, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (13, 'OPEN_DRAFTBOX', 4, '是否开启草稿功能', 2, '0:关闭草稿功能\r\n1:开启草稿功能\r\n', '新增文章时的草稿功能配置', '1', 7, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (15, 'LIST_ROWS', 0, '后台每页记录数', 2, '', '后台数据每页显示记录数', '10', 22, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (16, 'USER_ALLOW_REGISTER', 4, '是否允许用户注册', 3, '0:关闭注册\r\n1:允许注册', '是否开放用户注册', '1', 10, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (17, 'CODEMIRROR_THEME', 4, '预览插件的CodeMirror主题', 4, '3024-day:3024 day\r\n3024-night:3024 night\r\nambiance:ambiance\r\nbase16-dark:base16 dark\r\nbase16-light:base16 light\r\nblackboard:blackboard\r\ncobalt:cobalt\r\neclipse:eclipse\r\nelegant:elegant\r\nerlang-dark:erlang-dark\r\nlesser-dark:lesser-dark\r\nmidnight:midnight', '详情见CodeMirror官网', 'ambiance', 11, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (18, 'DATA_BACKUP_PATH', 1, '数据库备份根路径', 4, '', '路径必须以 / 结尾', './Data/', 14, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (19, 'DATA_BACKUP_PART_SIZE', 0, '数据库备份卷大小', 4, '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '20971520', 16, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (20, 'DATA_BACKUP_COMPRESS', 4, '数据库备份文件是否启用压缩', 4, '0:不压缩\r\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1', 20, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (21, 'DATA_BACKUP_COMPRESS_LEVEL', 4, '数据库备份文件压缩级别', 4, '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '9', 23, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (22, 'DEVELOP_MODE', 4, '开启开发者模式', 4, '0:关闭\r\n1:开启', '是否开启开发者模式', '1', 24, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (23, 'ALLOW_VISIT', 3, '不受限控制器方法', 4, '', '任何人员都可访问的控制器方法', '0:Index/index\n1:Permission/index\n2:Stat/index\n3:Stat/area\n4:Stat/sex\n5:Stat/pv\n6:Stat/uv', 3, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (39, 'BAIDU_MAP_KEY', 1, '百度地图密钥', 1, '', '', '8HsQTAn8hxm4SIaSdKyhKzdyr7TS8ETd', 0, 1488506672, 1, 1488506551, 'admin');
INSERT INTO `config` VALUES (24, 'DENY_VISIT', 3, '超管专限控制器方法', 4, '', '仅超级管理员可访问的控制器方法', '', 2, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (25, 'REPLY_LIST_ROWS', 0, '回复列表每页条数', 2, '', '', '1000', 4, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (26, 'ADMIN_ALLOW_IP', 2, '后台允许访问IP', 4, '', '多个用逗号分隔，如果不配置表示不限制IP访问', '', 25, NULL, 1, NULL, NULL);
INSERT INTO `config` VALUES (35, 'WEB_COPYRIGHT_CN', 1, '网站版权中文版', 1, '', '', '协呈服务', 0, 1445938021, 1, 1445938021, 'admin');
INSERT INTO `config` VALUES (36, 'WEB_COPYRIGHT_EN', 1, '网站版权英文版', 1, '', '', '2014-2015 111ji.com, All Rights', 0, 1445938073, 1, 1445938073, 'admin');
INSERT INTO `config` VALUES (37, 'WEB_COPYRIGHT_URL', 1, '网站版权跳转链接', 1, '', '', 'http://www.111ji.com', 0, 1446000755, 0, 1446000755, 'admin');
INSERT INTO `config` VALUES (38, 'WEB_SITE_TITLE_ABBR', 1, '网站标题缩写', 1, '', '字数两个字最好', '面世', 0, 1446170504, 1, 1446170503, 'admin');
INSERT INTO `config` VALUES (40, 'COMPANY_ADDRESS', 1, '公司详细地址', 1, '', '', '北京市昌平区东小口镇半截塔村', 0, 1488506915, 1, 1488506749, 'admin');
INSERT INTO `config` VALUES (41, 'COMPANY_CITY', 0, '公司所在城市', 1, '', '', '北京市', 0, 1488506886, 1, 1488506857, 'admin');
INSERT INTO `config` VALUES (42, 'COMPANY_PHONE', 1, '公司联系电话', 1, '', '', '+86 182 0101 8926', 0, 1488507307, 1, 1488507307, 'admin');
INSERT INTO `config` VALUES (43, 'COMPANY_EMAIL', 1, '公司联系邮箱', 1, '', '', '1326336909@qq.com', 0, 1488507579, 1, 1488507579, 'admin');
INSERT INTO `config` VALUES (44, 'COMPANY_WEBSITE', 1, '公司网站', 1, '', '', 'www.xiechengfuwu.com', 0, 1488507765, 1, 1488507765, 'admin');
INSERT INTO `config` VALUES (45, 'COMPANY_INTRO', 1, '公司简介', 1, '', '', '我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。我们是一群健康向上的好学生，为了完成祖国交给我们的伟大的任务，解放全人类。', 0, 1488508412, 1, 1488508392, 'admin');

-- ----------------------------
-- Table structure for contact
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电子邮箱',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '意见内容',
  `ip_adress` int(11) NOT NULL COMMENT 'IP地址',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '意见信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of contact
-- ----------------------------
INSERT INTO `contact` VALUES (1, '张晓飞', '1326336909@qq.com', '呵呵，笑声真他妈的销魂', 0, 1, 1488532762);
INSERT INTO `contact` VALUES (2, '1111', '1326336909@qq.com', '2222222222222', 0, 1, 1488764742);

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '状态',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 136 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of file
-- ----------------------------
INSERT INTO `file` VALUES (96, 'image/jpeg', '/Uploads/Picture/2015-10-28/56308a106ce2a.jpg', '', '076e3caed758a1c18c91a0e9cae3368f', 'f5f8ad26819a471318d24631fa5055036712a87e', 1, 1446021648, 'admin');
INSERT INTO `file` VALUES (135, 'image/jpeg', '/Uploads/Picture/2017-03-15/58c8e58c4993d.jpg', '', 'ba45c8f60456a672e003a875e469d0eb', '30420d1a9afb2bcb60335812569af4435a59ce17', 1, 1489560972, 'admin');
INSERT INTO `file` VALUES (132, 'image/jpeg', '/Uploads/Picture/2016-10-13/57ff00b49eabd.jpg', '', '9d377b10ce778c4938b3c7e2c63a229a', 'df7be9dc4f467187783aca68c7ce98e4df2172d0', 1, 1476329652, 'admin');
INSERT INTO `file` VALUES (128, 'image/jpeg', '/Uploads/Picture/2016-06-24/576caae775aa1.jpg', '', 'fafa5efeaf3cbe3b23b2748d13e629a1', '54c2f1a1eb6f12d681a5c7078421a5500cee02ad', 1, 1466739431, 'admin');
INSERT INTO `file` VALUES (126, 'image/jpeg', '/Uploads/Picture/2016-06-24/576ca66c18869.jpg', '', '24d0c21ce5b01e4279cfd7be61570e7b', '2b1e00a0a1da08276d40dc8dfe5ecf468a823edb', 1, 1466738284, 'admin');
INSERT INTO `file` VALUES (6, 'image/jpeg', '/Uploads/Download/2015-08-26/55dd5b50bbdda.jpg', '', 'c10b38a7f963d2d79135abb7854c50da', 'f0a718ebeb0ce6f2daa3bd023f129808ca49b0af', 1, 1440570192, NULL);
INSERT INTO `file` VALUES (133, 'image/jpeg', '/Uploads/Picture/2017-03-10/58c24f87aefec.jpg', '', '1d4c6c8b4dbf7a4928d96f0d145acfec', '733c3c5c28a9f20896450f14a06ae743067c21fd', 1, 1489129351, 'admin');
INSERT INTO `file` VALUES (134, 'image/jpeg', '/Uploads/Picture/2017-03-10/58c26427773ba.jpg', '', 'c1bf5a0e8dc45442a41ab669a2725a77', 'ea3365668fdd9d0cd22f588d03c1950afa4e7b5f', 1, 1489134631, 'admin');
INSERT INTO `file` VALUES (124, 'image/jpeg', '/Uploads/Picture/2016-06-24/576c9f17df8b6.jpg', '', '5a44c7ba5bbe4ec867233d67e4806848', '3b15be84aff20b322a93c0b9aaa62e25ad33b4b4', 1, 1466736407, 'admin');
INSERT INTO `file` VALUES (130, 'image/jpeg', '/Uploads/Picture/2016-10-12/57fdde72cb386.jpg', '', '754058b1d2e7fcb3b9e62c3d640a00ad', 'bd145ae283980d3a58cc518a1b1178368947463d', 1, 1476255346, 'admin');
INSERT INTO `file` VALUES (11, 'image/jpeg', '/Uploads/Download/2015-08-26/55dd7baf6f687.jpg', '', '216782348aec1f7a0fa2b82a7a1c257d', '524aa2496705250fbd943af4414743cebefe4938', 1, 1440578479, NULL);
INSERT INTO `file` VALUES (12, 'image/jpeg', '/Uploads/Download/2015-08-26/55dd7baf79dd8.jpg', '', '0cb4d48830ed95c7cf0800c2cb8b2733', 'b629d49f165163afe40c5d84b982516b0441dad2', 1, 1440578479, NULL);
INSERT INTO `file` VALUES (125, 'image/jpeg', '/Uploads/Picture/2016-06-24/576ca3c85df1d.jpg', '', '2b04df3ecc1d94afddff082d139c6f15', '9c3dcb1f9185a314ea25d51aed3b5881b32f420c', 1, 1466737608, 'admin');
INSERT INTO `file` VALUES (14, 'image/jpeg', '/Uploads/Download/2015-08-28/55dfd3161a07d.jpg', '', '4bf36063869c43504483e37e85c22739', '6f3c54928ca427eec94ad382dc8dd5340d84190d', 1, 1440731925, NULL);
INSERT INTO `file` VALUES (15, 'image/jpeg', '/Uploads/Download/2015-08-28/55dfd4ecc305f.jpg', '', 'b4b1d9f8ae57dff68010ed66cef4bb6a', '0dc877894a517f71c01869e8afd520899562d845', 1, 1440732396, NULL);
INSERT INTO `file` VALUES (16, 'image/jpeg', '/Uploads/Download/2015-08-28/55dfd4eccba6b.jpg', '', '715a16bb076f913fb702a1e5170043a3', '5884a7d799a6c6fe8e463263b6cbbc2006028a12', 1, 1440732396, NULL);
INSERT INTO `file` VALUES (92, 'image/jpeg', '/Uploads/Download/2015-08-28/55dfd4eccba6b.jpg', '', '715a16bb076f913fb702a1e5170043a3', '5884a7d799a6c6fe8e463263b6cbbc2006028a12', 1, 1440732396, NULL);
INSERT INTO `file` VALUES (93, 'image/jpeg', '/Uploads/Download/2015-08-28/55dfd4ecc305f.jpg', '', 'b4b1d9f8ae57dff68010ed66cef4bb6a', '0dc877894a517f71c01869e8afd520899562d845', 1, 1440732396, NULL);
INSERT INTO `file` VALUES (94, 'image/jpeg', '/Uploads/Download/2015-08-28/55dfd3161a07d.jpg', '', '4bf36063869c43504483e37e85c22739', '6f3c54928ca427eec94ad382dc8dd5340d84190d', 1, 1440731925, NULL);
INSERT INTO `file` VALUES (127, 'image/jpeg', '/Uploads/Picture/2016-06-24/576ca699d62ed.jpg', '', '8969288f4245120e7c3870287cce0ff3', '1b4605b0e20ceccf91aa278d10e81fad64e24e27', 1, 1466738329, 'admin');
INSERT INTO `file` VALUES (129, 'image/jpeg', '/Uploads/Picture/2016-10-12/57fdde729cc50.jpg', '', 'f4ed9818097a6cad88b7b9ef9754fb60', '1e07b751f8d54d440b081afae5157cfc1cb2a6e6', 1, 1476255346, 'admin');
INSERT INTO `file` VALUES (131, 'image/jpeg', '/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg', '', 'b7ce7c65f4d2684eb714eba9ec7c94fc', '554a67bbbad47c4d76d7b9657d9e348c2a6e1d0b', 1, 1476255346, 'admin');
INSERT INTO `file` VALUES (105, 'image/jpeg', '/Uploads/Picture/2015-11-03/56384e8771d77.jpg', '', 'bdf3bf1da3405725be763540d6601144', 'd997e1c37edc05ad87d03603e32ad495ee2cfce1', 1, 1446530695, 'admin');
INSERT INTO `file` VALUES (112, 'image/jpeg', '/Uploads/Picture/2016-06-23/576b9ef19ed29.jpg', '', '649a2de5e148b3a8994c50f5c9f387d2', '57eb6a45424ce01aff53b446957c0ce0bf7b5b37', 1, 1466670833, 'admin');

-- ----------------------------
-- Table structure for hooks
-- ----------------------------
DROP TABLE IF EXISTS `hooks`;
CREATE TABLE `hooks`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型',
  `addons` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 \'，\'分割',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 42 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hooks
-- ----------------------------
INSERT INTO `hooks` VALUES (13, 'AdminIndex', '首页小格子个性化显示', 1, 'SystemInfo', 1445935331, 1, 1445934497, 'admin');

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '游记标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '游记内容',
  `picture` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '预览图片',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '作者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '项目信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES (1, '北方工业-数据采集系统', '<p>123123132131313123123123132123123</p><p>123123132131313123123123132123123</p><p>123123132131313123123123132123123</p><p>123123132131313123123123132123123</p><p>123123132131313123123123132123123</p><p>222222222222222222222</p><p></p>', '/Uploads/Picture/2016-10-12/57fdde72cb386.jpg', 1, 1489560757, 'admin');
INSERT INTO `item` VALUES (2, '123213', '<p>1231231231</p><p></p><p>    foreach($result[\\\'data\\\'] as &$vo)    {      if(!empty($vo))      {        $where = array();        $where[\\\'type\\\'] = 2;        $where[\\\'oid\\\'] = $vo[\\\'id\\\'];        $cids = get_array_field(D(\\\'CategoryRelation\\\')->getWithWhereTableInfo($where, \\\'cid\\\', \\\'id ASC\\\'), \\\'cid\\\');        $lids = get_array_field(D(\\\'LabelRelation\\\')->getWithWhereTableInfo($where, \\\'lid\\\', \\\'id ASC\\\'), \\\'lid\\\');        if(!empty($cids))        {          $where = array();          $where[\\\'id\\\'] = array(\\\'in\\\', $cids);          $vo[\\\'category\\\'] = get_array_field(D(\\\'Category\\\')->getWithWhereTableInfo($where, \\\'title\\\'), \\\'title\\\');        }        if(!empty($lids))        {          $where[\\\'id\\\'] = array(\\\'in\\\', $lids);          $vo[\\\'label\\\'] = get_array_field(D(\\\'Label\\\')->getWithWhereTableInfo($where, \\\'title\\\'), \\\'title\\\');        }      }    }</p>', '/Uploads/Picture/2017-03-10/58c26427773ba.jpg', 1, 1489560962, 'admin');
INSERT INTO `item` VALUES (3, '快讯！朴槿惠被全票弹劾！开韩国历史先河', '<div class=\"adNoH600NoBor\" id=\"adSba_1\"><br/></div>      <br/><p style=\"text-align: center; font-size: 16px;\"><img src=\"http://himg2.huanqiu.com/attachment2010/2017/0310/09/36/20170310093616411.jpg\" style=\"width: 421px; height: 502px\"/></p><p style=\"text-align: center; font-size: 16px;\">资料图：朴槿惠</p><p style=\"font-size: 16px;\">　　【环球网快讯记者 丁洁芸】据韩联社3月10日报道，<a href=\"http://country.huanqiu.com/korea\" class=\"linkAbout\" target=\"_blank\" title=\"韩国\">韩国</a>当地时间10日上午11点20分许(北京时间10时20分许)，韩国宪法法院对总统弹劾案作出弹劾判决，8名大法官全票通过。</p><p style=\"font-size: 16px;\">　　朴槿惠由此成为韩国历史上首位被成功弹劾的总统。</p><p style=\"font-size: 16px;\"><strong>　　<a href=\"http://country.huanqiu.com/america\" class=\"linkAbout\" target=\"_blank\" title=\"美国\">美国</a>务院：尊重韩国国民的决定</strong></p><p style=\"font-size: 16px;\">　　韩联社3月10日报道称，美国国务院副发言人马克·托纳9日在向韩联社发送的评论中就韩国宪法法院裁决总统弹劾案成立，朴槿惠被罢免下台一事表示，美国尊重韩国国民的决定，不对其他国家内政发表立场。</p><p style=\"font-size: 16px;\">　　评论表示，这是韩国国民和民主机构就本国的未来作出的决定，美国尊重这种决定。韩美同盟将继续在维护地区安全方面发挥核心作用。美国将继续尽盟国之责，帮助韩国防御<a href=\"http://country.huanqiu.com/north_korea\" class=\"linkAbout\" target=\"_blank\" title=\"朝鲜\">朝鲜</a>威胁。</p><p><br/></p>', '/Uploads/Picture/2017-03-15/58c8e58c4993d.jpg', 1, 1489560979, 'admin');
INSERT INTO `item` VALUES (4, '213123123123', '<p><span style=\"color:#ff0000\"><strong>123123123</strong></span></p><p><span style=\"color:#ff0000\"><strong>1231</strong></span></p><p><span style=\"color:#ff0000\"><strong>123123</strong></span></p><p><span style=\"color:#ff0000\"><strong>123123</strong></span></p><p><span style=\"color:#ff0000\"><strong><br/></strong></span></p><p><span style=\"color:#ff0000\"><strong>123</strong></span></p><p><span style=\"color:#ff0000\"><strong><br/></strong></span></p><p><span style=\"color:#ff0000\"><strong>123123123<br/></strong></span></p>', '/Uploads/Picture/2017-03-10/58c24f87aefec.jpg', 1, 1489631111, 'admin');

-- ----------------------------
-- Table structure for item_extend
-- ----------------------------
DROP TABLE IF EXISTS `item_extend`;
CREATE TABLE `item_extend`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `tid` int(11) NOT NULL COMMENT '游记编号',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '游记图片链接地址',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '项目扩展信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of item_extend
-- ----------------------------
INSERT INTO `item_extend` VALUES (1, 4, '/Uploads/Picture/2016-10-12/57fdde72cb386.jpg', 1);
INSERT INTO `item_extend` VALUES (2, 4, '/Uploads/Picture/2016-10-12/57fdde729cc50.jpg', 1);
INSERT INTO `item_extend` VALUES (3, 4, '/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg', 1);
INSERT INTO `item_extend` VALUES (8, 8, '/Uploads/Download/2015-08-26/55dd5b50cc71c.jpg', 1);
INSERT INTO `item_extend` VALUES (9, 8, '/Uploads/Download/2015-08-26/55dd5b50d4f98.jpg', 1);
INSERT INTO `item_extend` VALUES (10, 0, '/Uploads/Picture/2016-06-24/576ca3c85df1d.jpg', 1);
INSERT INTO `item_extend` VALUES (11, 0, '/Uploads/Picture/2016-10-13/57ff00b49eabd.jpg', 1);
INSERT INTO `item_extend` VALUES (12, 0, '/Uploads/Picture/2016-10-13/57ff00b49eabd.jpg', 1);
INSERT INTO `item_extend` VALUES (13, 0, '/Uploads/Picture/2016-06-24/576ca3c85df1d.jpg', 1);
INSERT INTO `item_extend` VALUES (14, 0, '/Uploads/Picture/2016-10-12/57fdde729cc50.jpg', 1);
INSERT INTO `item_extend` VALUES (15, 0, '/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg', 1);
INSERT INTO `item_extend` VALUES (16, 0, '/Uploads/Download/2015-08-28/55dfd4eccba6b.jpg', 1);
INSERT INTO `item_extend` VALUES (17, 0, '/Uploads/Picture/2016-10-12/57fdde729cc50.jpg', 1);
INSERT INTO `item_extend` VALUES (18, 0, '/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg', 1);
INSERT INTO `item_extend` VALUES (19, 0, '/Uploads/Download/2015-08-28/55dfd4ecc305f.jpg', 1);
INSERT INTO `item_extend` VALUES (28, 7, '/Uploads/Picture/2016-10-12/57fdde729cc50.jpg', 1);
INSERT INTO `item_extend` VALUES (29, 7, '/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg', 1);
INSERT INTO `item_extend` VALUES (30, 7, '/Uploads/Download/2015-08-28/55dfd4eccba6b.jpg', 1);
INSERT INTO `item_extend` VALUES (31, 7, '/Uploads/Download/2015-08-28/55dfd4ecc305f.jpg', 1);

-- ----------------------------
-- Table structure for label
-- ----------------------------
DROP TABLE IF EXISTS `label`;
CREATE TABLE `label`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '标签类型 1.游记 2.随笔 ',
  `pid` int(11) NULL DEFAULT 0 COMMENT '父级编号',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签标题',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '标签描述',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '作者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of label
-- ----------------------------
INSERT INTO `label` VALUES (1, 1, 0, '野营', '', 1, 1465885992, 'admin');
INSERT INTO `label` VALUES (2, 1, 1, '徒步', '', 1, 1465886011, 'admin');
INSERT INTO `label` VALUES (3, 2, 0, '中职动力', '', 1, 1476349825, 'admin');
INSERT INTO `label` VALUES (4, 2, 0, '同丹科技', '', 1, 1476349945, 'admin');

-- ----------------------------
-- Table structure for label_relevance
-- ----------------------------
DROP TABLE IF EXISTS `label_relevance`;
CREATE TABLE `label_relevance`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '标签类型 1.游记 2.随笔',
  `oid` int(11) NOT NULL COMMENT '对象编号',
  `lid` int(11) NOT NULL COMMENT '标签编号',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类关联信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of label_relevance
-- ----------------------------
INSERT INTO `label_relevance` VALUES (27, 2, 2, 4, 1);
INSERT INTO `label_relevance` VALUES (28, 2, 2, 3, 1);
INSERT INTO `label_relevance` VALUES (30, 2, 4, 3, 1);
INSERT INTO `label_relevance` VALUES (35, 1, 2, 1, 1);
INSERT INTO `label_relevance` VALUES (37, 1, 1, 2, 1);
INSERT INTO `label_relevance` VALUES (38, 1, 1, 1, 1);
INSERT INTO `label_relevance` VALUES (41, 1, 3, 1, 1);
INSERT INTO `label_relevance` VALUES (42, 1, 4, 1, 1);
INSERT INTO `label_relevance` VALUES (43, 2, 12, 4, 1);
INSERT INTO `label_relevance` VALUES (44, 2, 13, 4, 1);
INSERT INTO `label_relevance` VALUES (45, 2, 14, 4, 1);

-- ----------------------------
-- Table structure for link
-- ----------------------------
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接标题',
  `link` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '友情链接信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of link
-- ----------------------------
INSERT INTO `link` VALUES (1, '111', 'www.baidu.com', 1, 1444293540, 'admin');
INSERT INTO `link` VALUES (2, '222', 'www.google.com', 1, 1445293540, 'admin');

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '行为id',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '触发行为的数据id',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '执行行为的时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `action_ip_ix`(`action_ip`) USING BTREE,
  INDEX `action_id_ix`(`action_id`) USING BTREE,
  INDEX `user_id_ix`(`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 698 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '行为日志表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES (695, 2, 1, 0, 'member', 1, '张晓飞在2017-03-28 16:46退出了后台', 1, 1490690764, 'admin');
INSERT INTO `log` VALUES (694, 2, 1, 0, 'member', 1, '张晓飞在2017-03-28 16:21退出了后台', 1, 1490689309, 'admin');
INSERT INTO `log` VALUES (693, 2, 1, 0, 'member', 1, '张晓飞在2017-03-28 11:05退出了后台', 1, 1490670351, 'admin');
INSERT INTO `log` VALUES (692, 2, 1, 0, 'member', 1, '张晓飞在2017-03-28 11:02退出了后台', 1, 1490670157, 'admin');
INSERT INTO `log` VALUES (691, 2, 1, 0, 'member', 1, '张晓飞在2017-03-28 10:40退出了后台', 1, 1490668829, 'admin');
INSERT INTO `log` VALUES (690, 12, 22, 0, 'Member', 22, '沐雲2在2017-03-06 12:34更新了用户', 1, 1488774860, 'root');
INSERT INTO `log` VALUES (689, 2, 1, 0, 'member', 1, '张晓飞在2017-03-06 12:23退出了后台', 1, 1488774235, 'admin');
INSERT INTO `log` VALUES (688, 17, 1, 0, 'Member', 22, '张晓飞在2017-03-06 12:23授权了用户', 1, 1488774218, 'admin');
INSERT INTO `log` VALUES (687, 6, 1, 0, 'Role', 28, '张晓飞在2017-03-06 12:00新增了角色', 1, 1488772855, 'admin');
INSERT INTO `log` VALUES (686, 2, 22, 0, 'member', 22, '沐雲2在2017-03-06 11:50退出了后台', 1, 1488772252, 'root');
INSERT INTO `log` VALUES (685, 2, 1, 0, 'member', 1, '张晓飞在2017-03-06 11:32退出了后台', 1, 1488771150, 'admin');
INSERT INTO `log` VALUES (683, 2, 1, 0, 'member', 1, '张晓飞在2017-03-06 10:00退出了后台', 1, 1488765652, 'admin');
INSERT INTO `log` VALUES (696, 2, 1, 2130706433, 'member', 1, '张晓飞在2019-09-15 21:43退出了后台', 1, 1568555000, 'admin');
INSERT INTO `log` VALUES (697, 2, 1, 2130706433, 'member', 1, '张晓飞在2019-09-15 21:44退出了后台', 1, 1568555099, 'admin');

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户邮箱',
  `mobile` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户手机',
  `reg_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '注册时间',
  `reg_ip` bigint(20) NULL DEFAULT 0 COMMENT '注册IP',
  `login_number` int(11) NULL DEFAULT 0 COMMENT '登录次数',
  `last_login_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_login_ip` bigint(20) NULL DEFAULT 0 COMMENT '最后登录IP',
  `update_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '用户状态',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES (1, 'admin', '690e92d3b285dfc6e724a72141af5a50', '13263326909@qq.com', '18201018926', 1421659112, 0, 431, 1568555114, 2130706433, 1444635291, 1453852831, 1, 'admin');
INSERT INTO `member` VALUES (22, 'root', '690e92d3b285dfc6e724a72141af5a50', 'root@123.com', '18201018912', 1436514562, 0, 37, 1488774240, 0, 1436514562, 1453852831, 1, 'admin');

-- ----------------------------
-- Table structure for member_extend
-- ----------------------------
DROP TABLE IF EXISTS `member_extend`;
CREATE TABLE `member_extend`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `uid` int(11) NULL DEFAULT NULL COMMENT '用户编号',
  `nickname` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `picture` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '人物介绍',
  `sex` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `province` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '省份',
  `qq` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'qq号',
  `handle` int(11) NULL DEFAULT 0 COMMENT '操作系统次数',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`nickname`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of member_extend
-- ----------------------------
INSERT INTO `member_extend` VALUES (1, 1, '张晓飞', '/Uploads/Picture/2016-06-24/576ca3c85df1d.jpg', '1.使用PHP语言开发互联网应用程序;\r\n\r\n2.网站产品和网站功能模块的开发与维护;\r\n\r\n3.与页面设计师协调沟通，编写部分Javascript和HTML;\r\n\r\n4.手机APP接口开发与后台管理系统开发、维护、管理;\r\n\r\n \r\n\r\n任职资格： \r\n\r\n1、至少3年以上的PHP项目开发经验，具备良好的代码编程习惯及较强的文档编写能力；\r\n\r\n2、精通PHP语言，熟练掌握HTML语言、JavaScript脚本语言，熟练掌握mysql；\r\n\r\n3、熟悉LINUX和WINDOWS操作系统；\r\n\r\n4、熟练掌握php、mysql等；\r\n\r\n5、熟练掌握thinkphp、phpcms、phpwind中至少一种；\r\n\r\n6、必须精通ecshop二次开发，完全了解ecshop设计原理模式\r\n\r\n7、有良好的沟通、协调能力和学习能力，具备良好的团队合作精神，对工作积极严谨踏实，能承受较大的工作压力。', 1, '1998-09-24', '12', '1326336909', 166, 1466758589);
INSERT INTO `member_extend` VALUES (16, 22, '沐雲2', NULL, NULL, 2, '2015-07-15', '22', '', 0, NULL);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级分类ID',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序（同级有效）',
  `url` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否隐藏',
  `tip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '提示',
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分组',
  `is_dev` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否仅开发者模式可见',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1,
  `create_time` int(10) NULL DEFAULT NULL,
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'admin',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1403 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, '控制台', 0, 1, 'Admin/Index/index', 0, '', '', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (2, '用户管理', 0, 2, 'javascript:;', 0, '', '', 0, 1442216059, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (3, '用户信息', 2, 0, 'Admin/User/index', 0, '', '用户管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (4, '新增用户', 3, 1, 'Admin/User/add', 0, '', '用户管理', 0, 1438322641, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (5, '编辑用户', 3, 2, 'Admin/User/edit', 0, '', '用户管理', 0, 1438322692, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (6, '重置密码', 3, 3, 'Admin/User/password', 0, '', '用户管理', 0, 1438322700, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (7, '授权用户', 3, 4, 'Admin/User/authorization', 0, '', '用户管理', 0, 1438323646, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (8, '禁用用户', 3, 5, 'Admin/User/changeStatus?method=forbid', 0, '', '用户管理', 0, 1438322958, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (9, '启用用户', 3, 6, 'Admin/User/changeStatus?method=resume', 0, '', '用户管理', 0, 1438322973, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (10, '删除用户', 3, 7, 'Admin/User/changeStatus?method=delete', 0, '', '用户管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (11, '角色信息', 2, 0, 'Admin/Role/index', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (12, '新增角色', 11, 0, 'Admin/Role/add', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (13, '编辑角色', 11, 0, 'Admin/Role/edit', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (14, '访问授权', 11, 0, 'Admin/Role/visit', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (15, '成员授权', 11, 0, 'Admin/Role/user', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (16, '解除授权', 11, 0, 'Admin/Role/removeUser', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (17, '分类授权', 11, 0, 'Admin/Role/category', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (18, '禁用角色', 11, 0, 'Admin/Role/changeStatus?method=forbid', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (19, '启用角色', 11, 0, 'Admin/Role/changeStatus?method=resume', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (20, '删除角色', 11, 0, 'Admin/Role/changeStatus?method=delete', 0, '', '角色管理', 0, 1438322903, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (21, '插件管理', 0, 4, 'javascript:;', 0, '', '', 0, 1442216848, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (22, '插件信息', 21, 0, 'Admin/Addons/index', 0, '', '插件管理', 0, 1442216823, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (23, '检测创建', 22, 0, 'Admin/Addons/checkForm', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (24, '插件预览', 22, 0, 'Admin/Addons/preview', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (25, '生成插件', 22, 0, 'Admin/Addons/build', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (26, '插件设置', 22, 0, 'Admin/Addons/config', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (27, '禁用插件', 22, 0, 'Admin/Addons/changeStatus?method=forbid', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (28, '启用插件', 22, 0, 'Admin/Addons/changeStatus?method=resume', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (29, '安装插件', 22, 0, 'Admin/Addons/install', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (30, '卸载插件', 22, 0, 'Admin/Addons/uninstall', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (31, '更新配置', 22, 0, 'Admin/Addons/saveconfig', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (32, '插件后台列表', 22, 0, 'Admin/Addons/installed', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (33, 'URL方式访问插件', 22, 0, 'Admin/Addons/execute', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (34, '创建插件', 22, 0, 'Admin/Addons/add', 0, '', '插件管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (35, '钩子信息', 21, 0, 'Admin/Hooks/index', 0, '', '钩子管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (36, '新增钩子', 35, 0, 'Admin/Hooks/add', 0, '', '钩子管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (37, '编辑钩子', 35, 0, 'Admin/Hooks/edit', 0, '', '钩子管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (38, '启用钩子', 35, 4, 'Admin/Hooks/changeStatus?method=resume', 0, '', '钩子管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (39, '禁用钩子', 35, 5, 'Admin/Hooks/changeStatus?method=forbid', 0, '', '钩子管理', 0, 1438324509, 1, 1438324508, 'admin');
INSERT INTO `menu` VALUES (40, '删除钩子', 35, 2, 'Admin/Hooks/changeStatus?method=delete', 0, '', '钩子管理', 0, 1438324885, 1, 1438324834, 'admin');
INSERT INTO `menu` VALUES (41, '日志管理', 0, 4, 'javascript:;', 0, '', '', 0, 1442216881, 1, 1442216881, 'admin');
INSERT INTO `menu` VALUES (42, '日志信息', 41, 1, 'Admin/Log/index', 0, '', '日志管理', 0, 1442976974, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (43, '日志详情', 42, 1, 'Admin/Log/view', 0, '', '日志管理', 0, 1442991293, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (44, '清空日志', 42, 3, 'Admin/Log/clear', 0, '', '日志管理', 0, 1438324894, 1, 1438324757, 'admin');
INSERT INTO `menu` VALUES (45, '删除日志', 42, 2, 'Admin/Log/changeStatus?method=delete', 0, '', '日志管理', 0, 1438324885, 1, 1438324834, 'admin');
INSERT INTO `menu` VALUES (46, '行为信息', 41, 2, 'Admin/Action/index', 0, '', '行为管理', 0, 1442976927, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (47, '新增行为', 46, 1, 'Admin/Action/add', 0, '', '行为管理', 0, 1438324348, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (48, '编辑行为', 46, 2, 'Admin/Action/edit', 0, '', '行为管理', 0, 1438324362, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (49, '禁用行为', 46, 5, 'Admin/Action/changeStatus?method=forbid', 0, '', '行为管理', 0, 1438324509, 1, 1438324508, 'admin');
INSERT INTO `menu` VALUES (50, '启用行为', 46, 4, 'Admin/Action/changeStatus?method=resume', 0, '', '行为管理', 0, 1438324477, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (51, '删除行为', 46, 3, 'Admin/Action/changeStatus?method=delete', 0, '', '行为管理', 0, 1438324432, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (52, '系统管理', 0, 5, 'javascript:;', 0, '', '', 0, 1442216916, 1, 1442216916, 'admin');
INSERT INTO `menu` VALUES (53, '网站设置', 52, 2, 'Admin/Config/setting', 0, '', '配置管理', 0, 1444269998, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (54, '配置信息', 52, 4, 'Admin/Config/index', 0, '', '配置管理', 0, 1442217379, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (55, '新增配置', 54, 1, 'Admin/Config/add', 0, '', '配置管理', 0, 1438325776, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (56, '编辑配置', 54, 2, 'Admin/Config/edit', 0, '', '配置管理', 0, 1438325844, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (57, '删除配置', 54, 3, 'Admin/Config/changeStatus?method=delete', 0, '', '配置管理', 0, 1438325935, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (58, '后台菜单', 52, 1, 'Admin/Menu/index', 0, '', '菜单管理', 0, 1442287745, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (59, '新增菜单', 58, 1, 'Admin/Menu/add', 0, '', '菜单管理', 0, 1438326158, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (60, '编辑菜单', 58, 2, 'Admin/Menu/edit', 0, '', '菜单管理', 0, 1438326174, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (61, '菜单排序', 58, 3, 'Admin/Menu/sort', 1, '', '菜单管理', 0, 1438326221, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (62, '菜单是否显示', 58, 4, 'Admin/Menu/toogleHide', 0, '', '菜单管理', 0, 1438326339, 1, 1438326339, 'admin');
INSERT INTO `menu` VALUES (63, '菜单开发者是否可见', 58, 5, 'Admin/Menu/toogleDev', 0, '', '菜单管理', 0, 1438326382, 1, 1438326382, 'admin');
INSERT INTO `menu` VALUES (64, '禁用菜单', 58, 6, 'Admin/Menu/changeStatus?method=forbid', 0, '', '菜单管理', 0, 1438326205, 1, 1438326205, 'admin');
INSERT INTO `menu` VALUES (65, '启用菜单', 58, 7, 'Admin/Menu/changeStatus?method=resume', 0, '', '菜单管理', 0, 1438326205, 1, 1438326205, 'admin');
INSERT INTO `menu` VALUES (66, '删除菜单', 58, 8, 'Admin/Menu/changeStatus?method=delete', 0, '', '菜单管理', 0, 1438326205, 1, 1438326205, 'admin');
INSERT INTO `menu` VALUES (67, '前台导航', 52, 1, 'Admin/Channel/index', 0, '', '菜单管理', 0, 1442287753, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (68, '新增导航', 67, 1, 'Admin/Channel/add', 0, '', '菜单管理', 0, 1438326592, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (69, '编辑导航', 67, 2, 'Admin/Channel/edit', 0, '', '菜单管理', 0, 1438326520, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (70, '导航排序', 67, 4, 'Admin/Channel/sort', 1, '', '菜单管理', 0, 1438326575, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (71, '禁用导航', 67, 6, 'Admin/Channel/changeStatus?method=forbid', 0, '', '菜单管理', 0, 1438326856, 1, 1438326856, 'admin');
INSERT INTO `menu` VALUES (72, '启用导航', 67, 5, 'Admin/Channel/changeStatus?method=resume', 0, '', '菜单管理', 0, 1438326812, 1, 1438326812, 'admin');
INSERT INTO `menu` VALUES (73, '删除导航', 67, 3, 'Admin/Channel/changeStatus?method=delete', 0, '', '菜单管理', 0, 1438326560, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (74, '备份数据库', 52, 0, 'Admin/Database/index', 0, '', '备份管理', 0, 1442290296, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (75, '优化表', 74, 1, 'Admin/Database/optimize', 0, '', '数据备份', 0, 1438326926, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (76, '修复表', 74, 2, 'Admin/Database/repair', 0, '', '数据备份', 0, 1438326940, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (77, '数据备份', 74, 3, 'Admin/Database/export', 0, '', '数据备份', 0, 1438326956, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (78, '还原数据库', 52, 0, 'Admin/Database/undo', 0, '', '备份管理', 0, 1444269981, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (79, '还原备份', 78, 1, 'Admin/Database/import', 0, '', '数据备份', 0, 1438327511, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (80, '删除备份', 78, 2, 'Admin/Database/del', 0, '', '数据备份', 0, 1438327501, 1, 1438324477, 'admin');
INSERT INTO `menu` VALUES (81, '链接信息', 52, 5, 'Admin/Link/index', 0, '', '友情链接', 0, 1442217574, 1, 1442217574, 'admin');
INSERT INTO `menu` VALUES (82, '新增链接', 81, 1, 'Admin/Link/add', 0, '', '友情链接', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (83, '编辑链接', 81, 2, 'Admin/Link/edit', 0, '', '友情链接', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (84, '禁用链接', 81, 3, 'Admin/Link/changeStatus?method=forbid', 0, '', '友情链接', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (85, '启用链接', 81, 4, 'Admin/Link/changeStatus?method=resume', 0, '', '友情链接', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (86, '删除链接', 81, 5, 'Admin/Link/changeStatus?method=delete', 0, '', '友情链接', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (87, '缓存信息', 52, 2, 'Admin/Cache/index', 0, '', '缓存管理', 0, 1444269964, 1, 1442217422, 'admin');
INSERT INTO `menu` VALUES (88, '清空缓存', 87, 1, 'Admin/Cache/clearcache', 0, '', '缓存管理', 0, 1444269669, 1, 1444269669, 'admin');
INSERT INTO `menu` VALUES (89, '清空日志', 87, 1, 'Admin/Cache/logcache', 0, '', '缓存管理', 0, 1444269669, 1, 1444269669, 'admin');
INSERT INTO `menu` VALUES (90, '清空临时', 87, 1, 'Admin/Cache/tempcache', 0, '', '缓存管理', 0, 1444269669, 1, 1444269669, 'admin');
INSERT INTO `menu` VALUES (91, 'SEO信息', 52, 6, 'Admin/Seo/index', 0, '', 'SEO管理', 0, 1442217610, 1, 1442217610, 'admin');
INSERT INTO `menu` VALUES (92, '新增SEO', 91, 2, 'Admin/Seo/add', 0, '', 'SEO管理', 0, 1443164422, 1, 1443164421, 'admin');
INSERT INTO `menu` VALUES (93, '编辑SEO', 91, 3, 'Admin/Seo/edit', 0, '', 'SEO管理', 0, 1443164472, 1, 1443164472, 'admin');
INSERT INTO `menu` VALUES (94, '禁用SEO', 91, 3, 'Admin/Seo/changeStatus?method=forbid', 0, '', 'SEO管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (95, '启用SEO', 91, 4, 'Admin/Seo/changeStatus?method=resume', 0, '', 'SEO管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (96, '删除SEO', 91, 4, 'Admin/Seo/changeStatus?method=delete', 0, '', 'SEO管理', 0, 1443164528, 1, 1443164528, 'admin');
INSERT INTO `menu` VALUES (97, '业务管理', 0, 3, 'javascript:;', 0, '', '', 0, 1451374211, 1, 1442216134, 'admin');
INSERT INTO `menu` VALUES (98, '广告信息', 97, 9, 'Admin/Publicity/index', 0, '', '广告管理', 0, 1451376694, 1, 1445998554, 'admin');
INSERT INTO `menu` VALUES (99, '新增广告', 98, 1, 'Admin/Publicity/add', 0, '', '广告管理', 0, 1445998663, 1, 1445998663, 'admin');
INSERT INTO `menu` VALUES (100, '编辑广告', 98, 2, 'Admin/Publicity/edit', 0, '', '广告管理', 0, 1445998735, 1, 1445998735, 'admin');
INSERT INTO `menu` VALUES (101, '禁用广告', 98, 4, 'Admin/Publicity/changeStatus?method=forbid', 0, '', '广告管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (102, '启用广告', 98, 3, 'Admin/Publicity/changeStatus?method=resume', 0, '', '广告管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (103, '删除广告', 98, 5, 'Admin/Publicity/changeStatus?method=delete', 0, '', '广告管理', 0, 1445998949, 1, 1445998949, 'admin');
INSERT INTO `menu` VALUES (104, '分类信息', 97, 1, 'Admin/Category/index', 0, '', '分类管理', 0, 1451709246, 1, 1446618067, 'admin');
INSERT INTO `menu` VALUES (105, '新增分类', 104, 2, 'Admin/Category/add', 0, '', '分类管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (106, '编辑分类', 104, 2, 'Admin/Category/edit', 0, '', '分类管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (107, '禁用分类', 104, 4, 'Admin/Category/changeStatus?method=forbid', 0, '', '分类管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (108, '启用分类', 104, 3, 'Admin/Category/changeStatus?method=resume', 0, '', '分类管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (109, '删除分类', 104, 2, 'Admin/Category/changeStatus?method=delete', 0, '', '分类管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (110, '项目信息', 97, 0, 'Admin/Item/index', 0, '', '项目管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (111, '新增项目', 110, 1, 'Admin/Item/add', 0, '', '项目管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (112, '编辑项目', 110, 2, 'Admin/Item/edit', 0, '', '项目管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (113, '禁用项目', 110, 3, 'Admin/Item/changeStatus?method=forbid', 0, '', '项目管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (114, '启用项目', 110, 4, 'Admin/Item/changeStatus?method=resume', 0, '', '项目管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (115, '删除项目', 110, 5, 'Admin/Item/changeStatus?method=delete', 0, '', '项目管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (116, '随笔信息', 97, 0, 'Admin/Note/index', 0, '', '随笔管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (117, '新增随笔', 116, 1, 'Admin/Note/add', 0, '', '随笔管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (118, '编辑随笔', 116, 2, 'Admin/Note/edit', 0, '', '随笔管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (119, '禁用随笔', 116, 3, 'Admin/Note/changeStatus?method=forbid', 0, '', '随笔管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (120, '启用随笔', 116, 4, 'Admin/Note/changeStatus?method=resume', 0, '', '随笔管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (121, '删除随笔', 116, 5, 'Admin/Note/changeStatus?method=delete', 0, '', '随笔管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (122, '服务信息', 97, 0, 'Admin/Service/index', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (123, '新增服务', 122, 1, 'Admin/Service/add', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (124, '编辑服务', 122, 2, 'Admin/Service/edit', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (125, '禁用服务', 122, 3, 'Admin/Service/changeStatus?method=forbid', 0, '', '服务管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (126, '启用服务', 122, 4, 'Admin/Service/changeStatus?method=resume', 0, '', '服务管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (127, '删除服务', 122, 5, 'Admin/Service/changeStatus?method=delete', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (128, '关于信息', 97, 0, 'Admin/About/index', 0, '', '关于管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (129, '新增关于', 128, 1, 'Admin/About/add', 0, '', '关于管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (130, '编辑关于', 128, 2, 'Admin/About/edit', 0, '', '关于管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (131, '禁用关于', 128, 3, 'Admin/About/changeStatus?method=forbid', 0, '', '关于管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (132, '启用关于', 128, 4, 'Admin/About/changeStatus?method=resume', 0, '', '关于管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (133, '删除关于', 128, 5, 'Admin/About/changeStatus?method=delete', 0, '', '关于管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (134, '联系信息', 97, 0, 'Admin/Contact/index', 0, '', '联系管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (135, '新增联系', 134, 1, 'Admin/Contact/add', 0, '', '联系管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (136, '意见详情', 134, 2, 'Admin/Contact/detail', 0, '', '联系管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (145, '新增人物', 144, 2, 'Admin/Person/add', 0, '', '关于管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (144, '人物信息', 97, 1, 'Admin/Person/index', 0, '', '关于管理', 0, 1451709246, 1, 1446618067, 'admin');
INSERT INTO `menu` VALUES (137, '删除联系', 134, 5, 'Admin/Contact/changeStatus?method=delete', 0, '', '联系管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (138, '标签信息', 97, 1, 'Admin/Label/index', 0, '', '标签管理', 0, 1451709246, 1, 1446618067, 'admin');
INSERT INTO `menu` VALUES (139, '新增标签', 138, 2, 'Admin/Label/add', 0, '', '标签管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (140, '编辑标签', 138, 2, 'Admin/Label/edit', 0, '', '标签管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (141, '禁用标签', 138, 4, 'Admin/Label/changeStatus?method=forbid', 0, '', '标签管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (142, '启用标签', 138, 3, 'Admin/Label/changeStatus?method=resume', 0, '', '标签管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (143, '删除标签', 138, 2, 'Admin/Label/changeStatus?method=delete', 0, '', '标签管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (146, '编辑人物', 144, 2, 'Admin/Person/edit', 0, '', '关于管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (147, '禁用人物', 144, 4, 'Admin/Person/changeStatus?method=forbid', 0, '', '关于管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (148, '启用人物', 144, 3, 'Admin/Person/changeStatus?method=resume', 0, '', '关于管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (149, '删除人物', 144, 2, 'Admin/Person/changeStatus?method=delete', 0, '', '关于管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (150, '客户信息', 97, 1, 'Admin/Client/index', 0, '', '服务管理', 0, 1451709246, 1, 1446618067, 'admin');
INSERT INTO `menu` VALUES (151, '新增客户', 150, 2, 'Admin/Client/add', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (152, '编辑客户', 150, 2, 'Admin/Client/edit', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (153, '禁用客户', 150, 4, 'Admin/Client/changeStatus?method=forbid', 0, '', '服务管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (154, '启用客户', 150, 3, 'Admin/Client/changeStatus?method=resume', 0, '', '服务管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (155, '删除客户', 150, 2, 'Admin/Client/changeStatus?method=delete', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (156, '擅长信息', 97, 1, 'Admin/Merit/index', 0, '', '服务管理', 0, 1451709246, 1, 1446618067, 'admin');
INSERT INTO `menu` VALUES (157, '新增擅长', 156, 2, 'Admin/Merit/add', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (158, '编辑擅长', 156, 2, 'Admin/Merit/edit', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (159, '禁用擅长', 156, 4, 'Admin/Merit/changeStatus?method=forbid', 0, '', '服务管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (160, '启用擅长', 156, 3, 'Admin/Merit/changeStatus?method=resume', 0, '', '服务管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (161, '删除擅长', 156, 2, 'Admin/Merit/changeStatus?method=delete', 0, '', '服务管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (162, '讨论信息', 97, 1, 'Admin/NoteComment/index', 0, '', '随笔管理', 0, 1451709246, 1, 1446618067, 'admin');
INSERT INTO `menu` VALUES (163, '新增讨论', 162, 2, 'Admin/NoteComment/add', 0, '', '随笔管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (164, '编辑讨论', 162, 2, 'Admin/NoteComment/edit', 0, '', '随笔管理', 0, 1447220931, 1, 1447220931, 'admin');
INSERT INTO `menu` VALUES (165, '禁用讨论', 162, 4, 'Admin/NoteComment/changeStatus?method=forbid', 0, '', '随笔管理', 0, 1445998896, 1, 1445998896, 'admin');
INSERT INTO `menu` VALUES (166, '启用讨论', 162, 3, 'Admin/NoteComment/changeStatus?method=resume', 0, '', '随笔管理', 0, 1445998848, 1, 1445998848, 'admin');
INSERT INTO `menu` VALUES (167, '删除讨论', 162, 2, 'Admin/NoteComment/changeStatus?method=delete', 0, '', '随笔管理', 0, 1447220931, 1, 1447220931, 'admin');

-- ----------------------------
-- Table structure for merit
-- ----------------------------
DROP TABLE IF EXISTS `merit`;
CREATE TABLE `merit`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `oid` int(11) NOT NULL COMMENT '服务标题编号',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '服务名称',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '服务内容',
  `picture` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '服务图标',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '服务信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of merit
-- ----------------------------
INSERT INTO `merit` VALUES (1, 1, 'PHP维护', '<p>定义和用法</p><p>strpos() 函数查找字符串在另一字符串中第一次出现的位置。</p><p class=\\\"\\\\\\\"\\\\\\\\\\\\\\\"note\\\\\\\\\\\\\\\"\\\\\\\"\\\">注释：strpos() 函数对大小写敏感。</p><p class=\\\"\\\\\\\"\\\\\\\\\\\\\\\"note\\\\\\\\\\\\\\\"\\\\\\\"\\\">注释：该函数是二进制安全的。</p><p>相关函数：stripos() - 查找字符串在另一字符串中第一次出现的位置（不区分大小写）strripos() - 查找字符串在另一字符串中最后一次出现的位置（不区分大小写）strrpos() - 查找字符串在另一字符串中最后一次出现的位置（区分大小写）</p><p></p>', '/Uploads/Download/2015-08-26/55dd7baf6f687.jpg', 1, 1489136457, 'admin');
INSERT INTO `merit` VALUES (2, 1, 'PHP网站开发', '<p>定义和用法</p><p>strpos() 函数查找字符串在另一字符串中第一次出现的位置。</p><p class=\\\"\\\\\\\"note\\\\\\\"\\\">注释：strpos() 函数对大小写敏感。</p><p class=\\\"\\\\\\\"note\\\\\\\"\\\">注释：该函数是二进制安全的。</p><p>相关函数：stripos() - 查找字符串在另一字符串中第一次出现的位置（不区分大小写）strripos() - 查找字符串在另一字符串中最后一次出现的位置（不区分大小写）strrpos() - 查找字符串在另一字符串中最后一次出现的位置（区分大小写）</p><p></p>', '/Uploads/Download/2015-08-26/55dd5b50bbdda.jpg', 1, 1489136521, 'admin');
INSERT INTO `merit` VALUES (3, 1, 'Wordpress网站开发', '<p>定义和用法</p><p>strpos() 函数查找字符串在另一字符串中第一次出现的位置。</p><p class=\\\"\\\\\\\"note\\\\\\\"\\\">注释：strpos() 函数对大小写敏感。</p><p class=\\\"\\\\\\\"note\\\\\\\"\\\">注释：该函数是二进制安全的。</p><p>相关函数：stripos() - 查找字符串在另一字符串中第一次出现的位置（不区分大小写）strripos() - 查找字符串在另一字符串中最后一次出现的位置（不区分大小写）strrpos() - 查找字符串在另一字符串中最后一次出现的位置（区分大小写）</p><p></p>', '/Uploads/Picture/2017-03-10/58c26427773ba.jpg', 1, 1489136554, 'admin');
INSERT INTO `merit` VALUES (4, 1, 'HTML5开发', '<p>定义和用法</p><p>strpos() 函数查找字符串在另一字符串中第一次出现的位置。</p><p class=\\\"\\\\\\\"note\\\\\\\"\\\">注释：strpos() 函数对大小写敏感。</p><p class=\\\"\\\\\\\"note\\\\\\\"\\\">注释：该函数是二进制安全的。</p><p>相关函数：stripos() - 查找字符串在另一字符串中第一次出现的位置（不区分大小写）strripos() - 查找字符串在另一字符串中最后一次出现的位置（不区分大小写）strrpos() - 查找字符串在另一字符串中最后一次出现的位置（区分大小写）</p><p></p>', '/Uploads/Picture/2017-03-10/58c26427773ba.jpg', 1, 1489136573, 'admin');
INSERT INTO `merit` VALUES (5, 1, '网页切图', '<p>定义和用法</p><p>strpos() 函数查找字符串在另一字符串中第一次出现的位置。</p><p class=\\\"\\\\\\\"note\\\\\\\"\\\">注释：strpos() 函数对大小写敏感。</p><p class=\\\"\\\\\\\"note\\\\\\\"\\\">注释：该函数是二进制安全的。</p><p>相关函数：stripos() - 查找字符串在另一字符串中第一次出现的位置（不区分大小写）strripos() - 查找字符串在另一字符串中最后一次出现的位置（不区分大小写）strrpos() - 查找字符串在另一字符串中最后一次出现的位置（区分大小写）</p><p></p>', '/Uploads/Picture/2017-03-10/58c24f87aefec.jpg', 1, 1489136596, 'admin');

-- ----------------------------
-- Table structure for note
-- ----------------------------
DROP TABLE IF EXISTS `note`;
CREATE TABLE `note`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '随笔标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '随笔内容',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '作者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '随笔信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of note
-- ----------------------------
INSERT INTO `note` VALUES (1, '111111111', '<p><embed type=\"application/x-shockwave-flash\" class=\"edui-faked-video\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" src=\"http://www.tudou.com/a/8XqZswYLy4s/&iid=133190980&resourceId=0_04_05_99/v.swf\" width=\"420\" height=\"280\" style=\"float:none\" wmode=\"transparent\" play=\"true\" loop=\"false\" menu=\"false\" allowscriptaccess=\"never\" allowfullscreen=\"true\"/></p><p><br/></p><p><span style=\"color:#e5b9b7\"><span style=\"text-decoration:underline;\"><em><strong>123123123123123123123</strong></em></span></span><br/></p>', 1, 1476350007, 'admin');
INSERT INTO `note` VALUES (2, '123', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing \r\nelit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\r\n Duis aute irure dolor in reprehenderit in voluptate velit esse cillum \r\ndolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non \r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n Integer posuere erat a ante venenatis dapibus posuere velit aliquet. \r\nDuis mollis, est non commodo luctus, nisi erat porttitor ligula, eget \r\nlacinia odio sem nec elit ornare sem lacinia quam venenatis vestibulum. \r\nVenenatis dapibus posuere velit aliquet. Duis mollis, est non commodo \r\nluctus, nisi erat porttitor ligula, eget lacinia.</p><p><img src=\"file:///C:/Users/wanglan/Desktop/entiri%20-%20%E5%89%AF%E6%9C%AC/img/1-6.jpg\"/>\r\n                  <img src=\"http://localhost:8094/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg\" _src=\"http://localhost:8094/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg\"/></p><p>Donec sed odio dui. Nulla vitae elit libero, a \r\npharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. \r\nInteger posuere erat a ante venenatis dapibus posuere velit aliquet.Pie \r\nwafer wypas candy canes toffee. Cookie icing candy jelly oat cake chupa \r\nchups bear claw topping applicake. Cookie danish dessert pie. \r\nMarshmallow wypas dessert. Chocolate cake sweet cotton candy toffee \r\ntopping lollipop. Gummi bears cake chocolate cake tiramisu sesame snaps.</p><p><img src=\"file:///C:/Users/wanglan/Desktop/entiri%20-%20%E5%89%AF%E6%9C%AC/img/1-6.jpg\"/>\r\n                  <img src=\"http://localhost:8094/Uploads/Download/2015-08-26/55dd7baf6f687.jpg\" _src=\"http://localhost:8094/Uploads/Download/2015-08-26/55dd7baf6f687.jpg\"/></p><blockquote>Sugar plum sugar plum liquorice cookie ice cream \r\ncaramels oat cake drag茅e. Dessert cookie faworki applicake apple pie. \r\nGingerbread cotton candy icing ice cream applicake wafer powder lemon \r\ndrops. Jujubes cheesecake marshmallow muffin. Bear claw muffin cotton \r\ncandy. Sweet roll pie drag茅e. Caramels gingerbread powder.</blockquote><p><img src=\"file:///C:/Users/wanglan/Desktop/entiri%20-%20%E5%89%AF%E6%9C%AC/img/1-6.jpg\"/>\r\n                  <img src=\"http://api.map.baidu.com/staticimage?center=116.404,39.915&zoom=10&width=528&height=338&markers=116.404,39.915\" height=\"338\" width=\"528\"/></p><p>Candy canes donut macaroon jelly-o icing carrot cake \r\ncheesecake. Powder ice cream marshmallow bonbon cupcake. Bear claw sweet\r\n roll marzipan macaroon wypas. Gummies donut brownie faworki toffee \r\ntoffee marshmallow marzipan. Gummies sugar plum brownie macaroon. Wafer \r\nchocolate cake topping. Ice cream applicake gummies pastry cookie \r\nlollipop. Candy canes gummies cookie lollipop cake. Tootsie roll cookie \r\ndanish ice cream croissant cotton candy souffl茅 danish bonbon. Pie \r\ngummies oat cake souffl茅 fruitcake faworki souffl茅 sesame snaps \r\nfruitcake. Caramels macaroon pudding wafer. Cake caramels bonbon chupa \r\nchups oat cake candy.</p><p><br/></p>', 1, 1489388056, 'admin');
INSERT INTO `note` VALUES (3, '2221', '<p>123123123<img src=\"http://localhost:8094/Uploads/Picture/2017-03-10/58c26427773ba.jpg\" _src=\"http://localhost:8094/Uploads/Picture/2017-03-10/58c26427773ba.jpg\"/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (4, '3331', '<p>123123123<br/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (5, '4441', '<p>123123123<img src=\"http://localhost:8094/Uploads/Picture/2016-06-24/576ca3c85df1d.jpg\" _src=\"http://localhost:8094/Uploads/Picture/2016-06-24/576ca3c85df1d.jpg\"/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (6, '5551', '<p>123123123<br/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (7, '6661', '<p>123123123<br/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (8, '7771', '<p>123123123<br/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (9, '8881', '<p>123123123<br/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (10, '99914', '<p>123123123<br/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (11, '123123123123', '<p>123123123<br/></p>', 1, 1489465690, 'admin');
INSERT INTO `note` VALUES (12, 'Mysql面试题', '<p>一、<strong>mysql相关知识</strong><br/>    1、 mysql优化方式<br/>            <a href=\"http://blog.csdn.net/jinxingfeng_cn/article/details/16878355\" target=\"_blank\">MYSQL 优化常用方法</a><br/>            <a href=\"http://blog.csdn.net/jinxingfeng_cn/article/details/16878295\" target=\"_blank\">mysql 性能优化方案</a><br/>  <br/>    2、如何分库分表<br/>           参考：<br/><a href=\"http://blog.sina.com.cn/s/blog_6e322ce70100zs9a.html\" target=\"_blank\">   http://blog.sina.com.cn/s/blog_6e322ce70100zs9a.html</a><br/>           <a href=\"http://www.jb51.net/article/29771.htm\" target=\"_blank\">http://www.jb51.net/article/29771.htm</a><br/><br/>   3、 Mysql+如何做双机热备和负载均衡<br/>http://www.dewen.org/q/51/Mysql+如何做双机热备和负载均衡<br/>    <br/>   4、数据表类型有哪些<br/>       MyISAM、<em>InnoDB、H</em>EAP、BOB,ARCHIVE,CSV等<br/>       MyISAM：成熟、稳定、易于管理，快速读取。一些功能不支持（事务等），表级锁。<br/>       <em>InnoDB</em>：支持事务、外键等特性、数据行锁定。空间占用大，不支持全文索引等。<br/><br/>       myisam和Innodb引擎的主要特点<br/>       <a href=\"http://www.dewen.org/q/196/MySQL%E7%9A%84%E5%AD%98%E5%82%A8%E5%BC%95%E6%93%8EMyISAM%E4%B8%8EInnoDB%E6%9C%89%E4%BB%80%E4%B9%88%E5%8C%BA%E5%88%AB%EF%BC%9F\" target=\"_blank\">MySQL的存储引擎MyISAM与InnoDB有什么区别？</a><br/><br/>   5、防sql注入方法<br/>      <span class=\"pln\">mysql_escape_string<span class=\"pun\">(<span class=\"pln\">strip_tags<span class=\"pun\">(<span class=\"pln\">$arr<span class=\"pun\">[<span class=\"str\">\"$val\"<span class=\"pun\">]));<br/></span></span></span></span></span></span></span></span></p><ol class=\"linenums\"><li class=\"L5\"><span class=\"com\">/**<br/></span></li><li class=\"L6\"><span class=\"com\">* 函数名称：post_check() <br/></span></li><li class=\"L7\"><span class=\"com\">* 函数作用：对提交的编辑内容进行处理 <br/></span></li><li class=\"L8\"><span class=\"com\">* 参　　数：$post: 要提交的内容 <br/></span></li><li class=\"L9\"><span class=\"com\">* 返 回 值：$post: 返回过滤后的内容 <br/></span></li><li class=\"L0\"><span class=\"com\">*/<span class=\"pln\"><br/></span></span></li><li class=\"L1\"><span class=\"pln\"><span class=\"kwd\">function<span class=\"pln\"> post_check<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">)<span class=\"pln\"><span class=\"pun\">{<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L2\"><span class=\"pln\"><span class=\"kwd\">if<span class=\"pun\">(!<span class=\"pln\">get_magic_quotes_gpc<span class=\"pun\">())<span class=\"pln\"><span class=\"pun\">{<span class=\"pln\"><span class=\"com\">//\r\n 判断magic_quotes_gpc是否为打开 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></li><li class=\"L3\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> addslashes<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n 进行magic_quotes_gpc没有打开的情况对提交数据的过滤 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L4\"><span class=\"pln\"><span class=\"pun\">}<span class=\"pln\"><br/></span></span></span></li><li class=\"L5\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> str_replace<span class=\"pun\">(<span class=\"str\">\"_\"<span class=\"pun\">,<span class=\"pln\"><span class=\"str\">\"\\_\"<span class=\"pun\">,<span class=\"pln\">\r\n $post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">// 把 \'_\'过滤掉<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></span></span></span></span></li><li class=\"L6\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> str_replace<span class=\"pun\">(<span class=\"str\">\"%\"<span class=\"pun\">,<span class=\"pln\"><span class=\"str\">\"\\%\"<span class=\"pun\">,<span class=\"pln\">\r\n $post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">// 把 \'%\'过滤掉<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></span></span></span></span></li><li class=\"L7\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> nl2br<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n 回车转换 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L8\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> htmlspecialchars<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n html标记转换 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L9\"><span class=\"pln\"><br/></span></li><li class=\"L0\"><span class=\"pln\"><span class=\"kwd\">return<span class=\"pln\"> $post<span class=\"pun\">;<span class=\"pln\"><br/></span></span></span></span></span></li><li class=\"L1\"><span class=\"pln\"><span class=\"pun\">}</span></span></li></ol><p> </p><p>   6、mysql把一个大表拆分多个表后,如何解决跨表查询效率问题<br/>   7、索引应用<br/>         什么情况下考虑索引<br/>         什么情况不适合索引<br/>         一个语句是否用到索引如何判断<br/>        经常发生的用不到索引的场景：<br/>                like \'%.....\'<br/>                数据类型隐式转换<br/>                or 关键字加其它条件约束<br/>       全文索引：<br/>                只能用于MYIsAM表，在CHAR,VARCHAR,TEXT类型的列上创建。<br/>       </p><p>   8、mysql对于大表(千万级),要怎么优化呢?<br/>        参考http://www.zhihu.com/question/19719997<br/><br/>   9、mysql的慢查询问题<br/>  其实通过慢查询日志来分析是一种比较简单的方式，如果不想看日志，可以借助工具来完成，</p><p>如mysqldumpslow, mysqlsla, myprofi, mysql-explain-slow-log, mysqllogfilter等，感觉自己来分析一个需要丰富的经验，一个浪费时间。</p><p>10、关于用户登录状态存session,cookie还是数据库或者memcache的优劣 http://www.dewen.org/q/11504/</p><p>关于用户登录状态存session%2Ccookie还是数据库或者memcache的优劣</p><p>  11、事务应用极端情况处理<br/>  12、sql语言分4大类请列举<br/>        DDL--CREATE,DROP,ALTER<br/>        DML--INSERT,UPDATE,DELETE<br/>        DQL-SELECT<br/>        DCL--GRANT,REVOKE,COMMIT,ROLLBACK<br/>         <br/></p><p><br/></p>', 1, 1501217917, 'admin');
INSERT INTO `note` VALUES (13, 'Mysql面试题', '<p>一、<strong>mysql相关知识</strong><br/>    1、 mysql优化方式<br/>            <a href=\"http://blog.csdn.net/jinxingfeng_cn/article/details/16878355\" target=\"_blank\">MYSQL 优化常用方法</a><br/>            <a href=\"http://blog.csdn.net/jinxingfeng_cn/article/details/16878295\" target=\"_blank\">mysql 性能优化方案</a><br/>  <br/>    2、如何分库分表<br/>           参考：<br/><a href=\"http://blog.sina.com.cn/s/blog_6e322ce70100zs9a.html\" target=\"_blank\">   http://blog.sina.com.cn/s/blog_6e322ce70100zs9a.html</a><br/>           <a href=\"http://www.jb51.net/article/29771.htm\" target=\"_blank\">http://www.jb51.net/article/29771.htm</a><br/><br/>   3、 Mysql+如何做双机热备和负载均衡<br/>http://www.dewen.org/q/51/Mysql+如何做双机热备和负载均衡<br/>    <br/>   4、数据表类型有哪些<br/>       MyISAM、<em>InnoDB、H</em>EAP、BOB,ARCHIVE,CSV等<br/>       MyISAM：成熟、稳定、易于管理，快速读取。一些功能不支持（事务等），表级锁。<br/>       <em>InnoDB</em>：支持事务、外键等特性、数据行锁定。空间占用大，不支持全文索引等。<br/><br/>       myisam和Innodb引擎的主要特点<br/>       <a href=\"http://www.dewen.org/q/196/MySQL%E7%9A%84%E5%AD%98%E5%82%A8%E5%BC%95%E6%93%8EMyISAM%E4%B8%8EInnoDB%E6%9C%89%E4%BB%80%E4%B9%88%E5%8C%BA%E5%88%AB%EF%BC%9F\" target=\"_blank\">MySQL的存储引擎MyISAM与InnoDB有什么区别？</a><br/><br/>   5、防sql注入方法<br/>      <span class=\"pln\">mysql_escape_string<span class=\"pun\">(<span class=\"pln\">strip_tags<span class=\"pun\">(<span class=\"pln\">$arr<span class=\"pun\">[<span class=\"str\">\"$val\"<span class=\"pun\">]));<br/></span></span></span></span></span></span></span></span></p><ol class=\"linenums\"><li class=\"L5\"><span class=\"com\">/**<br/></span></li><li class=\"L6\"><span class=\"com\">* 函数名称：post_check() <br/></span></li><li class=\"L7\"><span class=\"com\">* 函数作用：对提交的编辑内容进行处理 <br/></span></li><li class=\"L8\"><span class=\"com\">* 参　　数：$post: 要提交的内容 <br/></span></li><li class=\"L9\"><span class=\"com\">* 返 回 值：$post: 返回过滤后的内容 <br/></span></li><li class=\"L0\"><span class=\"com\">*/<span class=\"pln\"><br/></span></span></li><li class=\"L1\"><span class=\"pln\"><span class=\"kwd\">function<span class=\"pln\"> post_check<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">)<span class=\"pln\"><span class=\"pun\">{<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L2\"><span class=\"pln\"><span class=\"kwd\">if<span class=\"pun\">(!<span class=\"pln\">get_magic_quotes_gpc<span class=\"pun\">())<span class=\"pln\"><span class=\"pun\">{<span class=\"pln\"><span class=\"com\">//\r\n 判断magic_quotes_gpc是否为打开 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></li><li class=\"L3\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> addslashes<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n 进行magic_quotes_gpc没有打开的情况对提交数据的过滤 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L4\"><span class=\"pln\"><span class=\"pun\">}<span class=\"pln\"><br/></span></span></span></li><li class=\"L5\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> str_replace<span class=\"pun\">(<span class=\"str\">\"_\"<span class=\"pun\">,<span class=\"pln\"><span class=\"str\">\"\\_\"<span class=\"pun\">,<span class=\"pln\">\r\n $post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">// 把 \'_\'过滤掉<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></span></span></span></span></li><li class=\"L6\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> str_replace<span class=\"pun\">(<span class=\"str\">\"%\"<span class=\"pun\">,<span class=\"pln\"><span class=\"str\">\"\\%\"<span class=\"pun\">,<span class=\"pln\">\r\n $post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">// 把 \'%\'过滤掉<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></span></span></span></span></li><li class=\"L7\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> nl2br<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n 回车转换 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L8\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> htmlspecialchars<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n html标记转换 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L9\"><span class=\"pln\"><br/></span></li><li class=\"L0\"><span class=\"pln\"><span class=\"kwd\">return<span class=\"pln\"> $post<span class=\"pun\">;<span class=\"pln\"><br/></span></span></span></span></span></li><li class=\"L1\"><span class=\"pln\"><span class=\"pun\">}</span></span></li></ol><p> </p><p>   6、mysql把一个大表拆分多个表后,如何解决跨表查询效率问题<br/>   7、索引应用<br/>         什么情况下考虑索引<br/>         什么情况不适合索引<br/>         一个语句是否用到索引如何判断<br/>        经常发生的用不到索引的场景：<br/>                like \'%.....\'<br/>                数据类型隐式转换<br/>                or 关键字加其它条件约束<br/>       全文索引：<br/>                只能用于MYIsAM表，在CHAR,VARCHAR,TEXT类型的列上创建。<br/>       </p><p>   8、mysql对于大表(千万级),要怎么优化呢?<br/>        参考http://www.zhihu.com/question/19719997<br/><br/>   9、mysql的慢查询问题<br/>  其实通过慢查询日志来分析是一种比较简单的方式，如果不想看日志，可以借助工具来完成，</p><p>如mysqldumpslow, mysqlsla, myprofi, mysql-explain-slow-log, mysqllogfilter等，感觉自己来分析一个需要丰富的经验，一个浪费时间。</p><p>10、关于用户登录状态存session,cookie还是数据库或者memcache的优劣 http://www.dewen.org/q/11504/</p><p>关于用户登录状态存session%2Ccookie还是数据库或者memcache的优劣</p><p>  11、事务应用极端情况处理<br/>  12、sql语言分4大类请列举<br/>        DDL--CREATE,DROP,ALTER<br/>        DML--INSERT,UPDATE,DELETE<br/>        DQL-SELECT<br/>        DCL--GRANT,REVOKE,COMMIT,ROLLBACK<br/>         <br/></p><p><br/></p>', 1, 1501217936, 'admin');
INSERT INTO `note` VALUES (14, 'Mysql面试题', '<p>一、<strong>mysql相关知识</strong><br/>    1、 mysql优化方式<br/>            <a href=\"http://blog.csdn.net/jinxingfeng_cn/article/details/16878355\" target=\"_blank\">MYSQL 优化常用方法</a><br/>            <a href=\"http://blog.csdn.net/jinxingfeng_cn/article/details/16878295\" target=\"_blank\">mysql 性能优化方案</a><br/>  <br/>    2、如何分库分表<br/>           参考：<br/><a href=\"http://blog.sina.com.cn/s/blog_6e322ce70100zs9a.html\" target=\"_blank\">   http://blog.sina.com.cn/s/blog_6e322ce70100zs9a.html</a><br/>           <a href=\"http://www.jb51.net/article/29771.htm\" target=\"_blank\">http://www.jb51.net/article/29771.htm</a><br/><br/>   3、 Mysql+如何做双机热备和负载均衡<br/>http://www.dewen.org/q/51/Mysql+如何做双机热备和负载均衡<br/>    <br/>   4、数据表类型有哪些<br/>       MyISAM、<em>InnoDB、H</em>EAP、BOB,ARCHIVE,CSV等<br/>       MyISAM：成熟、稳定、易于管理，快速读取。一些功能不支持（事务等），表级锁。<br/>       <em>InnoDB</em>：支持事务、外键等特性、数据行锁定。空间占用大，不支持全文索引等。<br/><br/>       myisam和Innodb引擎的主要特点<br/>       <a href=\"http://www.dewen.org/q/196/MySQL%E7%9A%84%E5%AD%98%E5%82%A8%E5%BC%95%E6%93%8EMyISAM%E4%B8%8EInnoDB%E6%9C%89%E4%BB%80%E4%B9%88%E5%8C%BA%E5%88%AB%EF%BC%9F\" target=\"_blank\">MySQL的存储引擎MyISAM与InnoDB有什么区别？</a><br/><br/>   5、防sql注入方法<br/>      <span class=\"pln\">mysql_escape_string<span class=\"pun\">(<span class=\"pln\">strip_tags<span class=\"pun\">(<span class=\"pln\">$arr<span class=\"pun\">[<span class=\"str\">\"$val\"<span class=\"pun\">]));<br/></span></span></span></span></span></span></span></span></p><ol class=\"linenums\"><li class=\"L5\"><span class=\"com\">/**<br/></span></li><li class=\"L6\"><span class=\"com\">* 函数名称：post_check() <br/></span></li><li class=\"L7\"><span class=\"com\">* 函数作用：对提交的编辑内容进行处理 <br/></span></li><li class=\"L8\"><span class=\"com\">* 参　　数：$post: 要提交的内容 <br/></span></li><li class=\"L9\"><span class=\"com\">* 返 回 值：$post: 返回过滤后的内容 <br/></span></li><li class=\"L0\"><span class=\"com\">*/<span class=\"pln\"><br/></span></span></li><li class=\"L1\"><span class=\"pln\"><span class=\"kwd\">function<span class=\"pln\"> post_check<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">)<span class=\"pln\"><span class=\"pun\">{<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L2\"><span class=\"pln\"><span class=\"kwd\">if<span class=\"pun\">(!<span class=\"pln\">get_magic_quotes_gpc<span class=\"pun\">())<span class=\"pln\"><span class=\"pun\">{<span class=\"pln\"><span class=\"com\">//\r\n 判断magic_quotes_gpc是否为打开 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></li><li class=\"L3\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> addslashes<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n 进行magic_quotes_gpc没有打开的情况对提交数据的过滤 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L4\"><span class=\"pln\"><span class=\"pun\">}<span class=\"pln\"><br/></span></span></span></li><li class=\"L5\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> str_replace<span class=\"pun\">(<span class=\"str\">\"_\"<span class=\"pun\">,<span class=\"pln\"><span class=\"str\">\"\\_\"<span class=\"pun\">,<span class=\"pln\">\r\n $post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">// 把 \'_\'过滤掉<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></span></span></span></span></li><li class=\"L6\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> str_replace<span class=\"pun\">(<span class=\"str\">\"%\"<span class=\"pun\">,<span class=\"pln\"><span class=\"str\">\"\\%\"<span class=\"pun\">,<span class=\"pln\">\r\n $post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">// 把 \'%\'过滤掉<span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></span></span></span></span></span></li><li class=\"L7\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> nl2br<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n 回车转换 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L8\"><span class=\"pln\">$post <span class=\"pun\">=<span class=\"pln\"> htmlspecialchars<span class=\"pun\">(<span class=\"pln\">$post<span class=\"pun\">);<span class=\"pln\"><span class=\"com\">//\r\n html标记转换 <span class=\"pln\"><br/></span></span></span></span></span></span></span></span></span></li><li class=\"L9\"><span class=\"pln\"><br/></span></li><li class=\"L0\"><span class=\"pln\"><span class=\"kwd\">return<span class=\"pln\"> $post<span class=\"pun\">;<span class=\"pln\"><br/></span></span></span></span></span></li><li class=\"L1\"><span class=\"pln\"><span class=\"pun\">}</span></span></li></ol><p> </p><p>   6、mysql把一个大表拆分多个表后,如何解决跨表查询效率问题<br/>   7、索引应用<br/>         什么情况下考虑索引<br/>         什么情况不适合索引<br/>         一个语句是否用到索引如何判断<br/>        经常发生的用不到索引的场景：<br/>                like \'%.....\'<br/>                数据类型隐式转换<br/>                or 关键字加其它条件约束<br/>       全文索引：<br/>                只能用于MYIsAM表，在CHAR,VARCHAR,TEXT类型的列上创建。<br/>       </p><p>   8、mysql对于大表(千万级),要怎么优化呢?<br/>        参考http://www.zhihu.com/question/19719997<br/><br/>   9、mysql的慢查询问题<br/>  其实通过慢查询日志来分析是一种比较简单的方式，如果不想看日志，可以借助工具来完成，</p><p>如mysqldumpslow, mysqlsla, myprofi, mysql-explain-slow-log, mysqllogfilter等，感觉自己来分析一个需要丰富的经验，一个浪费时间。</p><p>10、关于用户登录状态存session,cookie还是数据库或者memcache的优劣 http://www.dewen.org/q/11504/</p><p>关于用户登录状态存session%2Ccookie还是数据库或者memcache的优劣</p><p>  11、事务应用极端情况处理<br/>  12、sql语言分4大类请列举<br/>        DDL--CREATE,DROP,ALTER<br/>        DML--INSERT,UPDATE,DELETE<br/>        DQL-SELECT<br/>        DCL--GRANT,REVOKE,COMMIT,ROLLBACK<br/>         <br/></p><p><br/></p>', 1, 1501217959, 'admin');

-- ----------------------------
-- Table structure for note_comment
-- ----------------------------
DROP TABLE IF EXISTS `note_comment`;
CREATE TABLE `note_comment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `nid` int(11) NULL DEFAULT NULL COMMENT '随笔编号',
  `content` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '回复内容',
  `reply_id` int(11) NULL DEFAULT NULL COMMENT '回复编号',
  `by_reply_id` int(11) NULL DEFAULT NULL COMMENT '被回复编号',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '随笔回复信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of note_comment
-- ----------------------------
INSERT INTO `note_comment` VALUES (1, 1, '111111111111', 2, 1, 1, 1489388056, 'admin');
INSERT INTO `note_comment` VALUES (2, 1, '123', NULL, NULL, 1, 1489557135, NULL);
INSERT INTO `note_comment` VALUES (3, 1, 'alert(1)', NULL, NULL, 1, 1489558027, NULL);
INSERT INTO `note_comment` VALUES (4, 1, ';\\\'#show tables#\\\'', NULL, NULL, 1, 1489558073, NULL);
INSERT INTO `note_comment` VALUES (5, 1, ';\\\\\\\'# show tables #\\\\\\\'', NULL, NULL, 1, 1489558086, NULL);
INSERT INTO `note_comment` VALUES (6, 14, '123123123123123213', NULL, NULL, 1, 1501217983, NULL);

-- ----------------------------
-- Table structure for note_extend
-- ----------------------------
DROP TABLE IF EXISTS `note_extend`;
CREATE TABLE `note_extend`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `nid` int(11) NOT NULL COMMENT '随笔编号',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '随笔图片链接地址',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '随笔扩展信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of note_extend
-- ----------------------------
INSERT INTO `note_extend` VALUES (1, 1, '/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg', 1);
INSERT INTO `note_extend` VALUES (2, 1, '/Uploads/Download/2015-08-28/55dfd4ecc305f.jpg', 1);
INSERT INTO `note_extend` VALUES (3, 1, '/Uploads/Download/2015-08-28/55dfd4eccba6b.jpg', 1);

-- ----------------------------
-- Table structure for page_view
-- ----------------------------
DROP TABLE IF EXISTS `page_view`;
CREATE TABLE `page_view`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `ip_address` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'IP地址',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1167 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '页面浏览量(PV)' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of page_view
-- ----------------------------
INSERT INTO `page_view` VALUES (1, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (2, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (3, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (4, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (5, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (6, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (7, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (8, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (9, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (10, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (11, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (12, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (13, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (14, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (15, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (16, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (17, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (18, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (19, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (20, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (21, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (22, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (23, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (24, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (25, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (26, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (27, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (28, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (29, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (30, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (31, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (32, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (33, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (34, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (35, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (36, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (37, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (38, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (39, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (40, '0', 1445183000, 1, '游客');
INSERT INTO `page_view` VALUES (41, '0', 1445239548, 1, '游客');
INSERT INTO `page_view` VALUES (42, '0', 1445239608, 1, '游客');
INSERT INTO `page_view` VALUES (43, '0', 1445239628, 1, '游客');
INSERT INTO `page_view` VALUES (44, '0', 1445239692, 1, '游客');
INSERT INTO `page_view` VALUES (45, '0', 1445240539, 1, '游客');
INSERT INTO `page_view` VALUES (46, '0', 1445241278, 1, '游客');
INSERT INTO `page_view` VALUES (47, '0', 1445241287, 1, '游客');
INSERT INTO `page_view` VALUES (48, '0', 1445241318, 1, '游客');
INSERT INTO `page_view` VALUES (49, '0', 1445243199, 1, '游客');
INSERT INTO `page_view` VALUES (50, '0', 1445304887, 1, '游客');
INSERT INTO `page_view` VALUES (51, '0', 1445494124, 1, '游客');
INSERT INTO `page_view` VALUES (52, '0', 1445494223, 1, '游客');
INSERT INTO `page_view` VALUES (53, '0', 1445494235, 1, '游客');
INSERT INTO `page_view` VALUES (54, '0', 1445494287, 1, '游客');
INSERT INTO `page_view` VALUES (55, '0', 1445494314, 1, '游客');
INSERT INTO `page_view` VALUES (56, '0', 1445494325, 1, '游客');
INSERT INTO `page_view` VALUES (57, '0', 1445494337, 1, '游客');
INSERT INTO `page_view` VALUES (58, '0', 1445494500, 1, '游客');
INSERT INTO `page_view` VALUES (59, '0', 1445494565, 1, '游客');
INSERT INTO `page_view` VALUES (60, '0', 1445497281, 1, '游客');
INSERT INTO `page_view` VALUES (61, '0', 1445582814, 1, '游客');
INSERT INTO `page_view` VALUES (62, '0', 1445824896, 1, '游客');
INSERT INTO `page_view` VALUES (63, '0', 1445841094, 1, '游客');
INSERT INTO `page_view` VALUES (64, '0', 1445842629, 1, '游客');
INSERT INTO `page_view` VALUES (65, '0', 1445909807, 1, '游客');
INSERT INTO `page_view` VALUES (66, '0', 1445910509, 1, '游客');
INSERT INTO `page_view` VALUES (67, '0', 1445911685, 1, '游客');
INSERT INTO `page_view` VALUES (68, '0', 1445911735, 1, '游客');
INSERT INTO `page_view` VALUES (69, '0', 1445912345, 1, '游客');
INSERT INTO `page_view` VALUES (70, '0', 1445913366, 1, '游客');
INSERT INTO `page_view` VALUES (71, '0', 1445913634, 1, '游客');
INSERT INTO `page_view` VALUES (72, '0', 1445927317, 1, '游客');
INSERT INTO `page_view` VALUES (73, '0', 1445927336, 1, '游客');
INSERT INTO `page_view` VALUES (74, '0', 1445928783, 1, '游客');
INSERT INTO `page_view` VALUES (75, '0', 1445928815, 1, '游客');
INSERT INTO `page_view` VALUES (76, '0', 1445928830, 1, '游客');
INSERT INTO `page_view` VALUES (77, '0', 1445929898, 1, '游客');
INSERT INTO `page_view` VALUES (78, '0', 1445929907, 1, '游客');
INSERT INTO `page_view` VALUES (79, '0', 1445929950, 1, '游客');
INSERT INTO `page_view` VALUES (80, '0', 1445930720, 1, '游客');
INSERT INTO `page_view` VALUES (81, '0', 1445930770, 1, '游客');
INSERT INTO `page_view` VALUES (82, '0', 1445930840, 1, '游客');
INSERT INTO `page_view` VALUES (83, '0', 1445930874, 1, '游客');
INSERT INTO `page_view` VALUES (84, '0', 1445930920, 1, '游客');
INSERT INTO `page_view` VALUES (85, '0', 1445937356, 1, '游客');
INSERT INTO `page_view` VALUES (86, '0', 1445937365, 1, '游客');
INSERT INTO `page_view` VALUES (87, '0', 1445995252, 1, '游客');
INSERT INTO `page_view` VALUES (88, '0', 1445999755, 1, '游客');
INSERT INTO `page_view` VALUES (89, '0', 1446003041, 1, '游客');
INSERT INTO `page_view` VALUES (90, '0', 1446003559, 1, '游客');
INSERT INTO `page_view` VALUES (91, '0', 1446004035, 1, '游客');
INSERT INTO `page_view` VALUES (92, '0', 1446004150, 1, '游客');
INSERT INTO `page_view` VALUES (93, '0', 1446005113, 1, '游客');
INSERT INTO `page_view` VALUES (94, '0', 1446083653, 1, '游客');
INSERT INTO `page_view` VALUES (95, '0', 1446083750, 1, '游客');
INSERT INTO `page_view` VALUES (96, '0', 1446086789, 1, '游客');
INSERT INTO `page_view` VALUES (97, '0', 1446086964, 1, '游客');
INSERT INTO `page_view` VALUES (98, '0', 1446086974, 1, '游客');
INSERT INTO `page_view` VALUES (99, '0', 1446087351, 1, '游客');
INSERT INTO `page_view` VALUES (100, '0', 1446166811, 1, '游客');
INSERT INTO `page_view` VALUES (101, '0', 1446170556, 1, '游客');
INSERT INTO `page_view` VALUES (102, '0', 1446170867, 1, '游客');
INSERT INTO `page_view` VALUES (103, '0', 1446171327, 1, '游客');
INSERT INTO `page_view` VALUES (104, '0', 1446171339, 1, '游客');
INSERT INTO `page_view` VALUES (105, '0', 1446173166, 1, '游客');
INSERT INTO `page_view` VALUES (106, '0', 1446173251, 1, '游客');
INSERT INTO `page_view` VALUES (107, '0', 1446176011, 1, '游客');
INSERT INTO `page_view` VALUES (108, '0', 1446180740, 1, '游客');
INSERT INTO `page_view` VALUES (109, '0', 1446185649, 1, '游客');
INSERT INTO `page_view` VALUES (110, '0', 1446185749, 1, '游客');
INSERT INTO `page_view` VALUES (111, '0', 1446186324, 1, '游客');
INSERT INTO `page_view` VALUES (112, '0', 1446186383, 1, '游客');
INSERT INTO `page_view` VALUES (113, '0', 1446186393, 1, '游客');
INSERT INTO `page_view` VALUES (114, '0', 1446186737, 1, '游客');
INSERT INTO `page_view` VALUES (115, '0', 1446187019, 1, '游客');
INSERT INTO `page_view` VALUES (116, '0', 1446190364, 1, '游客');
INSERT INTO `page_view` VALUES (117, '0', 1446433085, 1, '游客');
INSERT INTO `page_view` VALUES (118, '0', 1446433954, 1, '游客');
INSERT INTO `page_view` VALUES (119, '0', 1446433966, 1, '游客');
INSERT INTO `page_view` VALUES (120, '0', 1446433975, 1, '游客');
INSERT INTO `page_view` VALUES (121, '0', 1446444243, 1, '游客');
INSERT INTO `page_view` VALUES (122, '0', 1446514914, 1, '游客');
INSERT INTO `page_view` VALUES (123, '0', 1446530540, 1, '游客');
INSERT INTO `page_view` VALUES (124, '0', 1446542743, 1, '游客');
INSERT INTO `page_view` VALUES (125, '0', 1446600033, 1, '游客');
INSERT INTO `page_view` VALUES (126, '0', 1446685559, 1, '游客');
INSERT INTO `page_view` VALUES (127, '0', 1446772348, 1, '游客');
INSERT INTO `page_view` VALUES (128, '0', 1447029750, 1, '游客');
INSERT INTO `page_view` VALUES (129, '0', 1447060105, 1, '游客');
INSERT INTO `page_view` VALUES (130, '0', 1447060120, 1, '游客');
INSERT INTO `page_view` VALUES (131, '0', 1447118479, 1, '游客');
INSERT INTO `page_view` VALUES (132, '0', 1447205240, 1, '游客');
INSERT INTO `page_view` VALUES (133, '0', 1447205571, 1, '游客');
INSERT INTO `page_view` VALUES (134, '0', 1447208400, 1, '游客');
INSERT INTO `page_view` VALUES (135, '0', 1447290634, 1, '游客');
INSERT INTO `page_view` VALUES (136, '0', 1447290759, 1, '游客');
INSERT INTO `page_view` VALUES (137, '0', 1447382943, 1, '游客');
INSERT INTO `page_view` VALUES (138, '0', 1447721821, 1, '游客');
INSERT INTO `page_view` VALUES (139, '0', 1447741854, 1, '游客');
INSERT INTO `page_view` VALUES (140, '0', 1447809776, 1, '游客');
INSERT INTO `page_view` VALUES (141, '0', 1447896352, 1, '游客');
INSERT INTO `page_view` VALUES (142, '0', 1447901174, 1, '游客');
INSERT INTO `page_view` VALUES (143, '0', 1447980551, 1, '游客');
INSERT INTO `page_view` VALUES (144, '0', 1447986285, 1, '游客');
INSERT INTO `page_view` VALUES (145, '0', 1448007153, 1, '游客');
INSERT INTO `page_view` VALUES (146, '0', 1448240732, 1, '游客');
INSERT INTO `page_view` VALUES (147, '0', 1448327555, 1, '游客');
INSERT INTO `page_view` VALUES (148, '0', 1448349100, 1, '游客');
INSERT INTO `page_view` VALUES (149, '0', 1448353987, 1, '游客');
INSERT INTO `page_view` VALUES (150, '0', 1448354136, 1, '游客');
INSERT INTO `page_view` VALUES (151, '0', 1448415911, 1, '游客');
INSERT INTO `page_view` VALUES (152, '3232256323', 1448507120, 1, '游客');
INSERT INTO `page_view` VALUES (153, '3232256323', 1448611571, 1, '游客');
INSERT INTO `page_view` VALUES (154, '3232256323', 1448865496, 1, '游客');
INSERT INTO `page_view` VALUES (155, '3232256323', 1448935777, 1, '游客');
INSERT INTO `page_view` VALUES (156, '3232256323', 1448935910, 1, '游客');
INSERT INTO `page_view` VALUES (157, '3232256323', 1448936659, 1, '游客');
INSERT INTO `page_view` VALUES (158, '3232256323', 1448938212, 1, '游客');
INSERT INTO `page_view` VALUES (159, '3232256323', 1449018524, 1, '游客');
INSERT INTO `page_view` VALUES (160, '3232256322', 1449038333, 1, '游客');
INSERT INTO `page_view` VALUES (161, '3232256322', 1449046390, 1, '游客');
INSERT INTO `page_view` VALUES (162, '3232256322', 1449108547, 1, '游客');
INSERT INTO `page_view` VALUES (163, '3232256322', 1449110181, 1, '游客');
INSERT INTO `page_view` VALUES (164, '3232256322', 1449110758, 1, '游客');
INSERT INTO `page_view` VALUES (165, '3232256322', 1449110786, 1, '游客');
INSERT INTO `page_view` VALUES (166, '3232256322', 1449112773, 1, '游客');
INSERT INTO `page_view` VALUES (167, '3232256322', 1449117736, 1, '游客');
INSERT INTO `page_view` VALUES (168, '3232256323', 1449208986, 1, '游客');
INSERT INTO `page_view` VALUES (169, '3232256323', 1449209419, 1, '游客');
INSERT INTO `page_view` VALUES (170, '3232256323', 1449209445, 1, '游客');
INSERT INTO `page_view` VALUES (171, '3232256323', 1449209529, 1, '游客');
INSERT INTO `page_view` VALUES (172, '3232256323', 1449214238, 1, '游客');
INSERT INTO `page_view` VALUES (173, '3232256323', 1449214490, 1, '游客');
INSERT INTO `page_view` VALUES (174, '3232256323', 1449214673, 1, '游客');
INSERT INTO `page_view` VALUES (175, '3232256323', 1449214700, 1, '游客');
INSERT INTO `page_view` VALUES (176, '3232256323', 1449214707, 1, '游客');
INSERT INTO `page_view` VALUES (177, '3232256323', 1449215880, 1, '游客');
INSERT INTO `page_view` VALUES (178, '3232256323', 1449215980, 1, '游客');
INSERT INTO `page_view` VALUES (179, '3232256323', 1449451461, 1, '游客');
INSERT INTO `page_view` VALUES (180, '3232256323', 1449451831, 1, '游客');
INSERT INTO `page_view` VALUES (181, '3232256323', 1449451874, 1, '游客');
INSERT INTO `page_view` VALUES (182, '3232256323', 1449451877, 1, '游客');
INSERT INTO `page_view` VALUES (183, '3232256323', 1449451889, 1, '游客');
INSERT INTO `page_view` VALUES (184, '3232256323', 1449452062, 1, '游客');
INSERT INTO `page_view` VALUES (185, '3232256323', 1449452065, 1, '游客');
INSERT INTO `page_view` VALUES (186, '3232256323', 1449452078, 1, '游客');
INSERT INTO `page_view` VALUES (187, '3232256323', 1449452097, 1, '游客');
INSERT INTO `page_view` VALUES (188, '3232256323', 1449467337, 1, '游客');
INSERT INTO `page_view` VALUES (189, '3232256323', 1449470715, 1, '游客');
INSERT INTO `page_view` VALUES (190, '3232256323', 1449470960, 1, '游客');
INSERT INTO `page_view` VALUES (191, '3232256323', 1449471967, 1, '游客');
INSERT INTO `page_view` VALUES (192, '3232256323', 1449472421, 1, '游客');
INSERT INTO `page_view` VALUES (193, '3232256323', 1449473507, 1, '游客');
INSERT INTO `page_view` VALUES (194, '3232256323', 1449474107, 1, '游客');
INSERT INTO `page_view` VALUES (195, '3232256323', 1449474116, 1, '游客');
INSERT INTO `page_view` VALUES (196, '3232256323', 1449474166, 1, '游客');
INSERT INTO `page_view` VALUES (197, '3232256323', 1449474781, 1, '游客');
INSERT INTO `page_view` VALUES (198, '3232256323', 1449475125, 1, '游客');
INSERT INTO `page_view` VALUES (199, '3232256323', 1449475282, 1, '游客');
INSERT INTO `page_view` VALUES (200, '3232256323', 1449475776, 1, '游客');
INSERT INTO `page_view` VALUES (201, '3232256323', 1449475819, 1, '游客');
INSERT INTO `page_view` VALUES (202, '3232256323', 1449476065, 1, '游客');
INSERT INTO `page_view` VALUES (203, '3232256323', 1449476066, 1, '游客');
INSERT INTO `page_view` VALUES (204, '3232256323', 1449476305, 1, '游客');
INSERT INTO `page_view` VALUES (205, '3232256323', 1449476305, 1, '游客');
INSERT INTO `page_view` VALUES (206, '3232256323', 1449476651, 1, '游客');
INSERT INTO `page_view` VALUES (207, '3232256323', 1449476814, 1, '游客');
INSERT INTO `page_view` VALUES (208, '3232256323', 1449476862, 1, '游客');
INSERT INTO `page_view` VALUES (209, '3232256323', 1449478976, 1, '游客');
INSERT INTO `page_view` VALUES (210, '3232256323', 1449479745, 1, '游客');
INSERT INTO `page_view` VALUES (211, '3232256323', 1449483331, 1, '游客');
INSERT INTO `page_view` VALUES (212, '3232256323', 1449535181, 1, '游客');
INSERT INTO `page_view` VALUES (213, '3232256323', 1449536811, 1, '游客');
INSERT INTO `page_view` VALUES (214, '3232256323', 1449536821, 1, '游客');
INSERT INTO `page_view` VALUES (215, '3232256323', 1449536840, 1, '游客');
INSERT INTO `page_view` VALUES (216, '3232256323', 1449536855, 1, '游客');
INSERT INTO `page_view` VALUES (217, '3232256323', 1449536981, 1, '游客');
INSERT INTO `page_view` VALUES (218, '3232256323', 1449537000, 1, '游客');
INSERT INTO `page_view` VALUES (219, '3232256323', 1449537106, 1, '游客');
INSERT INTO `page_view` VALUES (220, '3232256323', 1449537120, 1, '游客');
INSERT INTO `page_view` VALUES (221, '3232256323', 1449537128, 1, '游客');
INSERT INTO `page_view` VALUES (222, '3232256323', 1449537136, 1, '游客');
INSERT INTO `page_view` VALUES (223, '3232256323', 1449537152, 1, '游客');
INSERT INTO `page_view` VALUES (224, '3232256323', 1449537204, 1, '游客');
INSERT INTO `page_view` VALUES (225, '3232256323', 1449537365, 1, '游客');
INSERT INTO `page_view` VALUES (226, '3232256323', 1449537372, 1, '游客');
INSERT INTO `page_view` VALUES (227, '3232256323', 1449537449, 1, '游客');
INSERT INTO `page_view` VALUES (228, '3232256323', 1449537457, 1, '游客');
INSERT INTO `page_view` VALUES (229, '3232256323', 1449537653, 1, '游客');
INSERT INTO `page_view` VALUES (230, '3232256323', 1449537795, 1, '游客');
INSERT INTO `page_view` VALUES (231, '3232256323', 1449538766, 1, '游客');
INSERT INTO `page_view` VALUES (232, '3232256323', 1449538816, 1, '游客');
INSERT INTO `page_view` VALUES (233, '3232256323', 1449539031, 1, '游客');
INSERT INTO `page_view` VALUES (234, '3232256323', 1449539330, 1, '游客');
INSERT INTO `page_view` VALUES (235, '3232256323', 1449540858, 1, '游客');
INSERT INTO `page_view` VALUES (236, '3232256323', 1449541290, 1, '游客');
INSERT INTO `page_view` VALUES (237, '3232256323', 1449541488, 1, '游客');
INSERT INTO `page_view` VALUES (238, '3232256323', 1449543097, 1, '游客');
INSERT INTO `page_view` VALUES (239, '3232256323', 1449543314, 1, '游客');
INSERT INTO `page_view` VALUES (240, '3232256323', 1449545025, 1, '游客');
INSERT INTO `page_view` VALUES (241, '3232256323', 1449553430, 1, '游客');
INSERT INTO `page_view` VALUES (242, '3232256323', 1449553489, 1, '游客');
INSERT INTO `page_view` VALUES (243, '3232256323', 1449555532, 1, '游客');
INSERT INTO `page_view` VALUES (244, '3232256323', 1449556517, 1, '游客');
INSERT INTO `page_view` VALUES (245, '3232256323', 1449556556, 1, '游客');
INSERT INTO `page_view` VALUES (246, '3232256323', 1449556557, 1, '游客');
INSERT INTO `page_view` VALUES (247, '3232256323', 1449556650, 1, '游客');
INSERT INTO `page_view` VALUES (248, '3232256323', 1449557069, 1, '游客');
INSERT INTO `page_view` VALUES (249, '3232256323', 1449557139, 1, '游客');
INSERT INTO `page_view` VALUES (250, '3232256323', 1449557929, 1, '游客');
INSERT INTO `page_view` VALUES (251, '3232256323', 1449558771, 1, '游客');
INSERT INTO `page_view` VALUES (252, '3232256323', 1449559270, 1, '游客');
INSERT INTO `page_view` VALUES (253, '3232256323', 1449559763, 1, '游客');
INSERT INTO `page_view` VALUES (254, '3232256323', 1449559842, 1, '游客');
INSERT INTO `page_view` VALUES (255, '3232256323', 1449559995, 1, '游客');
INSERT INTO `page_view` VALUES (256, '3232256323', 1449562958, 1, '游客');
INSERT INTO `page_view` VALUES (257, '3232256323', 1449565509, 1, '游客');
INSERT INTO `page_view` VALUES (258, '3232256323', 1449565702, 1, '游客');
INSERT INTO `page_view` VALUES (259, '3232256323', 1449565816, 1, '游客');
INSERT INTO `page_view` VALUES (260, '3232256323', 1449565945, 1, '游客');
INSERT INTO `page_view` VALUES (261, '3232256323', 1449566005, 1, '游客');
INSERT INTO `page_view` VALUES (262, '3232256323', 1449566265, 1, '游客');
INSERT INTO `page_view` VALUES (263, '3232256323', 1449623545, 1, '游客');
INSERT INTO `page_view` VALUES (264, '3232256323', 1449624794, 1, '游客');
INSERT INTO `page_view` VALUES (265, '3232256323', 1449625013, 1, '游客');
INSERT INTO `page_view` VALUES (266, '3232256323', 1449625043, 1, '游客');
INSERT INTO `page_view` VALUES (267, '3232256323', 1449625538, 1, '游客');
INSERT INTO `page_view` VALUES (268, '3232256323', 1449626643, 1, '游客');
INSERT INTO `page_view` VALUES (269, '3232256323', 1449626674, 1, '游客');
INSERT INTO `page_view` VALUES (270, '3232256323', 1449629687, 1, '游客');
INSERT INTO `page_view` VALUES (271, '3232256323', 1449630905, 1, '游客');
INSERT INTO `page_view` VALUES (272, '3232256323', 1449630968, 1, '游客');
INSERT INTO `page_view` VALUES (273, '3232256323', 1449631801, 1, '游客');
INSERT INTO `page_view` VALUES (274, '3232256323', 1449631880, 1, '游客');
INSERT INTO `page_view` VALUES (275, '3232256323', 1449632395, 1, '游客');
INSERT INTO `page_view` VALUES (276, '3232256323', 1449632480, 1, '游客');
INSERT INTO `page_view` VALUES (277, '3232256323', 1449633299, 1, '游客');
INSERT INTO `page_view` VALUES (278, '3232256323', 1449633308, 1, '游客');
INSERT INTO `page_view` VALUES (279, '3232256323', 1449633318, 1, '游客');
INSERT INTO `page_view` VALUES (280, '3232256323', 1449633349, 1, '游客');
INSERT INTO `page_view` VALUES (281, '3232256323', 1449633379, 1, '游客');
INSERT INTO `page_view` VALUES (282, '3232256323', 1449633474, 1, '游客');
INSERT INTO `page_view` VALUES (283, '3232256323', 1449637174, 1, '游客');
INSERT INTO `page_view` VALUES (284, '3232256323', 1449638587, 1, '游客');
INSERT INTO `page_view` VALUES (285, '3232256323', 1449641176, 1, '游客');
INSERT INTO `page_view` VALUES (286, '3232256323', 1449641208, 1, '游客');
INSERT INTO `page_view` VALUES (287, '3232256323', 1449641485, 1, '游客');
INSERT INTO `page_view` VALUES (288, '3232256323', 1449641523, 1, '游客');
INSERT INTO `page_view` VALUES (289, '3232256323', 1449642150, 1, '游客');
INSERT INTO `page_view` VALUES (290, '3232256323', 1449642569, 1, '游客');
INSERT INTO `page_view` VALUES (291, '3232256323', 1449644978, 1, '游客');
INSERT INTO `page_view` VALUES (292, '3232256323', 1449645984, 1, '游客');
INSERT INTO `page_view` VALUES (293, '3232256323', 1449646292, 1, '游客');
INSERT INTO `page_view` VALUES (294, '3232256323', 1449646507, 1, '游客');
INSERT INTO `page_view` VALUES (295, '3232256323', 1449646539, 1, '游客');
INSERT INTO `page_view` VALUES (296, '3232256323', 1449654014, 1, '游客');
INSERT INTO `page_view` VALUES (297, '3232256322', 1449657289, 1, '游客');
INSERT INTO `page_view` VALUES (298, '3232256323', 1449708256, 1, '游客');
INSERT INTO `page_view` VALUES (299, '3232256323', 1449710156, 1, '游客');
INSERT INTO `page_view` VALUES (300, '3232256323', 1449711456, 1, '游客');
INSERT INTO `page_view` VALUES (301, '3232256323', 1449712511, 1, '游客');
INSERT INTO `page_view` VALUES (302, '3232256323', 1449714556, 1, '游客');
INSERT INTO `page_view` VALUES (303, '3232256323', 1449714567, 1, '游客');
INSERT INTO `page_view` VALUES (304, '3232256323', 1449714674, 1, '游客');
INSERT INTO `page_view` VALUES (305, '3232256323', 1449714738, 1, '游客');
INSERT INTO `page_view` VALUES (306, '3232256323', 1449714762, 1, '游客');
INSERT INTO `page_view` VALUES (307, '3232256323', 1449714857, 1, '游客');
INSERT INTO `page_view` VALUES (308, '3232256323', 1449715923, 1, '游客');
INSERT INTO `page_view` VALUES (309, '3232256323', 1449719946, 1, '游客');
INSERT INTO `page_view` VALUES (310, '3232256323', 1449721138, 1, '游客');
INSERT INTO `page_view` VALUES (311, '3232256323', 1449725482, 1, '游客');
INSERT INTO `page_view` VALUES (312, '3232256323', 1449730236, 1, '游客');
INSERT INTO `page_view` VALUES (313, '3232256323', 1449735489, 1, '游客');
INSERT INTO `page_view` VALUES (314, '3232256322', 1449796221, 1, '游客');
INSERT INTO `page_view` VALUES (315, '3232256322', 1449796886, 1, '游客');
INSERT INTO `page_view` VALUES (316, '3232256322', 1449797101, 1, '游客');
INSERT INTO `page_view` VALUES (317, '3232256322', 1449798027, 1, '游客');
INSERT INTO `page_view` VALUES (318, '3232256322', 1449803456, 1, '游客');
INSERT INTO `page_view` VALUES (319, '3232256322', 1449803784, 1, '游客');
INSERT INTO `page_view` VALUES (320, '3232256322', 1449805093, 1, '游客');
INSERT INTO `page_view` VALUES (321, '3232256323', 1449815028, 1, '游客');
INSERT INTO `page_view` VALUES (322, '3232256323', 1449815029, 1, '游客');
INSERT INTO `page_view` VALUES (323, '3232256323', 1449815697, 1, '游客');
INSERT INTO `page_view` VALUES (324, '3232256323', 1449818101, 1, '游客');
INSERT INTO `page_view` VALUES (325, '3232256323', 1449818198, 1, '游客');
INSERT INTO `page_view` VALUES (326, '3232256323', 1449820134, 1, '游客');
INSERT INTO `page_view` VALUES (327, '3232256323', 1449821382, 1, '游客');
INSERT INTO `page_view` VALUES (328, '3232256323', 1449821475, 1, '游客');
INSERT INTO `page_view` VALUES (329, '3232256323', 1449821520, 1, '游客');
INSERT INTO `page_view` VALUES (330, '3232256323', 1449821796, 1, '游客');
INSERT INTO `page_view` VALUES (331, '3232256323', 1449821807, 1, '游客');
INSERT INTO `page_view` VALUES (332, '3232256323', 1449821938, 1, '游客');
INSERT INTO `page_view` VALUES (333, '3232256323', 1449825864, 1, '游客');
INSERT INTO `page_view` VALUES (334, '3232256322', 1450057065, 1, '游客');
INSERT INTO `page_view` VALUES (335, '3232256322', 1450057570, 1, '游客');
INSERT INTO `page_view` VALUES (336, '3232256323', 1450059852, 1, '游客');
INSERT INTO `page_view` VALUES (337, '3232256323', 1450062310, 1, '游客');
INSERT INTO `page_view` VALUES (338, '3232256323', 1450063550, 1, '游客');
INSERT INTO `page_view` VALUES (339, '3232256323', 1450070938, 1, '游客');
INSERT INTO `page_view` VALUES (340, '3232256323', 1450073791, 1, '游客');
INSERT INTO `page_view` VALUES (341, '3232256323', 1450076491, 1, '游客');
INSERT INTO `page_view` VALUES (342, '3232256323', 1450076846, 1, '游客');
INSERT INTO `page_view` VALUES (343, '3232256323', 1450077091, 1, '游客');
INSERT INTO `page_view` VALUES (344, '3232256323', 1450083656, 1, '游客');
INSERT INTO `page_view` VALUES (345, '3232256323', 1450086468, 1, '游客');
INSERT INTO `page_view` VALUES (346, '3232256323', 1450086714, 1, '游客');
INSERT INTO `page_view` VALUES (347, '3232256323', 1450088579, 1, '游客');
INSERT INTO `page_view` VALUES (348, '3232256323', 1450142533, 1, '游客');
INSERT INTO `page_view` VALUES (349, '3232256323', 1450143281, 1, '游客');
INSERT INTO `page_view` VALUES (350, '3232256323', 1450143672, 1, '游客');
INSERT INTO `page_view` VALUES (351, '3232256323', 1450144561, 1, '游客');
INSERT INTO `page_view` VALUES (352, '3232256323', 1450145125, 1, '游客');
INSERT INTO `page_view` VALUES (353, '3232256323', 1450148065, 1, '游客');
INSERT INTO `page_view` VALUES (354, '3232256323', 1450148066, 1, '游客');
INSERT INTO `page_view` VALUES (355, '3232256323', 1450148068, 1, '游客');
INSERT INTO `page_view` VALUES (356, '3232256323', 1450148146, 1, '游客');
INSERT INTO `page_view` VALUES (357, '3232256323', 1450148335, 1, '游客');
INSERT INTO `page_view` VALUES (358, '3232256323', 1450158833, 1, '游客');
INSERT INTO `page_view` VALUES (359, '3232256323', 1450161437, 1, '游客');
INSERT INTO `page_view` VALUES (360, '3232256323', 1450162616, 1, '游客');
INSERT INTO `page_view` VALUES (361, '3232256323', 1450172302, 1, '游客');
INSERT INTO `page_view` VALUES (362, '3232256323', 1450228800, 1, '游客');
INSERT INTO `page_view` VALUES (363, '3232256322', 1450230219, 1, '游客');
INSERT INTO `page_view` VALUES (364, '3232256322', 1450231737, 1, '游客');
INSERT INTO `page_view` VALUES (365, '3232256322', 1450233996, 1, '游客');
INSERT INTO `page_view` VALUES (366, '3232256323', 1450246608, 1, '游客');
INSERT INTO `page_view` VALUES (367, '3232256323', 1450252551, 1, '游客');
INSERT INTO `page_view` VALUES (368, '3232256323', 1450254056, 1, '游客');
INSERT INTO `page_view` VALUES (369, '3232256323', 1450255654, 1, '游客');
INSERT INTO `page_view` VALUES (370, '3232256323', 1450256488, 1, '游客');
INSERT INTO `page_view` VALUES (371, '3232286786', 1450285429, 1, '游客');
INSERT INTO `page_view` VALUES (372, '3232256323', 1450260567, 1, '游客');
INSERT INTO `page_view` VALUES (373, '3232256323', 1450260627, 1, '游客');
INSERT INTO `page_view` VALUES (374, '3232256323', 1450260700, 1, '游客');
INSERT INTO `page_view` VALUES (375, '3232256323', 1450261056, 1, '游客');
INSERT INTO `page_view` VALUES (376, '3232256323', 1450263521, 1, '游客');
INSERT INTO `page_view` VALUES (377, '3232256323', 1450263540, 1, '游客');
INSERT INTO `page_view` VALUES (378, '3232256323', 1450263583, 1, '游客');
INSERT INTO `page_view` VALUES (379, '3232256323', 1450263656, 1, '游客');
INSERT INTO `page_view` VALUES (380, '3232256323', 1450263932, 1, '游客');
INSERT INTO `page_view` VALUES (381, '3232256323', 1450264141, 1, '游客');
INSERT INTO `page_view` VALUES (382, '3232256323', 1450264375, 1, '游客');
INSERT INTO `page_view` VALUES (383, '3232256323', 1450264695, 1, '游客');
INSERT INTO `page_view` VALUES (384, '3232256323', 1450313872, 1, '游客');
INSERT INTO `page_view` VALUES (385, '3232256323', 1450313920, 1, '游客');
INSERT INTO `page_view` VALUES (386, '3232256323', 1450314963, 1, '游客');
INSERT INTO `page_view` VALUES (387, '3232256323', 1450315636, 1, '游客');
INSERT INTO `page_view` VALUES (388, '3232256323', 1450316733, 1, '游客');
INSERT INTO `page_view` VALUES (389, '3232256323', 1450316736, 1, '游客');
INSERT INTO `page_view` VALUES (390, '3232256323', 1450316767, 1, '游客');
INSERT INTO `page_view` VALUES (391, '3232256323', 1450316791, 1, '游客');
INSERT INTO `page_view` VALUES (392, '3232256323', 1450316828, 1, '游客');
INSERT INTO `page_view` VALUES (393, '3232256323', 1450316938, 1, '游客');
INSERT INTO `page_view` VALUES (394, '3232256323', 1450322381, 1, '游客');
INSERT INTO `page_view` VALUES (395, '3232256323', 1450330181, 1, '游客');
INSERT INTO `page_view` VALUES (396, '3232256323', 1450330201, 1, '游客');
INSERT INTO `page_view` VALUES (397, '3232256323', 1450330228, 1, '游客');
INSERT INTO `page_view` VALUES (398, '3232256323', 1450330274, 1, '游客');
INSERT INTO `page_view` VALUES (399, '3232256323', 1450330339, 1, '游客');
INSERT INTO `page_view` VALUES (400, '3232256323', 1450331574, 1, '游客');
INSERT INTO `page_view` VALUES (401, '3232256323', 1450333080, 1, '游客');
INSERT INTO `page_view` VALUES (402, '3232256323', 1450333166, 1, '游客');
INSERT INTO `page_view` VALUES (403, '3232256323', 1450333182, 1, '游客');
INSERT INTO `page_view` VALUES (404, '3232256323', 1450333750, 1, '游客');
INSERT INTO `page_view` VALUES (405, '3232256323', 1450335465, 1, '游客');
INSERT INTO `page_view` VALUES (406, '3232256323', 1450337962, 1, '游客');
INSERT INTO `page_view` VALUES (407, '3232256323', 1450337979, 1, '游客');
INSERT INTO `page_view` VALUES (408, '3232256323', 1450338955, 1, '游客');
INSERT INTO `page_view` VALUES (409, '3232256323', 1450338989, 1, '游客');
INSERT INTO `page_view` VALUES (410, '3232256323', 1450339314, 1, '游客');
INSERT INTO `page_view` VALUES (411, '3232256323', 1450341195, 1, '游客');
INSERT INTO `page_view` VALUES (412, '3232256323', 1450342314, 1, '游客');
INSERT INTO `page_view` VALUES (413, '3232256322', 1450361996, 1, '游客');
INSERT INTO `page_view` VALUES (414, '3232256322', 1450362002, 1, '游客');
INSERT INTO `page_view` VALUES (415, '3232256323', 1450401406, 1, '游客');
INSERT INTO `page_view` VALUES (416, '3232256322', 1450402443, 1, '游客');
INSERT INTO `page_view` VALUES (417, '3232256322', 1450403538, 1, '游客');
INSERT INTO `page_view` VALUES (418, '3232256322', 1450403648, 1, '游客');
INSERT INTO `page_view` VALUES (419, '3232256322', 1450403682, 1, '游客');
INSERT INTO `page_view` VALUES (420, '3232256322', 1450411686, 1, '游客');
INSERT INTO `page_view` VALUES (421, '3232256322', 1450411715, 1, '游客');
INSERT INTO `page_view` VALUES (422, '3232256323', 1450659025, 1, '游客');
INSERT INTO `page_view` VALUES (423, '3232256323', 1450662639, 1, '游客');
INSERT INTO `page_view` VALUES (424, '3232256323', 1450667404, 1, '游客');
INSERT INTO `page_view` VALUES (425, '3232256323', 1450668805, 1, '游客');
INSERT INTO `page_view` VALUES (426, '3232256323', 1450669805, 1, '游客');
INSERT INTO `page_view` VALUES (427, '3232256323', 1450672174, 1, '游客');
INSERT INTO `page_view` VALUES (428, '3232256323', 1450673335, 1, '游客');
INSERT INTO `page_view` VALUES (429, '3232256323', 1450673780, 1, '游客');
INSERT INTO `page_view` VALUES (430, '3232256323', 1450673869, 1, '游客');
INSERT INTO `page_view` VALUES (431, '3232256323', 1450673884, 1, '游客');
INSERT INTO `page_view` VALUES (432, '3232256323', 1450676911, 1, '游客');
INSERT INTO `page_view` VALUES (433, '3232256323', 1450677004, 1, '游客');
INSERT INTO `page_view` VALUES (434, '3232256323', 1450677061, 1, '游客');
INSERT INTO `page_view` VALUES (435, '3232256323', 1450677254, 1, '游客');
INSERT INTO `page_view` VALUES (436, '3232256323', 1450679253, 1, '游客');
INSERT INTO `page_view` VALUES (437, '3232256323', 1450679368, 1, '游客');
INSERT INTO `page_view` VALUES (438, '3232256323', 1450679544, 1, '游客');
INSERT INTO `page_view` VALUES (439, '3232256323', 1450679559, 1, '游客');
INSERT INTO `page_view` VALUES (440, '3232256323', 1450679809, 1, '游客');
INSERT INTO `page_view` VALUES (441, '3232256323', 1450679857, 1, '游客');
INSERT INTO `page_view` VALUES (442, '3232256323', 1450679925, 1, '游客');
INSERT INTO `page_view` VALUES (443, '3232256323', 1450680259, 1, '游客');
INSERT INTO `page_view` VALUES (444, '3232256323', 1450747069, 1, '游客');
INSERT INTO `page_view` VALUES (445, '3232256323', 1450749123, 1, '游客');
INSERT INTO `page_view` VALUES (446, '3232256323', 1450753326, 1, '游客');
INSERT INTO `page_view` VALUES (447, '3232256323', 1450761660, 1, '游客');
INSERT INTO `page_view` VALUES (448, '3232256323', 1450762685, 1, '游客');
INSERT INTO `page_view` VALUES (449, '3232256323', 1450763711, 1, '游客');
INSERT INTO `page_view` VALUES (450, '3232256323', 1450763727, 1, '游客');
INSERT INTO `page_view` VALUES (451, '3232256323', 1450763786, 1, '游客');
INSERT INTO `page_view` VALUES (452, '3232256323', 1450763843, 1, '游客');
INSERT INTO `page_view` VALUES (453, '3232256323', 1450763851, 1, '游客');
INSERT INTO `page_view` VALUES (454, '3232256323', 1450763868, 1, '游客');
INSERT INTO `page_view` VALUES (455, '3232256323', 1450763975, 1, '游客');
INSERT INTO `page_view` VALUES (456, '3232256323', 1450764212, 1, '游客');
INSERT INTO `page_view` VALUES (457, '3232256323', 1450765312, 1, '游客');
INSERT INTO `page_view` VALUES (458, '3232256323', 1450765977, 1, '游客');
INSERT INTO `page_view` VALUES (459, '3232256323', 1450765988, 1, '游客');
INSERT INTO `page_view` VALUES (460, '3232256323', 1450766340, 1, '游客');
INSERT INTO `page_view` VALUES (461, '3232256323', 1450766510, 1, '游客');
INSERT INTO `page_view` VALUES (462, '3232256323', 1450766589, 1, '游客');
INSERT INTO `page_view` VALUES (463, '3232256323', 1450766715, 1, '游客');
INSERT INTO `page_view` VALUES (464, '3232256323', 1450769070, 1, '游客');
INSERT INTO `page_view` VALUES (465, '3232256323', 1450769132, 1, '游客');
INSERT INTO `page_view` VALUES (466, '3232256323', 1450769233, 1, '游客');
INSERT INTO `page_view` VALUES (467, '3232256323', 1450769572, 1, '游客');
INSERT INTO `page_view` VALUES (468, '3232256323', 1450771386, 1, '游客');
INSERT INTO `page_view` VALUES (469, '3232256323', 1450771450, 1, '游客');
INSERT INTO `page_view` VALUES (470, '3232256323', 1450771632, 1, '游客');
INSERT INTO `page_view` VALUES (471, '3232256323', 1450773630, 1, '游客');
INSERT INTO `page_view` VALUES (472, '3232256323', 1450773639, 1, '游客');
INSERT INTO `page_view` VALUES (473, '3232256323', 1450773648, 1, '游客');
INSERT INTO `page_view` VALUES (474, '3232256323', 1450773769, 1, '游客');
INSERT INTO `page_view` VALUES (475, '3232256323', 1450773849, 1, '游客');
INSERT INTO `page_view` VALUES (476, '3232256323', 1450774945, 1, '游客');
INSERT INTO `page_view` VALUES (477, '3232256323', 1450792061, 1, '游客');
INSERT INTO `page_view` VALUES (478, '3232256323', 1450833538, 1, '游客');
INSERT INTO `page_view` VALUES (479, '3232256323', 1450833658, 1, '游客');
INSERT INTO `page_view` VALUES (480, '3232256323', 1450835754, 1, '游客');
INSERT INTO `page_view` VALUES (481, '3232256323', 1450836032, 1, '游客');
INSERT INTO `page_view` VALUES (482, '3232256323', 1450836181, 1, '游客');
INSERT INTO `page_view` VALUES (483, '3232256323', 1450839567, 1, '游客');
INSERT INTO `page_view` VALUES (484, '3232256323', 1450846618, 1, '游客');
INSERT INTO `page_view` VALUES (485, '3232256323', 1450846710, 1, '游客');
INSERT INTO `page_view` VALUES (486, '3232256323', 1450849415, 1, '游客');
INSERT INTO `page_view` VALUES (487, '3232256323', 1450849430, 1, '游客');
INSERT INTO `page_view` VALUES (488, '3232256323', 1450850966, 1, '游客');
INSERT INTO `page_view` VALUES (489, '3232256323', 1450851027, 1, '游客');
INSERT INTO `page_view` VALUES (490, '3232256323', 1450851071, 1, '游客');
INSERT INTO `page_view` VALUES (491, '3232256323', 1450851115, 1, '游客');
INSERT INTO `page_view` VALUES (492, '3232256323', 1450851284, 1, '游客');
INSERT INTO `page_view` VALUES (493, '3232256323', 1450851536, 1, '游客');
INSERT INTO `page_view` VALUES (494, '3232256323', 1450851537, 1, '游客');
INSERT INTO `page_view` VALUES (495, '3232256323', 1450855092, 1, '游客');
INSERT INTO `page_view` VALUES (496, '3232256323', 1450855217, 1, '游客');
INSERT INTO `page_view` VALUES (497, '3232256322', 1450872873, 1, '游客');
INSERT INTO `page_view` VALUES (498, '3232256322', 1450873153, 1, '游客');
INSERT INTO `page_view` VALUES (499, '3232256323', 1450919254, 1, '游客');
INSERT INTO `page_view` VALUES (500, '3232256323', 1450920322, 1, '游客');
INSERT INTO `page_view` VALUES (501, '3232256322', 1450935404, 1, '游客');
INSERT INTO `page_view` VALUES (502, '3232256322', 1450936004, 1, '游客');
INSERT INTO `page_view` VALUES (503, '3232256322', 1450936135, 1, '游客');
INSERT INTO `page_view` VALUES (504, '3232256322', 1450936924, 1, '游客');
INSERT INTO `page_view` VALUES (505, '3232256322', 1450937180, 1, '游客');
INSERT INTO `page_view` VALUES (506, '3232256322', 1450937270, 1, '游客');
INSERT INTO `page_view` VALUES (507, '3232256322', 1450937860, 1, '游客');
INSERT INTO `page_view` VALUES (508, '3232256322', 1450938340, 1, '游客');
INSERT INTO `page_view` VALUES (509, '3232256322', 1450942053, 1, '游客');
INSERT INTO `page_view` VALUES (510, '3232256322', 1450947276, 1, '游客');
INSERT INTO `page_view` VALUES (511, '3232256322', 1450971201, 1, '游客');
INSERT INTO `page_view` VALUES (512, '3232256323', 1451006914, 1, '游客');
INSERT INTO `page_view` VALUES (513, '3232256322', 1451010233, 1, '游客');
INSERT INTO `page_view` VALUES (514, '3232256322', 1451010238, 1, '游客');
INSERT INTO `page_view` VALUES (515, '3232256322', 1451010249, 1, '游客');
INSERT INTO `page_view` VALUES (516, '0', 1451372245, 1, '游客');
INSERT INTO `page_view` VALUES (517, '0', 1451373818, 1, '游客');
INSERT INTO `page_view` VALUES (518, '0', 1451373959, 1, '游客');
INSERT INTO `page_view` VALUES (519, '0', 1451374052, 1, '游客');
INSERT INTO `page_view` VALUES (520, '0', 1451374223, 1, '游客');
INSERT INTO `page_view` VALUES (521, '0', 1451375467, 1, '游客');
INSERT INTO `page_view` VALUES (522, '0', 1451377585, 1, '游客');
INSERT INTO `page_view` VALUES (523, '0', 1451438625, 1, '游客');
INSERT INTO `page_view` VALUES (524, '0', 1451703220, 1, '游客');
INSERT INTO `page_view` VALUES (525, '0', 1451705240, 1, '游客');
INSERT INTO `page_view` VALUES (526, '0', 1451728418, 1, '游客');
INSERT INTO `page_view` VALUES (527, '0', 1451728419, 1, '游客');
INSERT INTO `page_view` VALUES (528, '0', 1451728425, 1, '游客');
INSERT INTO `page_view` VALUES (529, '0', 1451728660, 1, '游客');
INSERT INTO `page_view` VALUES (530, '0', 1451728873, 1, '游客');
INSERT INTO `page_view` VALUES (531, '0', 1451729329, 1, '游客');
INSERT INTO `page_view` VALUES (532, '0', 1451729340, 1, '游客');
INSERT INTO `page_view` VALUES (533, '0', 1451870619, 1, '游客');
INSERT INTO `page_view` VALUES (534, '0', 1451870794, 1, '游客');
INSERT INTO `page_view` VALUES (535, '0', 1451956152, 1, '游客');
INSERT INTO `page_view` VALUES (536, '0', 1452041353, 1, '游客');
INSERT INTO `page_view` VALUES (537, '0', 1452128033, 1, '游客');
INSERT INTO `page_view` VALUES (538, '0', 1452214054, 1, '游客');
INSERT INTO `page_view` VALUES (539, '0', 1452236332, 1, '游客');
INSERT INTO `page_view` VALUES (540, '0', 1452237746, 1, '游客');
INSERT INTO `page_view` VALUES (541, '0', 1452239405, 1, '游客');
INSERT INTO `page_view` VALUES (542, '0', 1452474138, 1, '游客');
INSERT INTO `page_view` VALUES (543, '0', 1452560505, 1, '游客');
INSERT INTO `page_view` VALUES (544, '0', 1452647021, 1, '游客');
INSERT INTO `page_view` VALUES (545, '0', 1452733537, 1, '游客');
INSERT INTO `page_view` VALUES (546, '0', 1452820792, 1, '游客');
INSERT INTO `page_view` VALUES (547, '0', 1453078727, 1, '游客');
INSERT INTO `page_view` VALUES (548, '0', 1453167146, 1, '游客');
INSERT INTO `page_view` VALUES (549, '0', 1453251668, 1, '游客');
INSERT INTO `page_view` VALUES (550, '0', 1453257798, 1, '游客');
INSERT INTO `page_view` VALUES (551, '0', 1453257836, 1, '游客');
INSERT INTO `page_view` VALUES (552, '0', 1453270181, 1, '游客');
INSERT INTO `page_view` VALUES (553, '0', 1453270460, 1, '游客');
INSERT INTO `page_view` VALUES (554, '0', 1453270465, 1, '游客');
INSERT INTO `page_view` VALUES (555, '0', 1453270575, 1, '游客');
INSERT INTO `page_view` VALUES (556, '0', 1453270579, 1, '游客');
INSERT INTO `page_view` VALUES (557, '0', 1453270593, 1, '游客');
INSERT INTO `page_view` VALUES (558, '0', 1453270600, 1, '游客');
INSERT INTO `page_view` VALUES (559, '0', 1453270602, 1, '游客');
INSERT INTO `page_view` VALUES (560, '0', 1453270660, 1, '游客');
INSERT INTO `page_view` VALUES (561, '0', 1453270676, 1, '游客');
INSERT INTO `page_view` VALUES (562, '0', 1453270680, 1, '游客');
INSERT INTO `page_view` VALUES (563, '0', 1453270684, 1, '游客');
INSERT INTO `page_view` VALUES (564, '0', 1453270700, 1, '游客');
INSERT INTO `page_view` VALUES (565, '0', 1453270728, 1, '游客');
INSERT INTO `page_view` VALUES (566, '0', 1453270826, 1, '游客');
INSERT INTO `page_view` VALUES (567, '0', 1453270847, 1, '游客');
INSERT INTO `page_view` VALUES (568, '0', 1453270853, 1, '游客');
INSERT INTO `page_view` VALUES (569, '0', 1453270880, 1, '游客');
INSERT INTO `page_view` VALUES (570, '0', 1453270905, 1, '游客');
INSERT INTO `page_view` VALUES (571, '0', 1453270911, 1, '游客');
INSERT INTO `page_view` VALUES (572, '0', 1453270918, 1, '游客');
INSERT INTO `page_view` VALUES (573, '0', 1453270930, 1, '游客');
INSERT INTO `page_view` VALUES (574, '0', 1453270934, 1, '游客');
INSERT INTO `page_view` VALUES (575, '0', 1453270941, 1, '游客');
INSERT INTO `page_view` VALUES (576, '0', 1453270957, 1, '游客');
INSERT INTO `page_view` VALUES (577, '0', 1453270964, 1, '游客');
INSERT INTO `page_view` VALUES (578, '0', 1453270967, 1, '游客');
INSERT INTO `page_view` VALUES (579, '0', 1453270973, 1, '游客');
INSERT INTO `page_view` VALUES (580, '0', 1453270996, 1, '游客');
INSERT INTO `page_view` VALUES (581, '0', 1453271013, 1, '游客');
INSERT INTO `page_view` VALUES (582, '0', 1453271024, 1, '游客');
INSERT INTO `page_view` VALUES (583, '0', 1453271271, 1, '游客');
INSERT INTO `page_view` VALUES (584, '0', 1453271472, 1, '游客');
INSERT INTO `page_view` VALUES (585, '0', 1453271523, 1, '游客');
INSERT INTO `page_view` VALUES (586, '0', 1453271900, 1, '游客');
INSERT INTO `page_view` VALUES (587, '0', 1453271918, 1, '游客');
INSERT INTO `page_view` VALUES (588, '0', 1453271943, 1, '游客');
INSERT INTO `page_view` VALUES (589, '0', 1453272218, 1, '游客');
INSERT INTO `page_view` VALUES (590, '0', 1453272222, 1, '游客');
INSERT INTO `page_view` VALUES (591, '0', 1453272681, 1, '游客');
INSERT INTO `page_view` VALUES (592, '0', 1453272987, 1, '游客');
INSERT INTO `page_view` VALUES (593, '0', 1453273200, 1, '游客');
INSERT INTO `page_view` VALUES (594, '0', 1453273216, 1, '游客');
INSERT INTO `page_view` VALUES (595, '0', 1453273227, 1, '游客');
INSERT INTO `page_view` VALUES (596, '0', 1453273395, 1, '游客');
INSERT INTO `page_view` VALUES (597, '0', 1453273416, 1, '游客');
INSERT INTO `page_view` VALUES (598, '0', 1453273426, 1, '游客');
INSERT INTO `page_view` VALUES (599, '0', 1453273439, 1, '游客');
INSERT INTO `page_view` VALUES (600, '0', 1453273508, 1, '游客');
INSERT INTO `page_view` VALUES (601, '0', 1453273566, 1, '游客');
INSERT INTO `page_view` VALUES (602, '0', 1453273602, 1, '游客');
INSERT INTO `page_view` VALUES (603, '0', 1453273639, 1, '游客');
INSERT INTO `page_view` VALUES (604, '0', 1453273669, 1, '游客');
INSERT INTO `page_view` VALUES (605, '0', 1453273676, 1, '游客');
INSERT INTO `page_view` VALUES (606, '0', 1453274027, 1, '游客');
INSERT INTO `page_view` VALUES (607, '0', 1453274099, 1, '游客');
INSERT INTO `page_view` VALUES (608, '0', 1453274109, 1, '游客');
INSERT INTO `page_view` VALUES (609, '0', 1453274115, 1, '游客');
INSERT INTO `page_view` VALUES (610, '0', 1453274204, 1, '游客');
INSERT INTO `page_view` VALUES (611, '0', 1453274225, 1, '游客');
INSERT INTO `page_view` VALUES (612, '0', 1453274271, 1, '游客');
INSERT INTO `page_view` VALUES (613, '0', 1453274308, 1, '游客');
INSERT INTO `page_view` VALUES (614, '0', 1453274337, 1, '游客');
INSERT INTO `page_view` VALUES (615, '0', 1453274379, 1, '游客');
INSERT INTO `page_view` VALUES (616, '0', 1453274391, 1, '游客');
INSERT INTO `page_view` VALUES (617, '0', 1453274504, 1, '游客');
INSERT INTO `page_view` VALUES (618, '0', 1453274717, 1, '游客');
INSERT INTO `page_view` VALUES (619, '0', 1453274733, 1, '游客');
INSERT INTO `page_view` VALUES (620, '0', 1453274758, 1, '游客');
INSERT INTO `page_view` VALUES (621, '0', 1453274779, 1, '游客');
INSERT INTO `page_view` VALUES (622, '0', 1453274806, 1, '游客');
INSERT INTO `page_view` VALUES (623, '0', 1453274827, 1, '游客');
INSERT INTO `page_view` VALUES (624, '0', 1453274882, 1, '游客');
INSERT INTO `page_view` VALUES (625, '0', 1453274933, 1, '游客');
INSERT INTO `page_view` VALUES (626, '0', 1453274943, 1, '游客');
INSERT INTO `page_view` VALUES (627, '0', 1453274972, 1, '游客');
INSERT INTO `page_view` VALUES (628, '0', 1453274991, 1, '游客');
INSERT INTO `page_view` VALUES (629, '0', 1453275001, 1, '游客');
INSERT INTO `page_view` VALUES (630, '0', 1453275010, 1, '游客');
INSERT INTO `page_view` VALUES (631, '0', 1453275017, 1, '游客');
INSERT INTO `page_view` VALUES (632, '0', 1453275027, 1, '游客');
INSERT INTO `page_view` VALUES (633, '0', 1453275044, 1, '游客');
INSERT INTO `page_view` VALUES (634, '0', 1453275098, 1, '游客');
INSERT INTO `page_view` VALUES (635, '0', 1453275123, 1, '游客');
INSERT INTO `page_view` VALUES (636, '0', 1453275142, 1, '游客');
INSERT INTO `page_view` VALUES (637, '0', 1453275157, 1, '游客');
INSERT INTO `page_view` VALUES (638, '0', 1453275196, 1, '游客');
INSERT INTO `page_view` VALUES (639, '0', 1453275274, 1, '游客');
INSERT INTO `page_view` VALUES (640, '0', 1453275296, 1, '游客');
INSERT INTO `page_view` VALUES (641, '0', 1453275305, 1, '游客');
INSERT INTO `page_view` VALUES (642, '0', 1453275345, 1, '游客');
INSERT INTO `page_view` VALUES (643, '0', 1453275362, 1, '游客');
INSERT INTO `page_view` VALUES (644, '0', 1453275441, 1, '游客');
INSERT INTO `page_view` VALUES (645, '0', 1453275461, 1, '游客');
INSERT INTO `page_view` VALUES (646, '0', 1453275490, 1, '游客');
INSERT INTO `page_view` VALUES (647, '0', 1453275501, 1, '游客');
INSERT INTO `page_view` VALUES (648, '0', 1453275529, 1, '游客');
INSERT INTO `page_view` VALUES (649, '0', 1453275535, 1, '游客');
INSERT INTO `page_view` VALUES (650, '0', 1453275552, 1, '游客');
INSERT INTO `page_view` VALUES (651, '0', 1453275592, 1, '游客');
INSERT INTO `page_view` VALUES (652, '0', 1453275600, 1, '游客');
INSERT INTO `page_view` VALUES (653, '0', 1453275651, 1, '游客');
INSERT INTO `page_view` VALUES (654, '0', 1453275671, 1, '游客');
INSERT INTO `page_view` VALUES (655, '0', 1453275690, 1, '游客');
INSERT INTO `page_view` VALUES (656, '0', 1453275926, 1, '游客');
INSERT INTO `page_view` VALUES (657, '0', 1453275957, 1, '游客');
INSERT INTO `page_view` VALUES (658, '0', 1453275981, 1, '游客');
INSERT INTO `page_view` VALUES (659, '0', 1453276010, 1, '游客');
INSERT INTO `page_view` VALUES (660, '0', 1453276040, 1, '游客');
INSERT INTO `page_view` VALUES (661, '0', 1453276054, 1, '游客');
INSERT INTO `page_view` VALUES (662, '0', 1453276115, 1, '游客');
INSERT INTO `page_view` VALUES (663, '0', 1453276127, 1, '游客');
INSERT INTO `page_view` VALUES (664, '0', 1453276159, 1, '游客');
INSERT INTO `page_view` VALUES (665, '0', 1453276175, 1, '游客');
INSERT INTO `page_view` VALUES (666, '0', 1453276244, 1, '游客');
INSERT INTO `page_view` VALUES (667, '0', 1453276305, 1, '游客');
INSERT INTO `page_view` VALUES (668, '0', 1453276360, 1, '游客');
INSERT INTO `page_view` VALUES (669, '0', 1453276386, 1, '游客');
INSERT INTO `page_view` VALUES (670, '0', 1453276654, 1, '游客');
INSERT INTO `page_view` VALUES (671, '0', 1453276684, 1, '游客');
INSERT INTO `page_view` VALUES (672, '0', 1453276779, 1, '游客');
INSERT INTO `page_view` VALUES (673, '0', 1453276814, 1, '游客');
INSERT INTO `page_view` VALUES (674, '0', 1453276865, 1, '游客');
INSERT INTO `page_view` VALUES (675, '0', 1453277015, 1, '游客');
INSERT INTO `page_view` VALUES (676, '0', 1453277427, 1, '游客');
INSERT INTO `page_view` VALUES (677, '0', 1453277784, 1, '游客');
INSERT INTO `page_view` VALUES (678, '0', 1453278357, 1, '游客');
INSERT INTO `page_view` VALUES (679, '0', 1453278414, 1, '游客');
INSERT INTO `page_view` VALUES (680, '0', 1453278475, 1, '游客');
INSERT INTO `page_view` VALUES (681, '0', 1453278489, 1, '游客');
INSERT INTO `page_view` VALUES (682, '0', 1453279005, 1, '游客');
INSERT INTO `page_view` VALUES (683, '0', 1453279271, 1, '游客');
INSERT INTO `page_view` VALUES (684, '0', 1453279284, 1, '游客');
INSERT INTO `page_view` VALUES (685, '0', 1453279451, 1, '游客');
INSERT INTO `page_view` VALUES (686, '0', 1453279465, 1, '游客');
INSERT INTO `page_view` VALUES (687, '0', 1453279482, 1, '游客');
INSERT INTO `page_view` VALUES (688, '0', 1453279503, 1, '游客');
INSERT INTO `page_view` VALUES (689, '0', 1453279610, 1, '游客');
INSERT INTO `page_view` VALUES (690, '0', 1453279625, 1, '游客');
INSERT INTO `page_view` VALUES (691, '0', 1453279723, 1, '游客');
INSERT INTO `page_view` VALUES (692, '0', 1453279746, 1, '游客');
INSERT INTO `page_view` VALUES (693, '0', 1453279757, 1, '游客');
INSERT INTO `page_view` VALUES (694, '0', 1453279823, 1, '游客');
INSERT INTO `page_view` VALUES (695, '0', 1453279844, 1, '游客');
INSERT INTO `page_view` VALUES (696, '0', 1453279852, 1, '游客');
INSERT INTO `page_view` VALUES (697, '0', 1453279929, 1, '游客');
INSERT INTO `page_view` VALUES (698, '0', 1453279936, 1, '游客');
INSERT INTO `page_view` VALUES (699, '0', 1453279972, 1, '游客');
INSERT INTO `page_view` VALUES (700, '0', 1453280009, 1, '游客');
INSERT INTO `page_view` VALUES (701, '0', 1453280018, 1, '游客');
INSERT INTO `page_view` VALUES (702, '0', 1453280027, 1, '游客');
INSERT INTO `page_view` VALUES (703, '0', 1453280047, 1, '游客');
INSERT INTO `page_view` VALUES (704, '0', 1453280065, 1, '游客');
INSERT INTO `page_view` VALUES (705, '0', 1453280074, 1, '游客');
INSERT INTO `page_view` VALUES (706, '0', 1453280084, 1, '游客');
INSERT INTO `page_view` VALUES (707, '0', 1453280105, 1, '游客');
INSERT INTO `page_view` VALUES (708, '0', 1453280236, 1, '游客');
INSERT INTO `page_view` VALUES (709, '0', 1453280271, 1, '游客');
INSERT INTO `page_view` VALUES (710, '0', 1453280302, 1, '游客');
INSERT INTO `page_view` VALUES (711, '0', 1453280332, 1, '游客');
INSERT INTO `page_view` VALUES (712, '0', 1453280398, 1, '游客');
INSERT INTO `page_view` VALUES (713, '0', 1453280415, 1, '游客');
INSERT INTO `page_view` VALUES (714, '0', 1453280432, 1, '游客');
INSERT INTO `page_view` VALUES (715, '0', 1453280447, 1, '游客');
INSERT INTO `page_view` VALUES (716, '0', 1453280461, 1, '游客');
INSERT INTO `page_view` VALUES (717, '0', 1453280538, 1, '游客');
INSERT INTO `page_view` VALUES (718, '0', 1453280561, 1, '游客');
INSERT INTO `page_view` VALUES (719, '0', 1453280595, 1, '游客');
INSERT INTO `page_view` VALUES (720, '0', 1453280652, 1, '游客');
INSERT INTO `page_view` VALUES (721, '0', 1453280675, 1, '游客');
INSERT INTO `page_view` VALUES (722, '0', 1453280740, 1, '游客');
INSERT INTO `page_view` VALUES (723, '0', 1453280762, 1, '游客');
INSERT INTO `page_view` VALUES (724, '0', 1453280779, 1, '游客');
INSERT INTO `page_view` VALUES (725, '0', 1453280797, 1, '游客');
INSERT INTO `page_view` VALUES (726, '0', 1453280986, 1, '游客');
INSERT INTO `page_view` VALUES (727, '0', 1453280998, 1, '游客');
INSERT INTO `page_view` VALUES (728, '0', 1453281015, 1, '游客');
INSERT INTO `page_view` VALUES (729, '0', 1453281132, 1, '游客');
INSERT INTO `page_view` VALUES (730, '0', 1453281524, 1, '游客');
INSERT INTO `page_view` VALUES (731, '0', 1453281582, 1, '游客');
INSERT INTO `page_view` VALUES (732, '0', 1453281640, 1, '游客');
INSERT INTO `page_view` VALUES (733, '0', 1453281753, 1, '游客');
INSERT INTO `page_view` VALUES (734, '0', 1453282307, 1, '游客');
INSERT INTO `page_view` VALUES (735, '0', 1453338260, 1, '游客');
INSERT INTO `page_view` VALUES (736, '0', 1453338496, 1, '游客');
INSERT INTO `page_view` VALUES (737, '0', 1453338521, 1, '游客');
INSERT INTO `page_view` VALUES (738, '0', 1453338538, 1, '游客');
INSERT INTO `page_view` VALUES (739, '0', 1453338601, 1, '游客');
INSERT INTO `page_view` VALUES (740, '0', 1453338700, 1, '游客');
INSERT INTO `page_view` VALUES (741, '0', 1453338711, 1, '游客');
INSERT INTO `page_view` VALUES (742, '0', 1453338859, 1, '游客');
INSERT INTO `page_view` VALUES (743, '0', 1453338940, 1, '游客');
INSERT INTO `page_view` VALUES (744, '0', 1453338967, 1, '游客');
INSERT INTO `page_view` VALUES (745, '0', 1453338983, 1, '游客');
INSERT INTO `page_view` VALUES (746, '0', 1453339005, 1, '游客');
INSERT INTO `page_view` VALUES (747, '0', 1453339047, 1, '游客');
INSERT INTO `page_view` VALUES (748, '0', 1453339076, 1, '游客');
INSERT INTO `page_view` VALUES (749, '0', 1453339109, 1, '游客');
INSERT INTO `page_view` VALUES (750, '0', 1453339132, 1, '游客');
INSERT INTO `page_view` VALUES (751, '0', 1453339153, 1, '游客');
INSERT INTO `page_view` VALUES (752, '0', 1453339169, 1, '游客');
INSERT INTO `page_view` VALUES (753, '0', 1453339189, 1, '游客');
INSERT INTO `page_view` VALUES (754, '0', 1453339209, 1, '游客');
INSERT INTO `page_view` VALUES (755, '0', 1453339247, 1, '游客');
INSERT INTO `page_view` VALUES (756, '0', 1453339253, 1, '游客');
INSERT INTO `page_view` VALUES (757, '0', 1453339259, 1, '游客');
INSERT INTO `page_view` VALUES (758, '0', 1453339355, 1, '游客');
INSERT INTO `page_view` VALUES (759, '0', 1453339426, 1, '游客');
INSERT INTO `page_view` VALUES (760, '0', 1453339458, 1, '游客');
INSERT INTO `page_view` VALUES (761, '0', 1453339482, 1, '游客');
INSERT INTO `page_view` VALUES (762, '0', 1453339508, 1, '游客');
INSERT INTO `page_view` VALUES (763, '0', 1453339579, 1, '游客');
INSERT INTO `page_view` VALUES (764, '0', 1453339594, 1, '游客');
INSERT INTO `page_view` VALUES (765, '0', 1453339628, 1, '游客');
INSERT INTO `page_view` VALUES (766, '0', 1453339649, 1, '游客');
INSERT INTO `page_view` VALUES (767, '0', 1453339680, 1, '游客');
INSERT INTO `page_view` VALUES (768, '0', 1453339742, 1, '游客');
INSERT INTO `page_view` VALUES (769, '0', 1453339840, 1, '游客');
INSERT INTO `page_view` VALUES (770, '0', 1453339857, 1, '游客');
INSERT INTO `page_view` VALUES (771, '0', 1453339865, 1, '游客');
INSERT INTO `page_view` VALUES (772, '0', 1453339908, 1, '游客');
INSERT INTO `page_view` VALUES (773, '0', 1453339920, 1, '游客');
INSERT INTO `page_view` VALUES (774, '0', 1453339929, 1, '游客');
INSERT INTO `page_view` VALUES (775, '0', 1453339983, 1, '游客');
INSERT INTO `page_view` VALUES (776, '0', 1453340011, 1, '游客');
INSERT INTO `page_view` VALUES (777, '0', 1453340042, 1, '游客');
INSERT INTO `page_view` VALUES (778, '0', 1453340084, 1, '游客');
INSERT INTO `page_view` VALUES (779, '0', 1453340323, 1, '游客');
INSERT INTO `page_view` VALUES (780, '0', 1453340335, 1, '游客');
INSERT INTO `page_view` VALUES (781, '0', 1453340357, 1, '游客');
INSERT INTO `page_view` VALUES (782, '0', 1453340385, 1, '游客');
INSERT INTO `page_view` VALUES (783, '0', 1453340401, 1, '游客');
INSERT INTO `page_view` VALUES (784, '0', 1453340418, 1, '游客');
INSERT INTO `page_view` VALUES (785, '0', 1453340456, 1, '游客');
INSERT INTO `page_view` VALUES (786, '0', 1453340543, 1, '游客');
INSERT INTO `page_view` VALUES (787, '0', 1453340589, 1, '游客');
INSERT INTO `page_view` VALUES (788, '0', 1453340600, 1, '游客');
INSERT INTO `page_view` VALUES (789, '0', 1453340628, 1, '游客');
INSERT INTO `page_view` VALUES (790, '0', 1453340643, 1, '游客');
INSERT INTO `page_view` VALUES (791, '0', 1453340685, 1, '游客');
INSERT INTO `page_view` VALUES (792, '0', 1453340706, 1, '游客');
INSERT INTO `page_view` VALUES (793, '0', 1453340738, 1, '游客');
INSERT INTO `page_view` VALUES (794, '0', 1453340881, 1, '游客');
INSERT INTO `page_view` VALUES (795, '0', 1453340899, 1, '游客');
INSERT INTO `page_view` VALUES (796, '0', 1453340992, 1, '游客');
INSERT INTO `page_view` VALUES (797, '0', 1453341038, 1, '游客');
INSERT INTO `page_view` VALUES (798, '0', 1453341192, 1, '游客');
INSERT INTO `page_view` VALUES (799, '0', 1453341208, 1, '游客');
INSERT INTO `page_view` VALUES (800, '0', 1453341236, 1, '游客');
INSERT INTO `page_view` VALUES (801, '0', 1453341259, 1, '游客');
INSERT INTO `page_view` VALUES (802, '0', 1453341266, 1, '游客');
INSERT INTO `page_view` VALUES (803, '0', 1453341278, 1, '游客');
INSERT INTO `page_view` VALUES (804, '0', 1453341474, 1, '游客');
INSERT INTO `page_view` VALUES (805, '0', 1453341481, 1, '游客');
INSERT INTO `page_view` VALUES (806, '0', 1453341972, 1, '游客');
INSERT INTO `page_view` VALUES (807, '0', 1453342005, 1, '游客');
INSERT INTO `page_view` VALUES (808, '0', 1453342077, 1, '游客');
INSERT INTO `page_view` VALUES (809, '0', 1453342087, 1, '游客');
INSERT INTO `page_view` VALUES (810, '0', 1453342099, 1, '游客');
INSERT INTO `page_view` VALUES (811, '0', 1453342112, 1, '游客');
INSERT INTO `page_view` VALUES (812, '0', 1453342139, 1, '游客');
INSERT INTO `page_view` VALUES (813, '0', 1453342179, 1, '游客');
INSERT INTO `page_view` VALUES (814, '0', 1453342880, 1, '游客');
INSERT INTO `page_view` VALUES (815, '0', 1453342943, 1, '游客');
INSERT INTO `page_view` VALUES (816, '0', 1453342982, 1, '游客');
INSERT INTO `page_view` VALUES (817, '0', 1453343006, 1, '游客');
INSERT INTO `page_view` VALUES (818, '0', 1453343036, 1, '游客');
INSERT INTO `page_view` VALUES (819, '0', 1453343065, 1, '游客');
INSERT INTO `page_view` VALUES (820, '0', 1453343701, 1, '游客');
INSERT INTO `page_view` VALUES (821, '0', 1453343727, 1, '游客');
INSERT INTO `page_view` VALUES (822, '0', 1453343896, 1, '游客');
INSERT INTO `page_view` VALUES (823, '0', 1453343904, 1, '游客');
INSERT INTO `page_view` VALUES (824, '0', 1453344104, 1, '游客');
INSERT INTO `page_view` VALUES (825, '0', 1453344465, 1, '游客');
INSERT INTO `page_view` VALUES (826, '0', 1453344522, 1, '游客');
INSERT INTO `page_view` VALUES (827, '0', 1453344574, 1, '游客');
INSERT INTO `page_view` VALUES (828, '0', 1453344588, 1, '游客');
INSERT INTO `page_view` VALUES (829, '0', 1453344696, 1, '游客');
INSERT INTO `page_view` VALUES (830, '0', 1453344699, 1, '游客');
INSERT INTO `page_view` VALUES (831, '0', 1453344743, 1, '游客');
INSERT INTO `page_view` VALUES (832, '0', 1453344774, 1, '游客');
INSERT INTO `page_view` VALUES (833, '0', 1453344830, 1, '游客');
INSERT INTO `page_view` VALUES (834, '0', 1453344854, 1, '游客');
INSERT INTO `page_view` VALUES (835, '0', 1453347780, 1, '游客');
INSERT INTO `page_view` VALUES (836, '0', 1453347870, 1, '游客');
INSERT INTO `page_view` VALUES (837, '0', 1453356112, 1, '游客');
INSERT INTO `page_view` VALUES (838, '0', 1453356436, 1, '游客');
INSERT INTO `page_view` VALUES (839, '0', 1453356457, 1, '游客');
INSERT INTO `page_view` VALUES (840, '0', 1453356661, 1, '游客');
INSERT INTO `page_view` VALUES (841, '0', 1453358000, 1, '游客');
INSERT INTO `page_view` VALUES (842, '0', 1453358023, 1, '游客');
INSERT INTO `page_view` VALUES (843, '0', 1453358101, 1, '游客');
INSERT INTO `page_view` VALUES (844, '0', 1453361092, 1, '游客');
INSERT INTO `page_view` VALUES (845, '0', 1453361130, 1, '游客');
INSERT INTO `page_view` VALUES (846, '0', 1453361153, 1, '游客');
INSERT INTO `page_view` VALUES (847, '0', 1453362327, 1, '游客');
INSERT INTO `page_view` VALUES (848, '0', 1453363563, 1, '游客');
INSERT INTO `page_view` VALUES (849, '0', 1453425096, 1, '游客');
INSERT INTO `page_view` VALUES (850, '0', 1453438059, 1, '游客');
INSERT INTO `page_view` VALUES (851, '2130706433', 1453447817, 1, '游客');
INSERT INTO `page_view` VALUES (852, '0', 1453451300, 1, '游客');
INSERT INTO `page_view` VALUES (853, '0', 1453856898, 1, '游客');
INSERT INTO `page_view` VALUES (854, '0', 1453863965, 1, '游客');
INSERT INTO `page_view` VALUES (855, '0', 1453880452, 1, '游客');
INSERT INTO `page_view` VALUES (856, '0', 1453882710, 1, '游客');
INSERT INTO `page_view` VALUES (857, '0', 1453882799, 1, '游客');
INSERT INTO `page_view` VALUES (858, '0', 1453945926, 1, '游客');
INSERT INTO `page_view` VALUES (859, '0', 1453945983, 1, '游客');
INSERT INTO `page_view` VALUES (860, '0', 1453946156, 1, '游客');
INSERT INTO `page_view` VALUES (861, '0', 1453946163, 1, '游客');
INSERT INTO `page_view` VALUES (862, '0', 1453946239, 1, '游客');
INSERT INTO `page_view` VALUES (863, '0', 1453946257, 1, '游客');
INSERT INTO `page_view` VALUES (864, '0', 1453946292, 1, '游客');
INSERT INTO `page_view` VALUES (865, '0', 1453946305, 1, '游客');
INSERT INTO `page_view` VALUES (866, '0', 1453946327, 1, '游客');
INSERT INTO `page_view` VALUES (867, '0', 1453946418, 1, '游客');
INSERT INTO `page_view` VALUES (868, '0', 1453946473, 1, '游客');
INSERT INTO `page_view` VALUES (869, '0', 1453946491, 1, '游客');
INSERT INTO `page_view` VALUES (870, '0', 1453946496, 1, '游客');
INSERT INTO `page_view` VALUES (871, '0', 1453949015, 1, '游客');
INSERT INTO `page_view` VALUES (872, '0', 1453949790, 1, '游客');
INSERT INTO `page_view` VALUES (873, '0', 1453950135, 1, '游客');
INSERT INTO `page_view` VALUES (874, '0', 1453950146, 1, '游客');
INSERT INTO `page_view` VALUES (875, '0', 1453950230, 1, '游客');
INSERT INTO `page_view` VALUES (876, '0', 1453950242, 1, '游客');
INSERT INTO `page_view` VALUES (877, '0', 1453950255, 1, '游客');
INSERT INTO `page_view` VALUES (878, '0', 1453950408, 1, '游客');
INSERT INTO `page_view` VALUES (879, '0', 1453950444, 1, '游客');
INSERT INTO `page_view` VALUES (880, '0', 1453950527, 1, '游客');
INSERT INTO `page_view` VALUES (881, '0', 1453951039, 1, '游客');
INSERT INTO `page_view` VALUES (882, '0', 1453951047, 1, '游客');
INSERT INTO `page_view` VALUES (883, '0', 1453951749, 1, '游客');
INSERT INTO `page_view` VALUES (884, '0', 1453952197, 1, '游客');
INSERT INTO `page_view` VALUES (885, '0', 1453952214, 1, '游客');
INSERT INTO `page_view` VALUES (886, '0', 1453952423, 1, '游客');
INSERT INTO `page_view` VALUES (887, '0', 1453952434, 1, '游客');
INSERT INTO `page_view` VALUES (888, '0', 1453952805, 1, '游客');
INSERT INTO `page_view` VALUES (889, '0', 1453952868, 1, '游客');
INSERT INTO `page_view` VALUES (890, '0', 1453953495, 1, '游客');
INSERT INTO `page_view` VALUES (891, '0', 1453953677, 1, '游客');
INSERT INTO `page_view` VALUES (892, '0', 1453953927, 1, '游客');
INSERT INTO `page_view` VALUES (893, '0', 1453960664, 1, '游客');
INSERT INTO `page_view` VALUES (894, '0', 1453960676, 1, '游客');
INSERT INTO `page_view` VALUES (895, '0', 1453960689, 1, '游客');
INSERT INTO `page_view` VALUES (896, '0', 1453960908, 1, '游客');
INSERT INTO `page_view` VALUES (897, '0', 1453960937, 1, '游客');
INSERT INTO `page_view` VALUES (898, '0', 1453960963, 1, '游客');
INSERT INTO `page_view` VALUES (899, '0', 1453960980, 1, '游客');
INSERT INTO `page_view` VALUES (900, '0', 1453960981, 1, '游客');
INSERT INTO `page_view` VALUES (901, '0', 1453960989, 1, '游客');
INSERT INTO `page_view` VALUES (902, '0', 1453961012, 1, '游客');
INSERT INTO `page_view` VALUES (903, '0', 1453961054, 1, '游客');
INSERT INTO `page_view` VALUES (904, '0', 1453961063, 1, '游客');
INSERT INTO `page_view` VALUES (905, '0', 1453961071, 1, '游客');
INSERT INTO `page_view` VALUES (906, '0', 1453961084, 1, '游客');
INSERT INTO `page_view` VALUES (907, '0', 1453961091, 1, '游客');
INSERT INTO `page_view` VALUES (908, '0', 1453961105, 1, '游客');
INSERT INTO `page_view` VALUES (909, '0', 1453961120, 1, '游客');
INSERT INTO `page_view` VALUES (910, '0', 1453961132, 1, '游客');
INSERT INTO `page_view` VALUES (911, '0', 1453961148, 1, '游客');
INSERT INTO `page_view` VALUES (912, '0', 1453961163, 1, '游客');
INSERT INTO `page_view` VALUES (913, '0', 1453961171, 1, '游客');
INSERT INTO `page_view` VALUES (914, '0', 1453961177, 1, '游客');
INSERT INTO `page_view` VALUES (915, '0', 1453961196, 1, '游客');
INSERT INTO `page_view` VALUES (916, '0', 1453961209, 1, '游客');
INSERT INTO `page_view` VALUES (917, '0', 1453961210, 1, '游客');
INSERT INTO `page_view` VALUES (918, '0', 1453961210, 1, '游客');
INSERT INTO `page_view` VALUES (919, '0', 1453961210, 1, '游客');
INSERT INTO `page_view` VALUES (920, '0', 1453961221, 1, '游客');
INSERT INTO `page_view` VALUES (921, '0', 1453961234, 1, '游客');
INSERT INTO `page_view` VALUES (922, '0', 1453961244, 1, '游客');
INSERT INTO `page_view` VALUES (923, '0', 1453961257, 1, '游客');
INSERT INTO `page_view` VALUES (924, '0', 1453961280, 1, '游客');
INSERT INTO `page_view` VALUES (925, '0', 1453961291, 1, '游客');
INSERT INTO `page_view` VALUES (926, '0', 1453961303, 1, '游客');
INSERT INTO `page_view` VALUES (927, '0', 1453961318, 1, '游客');
INSERT INTO `page_view` VALUES (928, '0', 1453968502, 1, '游客');
INSERT INTO `page_view` VALUES (929, '0', 1453968509, 1, '游客');
INSERT INTO `page_view` VALUES (930, '0', 1453968535, 1, '游客');
INSERT INTO `page_view` VALUES (931, '0', 1455585200, 1, '游客');
INSERT INTO `page_view` VALUES (932, '0', 1455844955, 1, '游客');
INSERT INTO `page_view` VALUES (933, '0', 1456368283, 1, '游客');
INSERT INTO `page_view` VALUES (934, '0', 1456369001, 1, '游客');
INSERT INTO `page_view` VALUES (935, '0', 1456369096, 1, '游客');
INSERT INTO `page_view` VALUES (936, '0', 1456369201, 1, '游客');
INSERT INTO `page_view` VALUES (937, '0', 1458108125, 1, '游客');
INSERT INTO `page_view` VALUES (938, '0', 1458108166, 1, '游客');
INSERT INTO `page_view` VALUES (939, '0', 1458198837, 1, '游客');
INSERT INTO `page_view` VALUES (940, '0', 1458200105, 1, '游客');
INSERT INTO `page_view` VALUES (941, '0', 1458270593, 1, '游客');
INSERT INTO `page_view` VALUES (942, '0', 1458787246, 1, '游客');
INSERT INTO `page_view` VALUES (943, '0', 1462264940, 1, '游客');
INSERT INTO `page_view` VALUES (944, '0', 1462266046, 1, '游客');
INSERT INTO `page_view` VALUES (945, '0', 1462331299, 1, '游客');
INSERT INTO `page_view` VALUES (946, '0', 1462331332, 1, '游客');
INSERT INTO `page_view` VALUES (947, '0', 1462946806, 1, '游客');
INSERT INTO `page_view` VALUES (948, '0', 1464077856, 1, '游客');
INSERT INTO `page_view` VALUES (949, '0', 1464226166, 1, '游客');
INSERT INTO `page_view` VALUES (950, '0', 1465871489, 1, '游客');
INSERT INTO `page_view` VALUES (951, '0', 1465956550, 1, '游客');
INSERT INTO `page_view` VALUES (952, '0', 1466047994, 1, '游客');
INSERT INTO `page_view` VALUES (953, '0', 1466663005, 1, '游客');
INSERT INTO `page_view` VALUES (954, '0', 1466726954, 1, '游客');
INSERT INTO `page_view` VALUES (955, '0', 1466759231, 1, '游客');
INSERT INTO `page_view` VALUES (956, '0', 1466759304, 1, '游客');
INSERT INTO `page_view` VALUES (957, '0', 1476238957, 1, '游客');
INSERT INTO `page_view` VALUES (958, '0', 1476324598, 1, '游客');
INSERT INTO `page_view` VALUES (959, '0', 1476410564, 1, '游客');
INSERT INTO `page_view` VALUES (960, '0', 1476669601, 1, '游客');
INSERT INTO `page_view` VALUES (961, '0', 1481702752, 1, '游客');
INSERT INTO `page_view` VALUES (962, '0', 1483412008, 1, '游客');
INSERT INTO `page_view` VALUES (963, '0', 1483494974, 1, '游客');
INSERT INTO `page_view` VALUES (964, '2130706433', 1483598089, 1, '游客');
INSERT INTO `page_view` VALUES (965, '0', 1483672405, 1, '游客');
INSERT INTO `page_view` VALUES (966, '0', 1487130639, 1, '游客');
INSERT INTO `page_view` VALUES (967, '0', 1488505552, 1, '游客');
INSERT INTO `page_view` VALUES (968, '0', 1488514314, 1, '游客');
INSERT INTO `page_view` VALUES (969, '0', 1488526867, 1, '游客');
INSERT INTO `page_view` VALUES (970, '0', 1488528279, 1, '游客');
INSERT INTO `page_view` VALUES (971, '0', 1488528285, 1, '游客');
INSERT INTO `page_view` VALUES (972, '0', 1488528355, 1, '游客');
INSERT INTO `page_view` VALUES (973, '0', 1488528547, 1, '游客');
INSERT INTO `page_view` VALUES (974, '0', 1488764632, 1, '游客');
INSERT INTO `page_view` VALUES (975, '0', 1488765665, 1, '游客');
INSERT INTO `page_view` VALUES (976, '0', 1488765708, 1, '游客');
INSERT INTO `page_view` VALUES (977, '0', 1488765720, 1, '游客');
INSERT INTO `page_view` VALUES (978, '0', 1488772245, 1, '游客');
INSERT INTO `page_view` VALUES (979, '0', 1488772270, 1, '游客');
INSERT INTO `page_view` VALUES (980, '0', 1488774240, 1, '游客');
INSERT INTO `page_view` VALUES (981, '0', 1488774308, 1, '游客');
INSERT INTO `page_view` VALUES (982, '0', 1488774320, 1, '游客');
INSERT INTO `page_view` VALUES (983, '0', 1488774374, 1, '游客');
INSERT INTO `page_view` VALUES (984, '0', 1488774397, 1, '游客');
INSERT INTO `page_view` VALUES (985, '0', 1488774437, 1, '游客');
INSERT INTO `page_view` VALUES (986, '0', 1488774469, 1, '游客');
INSERT INTO `page_view` VALUES (987, '0', 1488774479, 1, '游客');
INSERT INTO `page_view` VALUES (988, '0', 1488774575, 1, '游客');
INSERT INTO `page_view` VALUES (989, '0', 1488774652, 1, '游客');
INSERT INTO `page_view` VALUES (990, '0', 1488774698, 1, '游客');
INSERT INTO `page_view` VALUES (991, '0', 1488774708, 1, '游客');
INSERT INTO `page_view` VALUES (992, '0', 1488774712, 1, '游客');
INSERT INTO `page_view` VALUES (993, '0', 1488774713, 1, '游客');
INSERT INTO `page_view` VALUES (994, '0', 1488774722, 1, '游客');
INSERT INTO `page_view` VALUES (995, '0', 1488774818, 1, '游客');
INSERT INTO `page_view` VALUES (996, '0', 1488774826, 1, '游客');
INSERT INTO `page_view` VALUES (997, '0', 1488872055, 1, '游客');
INSERT INTO `page_view` VALUES (998, '0', 1488877505, 1, '游客');
INSERT INTO `page_view` VALUES (999, '0', 1488877749, 1, '游客');
INSERT INTO `page_view` VALUES (1000, '0', 1488963468, 1, '游客');
INSERT INTO `page_view` VALUES (1001, '0', 1488963475, 1, '游客');
INSERT INTO `page_view` VALUES (1002, '0', 1488963563, 1, '游客');
INSERT INTO `page_view` VALUES (1003, '0', 1488963723, 1, '游客');
INSERT INTO `page_view` VALUES (1004, '0', 1488963832, 1, '游客');
INSERT INTO `page_view` VALUES (1005, '0', 1488964181, 1, '游客');
INSERT INTO `page_view` VALUES (1006, '0', 1488964311, 1, '游客');
INSERT INTO `page_view` VALUES (1007, '0', 1488964364, 1, '游客');
INSERT INTO `page_view` VALUES (1008, '0', 1488964585, 1, '游客');
INSERT INTO `page_view` VALUES (1009, '0', 1488964633, 1, '游客');
INSERT INTO `page_view` VALUES (1010, '0', 1488964646, 1, '游客');
INSERT INTO `page_view` VALUES (1011, '0', 1488964652, 1, '游客');
INSERT INTO `page_view` VALUES (1012, '0', 1488964704, 1, '游客');
INSERT INTO `page_view` VALUES (1013, '0', 1488964859, 1, '游客');
INSERT INTO `page_view` VALUES (1014, '0', 1488964868, 1, '游客');
INSERT INTO `page_view` VALUES (1015, '0', 1488964883, 1, '游客');
INSERT INTO `page_view` VALUES (1016, '0', 1488964914, 1, '游客');
INSERT INTO `page_view` VALUES (1017, '0', 1488964923, 1, '游客');
INSERT INTO `page_view` VALUES (1018, '0', 1488964937, 1, '游客');
INSERT INTO `page_view` VALUES (1019, '0', 1488965008, 1, '游客');
INSERT INTO `page_view` VALUES (1020, '0', 1488965043, 1, '游客');
INSERT INTO `page_view` VALUES (1021, '0', 1488965060, 1, '游客');
INSERT INTO `page_view` VALUES (1022, '0', 1488965076, 1, '游客');
INSERT INTO `page_view` VALUES (1023, '0', 1488965086, 1, '游客');
INSERT INTO `page_view` VALUES (1024, '0', 1488965103, 1, '游客');
INSERT INTO `page_view` VALUES (1025, '0', 1488965108, 1, '游客');
INSERT INTO `page_view` VALUES (1026, '0', 1488965165, 1, '游客');
INSERT INTO `page_view` VALUES (1027, '0', 1488965209, 1, '游客');
INSERT INTO `page_view` VALUES (1028, '0', 1488965225, 1, '游客');
INSERT INTO `page_view` VALUES (1029, '0', 1488965233, 1, '游客');
INSERT INTO `page_view` VALUES (1030, '0', 1488965247, 1, '游客');
INSERT INTO `page_view` VALUES (1031, '0', 1488965297, 1, '游客');
INSERT INTO `page_view` VALUES (1032, '0', 1488965307, 1, '游客');
INSERT INTO `page_view` VALUES (1033, '0', 1488965320, 1, '游客');
INSERT INTO `page_view` VALUES (1034, '0', 1488965330, 1, '游客');
INSERT INTO `page_view` VALUES (1035, '0', 1488965346, 1, '游客');
INSERT INTO `page_view` VALUES (1036, '0', 1488965352, 1, '游客');
INSERT INTO `page_view` VALUES (1037, '0', 1488965424, 1, '游客');
INSERT INTO `page_view` VALUES (1038, '0', 1489025031, 1, '游客');
INSERT INTO `page_view` VALUES (1039, '0', 1489025098, 1, '游客');
INSERT INTO `page_view` VALUES (1040, '0', 1489025321, 1, '游客');
INSERT INTO `page_view` VALUES (1041, '0', 1489025935, 1, '游客');
INSERT INTO `page_view` VALUES (1042, '0', 1489026098, 1, '游客');
INSERT INTO `page_view` VALUES (1043, '0', 1489026136, 1, '游客');
INSERT INTO `page_view` VALUES (1044, '0', 1489026142, 1, '游客');
INSERT INTO `page_view` VALUES (1045, '0', 1489026391, 1, '游客');
INSERT INTO `page_view` VALUES (1046, '0', 1489026556, 1, '游客');
INSERT INTO `page_view` VALUES (1047, '0', 1489026738, 1, '游客');
INSERT INTO `page_view` VALUES (1048, '0', 1489026800, 1, '游客');
INSERT INTO `page_view` VALUES (1049, '0', 1489026804, 1, '游客');
INSERT INTO `page_view` VALUES (1050, '0', 1489026979, 1, '游客');
INSERT INTO `page_view` VALUES (1051, '0', 1489027121, 1, '游客');
INSERT INTO `page_view` VALUES (1052, '0', 1489027330, 1, '游客');
INSERT INTO `page_view` VALUES (1053, '0', 1489027371, 1, '游客');
INSERT INTO `page_view` VALUES (1054, '0', 1489029891, 1, '游客');
INSERT INTO `page_view` VALUES (1055, '0', 1489029900, 1, '游客');
INSERT INTO `page_view` VALUES (1056, '0', 1489029936, 1, '游客');
INSERT INTO `page_view` VALUES (1057, '0', 1489041026, 1, '游客');
INSERT INTO `page_view` VALUES (1058, '0', 1489041611, 1, '游客');
INSERT INTO `page_view` VALUES (1059, '0', 1489041616, 1, '游客');
INSERT INTO `page_view` VALUES (1060, '0', 1489041709, 1, '游客');
INSERT INTO `page_view` VALUES (1061, '0', 1489041771, 1, '游客');
INSERT INTO `page_view` VALUES (1062, '0', 1489041795, 1, '游客');
INSERT INTO `page_view` VALUES (1063, '0', 1489041802, 1, '游客');
INSERT INTO `page_view` VALUES (1064, '0', 1489041948, 1, '游客');
INSERT INTO `page_view` VALUES (1065, '0', 1489042060, 1, '游客');
INSERT INTO `page_view` VALUES (1066, '0', 1489042294, 1, '游客');
INSERT INTO `page_view` VALUES (1067, '0', 1489042348, 1, '游客');
INSERT INTO `page_view` VALUES (1068, '0', 1489042438, 1, '游客');
INSERT INTO `page_view` VALUES (1069, '0', 1489042525, 1, '游客');
INSERT INTO `page_view` VALUES (1070, '0', 1489042615, 1, '游客');
INSERT INTO `page_view` VALUES (1071, '0', 1489042772, 1, '游客');
INSERT INTO `page_view` VALUES (1072, '0', 1489042780, 1, '游客');
INSERT INTO `page_view` VALUES (1073, '0', 1489042805, 1, '游客');
INSERT INTO `page_view` VALUES (1074, '0', 1489042871, 1, '游客');
INSERT INTO `page_view` VALUES (1075, '0', 1489043001, 1, '游客');
INSERT INTO `page_view` VALUES (1076, '0', 1489043075, 1, '游客');
INSERT INTO `page_view` VALUES (1077, '0', 1489043085, 1, '游客');
INSERT INTO `page_view` VALUES (1078, '0', 1489043105, 1, '游客');
INSERT INTO `page_view` VALUES (1079, '0', 1489043131, 1, '游客');
INSERT INTO `page_view` VALUES (1080, '0', 1489043144, 1, '游客');
INSERT INTO `page_view` VALUES (1081, '0', 1489043824, 1, '游客');
INSERT INTO `page_view` VALUES (1082, '0', 1489044232, 1, '游客');
INSERT INTO `page_view` VALUES (1083, '0', 1489126547, 1, '游客');
INSERT INTO `page_view` VALUES (1084, '0', 1489126611, 1, '游客');
INSERT INTO `page_view` VALUES (1085, '0', 1489369434, 1, '游客');
INSERT INTO `page_view` VALUES (1086, '0', 1489457289, 1, '游客');
INSERT INTO `page_view` VALUES (1087, '0', 1489544609, 1, '游客');
INSERT INTO `page_view` VALUES (1088, '0', 1489628761, 1, '游客');
INSERT INTO `page_view` VALUES (1089, '0', 1489715188, 1, '游客');
INSERT INTO `page_view` VALUES (1090, '0', 1490668800, 1, '游客');
INSERT INTO `page_view` VALUES (1091, '0', 1490668806, 1, '游客');
INSERT INTO `page_view` VALUES (1092, '0', 1490668815, 1, '游客');
INSERT INTO `page_view` VALUES (1093, '0', 1490669981, 1, '游客');
INSERT INTO `page_view` VALUES (1094, '0', 1490669992, 1, '游客');
INSERT INTO `page_view` VALUES (1095, '0', 1490670149, 1, '游客');
INSERT INTO `page_view` VALUES (1096, '0', 1490670185, 1, '游客');
INSERT INTO `page_view` VALUES (1097, '0', 1490670235, 1, '游客');
INSERT INTO `page_view` VALUES (1098, '0', 1490670342, 1, '游客');
INSERT INTO `page_view` VALUES (1099, '0', 1490670562, 1, '游客');
INSERT INTO `page_view` VALUES (1100, '0', 1490670751, 1, '游客');
INSERT INTO `page_view` VALUES (1101, '0', 1490670775, 1, '游客');
INSERT INTO `page_view` VALUES (1102, '0', 1490670795, 1, '游客');
INSERT INTO `page_view` VALUES (1103, '0', 1490670809, 1, '游客');
INSERT INTO `page_view` VALUES (1104, '0', 1490670835, 1, '游客');
INSERT INTO `page_view` VALUES (1105, '0', 1490670846, 1, '游客');
INSERT INTO `page_view` VALUES (1106, '0', 1490670870, 1, '游客');
INSERT INTO `page_view` VALUES (1107, '0', 1490671428, 1, '游客');
INSERT INTO `page_view` VALUES (1108, '0', 1490671482, 1, '游客');
INSERT INTO `page_view` VALUES (1109, '0', 1490682983, 1, '游客');
INSERT INTO `page_view` VALUES (1110, '0', 1490683304, 1, '游客');
INSERT INTO `page_view` VALUES (1111, '0', 1490683362, 1, '游客');
INSERT INTO `page_view` VALUES (1112, '0', 1490683459, 1, '游客');
INSERT INTO `page_view` VALUES (1113, '0', 1490683485, 1, '游客');
INSERT INTO `page_view` VALUES (1114, '0', 1490683630, 1, '游客');
INSERT INTO `page_view` VALUES (1115, '0', 1490683720, 1, '游客');
INSERT INTO `page_view` VALUES (1116, '0', 1490683737, 1, '游客');
INSERT INTO `page_view` VALUES (1117, '0', 1490684547, 1, '游客');
INSERT INTO `page_view` VALUES (1118, '0', 1490690493, 1, '游客');
INSERT INTO `page_view` VALUES (1119, '0', 1490690648, 1, '游客');
INSERT INTO `page_view` VALUES (1120, '0', 1490690759, 1, '游客');
INSERT INTO `page_view` VALUES (1121, '0', 1490690770, 1, '游客');
INSERT INTO `page_view` VALUES (1122, '0', 1490690852, 1, '游客');
INSERT INTO `page_view` VALUES (1123, '0', 1490690869, 1, '游客');
INSERT INTO `page_view` VALUES (1124, '0', 1490690895, 1, '游客');
INSERT INTO `page_view` VALUES (1125, '0', 1490690904, 1, '游客');
INSERT INTO `page_view` VALUES (1126, '0', 1490690914, 1, '游客');
INSERT INTO `page_view` VALUES (1127, '0', 1490690922, 1, '游客');
INSERT INTO `page_view` VALUES (1128, '0', 1490690929, 1, '游客');
INSERT INTO `page_view` VALUES (1129, '0', 1490690961, 1, '游客');
INSERT INTO `page_view` VALUES (1130, '0', 1490691043, 1, '游客');
INSERT INTO `page_view` VALUES (1131, '0', 1490691080, 1, '游客');
INSERT INTO `page_view` VALUES (1132, '0', 1490691138, 1, '游客');
INSERT INTO `page_view` VALUES (1133, '0', 1490691193, 1, '游客');
INSERT INTO `page_view` VALUES (1134, '0', 1490691205, 1, '游客');
INSERT INTO `page_view` VALUES (1135, '0', 1490691582, 1, '游客');
INSERT INTO `page_view` VALUES (1136, '0', 1490691647, 1, '游客');
INSERT INTO `page_view` VALUES (1137, '0', 1490691666, 1, '游客');
INSERT INTO `page_view` VALUES (1138, '0', 1490691686, 1, '游客');
INSERT INTO `page_view` VALUES (1139, '0', 1490691707, 1, '游客');
INSERT INTO `page_view` VALUES (1140, '0', 1490691999, 1, '游客');
INSERT INTO `page_view` VALUES (1141, '0', 1490691999, 1, '游客');
INSERT INTO `page_view` VALUES (1142, '0', 1490693318, 1, '游客');
INSERT INTO `page_view` VALUES (1143, '0', 1490754202, 1, '游客');
INSERT INTO `page_view` VALUES (1144, '0', 1490754333, 1, '游客');
INSERT INTO `page_view` VALUES (1145, '0', 1490754411, 1, '游客');
INSERT INTO `page_view` VALUES (1146, '0', 1490754481, 1, '游客');
INSERT INTO `page_view` VALUES (1147, '0', 1490754703, 1, '游客');
INSERT INTO `page_view` VALUES (1148, '0', 1490754744, 1, '游客');
INSERT INTO `page_view` VALUES (1149, '0', 1490754763, 1, '游客');
INSERT INTO `page_view` VALUES (1150, '0', 1490754793, 1, '游客');
INSERT INTO `page_view` VALUES (1151, '0', 1490754806, 1, '游客');
INSERT INTO `page_view` VALUES (1152, '0', 1490755492, 1, '游客');
INSERT INTO `page_view` VALUES (1153, '0', 1490755532, 1, '游客');
INSERT INTO `page_view` VALUES (1154, '0', 1490755584, 1, '游客');
INSERT INTO `page_view` VALUES (1155, '0', 1490755771, 1, '游客');
INSERT INTO `page_view` VALUES (1156, '0', 1490755789, 1, '游客');
INSERT INTO `page_view` VALUES (1157, '0', 1490755800, 1, '游客');
INSERT INTO `page_view` VALUES (1158, '0', 1490755821, 1, '游客');
INSERT INTO `page_view` VALUES (1159, '0', 1490755922, 1, '游客');
INSERT INTO `page_view` VALUES (1160, '2130706433', 1501217876, 1, '游客');
INSERT INTO `page_view` VALUES (1161, '2130706433', 1502515188, 1, '游客');
INSERT INTO `page_view` VALUES (1162, '2130706433', 1529111806, 1, '游客');
INSERT INTO `page_view` VALUES (1163, '2130706433', 1538100348, 1, '游客');
INSERT INTO `page_view` VALUES (1164, '2130706433', 1568554864, 1, '游客');
INSERT INTO `page_view` VALUES (1165, '2130706433', 1568555025, 1, '游客');
INSERT INTO `page_view` VALUES (1166, '2130706433', 1568555114, 1, '游客');

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `rid` int(11) NULL DEFAULT NULL COMMENT '角色编号',
  `module` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-url;2-主菜单',
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `condition` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `module`(`module`, `status`, `type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 146 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限规则表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1, 3, 'admin', 1, 'Admin/User/index', '用户信息', 1, NULL, '');
INSERT INTO `permission` VALUES (2, 11, 'admin', 1, 'Admin/Role/index', '角色信息', 1, NULL, '');
INSERT INTO `permission` VALUES (3, 12, 'admin', 1, 'Admin/Role/add', '新增角色', 1, NULL, '');
INSERT INTO `permission` VALUES (4, 13, 'admin', 1, 'Admin/Role/edit', '编辑角色', 1, NULL, '');
INSERT INTO `permission` VALUES (5, 14, 'admin', 1, 'Admin/Role/visit', '访问授权', 1, NULL, '');
INSERT INTO `permission` VALUES (6, 15, 'admin', 1, 'Admin/Role/user', '成员授权', 1, NULL, '');
INSERT INTO `permission` VALUES (7, 16, 'admin', 1, 'Admin/Role/removeUser', '解除授权', 1, NULL, '');
INSERT INTO `permission` VALUES (8, 17, 'admin', 1, 'Admin/Role/category', '分类授权', 1, NULL, '');
INSERT INTO `permission` VALUES (9, 18, 'admin', 1, 'Admin/Role/changeStatus?method=forbid', '禁用角色', 1, NULL, '');
INSERT INTO `permission` VALUES (10, 19, 'admin', 1, 'Admin/Role/changeStatus?method=resume', '启用角色', 1, NULL, '');
INSERT INTO `permission` VALUES (11, 20, 'admin', 1, 'Admin/Role/changeStatus?method=delete', '删除角色', 1, NULL, '');
INSERT INTO `permission` VALUES (12, 22, 'admin', 1, 'Admin/Addons/index', '插件信息', 1, NULL, '');
INSERT INTO `permission` VALUES (13, 23, 'admin', 1, 'Admin/Addons/checkForm', '检测创建', 1, NULL, '');
INSERT INTO `permission` VALUES (14, 24, 'admin', 1, 'Admin/Addons/preview', '插件预览', 1, NULL, '');
INSERT INTO `permission` VALUES (15, 25, 'admin', 1, 'Admin/Addons/build', '生成插件', 1, NULL, '');
INSERT INTO `permission` VALUES (16, 26, 'admin', 1, 'Admin/Addons/config', '插件设置', 1, NULL, '');
INSERT INTO `permission` VALUES (17, 27, 'admin', 1, 'Admin/Addons/changeStatus?method=forbid', '禁用插件', 1, NULL, '');
INSERT INTO `permission` VALUES (18, 28, 'admin', 1, 'Admin/Addons/changeStatus?method=resume', '启用插件', 1, NULL, '');
INSERT INTO `permission` VALUES (19, 29, 'admin', 1, 'Admin/Addons/install', '安装插件', 1, NULL, '');
INSERT INTO `permission` VALUES (20, 30, 'admin', 1, 'Admin/Addons/uninstall', '卸载插件', 1, NULL, '');
INSERT INTO `permission` VALUES (21, 31, 'admin', 1, 'Admin/Addons/saveconfig', '更新配置', 1, NULL, '');
INSERT INTO `permission` VALUES (22, 32, 'admin', 1, 'Admin/Addons/installed', '插件后台列表', 1, NULL, '');
INSERT INTO `permission` VALUES (23, 33, 'admin', 1, 'Admin/Addons/execute', 'URL方式访问插件', 1, NULL, '');
INSERT INTO `permission` VALUES (24, 34, 'admin', 1, 'Admin/Addons/add', '创建插件', 1, NULL, '');
INSERT INTO `permission` VALUES (25, 35, 'admin', 1, 'Admin/Hooks/index', '钩子信息', 1, NULL, '');
INSERT INTO `permission` VALUES (26, 36, 'admin', 1, 'Admin/Hooks/add', '新增钩子', 1, NULL, '');
INSERT INTO `permission` VALUES (27, 37, 'admin', 1, 'Admin/Hooks/edit', '编辑钩子', 1, NULL, '');
INSERT INTO `permission` VALUES (28, 74, 'admin', 1, 'Admin/Database/index', '备份数据库', 1, NULL, '');
INSERT INTO `permission` VALUES (29, 78, 'admin', 1, 'Admin/Database/undo', '还原数据库', 1, NULL, '');
INSERT INTO `permission` VALUES (30, 110, 'admin', 1, 'Admin/Travel/index', '游记信息', 1, NULL, '');
INSERT INTO `permission` VALUES (31, 116, 'admin', 1, 'Admin/Note/index', '随笔信息', 1, NULL, '');
INSERT INTO `permission` VALUES (32, 122, 'admin', 1, 'Admin/Service/index', '服务信息', 1, NULL, '');
INSERT INTO `permission` VALUES (33, 128, 'admin', 1, 'Admin/About/index', '关于信息', 1, NULL, '');
INSERT INTO `permission` VALUES (34, 134, 'admin', 1, 'Admin/Contact/index', '联系信息', 1, NULL, '');
INSERT INTO `permission` VALUES (35, 1, 'admin', 2, 'Admin/Index/index', '控制台', 1, NULL, '');
INSERT INTO `permission` VALUES (36, 4, 'admin', 1, 'Admin/User/add', '新增用户', 1, NULL, '');
INSERT INTO `permission` VALUES (37, 42, 'admin', 1, 'Admin/Log/index', '日志信息', 1, NULL, '');
INSERT INTO `permission` VALUES (38, 43, 'admin', 1, 'Admin/Log/view', '日志详情', 1, NULL, '');
INSERT INTO `permission` VALUES (39, 47, 'admin', 1, 'Admin/Action/add', '新增行为', 1, NULL, '');
INSERT INTO `permission` VALUES (40, 55, 'admin', 1, 'Admin/Config/add', '新增配置', 1, NULL, '');
INSERT INTO `permission` VALUES (41, 58, 'admin', 1, 'Admin/Menu/index', '后台菜单', 1, NULL, '');
INSERT INTO `permission` VALUES (42, 59, 'admin', 1, 'Admin/Menu/add', '新增菜单', 1, NULL, '');
INSERT INTO `permission` VALUES (43, 67, 'admin', 1, 'Admin/Channel/index', '前台导航', 1, NULL, '');
INSERT INTO `permission` VALUES (44, 68, 'admin', 1, 'Admin/Channel/add', '新增导航', 1, NULL, '');
INSERT INTO `permission` VALUES (45, 75, 'admin', 1, 'Admin/Database/optimize', '优化表', 1, NULL, '');
INSERT INTO `permission` VALUES (46, 79, 'admin', 1, 'Admin/Database/import', '还原备份', 1, NULL, '');
INSERT INTO `permission` VALUES (47, 82, 'admin', 1, 'Admin/Link/add', '新增链接', 1, NULL, '');
INSERT INTO `permission` VALUES (48, 88, 'admin', 1, 'Admin/Cache/clearcache', '清空缓存', 1, NULL, '');
INSERT INTO `permission` VALUES (49, 89, 'admin', 1, 'Admin/Cache/logcache', '清空日志', 1, NULL, '');
INSERT INTO `permission` VALUES (50, 90, 'admin', 1, 'Admin/Cache/tempcache', '清空临时', 1, NULL, '');
INSERT INTO `permission` VALUES (51, 99, 'admin', 1, 'Admin/Publicity/add', '新增广告', 1, NULL, '');
INSERT INTO `permission` VALUES (52, 104, 'admin', 1, 'Admin/Category/index', '分类信息', 1, NULL, '');
INSERT INTO `permission` VALUES (53, 111, 'admin', 1, 'Admin/Travel/add', '新增游记', 1, NULL, '');
INSERT INTO `permission` VALUES (54, 117, 'admin', 1, 'Admin/Note/add', '新增随笔', 1, NULL, '');
INSERT INTO `permission` VALUES (55, 123, 'admin', 1, 'Admin/Service/add', '新增服务', 1, NULL, '');
INSERT INTO `permission` VALUES (56, 129, 'admin', 1, 'Admin/About/add', '新增关于', 1, NULL, '');
INSERT INTO `permission` VALUES (57, 135, 'admin', 1, 'Admin/Contact/add', '新增联系', 1, NULL, '');
INSERT INTO `permission` VALUES (58, 140, 'admin', 1, 'Admin/Label/index', '标签信息', 1, NULL, '');
INSERT INTO `permission` VALUES (59, 97, 'admin', 2, 'Admin/User/manage', '业务管理', 1, NULL, '');
INSERT INTO `permission` VALUES (60, 5, 'admin', 1, 'Admin/User/edit', '编辑用户', 1, NULL, '');
INSERT INTO `permission` VALUES (61, 40, 'admin', 1, 'Admin/Hooks/changeStatus?method=delete', '删除钩子', 1, NULL, '');
INSERT INTO `permission` VALUES (62, 45, 'admin', 1, 'Admin/Log/changeStatus?method=delete', '删除日志', 1, NULL, '');
INSERT INTO `permission` VALUES (63, 46, 'admin', 1, 'Admin/Action/index', '行为信息', 1, NULL, '');
INSERT INTO `permission` VALUES (64, 48, 'admin', 1, 'Admin/Action/edit', '编辑行为', 1, NULL, '');
INSERT INTO `permission` VALUES (65, 53, 'admin', 1, 'Admin/Config/setting', '网站设置', 1, NULL, '');
INSERT INTO `permission` VALUES (66, 56, 'admin', 1, 'Admin/Config/edit', '编辑配置', 1, NULL, '');
INSERT INTO `permission` VALUES (67, 60, 'admin', 1, 'Admin/Menu/edit', '编辑菜单', 1, NULL, '');
INSERT INTO `permission` VALUES (68, 69, 'admin', 1, 'Admin/Channel/edit', '编辑导航', 1, NULL, '');
INSERT INTO `permission` VALUES (69, 76, 'admin', 1, 'Admin/Database/repair', '修复表', 1, NULL, '');
INSERT INTO `permission` VALUES (70, 80, 'admin', 1, 'Admin/Database/del', '删除备份', 1, NULL, '');
INSERT INTO `permission` VALUES (71, 83, 'admin', 1, 'Admin/Link/edit', '编辑链接', 1, NULL, '');
INSERT INTO `permission` VALUES (72, 87, 'admin', 1, 'Admin/Cache/index', '缓存信息', 1, NULL, '');
INSERT INTO `permission` VALUES (73, 92, 'admin', 1, 'Admin/Seo/add', '新增SEO', 1, NULL, '');
INSERT INTO `permission` VALUES (74, 100, 'admin', 1, 'Admin/Publicity/edit', '编辑广告', 1, NULL, '');
INSERT INTO `permission` VALUES (75, 105, 'admin', 1, 'Admin/Category/add', '新增分类', 1, NULL, '');
INSERT INTO `permission` VALUES (76, 106, 'admin', 1, 'Admin/Category/edit', '编辑分类', 1, NULL, '');
INSERT INTO `permission` VALUES (77, 109, 'admin', 1, 'Admin/Category/changeStatus?method=delete', '删除分类', 1, NULL, '');
INSERT INTO `permission` VALUES (78, 112, 'admin', 1, 'Admin/Travel/edit', '编辑游记', 1, NULL, '');
INSERT INTO `permission` VALUES (79, 118, 'admin', 1, 'Admin/Note/edit', '编辑随笔', 1, NULL, '');
INSERT INTO `permission` VALUES (80, 124, 'admin', 1, 'Admin/Service/edit', '编辑服务', 1, NULL, '');
INSERT INTO `permission` VALUES (81, 130, 'admin', 1, 'Admin/About/edit', '编辑关于', 1, NULL, '');
INSERT INTO `permission` VALUES (82, 136, 'admin', 1, 'Admin/Contact/edit', '编辑联系', 1, NULL, '');
INSERT INTO `permission` VALUES (83, 141, 'admin', 1, 'Admin/Label/add', '新增标签', 1, NULL, '');
INSERT INTO `permission` VALUES (84, 142, 'admin', 1, 'Admin/Label/edit', '编辑标签', 1, NULL, '');
INSERT INTO `permission` VALUES (85, 145, 'admin', 1, 'Admin/Label/changeStatus?method=delete', '删除标签', 1, NULL, '');
INSERT INTO `permission` VALUES (86, 6, 'admin', 1, 'Admin/User/password', '重置密码', 1, NULL, '');
INSERT INTO `permission` VALUES (87, 44, 'admin', 1, 'Admin/Log/clear', '清空日志', 1, NULL, '');
INSERT INTO `permission` VALUES (88, 51, 'admin', 1, 'Admin/Action/changeStatus?method=delete', '删除行为', 1, NULL, '');
INSERT INTO `permission` VALUES (89, 57, 'admin', 1, 'Admin/Config/changeStatus?method=delete', '删除配置', 1, NULL, '');
INSERT INTO `permission` VALUES (90, 61, 'admin', 1, 'Admin/Menu/sort', '菜单排序', 1, NULL, '');
INSERT INTO `permission` VALUES (91, 73, 'admin', 1, 'Admin/Channel/changeStatus?method=delete', '删除导航', 1, NULL, '');
INSERT INTO `permission` VALUES (92, 77, 'admin', 1, 'Admin/Database/export', '数据备份', 1, NULL, '');
INSERT INTO `permission` VALUES (93, 84, 'admin', 1, 'Admin/Link/changeStatus?method=forbid', '禁用链接', 1, NULL, '');
INSERT INTO `permission` VALUES (94, 93, 'admin', 1, 'Admin/Seo/edit', '编辑SEO', 1, NULL, '');
INSERT INTO `permission` VALUES (95, 94, 'admin', 1, 'Admin/Seo/changeStatus?method=forbid', '禁用SEO', 1, NULL, '');
INSERT INTO `permission` VALUES (96, 102, 'admin', 1, 'Admin/Publicity/changeStatus?method=resume', '启用广告', 1, NULL, '');
INSERT INTO `permission` VALUES (97, 108, 'admin', 1, 'Admin/Category/changeStatus?method=resume', '启用分类', 1, NULL, '');
INSERT INTO `permission` VALUES (98, 113, 'admin', 1, 'Admin/Travel/changeStatus?method=forbid', '禁用游记', 1, NULL, '');
INSERT INTO `permission` VALUES (99, 119, 'admin', 1, 'Admin/Note/changeStatus?method=forbid', '禁用随笔', 1, NULL, '');
INSERT INTO `permission` VALUES (100, 125, 'admin', 1, 'Admin/Service/changeStatus?method=forbid', '禁用服务', 1, NULL, '');
INSERT INTO `permission` VALUES (101, 131, 'admin', 1, 'Admin/About/changeStatus?method=forbid', '禁用关于', 1, NULL, '');
INSERT INTO `permission` VALUES (102, 137, 'admin', 1, 'Admin/Contact/changeStatus?method=forbid', '禁用联系', 1, NULL, '');
INSERT INTO `permission` VALUES (103, 144, 'admin', 1, 'Admin/Label/changeStatus?method=resume', '启用标签', 1, NULL, '');
INSERT INTO `permission` VALUES (104, 7, 'admin', 1, 'Admin/User/authorization', '授权用户', 1, NULL, '');
INSERT INTO `permission` VALUES (105, 21, 'admin', 2, 'Admin/Addons/manage', '插件管理', 1, NULL, '');
INSERT INTO `permission` VALUES (106, 38, 'admin', 1, 'Admin/Hooks/changeStatus?method=resume', '启用钩子', 1, NULL, '');
INSERT INTO `permission` VALUES (107, 41, 'admin', 2, 'Admin/Log/manage', '日志管理', 1, NULL, '');
INSERT INTO `permission` VALUES (108, 50, 'admin', 1, 'Admin/Action/changeStatus?method=resume', '启用行为', 1, NULL, '');
INSERT INTO `permission` VALUES (109, 54, 'admin', 1, 'Admin/Config/index', '配置信息', 1, NULL, '');
INSERT INTO `permission` VALUES (110, 62, 'admin', 1, 'Admin/Menu/toogleHide', '菜单是否显示', 1, NULL, '');
INSERT INTO `permission` VALUES (111, 70, 'admin', 1, 'Admin/Channel/sort', '导航排序', 1, NULL, '');
INSERT INTO `permission` VALUES (112, 85, 'admin', 1, 'Admin/Link/changeStatus?method=resume', '启用链接', 1, NULL, '');
INSERT INTO `permission` VALUES (113, 95, 'admin', 1, 'Admin/Seo/changeStatus?method=resume', '启用SEO', 1, NULL, '');
INSERT INTO `permission` VALUES (114, 96, 'admin', 1, 'Admin/Seo/changeStatus?method=delete', '删除SEO', 1, NULL, '');
INSERT INTO `permission` VALUES (115, 101, 'admin', 1, 'Admin/Publicity/changeStatus?method=forbid', '禁用广告', 1, NULL, '');
INSERT INTO `permission` VALUES (116, 107, 'admin', 1, 'Admin/Category/changeStatus?method=forbid', '禁用分类', 1, NULL, '');
INSERT INTO `permission` VALUES (117, 114, 'admin', 1, 'Admin/Travel/changeStatus?method=resume', '启用游记', 1, NULL, '');
INSERT INTO `permission` VALUES (118, 120, 'admin', 1, 'Admin/Note/changeStatus?method=resume', '启用随笔', 1, NULL, '');
INSERT INTO `permission` VALUES (119, 126, 'admin', 1, 'Admin/Service/changeStatus?method=resume', '启用服务', 1, NULL, '');
INSERT INTO `permission` VALUES (120, 132, 'admin', 1, 'Admin/About/changeStatus?method=resume', '启用关于', 1, NULL, '');
INSERT INTO `permission` VALUES (121, 138, 'admin', 1, 'Admin/Contact/changeStatus?method=resume', '启用联系', 1, NULL, '');
INSERT INTO `permission` VALUES (122, 143, 'admin', 1, 'Admin/Label/changeStatus?method=forbid', '禁用标签', 1, NULL, '');
INSERT INTO `permission` VALUES (123, 8, 'admin', 1, 'Admin/User/changeStatus?method=forbid', '禁用用户', 1, NULL, '');
INSERT INTO `permission` VALUES (124, 39, 'admin', 1, 'Admin/Hooks/changeStatus?method=forbid', '禁用钩子', 1, NULL, '');
INSERT INTO `permission` VALUES (125, 49, 'admin', 1, 'Admin/Action/changeStatus?method=forbid', '禁用行为', 1, NULL, '');
INSERT INTO `permission` VALUES (126, 52, 'admin', 2, 'Admin/System/manage', '系统管理', 1, NULL, '');
INSERT INTO `permission` VALUES (127, 63, 'admin', 1, 'Admin/Menu/toogleDev', '菜单开发者是否可见', 1, NULL, '');
INSERT INTO `permission` VALUES (128, 72, 'admin', 1, 'Admin/Channel/changeStatus?method=resume', '启用导航', 1, NULL, '');
INSERT INTO `permission` VALUES (129, 81, 'admin', 1, 'Admin/Link/index', '链接信息', 1, NULL, '');
INSERT INTO `permission` VALUES (130, 86, 'admin', 1, 'Admin/Link/changeStatus?method=delete', '删除链接', 1, NULL, '');
INSERT INTO `permission` VALUES (131, 103, 'admin', 1, 'Admin/Publicity/changeStatus?method=delete', '删除广告', 1, NULL, '');
INSERT INTO `permission` VALUES (132, 115, 'admin', 1, 'Admin/Travel/changeStatus?method=delete', '删除游记', 1, NULL, '');
INSERT INTO `permission` VALUES (133, 121, 'admin', 1, 'Admin/Note/changeStatus?method=delete', '删除随笔', 1, NULL, '');
INSERT INTO `permission` VALUES (134, 127, 'admin', 1, 'Admin/Service/changeStatus?method=delete', '删除服务', 1, NULL, '');
INSERT INTO `permission` VALUES (135, 133, 'admin', 1, 'Admin/About/changeStatus?method=delete', '删除关于', 1, NULL, '');
INSERT INTO `permission` VALUES (136, 139, 'admin', 1, 'Admin/Contact/changeStatus?method=delete', '删除联系', 1, NULL, '');
INSERT INTO `permission` VALUES (137, 9, 'admin', 1, 'Admin/User/changeStatus?method=resume', '启用用户', 1, NULL, '');
INSERT INTO `permission` VALUES (138, 64, 'admin', 1, 'Admin/Menu/changeStatus?method=forbid', '禁用菜单', 1, NULL, '');
INSERT INTO `permission` VALUES (139, 71, 'admin', 1, 'Admin/Channel/changeStatus?method=forbid', '禁用导航', 1, NULL, '');
INSERT INTO `permission` VALUES (140, 91, 'admin', 1, 'Admin/Seo/index', 'SEO信息', 1, NULL, '');
INSERT INTO `permission` VALUES (141, 10, 'admin', 1, 'Admin/User/changeStatus?method=delete', '删除用户', 1, NULL, '');
INSERT INTO `permission` VALUES (142, 65, 'admin', 1, 'Admin/Menu/changeStatus?method=resume', '启用菜单', 1, NULL, '');
INSERT INTO `permission` VALUES (143, 66, 'admin', 1, 'Admin/Menu/changeStatus?method=delete', '删除菜单', 1, NULL, '');
INSERT INTO `permission` VALUES (144, 98, 'admin', 1, 'Admin/Publicity/index', '广告信息', 1, NULL, '');
INSERT INTO `permission` VALUES (145, 136, 'admin', 1, 'Admin/Contact/detail', '意见详情', 1, NULL, '');

-- ----------------------------
-- Table structure for person
-- ----------------------------
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `oid` int(11) NOT NULL COMMENT '关于标题编号',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人们名称',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '人物内容',
  `picture` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人物图片地址',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '人物信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of person
-- ----------------------------
INSERT INTO `person` VALUES (1, 1, '123', '123', '/Uploads/Picture/2017-03-10/58c24f87aefec.jpg', 1, 1489129353, 'admin');
INSERT INTO `person` VALUES (2, 1, '234', '123', '/Uploads/Picture/2016-10-12/57fdde72dfc79.jpg', 1, 1489129374, 'admin');
INSERT INTO `person` VALUES (3, 1, '345', '123', '/Uploads/Download/2015-08-28/55dfd4eccba6b.jpg', 1, 1489129389, 'admin');
INSERT INTO `person` VALUES (4, 1, '张晓飞', '123', '/Uploads/Download/2015-08-26/55dd7baf79dd8.jpg', 1, 1489129401, 'admin');
INSERT INTO `person` VALUES (5, 1, '扬天', '<p>Auth 类已经在ThinkPHP代码仓库中存在很久了，但是因为一直没有出过它的教程， 很少人知道它， 它其实比RBAC更方便 。  \r\n    RBAC是按节点进行认证的，如果要控制比节点更细的权限就有点困难了，比如页面上面的操作按钮， 我想判断用户权限来显示这个按钮， \r\n如果没有权限就不会显示这个按钮；  再比如我想按积分进行权限认证，  积分在0-100时能干什么， 在101-200时能干什么。  \r\n这些权限认证用RABC都很困难。 \r\n    下面介绍 Auth权限认证， 它几乎是全能的， 除了能进行节点认证， 上面说的RABC很难认证的两种情况，它都能实现。  \r\n    Auth权限认证是按规则进行认证。我先说说它的原理。   在数据库中我们有  规则表（think_auth_rule） ,用户组表(think_auth_group), 用户组明显表（think_auth_group_access）\r\n     我们在规则表中定义权限规则 ， 在用户组表中定义每个用户组有哪些权限规则，在用户组明显表中 定义用户所属的用户组。 下面举例说明。  \r\n     我们要判断用户是否有显示一个操作按钮的权限， 首先定义一个规则， 在规则表中添加一个名为 show_button 的规则。  \r\n然后在用户组表添加一个用户组，定义这个用户组有show_button  \r\n的权限规则（think_auth_group表中rules字段存得时规则ID，多个以逗号隔开）， 然后在用户组明细表定义 UID 为1 的用户 \r\n属于刚才这个的这个用户组。 \r\n     ok，表数据定义好后， 判断权限很简单     import(\\\'ORG.Util.Auth\\\');//加载类库     $auth=new Auth();     if($auth->check(\\\'show_button\\\',1)){// 第一个参数是规则名称,第二个参数是用户UID      //有显示操作按钮的权限    }else{      //没有显示操作按钮的权限    }复制代码      Auth类同样可以做像RBAC一样的对节点进行认证。 我们只要将规则名称，定义为节点名称就行了。  </p>', '/Uploads/Download/2015-08-26/55dd7baf6f687.jpg', 1, 1489129518, 'admin');

-- ----------------------------
-- Table structure for province
-- ----------------------------
DROP TABLE IF EXISTS `province`;
CREATE TABLE `province`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '1 - 直辖市2 - 行政省3 - 自治区4 - 特别行政区5 - 其他国家见全局数据字典[省份类型] ',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '省份',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '省份信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of province
-- ----------------------------
INSERT INTO `province` VALUES (1, 5, '国外', NULL, 1, '');
INSERT INTO `province` VALUES (10, 1, '北京', NULL, 1, '');
INSERT INTO `province` VALUES (11, 1, '上海', NULL, 1, '');
INSERT INTO `province` VALUES (12, 1, '天津', NULL, 1, '');
INSERT INTO `province` VALUES (13, 1, '重庆', NULL, 1, '');
INSERT INTO `province` VALUES (14, 2, '河北', NULL, 1, '');
INSERT INTO `province` VALUES (15, 2, '山西', NULL, 1, '');
INSERT INTO `province` VALUES (16, 3, '内蒙古 ', NULL, 1, '');
INSERT INTO `province` VALUES (17, 2, '辽宁', NULL, 1, '');
INSERT INTO `province` VALUES (18, 2, '吉林', NULL, 1, '');
INSERT INTO `province` VALUES (19, 2, '黑龙江', NULL, 1, '');
INSERT INTO `province` VALUES (20, 2, '江苏', NULL, 1, '');
INSERT INTO `province` VALUES (21, 2, '浙江', NULL, 1, '');
INSERT INTO `province` VALUES (22, 2, '安徽', NULL, 1, '');
INSERT INTO `province` VALUES (23, 2, '福建', NULL, 1, '');
INSERT INTO `province` VALUES (24, 2, '江西', NULL, 1, '');
INSERT INTO `province` VALUES (25, 2, '山东', NULL, 1, '');
INSERT INTO `province` VALUES (26, 2, '河南', NULL, 1, '');
INSERT INTO `province` VALUES (27, 2, '湖北', NULL, 1, '');
INSERT INTO `province` VALUES (28, 2, '湖南', NULL, 1, '');
INSERT INTO `province` VALUES (29, 2, '广东', NULL, 1, '');
INSERT INTO `province` VALUES (30, 3, '广西', NULL, 1, '');
INSERT INTO `province` VALUES (31, 2, '海南', NULL, 1, '');
INSERT INTO `province` VALUES (32, 2, '四川', NULL, 1, '');
INSERT INTO `province` VALUES (33, 2, '贵州', NULL, 1, '');
INSERT INTO `province` VALUES (34, 2, '云南', NULL, 1, '');
INSERT INTO `province` VALUES (35, 3, '西藏', NULL, 1, '');
INSERT INTO `province` VALUES (36, 2, '陕西', NULL, 1, '');
INSERT INTO `province` VALUES (37, 2, '甘肃', NULL, 1, '');
INSERT INTO `province` VALUES (38, 2, '青海', NULL, 1, '');
INSERT INTO `province` VALUES (39, 3, '宁夏', NULL, 1, '');
INSERT INTO `province` VALUES (40, 3, '新疆', NULL, 1, '');
INSERT INTO `province` VALUES (41, 4, '香港', NULL, 1, '');
INSERT INTO `province` VALUES (42, 4, '澳门', NULL, 1, '');
INSERT INTO `province` VALUES (43, 2, '台湾', NULL, 1, '');

-- ----------------------------
-- Table structure for publicity
-- ----------------------------
DROP TABLE IF EXISTS `publicity`;
CREATE TABLE `publicity`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告编号',
  `category` tinyint(1) NULL DEFAULT 1 COMMENT '广告类型 1客户端 2网站端',
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '广告标题',
  `picture` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '图片地址',
  `href` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '点击图片跳转地址',
  `browse` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
  `sort` int(3) NULL DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态：0 正常 1 禁用',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '作者',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sort`(`sort`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '广告信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of publicity
-- ----------------------------
INSERT INTO `publicity` VALUES (1, 1, '123', '/Uploads/Picture/2016-06-24/576ca3c85df1d.jpg', '', 1, 0, 1, 1466670011, 'admin');
INSERT INTO `publicity` VALUES (2, 2, '123', '/Uploads/Picture/2016-06-24/576ca66c18869.jpg', '', 2, 0, 1, 1466738289, 'admin');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `module` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '角色所属模块',
  `type` tinyint(4) NULL DEFAULT NULL COMMENT '角色类型',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '角色名称',
  `description` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '角色描述',
  `rules` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '角色拥有的规则id，多个规则 , 隔开',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态：为1正常，为0禁用,-1为删除',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, 'admin', 1, '管理员组', '管理员组', '', 1442914061, 1, 1437107557, 'admin');
INSERT INTO `role` VALUES (28, 'admin', 1, '测试组', '测试', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143', 1488774151, 1, 1488772855, 'admin');

-- ----------------------------
-- Table structure for role_extend
-- ----------------------------
DROP TABLE IF EXISTS `role_extend`;
CREATE TABLE `role_extend`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `rid` int(11) NULL DEFAULT 0 COMMENT '角色编号',
  `cid` int(11) NULL DEFAULT 0 COMMENT '分类编号',
  `type` tinyint(1) NULL DEFAULT 0 COMMENT '扩展类型标识 1:栏目分类权限;2:模型权限',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `group_extend_type`(`rid`, `cid`, `type`) USING BTREE,
  INDEX `uid`(`rid`) USING BTREE,
  INDEX `group_id`(`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组与分类的对应关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_extend
-- ----------------------------
INSERT INTO `role_extend` VALUES (1, 1, 1, 2, 1, 0, '');

-- ----------------------------
-- Table structure for role_member_relevance
-- ----------------------------
DROP TABLE IF EXISTS `role_member_relevance`;
CREATE TABLE `role_member_relevance`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `uid` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `rid` int(11) UNSIGNED NOT NULL COMMENT '角色编号',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uid_group_id`(`uid`, `rid`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`rid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组访问权限表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of role_member_relevance
-- ----------------------------
INSERT INTO `role_member_relevance` VALUES (1, 1, 1);
INSERT INTO `role_member_relevance` VALUES (22, 22, 28);

-- ----------------------------
-- Table structure for seo
-- ----------------------------
DROP TABLE IF EXISTS `seo`;
CREATE TABLE `seo`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '标题',
  `application` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '应用模块',
  `controller` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '控制器',
  `index` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '方法',
  `seo_keywords` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'SEO关键字',
  `seo_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'SEO描述',
  `seo_title` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'SEO标题',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'SEO信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of seo
-- ----------------------------
INSERT INTO `seo` VALUES (1, '1', '1', '1', '111', '1', '1', '1', 1, 1450681193, NULL);
INSERT INTO `seo` VALUES (2, '2', '2', '2', NULL, NULL, NULL, NULL, 1, 1450481193, NULL);

-- ----------------------------
-- Table structure for service
-- ----------------------------
DROP TABLE IF EXISTS `service`;
CREATE TABLE `service`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `title` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '标签描述',
  `display` tinyint(1) NULL DEFAULT 0 COMMENT '是否显示 默认不显示',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '创建时间',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '作者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '服务信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of service
-- ----------------------------
INSERT INTO `service` VALUES (1, '服务1', 'About Project<p>Chupa chups apple pie brownie fruitcake cotton candy lemon\n drops. Marzipan gummies caramels icing brownie. Caramels drag茅e souffl茅\n lemon drops jujubes candy marshmallow lemon drops jelly-o. Cupcake \ndessert powder cheesecake chocolate cake cupcake sugar plum gingerbread \ncookie. Muffin carrot cake candy. Pastry chocolate cake gummi bears \nliquorice caramels cheesecake. Candy lemon drops cake souffl茅 halvah \ncotton candy gingerbread brownie caramels.\n            </p><p></p>', 1, 1, 1489133693, 'admin');

-- ----------------------------
-- Table structure for unique_visitor
-- ----------------------------
DROP TABLE IF EXISTS `unique_visitor`;
CREATE TABLE `unique_visitor`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `browser` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '浏览器',
  `ip_address` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'IP地址',
  `system` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '系统版本',
  `language` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '系统语言',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `founder` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 163 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'UV' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of unique_visitor
-- ----------------------------
INSERT INTO `unique_visitor` VALUES (1, 'Firefox', '0', '简体中文', 'Windows', 1445183000, 1444987490, 1, '游客');
INSERT INTO `unique_visitor` VALUES (2, 'Firefox', '0', '简体中文', 'Windows', 1445183000, 1444987502, 1, '游客');
INSERT INTO `unique_visitor` VALUES (3, 'Firefox', '0', '简体中文', 'Windows', 1445183000, 1445217683, 1, '游客');
INSERT INTO `unique_visitor` VALUES (4, 'Firefox', '0', '简体中文', 'Windows', 1445304887, 1445304887, 1, '游客');
INSERT INTO `unique_visitor` VALUES (5, 'Firefox', '0', '简体中文', 'Windows', 1445494124, 1445494124, 1, '游客');
INSERT INTO `unique_visitor` VALUES (6, 'Firefox', '0', '简体中文', 'Windows', 1445582814, 1445582814, 1, '游客');
INSERT INTO `unique_visitor` VALUES (7, 'Firefox', '0', '简体中文', 'Windows', 1445824896, 1445824896, 1, '游客');
INSERT INTO `unique_visitor` VALUES (8, 'Firefox', '0', '简体中文', 'Windows', 1445911685, 1445911685, 1, '游客');
INSERT INTO `unique_visitor` VALUES (9, 'Firefox', '0', '简体中文', 'Windows', 1445999755, 1445999755, 1, '游客');
INSERT INTO `unique_visitor` VALUES (10, 'Firefox', '0', '简体中文', 'Windows', 1446086789, 1446086789, 1, '游客');
INSERT INTO `unique_visitor` VALUES (11, 'Firefox', '0', '简体中文', 'Windows', 1446173251, 1446173251, 1, '游客');
INSERT INTO `unique_visitor` VALUES (12, 'Firefox', '0', '简体中文', 'Windows', 1446433085, 1446433085, 1, '游客');
INSERT INTO `unique_visitor` VALUES (13, 'Chrome', '0', '简体中文', 'Windows', 1446530541, 1446530540, 1, '游客');
INSERT INTO `unique_visitor` VALUES (14, 'Firefox', '0', '简体中文', 'Windows', 1446685559, 1446685559, 1, '游客');
INSERT INTO `unique_visitor` VALUES (15, 'Firefox', '0', '简体中文', 'Windows', 1446772348, 1446772348, 1, '游客');
INSERT INTO `unique_visitor` VALUES (16, 'Firefox', '0', '简体中文', 'Windows', 1447029751, 1447029750, 1, '游客');
INSERT INTO `unique_visitor` VALUES (17, 'Firefox', '0', '简体中文', 'Windows', 1447118479, 1447118479, 1, '游客');
INSERT INTO `unique_visitor` VALUES (18, 'Firefox', '0', '简体中文', 'Windows', 1447205240, 1447205240, 1, '游客');
INSERT INTO `unique_visitor` VALUES (19, 'Firefox', '0', '简体中文', 'Windows', 1447382944, 1447382943, 1, '游客');
INSERT INTO `unique_visitor` VALUES (20, 'Firefox', '0', '简体中文', 'Windows', 1447721822, 1447721821, 1, '游客');
INSERT INTO `unique_visitor` VALUES (21, 'Firefox', '0', '简体中文', 'Windows', 1447809776, 1447809776, 1, '游客');
INSERT INTO `unique_visitor` VALUES (22, 'Firefox', '0', '简体中文', 'Windows', 1447896353, 1447896352, 1, '游客');
INSERT INTO `unique_visitor` VALUES (23, 'Firefox', '0', '简体中文', 'Windows', 1447986285, 1447986285, 1, '游客');
INSERT INTO `unique_visitor` VALUES (24, 'Firefox', '0', '简体中文', 'Windows', 1448240732, 1448240732, 1, '游客');
INSERT INTO `unique_visitor` VALUES (25, 'Firefox', '0', '简体中文', 'Windows', 1448327555, 1448327555, 1, '游客');
INSERT INTO `unique_visitor` VALUES (26, 'Firefox', '0', '简体中文', 'Windows', 1448415912, 1448415911, 1, '游客');
INSERT INTO `unique_visitor` VALUES (27, 'Firefox', '3232256323', '简体中文', 'Windows', 1448507120, 1448507120, 1, '游客');
INSERT INTO `unique_visitor` VALUES (28, 'Firefox', '3232256323', '简体中文', 'Windows', 1448611572, 1448611571, 1, '游客');
INSERT INTO `unique_visitor` VALUES (29, 'Firefox', '3232256323', '简体中文', 'Windows', 1448865497, 1448865496, 1, '游客');
INSERT INTO `unique_visitor` VALUES (30, 'Firefox', '3232256323', '简体中文', 'Windows', 1449018524, 1449018524, 1, '游客');
INSERT INTO `unique_visitor` VALUES (31, 'Safari', '3232256322', '简体中文', 'MAC', 1449108553, 1449108547, 1, '游客');
INSERT INTO `unique_visitor` VALUES (32, 'Chrome', '3232256323', '简体中文', 'Windows', 1449208986, 1449208986, 1, '游客');
INSERT INTO `unique_visitor` VALUES (33, 'Firefox', '3232256323', '简体中文', 'Windows', 1449451461, 1449451461, 1, '游客');
INSERT INTO `unique_visitor` VALUES (34, 'Firefox', '3232256323', '简体中文', 'Windows', 1449538766, 1449538766, 1, '游客');
INSERT INTO `unique_visitor` VALUES (35, 'Chrome', '3232256323', '简体中文', 'Windows', 1449625539, 1449625538, 1, '游客');
INSERT INTO `unique_visitor` VALUES (36, 'Chrome', '3232256323', '简体中文', 'Windows', 1449712512, 1449712511, 1, '游客');
INSERT INTO `unique_visitor` VALUES (37, 'Chrome', '3232256322', '简体中文', 'Windows', 1449803456, 1449803456, 1, '游客');
INSERT INTO `unique_visitor` VALUES (38, 'Firefox', '3232256322', '简体中文', 'Windows', 1450057065, 1450057065, 1, '游客');
INSERT INTO `unique_visitor` VALUES (39, 'Chrome', '3232256323', '简体中文', 'Windows', 1450143672, 1450143672, 1, '游客');
INSERT INTO `unique_visitor` VALUES (40, 'Chrome', '3232256322', '简体中文', 'Windows', 1450230220, 1450230219, 1, '游客');
INSERT INTO `unique_visitor` VALUES (41, 'Chrome', '3232256323', '简体中文', 'Windows', 1450316733, 1450316733, 1, '游客');
INSERT INTO `unique_visitor` VALUES (42, 'Chrome', '3232256323', '简体中文', 'Windows', 1450316736, 1450316736, 1, '游客');
INSERT INTO `unique_visitor` VALUES (43, 'Chrome', '3232256322', '简体中文', 'Windows', 1450403538, 1450403538, 1, '游客');
INSERT INTO `unique_visitor` VALUES (44, 'Firefox', '3232256323', '简体中文', 'Windows', 1450659026, 1450659025, 1, '游客');
INSERT INTO `unique_visitor` VALUES (45, 'Firefox', '3232256323', '简体中文', 'Windows', 1450747070, 1450747069, 1, '游客');
INSERT INTO `unique_visitor` VALUES (46, 'Firefox', '3232256323', '简体中文', 'Windows', 1450833538, 1450833538, 1, '游客');
INSERT INTO `unique_visitor` VALUES (47, 'Firefox', '3232256323', '简体中文', 'Windows', 1450920322, 1450920322, 1, '游客');
INSERT INTO `unique_visitor` VALUES (48, 'Firefox', '3232256323', '简体中文', 'Windows', 1451006914, 1451006914, 1, '游客');
INSERT INTO `unique_visitor` VALUES (49, 'Firefox', '0', '简体中文', 'Windows', 1451372245, 1451372245, 1, '游客');
INSERT INTO `unique_visitor` VALUES (50, 'Firefox', '0', '简体中文', 'Windows', 1451703220, 1451703220, 1, '游客');
INSERT INTO `unique_visitor` VALUES (51, 'Firefox', '0', '简体中文', 'Windows', 1451870619, 1451870619, 1, '游客');
INSERT INTO `unique_visitor` VALUES (52, 'Firefox', '0', '简体中文', 'Windows', 1452041353, 1452041353, 1, '游客');
INSERT INTO `unique_visitor` VALUES (53, 'Firefox', '0', '简体中文', 'Windows', 1452128033, 1452128033, 1, '游客');
INSERT INTO `unique_visitor` VALUES (54, 'Chrome', '0', '简体中文', 'Windows', 1452236333, 1452236332, 1, '游客');
INSERT INTO `unique_visitor` VALUES (55, 'Firefox', '0', '简体中文', 'Windows', 1452474138, 1452474138, 1, '游客');
INSERT INTO `unique_visitor` VALUES (56, 'Firefox', '0', '简体中文', 'Windows', 1452647022, 1452647021, 1, '游客');
INSERT INTO `unique_visitor` VALUES (57, 'Firefox', '0', '简体中文', 'Windows', 1452733538, 1452733537, 1, '游客');
INSERT INTO `unique_visitor` VALUES (58, 'Firefox', '0', '简体中文', 'Windows', 1452820793, 1452820792, 1, '游客');
INSERT INTO `unique_visitor` VALUES (59, 'Firefox', '0', '简体中文', 'Windows', 1453078727, 1453078727, 1, '游客');
INSERT INTO `unique_visitor` VALUES (60, 'Firefox', '0', '简体中文', 'Windows', 1453167147, 1453167146, 1, '游客');
INSERT INTO `unique_visitor` VALUES (61, 'Firefox', '0', '简体中文', 'Windows', 1453257798, 1453257798, 1, '游客');
INSERT INTO `unique_visitor` VALUES (62, 'Firefox', '0', '简体中文', 'Windows', 1453257836, 1453257836, 1, '游客');
INSERT INTO `unique_visitor` VALUES (63, 'Firefox', '0', '简体中文', 'Windows', 1453344465, 1453344465, 1, '游客');
INSERT INTO `unique_visitor` VALUES (64, 'Firefox', '0', '简体中文', 'Windows', 1453438059, 1453438059, 1, '游客');
INSERT INTO `unique_visitor` VALUES (65, 'Firefox', '0', '简体中文', 'Windows', 1453856898, 1453856898, 1, '游客');
INSERT INTO `unique_visitor` VALUES (66, 'Firefox', '0', '简体中文', 'Windows', 1453945927, 1453945926, 1, '游客');
INSERT INTO `unique_visitor` VALUES (67, 'Firefox', '0', '简体中文', 'Windows', 1455585200, 1455585200, 1, '游客');
INSERT INTO `unique_visitor` VALUES (68, 'Firefox', '0', '简体中文', 'Windows', 1455844955, 1455844955, 1, '游客');
INSERT INTO `unique_visitor` VALUES (69, 'Firefox', '0', '简体中文', 'Windows', 1456368284, 1456368283, 1, '游客');
INSERT INTO `unique_visitor` VALUES (70, 'Firefox', '0', '简体中文', 'Windows', 1458108125, 1458108125, 1, '游客');
INSERT INTO `unique_visitor` VALUES (71, 'Firefox', '0', '简体中文', 'Windows', 1458108166, 1458108166, 1, '游客');
INSERT INTO `unique_visitor` VALUES (72, 'Firefox', '0', '简体中文', 'Windows', 1458198837, 1458198837, 1, '游客');
INSERT INTO `unique_visitor` VALUES (73, 'Firefox', '0', '简体中文', 'Windows', 1458787246, 1458787246, 1, '游客');
INSERT INTO `unique_visitor` VALUES (74, 'Firefox', '0', '简体中文', 'Windows', 1462264940, 1462264940, 1, '游客');
INSERT INTO `unique_visitor` VALUES (75, 'Firefox', '0', '简体中文', 'Windows', 1462946806, 1462946806, 1, '游客');
INSERT INTO `unique_visitor` VALUES (76, 'Firefox', '0', '简体中文', 'Windows', 1464077857, 1464077856, 1, '游客');
INSERT INTO `unique_visitor` VALUES (77, 'Firefox', '0', '简体中文', 'Windows', 1464226166, 1464226166, 1, '游客');
INSERT INTO `unique_visitor` VALUES (78, 'Firefox', '0', '简体中文', 'Windows', 1465871489, 1465871489, 1, '游客');
INSERT INTO `unique_visitor` VALUES (79, 'Firefox', '0', '简体中文', 'Windows', 1466047994, 1466047994, 1, '游客');
INSERT INTO `unique_visitor` VALUES (80, 'Firefox', '0', '简体中文', 'Windows', 1466663006, 1466663005, 1, '游客');
INSERT INTO `unique_visitor` VALUES (81, 'Firefox', '0', '简体中文', 'Windows', 1466759231, 1466759231, 1, '游客');
INSERT INTO `unique_visitor` VALUES (82, 'Firefox', '0', '简体中文', 'Windows', 1476238958, 1476238957, 1, '游客');
INSERT INTO `unique_visitor` VALUES (83, 'Firefox', '0', '简体中文', 'Windows', 1476410565, 1476410564, 1, '游客');
INSERT INTO `unique_visitor` VALUES (84, 'Firefox', '0', '简体中文', 'Windows', 1476669602, 1476669601, 1, '游客');
INSERT INTO `unique_visitor` VALUES (85, 'Firefox', '0', '简体中文', 'Windows', 1481702752, 1481702752, 1, '游客');
INSERT INTO `unique_visitor` VALUES (86, 'Firefox', '0', '简体中文', 'Windows', 1483412009, 1483412008, 1, '游客');
INSERT INTO `unique_visitor` VALUES (87, 'Firefox', '2130706433', '简体中文', 'Windows', 1483598089, 1483598089, 1, '游客');
INSERT INTO `unique_visitor` VALUES (88, 'Firefox', '0', '简体中文', 'Windows', 1487130640, 1487130639, 1, '游客');
INSERT INTO `unique_visitor` VALUES (89, 'Firefox', '0', '简体中文', 'Windows', 1488505553, 1488505552, 1, '游客');
INSERT INTO `unique_visitor` VALUES (90, 'Firefox', '0', '简体中文', 'Windows', 1488764632, 1488764632, 1, '游客');
INSERT INTO `unique_visitor` VALUES (91, 'Firefox', '0', '简体中文', 'Windows', 1488872055, 1488872055, 1, '游客');
INSERT INTO `unique_visitor` VALUES (92, 'Firefox', '0', '简体中文', 'Windows', 1488963468, 1488963468, 1, '游客');
INSERT INTO `unique_visitor` VALUES (93, 'Firefox', '0', '简体中文', 'Windows', 1488963476, 1488963475, 1, '游客');
INSERT INTO `unique_visitor` VALUES (94, 'Firefox', '0', '简体中文', 'Windows', 1489126547, 1489126547, 1, '游客');
INSERT INTO `unique_visitor` VALUES (95, 'Firefox', '0', '简体中文', 'Windows', 1489369435, 1489369434, 1, '游客');
INSERT INTO `unique_visitor` VALUES (96, 'Firefox', '0', '简体中文', 'Windows', 1489457289, 1489457289, 1, '游客');
INSERT INTO `unique_visitor` VALUES (97, 'Firefox', '0', '简体中文', 'Windows', 1489544609, 1489544609, 1, '游客');
INSERT INTO `unique_visitor` VALUES (98, 'Firefox', '0', '简体中文', 'Windows', 1489715189, 1489715188, 1, '游客');
INSERT INTO `unique_visitor` VALUES (99, 'Firefox', '0', '简体中文', 'Windows', 1490668800, 1490668800, 1, '游客');
INSERT INTO `unique_visitor` VALUES (100, 'Firefox', '0', '简体中文', 'Windows', 1490755492, 1490755492, 1, '游客');
INSERT INTO `unique_visitor` VALUES (101, 'Firefox', '2130706433', '简体中文', 'Windows', 1500950130, 1500950130, 1, '游客');
INSERT INTO `unique_visitor` VALUES (102, 'Firefox', '2130706433', '简体中文', 'Windows', 1500950352, 1500950352, 1, '游客');
INSERT INTO `unique_visitor` VALUES (103, 'Firefox', '2130706433', '简体中文', 'Windows', 1500950552, 1500950552, 1, '游客');
INSERT INTO `unique_visitor` VALUES (104, 'Firefox', '2130706433', '简体中文', 'Windows', 1500951232, 1500951232, 1, '游客');
INSERT INTO `unique_visitor` VALUES (105, 'Firefox', '2130706433', '简体中文', 'Windows', 1500951265, 1500951265, 1, '游客');
INSERT INTO `unique_visitor` VALUES (106, 'Firefox', '2130706433', '简体中文', 'Windows', 1500951631, 1500951631, 1, '游客');
INSERT INTO `unique_visitor` VALUES (107, 'Firefox', '2130706433', '简体中文', 'Windows', 1500951703, 1500951703, 1, '游客');
INSERT INTO `unique_visitor` VALUES (108, 'Firefox', '2130706433', '简体中文', 'Windows', 1500951808, 1500951808, 1, '游客');
INSERT INTO `unique_visitor` VALUES (109, 'Firefox', '2130706433', '简体中文', 'Windows', 1500951895, 1500951895, 1, '游客');
INSERT INTO `unique_visitor` VALUES (110, 'Firefox', '2130706433', '简体中文', 'Windows', 1500957522, 1500957521, 1, '游客');
INSERT INTO `unique_visitor` VALUES (111, 'Firefox', '2130706433', '简体中文', 'Windows', 1500960187, 1500960187, 1, '游客');
INSERT INTO `unique_visitor` VALUES (112, 'Firefox', '2130706433', '简体中文', 'Windows', 1500960303, 1500960303, 1, '游客');
INSERT INTO `unique_visitor` VALUES (113, 'Firefox', '2130706433', '简体中文', 'Windows', 1500960351, 1500960351, 1, '游客');
INSERT INTO `unique_visitor` VALUES (114, 'Firefox', '2130706433', '简体中文', 'Windows', 1500962282, 1500962282, 1, '游客');
INSERT INTO `unique_visitor` VALUES (115, 'Firefox', '2130706433', '简体中文', 'Windows', 1500987145, 1500987145, 1, '游客');
INSERT INTO `unique_visitor` VALUES (116, 'Firefox', '2130706433', '简体中文', 'Windows', 1500987172, 1500987172, 1, '游客');
INSERT INTO `unique_visitor` VALUES (117, 'Firefox', '2130706433', '简体中文', 'Windows', 1501046233, 1501046231, 1, '游客');
INSERT INTO `unique_visitor` VALUES (118, 'Firefox', '2130706433', '简体中文', 'Windows', 1501056400, 1501056400, 1, '游客');
INSERT INTO `unique_visitor` VALUES (119, 'Firefox', '2130706433', '简体中文', 'Windows', 1501056438, 1501056438, 1, '游客');
INSERT INTO `unique_visitor` VALUES (120, 'Firefox', '2130706433', '简体中文', 'Windows', 1501056508, 1501056508, 1, '游客');
INSERT INTO `unique_visitor` VALUES (121, 'Firefox', '2130706433', '简体中文', 'Windows', 1501057486, 1501057486, 1, '游客');
INSERT INTO `unique_visitor` VALUES (122, 'Firefox', '2130706433', '简体中文', 'Windows', 1501057844, 1501057844, 1, '游客');
INSERT INTO `unique_visitor` VALUES (123, 'Firefox', '2130706433', '简体中文', 'Windows', 1501058061, 1501058061, 1, '游客');
INSERT INTO `unique_visitor` VALUES (124, 'Firefox', '2130706433', '简体中文', 'Windows', 1501058170, 1501058170, 1, '游客');
INSERT INTO `unique_visitor` VALUES (125, 'Firefox', '2130706433', '简体中文', 'Windows', 1501217833, 1501217831, 1, '游客');
INSERT INTO `unique_visitor` VALUES (126, 'Firefox', '2130706433', '简体中文', 'Windows', 1501217877, 1501217876, 1, '游客');
INSERT INTO `unique_visitor` VALUES (127, 'Firefox', '2130706433', '简体中文', 'Windows', 1501217967, 1501217967, 1, '游客');
INSERT INTO `unique_visitor` VALUES (128, 'Firefox', '2130706433', '简体中文', 'Windows', 1501324993, 1501324991, 1, '游客');
INSERT INTO `unique_visitor` VALUES (129, 'Firefox', '2130706433', '简体中文', 'Windows', 1501325187, 1501325187, 1, '游客');
INSERT INTO `unique_visitor` VALUES (130, 'Firefox', '2130706433', '简体中文', 'Windows', 1502515177, 1502515175, 1, '游客');
INSERT INTO `unique_visitor` VALUES (131, 'Firefox', '2130706433', '简体中文', 'Windows', 1502515189, 1502515188, 1, '游客');
INSERT INTO `unique_visitor` VALUES (132, 'Firefox', '2130706433', '简体中文', 'Windows', 1505222271, 1505222269, 1, '游客');
INSERT INTO `unique_visitor` VALUES (133, 'Firefox', '2130706433', '简体中文', 'Windows', 1505225987, 1505225987, 1, '游客');
INSERT INTO `unique_visitor` VALUES (134, 'Firefox', '2130706433', '简体中文', 'Windows', 1505302615, 1505302614, 1, '游客');
INSERT INTO `unique_visitor` VALUES (135, 'Firefox', '2130706433', '简体中文', 'Windows', 1505390062, 1505390061, 1, '游客');
INSERT INTO `unique_visitor` VALUES (136, 'Firefox', '2130706433', '简体中文', 'Windows', 1507554898, 1507554896, 1, '游客');
INSERT INTO `unique_visitor` VALUES (137, 'Firefox', '2130706433', '简体中文', 'Windows', 1507634852, 1507634850, 1, '游客');
INSERT INTO `unique_visitor` VALUES (138, 'Firefox', '2130706433', '简体中文', 'Windows', 1507977400, 1507977398, 1, '游客');
INSERT INTO `unique_visitor` VALUES (139, 'Firefox', '2130706433', '简体中文', 'Windows', 1508326195, 1508326193, 1, '游客');
INSERT INTO `unique_visitor` VALUES (140, 'Firefox', '2130706433', '简体中文', 'Windows', 1509256804, 1509256802, 1, '游客');
INSERT INTO `unique_visitor` VALUES (141, 'Firefox', '2130706433', '简体中文', 'Windows', 1511525537, 1511525535, 1, '游客');
INSERT INTO `unique_visitor` VALUES (142, 'Firefox', '2130706433', '简体中文', 'Windows', 1516428850, 1516428848, 1, '游客');
INSERT INTO `unique_visitor` VALUES (143, 'Firefox', '2130706433', '简体中文', 'Windows', 1520148306, 1520148305, 1, '游客');
INSERT INTO `unique_visitor` VALUES (144, 'Firefox', '2130706433', '简体中文', 'Windows', 1520939600, 1520939599, 1, '游客');
INSERT INTO `unique_visitor` VALUES (145, 'Firefox', '2130706433', '简体中文', 'Windows', 1521719065, 1521719064, 1, '游客');
INSERT INTO `unique_visitor` VALUES (146, 'Firefox', '2130706433', '简体中文', 'Windows', 1522680643, 1522680642, 1, '游客');
INSERT INTO `unique_visitor` VALUES (147, 'Firefox', '2130706433', '简体中文', 'Windows', 1522767626, 1522767625, 1, '游客');
INSERT INTO `unique_visitor` VALUES (148, 'Firefox', '2130706433', '简体中文', 'Windows', 1529110890, 1529110889, 1, '游客');
INSERT INTO `unique_visitor` VALUES (149, 'Firefox', '2130706433', '简体中文', 'Windows', 1529110925, 1529110925, 1, '游客');
INSERT INTO `unique_visitor` VALUES (150, 'Firefox', '2130706433', '简体中文', 'Windows', 1529113647, 1529113647, 1, '游客');
INSERT INTO `unique_visitor` VALUES (151, 'Firefox', '2130706433', '简体中文', 'Windows', 1532091160, 1532091158, 1, '游客');
INSERT INTO `unique_visitor` VALUES (152, 'Firefox', '2130706433', '简体中文', 'Windows', 1532095909, 1532095909, 1, '游客');
INSERT INTO `unique_visitor` VALUES (153, 'Firefox', '2130706433', '简体中文', 'Windows', 1534937231, 1534937230, 1, '游客');
INSERT INTO `unique_visitor` VALUES (154, 'Firefox', '2130706433', '简体中文', 'Windows', 1535857788, 1535857787, 1, '游客');
INSERT INTO `unique_visitor` VALUES (155, 'Firefox', '2130706433', '简体中文', 'Windows', 1536975563, 1536975562, 1, '游客');
INSERT INTO `unique_visitor` VALUES (156, 'Firefox', '2130706433', '简体中文', 'Windows', 1538096710, 1538096709, 1, '游客');
INSERT INTO `unique_visitor` VALUES (157, 'Firefox', '2130706433', '简体中文', 'Windows', 1538877517, 1538877516, 1, '游客');
INSERT INTO `unique_visitor` VALUES (158, 'Firefox', '2130706433', '简体中文', 'Windows', 1539400431, 1539400431, 1, '游客');
INSERT INTO `unique_visitor` VALUES (159, 'Firefox', '2130706433', '简体中文', 'Windows', 1544194627, 1544194625, 1, '游客');
INSERT INTO `unique_visitor` VALUES (160, 'Firefox', '2130706433', '简体中文', 'Windows', 1559472063, 1559472061, 1, '游客');
INSERT INTO `unique_visitor` VALUES (161, 'Firefox', '2130706433', '简体中文', 'Windows', 1565000096, 1565000094, 1, '游客');
INSERT INTO `unique_visitor` VALUES (162, 'Firefox', '2130706433', '简体中文', 'Windows', 1568554149, 1568554148, 1, '游客');

SET FOREIGN_KEY_CHECKS = 1;
