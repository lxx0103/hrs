-- 导出 hrs 的数据库结构
CREATE DATABASE IF NOT EXISTS `hrs` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `hrs`;

-- 导出  表 hrs.s_addition 结构
CREATE TABLE IF NOT EXISTS `s_addition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_code` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `target` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '目标：1部门2员工',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类型，1中午2晚上',
  `addition` date NOT NULL DEFAULT '2000-01-01' COMMENT '开始日期',
  `hours` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '时间',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5556 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='额外工作时间';


-- 导出  表 hrs.s_department 结构
CREATE TABLE IF NOT EXISTS `s_department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '部门名称',
  `has_overtime` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否计算加班工时',
  `noon_break_start` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '12:00:00',
  `noon_break_end` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '13:00:00',
  `night_break_start` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '17:30:00',
  `night_break_end` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '18:00:00',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='部门表';


-- 导出  表 hrs.s_dept_sche 结构
CREATE TABLE IF NOT EXISTS `s_dept_sche` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '部门ID',
  `sche_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '班次ID',
  `start_date` date NOT NULL DEFAULT '2000-01-01' COMMENT '开始日期',
  `end_date` date NOT NULL DEFAULT '2000-01-01' COMMENT '结束日期',
  `start_time` time NOT NULL DEFAULT '00:00:00' COMMENT '上班时间',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='部门班次表';



-- 导出  表 hrs.s_duty 结构
CREATE TABLE IF NOT EXISTS `s_duty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_code` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `duty` date NOT NULL DEFAULT '2000-01-01' COMMENT '开始日期',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=593 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='值班时间';



-- 导出  表 hrs.s_holiday 结构
CREATE TABLE IF NOT EXISTS `s_holiday` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_code` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `target` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '目标：1部门2员工3全公司',
  `type` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类型：1:放假，2:事假，3:病假，4:其他',
  `holiday` date NOT NULL DEFAULT '2000-01-01' COMMENT '假期时间',
  `holiday_end` date NOT NULL DEFAULT '2000-01-01',
  `hours` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59824 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='假期表';



-- 导出  表 hrs.s_menu 结构
CREATE TABLE IF NOT EXISTS `s_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `dir` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单目录',
  `controller` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单控制器',
  `method` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单方法',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级菜单id',
  `need_privilege` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否需要权限',
  `is_hidden` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示在菜单',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='菜单表';

-- 正在导出表  hrs.s_menu 的数据：~59 rows (大约)
DELETE FROM `s_menu`;
/*!40000 ALTER TABLE `s_menu` DISABLE KEYS */;
INSERT INTO `s_menu` (`id`, `name`, `dir`, `controller`, `method`, `is_enable`, `parent_id`, `need_privilege`, `is_hidden`, `create_time`, `create_user`, `update_time`, `update_user`) VALUES
	(1, '我的主页', '', 'home', '', 1, 0, 1, 0, '2017-11-04 16:43:15', 'LIUXU', '2017-11-20 21:35:34', 'LIUXU'),
	(2, '菜单未设置', '', 'home', 'menu', 1, 1, 0, 1, '2017-11-04 17:08:48', 'LIUXU', '2017-11-05 17:25:28', 'LIUXU'),
	(3, '没有权限', '', 'home', 'privilege', 1, 1, 0, 1, '2017-11-04 17:08:48', 'LIUXU', '2017-11-05 17:25:29', 'LIUXU'),
	(4, '404页面', '', 'home', 'exists', 1, 1, 0, 1, '2017-11-04 17:08:48', 'LIUXU', '2017-11-05 17:25:31', 'LIUXU'),
	(5, '权限管理', '', '', '', 1, 0, 1, 0, '2017-11-04 17:08:48', 'LIUXU', '2017-11-05 17:35:31', 'LIUXU'),
	(6, '角色管理', 'privilege', 'role', '', 1, 5, 1, 0, '2017-11-04 17:08:48', 'LIUXU', '2021-08-14 16:17:14', 'LIUXU'),
	(7, '获取角色详情', 'privilege', 'role', 'one', 1, 5, 1, 1, '2017-11-04 17:08:48', 'LIUXU', '2017-11-06 16:41:13', 'LIUXU'),
	(8, '修改角色', 'privilege', 'role', 'save', 1, 5, 1, 1, '2017-11-04 17:08:48', 'LIUXU', '2017-11-06 16:56:31', 'LIUXU'),
	(9, '菜单管理', 'privilege', 'menu', '', 1, 5, 1, 0, '2017-11-04 17:08:48', 'LIUXU', '2017-11-08 14:23:54', 'LIUXU'),
	(10, '获取菜单详情', 'privilege', 'menu', 'one', 1, 5, 1, 1, '2017-11-04 17:08:48', 'LIUXU', '2017-11-08 15:16:17', 'LIUXU'),
	(11, '修改菜单', 'privilege', 'menu', 'save', 1, 5, 1, 1, '2017-11-08 15:07:16', '', '2017-11-20 21:35:24', 'LIUXU'),
	(12, '角色权限', 'privilege', 'privilege', '', 1, 5, 1, 1, '2017-11-08 15:41:40', 'a', '2017-11-08 15:43:33', 'a'),
	(13, '保存权限', 'privilege', 'privilege', 'save', 1, 5, 1, 1, '2017-11-11 16:07:31', 'a', '2017-11-11 16:07:31', 'a'),
	(14, '部门人员管理', '', '', '', 1, 0, 1, 0, '2017-11-11 17:06:58', 'a', '2017-11-11 17:06:58', 'a'),
	(15, '部门列表', 'organization', 'department', '', 1, 14, 1, 0, '2017-11-11 17:26:59', 'a', '2017-11-14 17:15:56', 'LIUXU'),
	(16, '获取部门详情', 'organization', 'department', 'one', 1, 14, 1, 1, '2017-11-14 17:15:49', 'LIUXU', '2017-11-14 17:15:49', 'LIUXU'),
	(17, '修改部门', 'organization', 'department', 'save', 1, 14, 1, 1, '2017-11-14 17:16:31', 'LIUXU', '2017-11-14 17:16:31', 'LIUXU'),
	(18, '人员列表', 'organization', 'staff', '', 1, 14, 1, 0, '2017-11-14 17:22:57', 'LIUXU', '2017-11-14 17:22:57', 'LIUXU'),
	(19, '获取人员详情', 'organization', 'staff', 'one', 1, 14, 1, 1, '2017-11-14 17:23:24', 'LIUXU', '2017-11-14 17:23:24', 'LIUXU'),
	(20, '修改人员', 'organization', 'staff', 'save', 1, 14, 1, 1, '2017-11-14 17:23:52', 'LIUXU', '2017-11-14 17:23:52', 'LIUXU'),
	(21, '职务列表', 'organization', 'position', '', 1, 14, 1, 0, '2017-11-15 20:31:11', 'LIUXU', '2017-11-15 20:31:18', 'LIUXU'),
	(22, '获取职务详情', 'organization', 'position', 'one', 1, 14, 1, 1, '2017-11-15 20:31:50', 'LIUXU', '2017-11-15 20:31:50', 'LIUXU'),
	(23, '修改职务', 'organization', 'position', 'save', 1, 14, 1, 1, '2017-11-15 20:32:13', 'LIUXU', '2017-11-15 20:32:13', 'LIUXU'),
	(24, '考勤规则管理', '', '', '', 1, 0, 1, 0, '2017-11-19 15:36:11', 'LIUXU', '2017-11-19 15:36:11', 'LIUXU'),
	(28, '部门班次设置', 'checkin', 'setsche', '', 1, 24, 1, 0, '2017-11-19 16:11:42', 'LIUXU', '2017-11-19 16:11:42', 'LIUXU'),
	(29, '获取部门班次详情', 'checkin', 'setsche', 'one', 1, 24, 1, 1, '2017-11-19 16:12:18', 'LIUXU', '2017-11-19 16:12:18', 'LIUXU'),
	(30, '修改部门班次', 'checkin', 'setsche', 'save', 1, 24, 1, 1, '2017-11-19 16:12:46', 'LIUXU', '2021-08-14 16:23:01', 'LIUXU'),
	(31, '员工班次设置', 'checkin', 'setsche', 'staff', 1, 24, 1, 0, '2017-11-19 17:10:25', 'LIUXU', '2017-11-19 17:11:56', 'LIUXU'),
	(32, '获取员工班次详情', 'checkin', 'setsche', 'onestaff', 1, 24, 1, 1, '2017-11-19 17:10:53', 'LIUXU', '2017-11-19 17:10:53', 'LIUXU'),
	(33, '修改员工班次', 'checkin', 'setsche', 'savestaff', 1, 24, 1, 1, '2017-11-19 17:11:16', 'LIUXU', '2017-11-19 17:11:16', 'LIUXU'),
	(34, '考勤记录', '', '', '', 1, 0, 1, 0, '2017-11-19 17:23:08', 'LIUXU', '2017-11-19 17:23:08', 'LIUXU'),
	(35, '打卡记录', 'checkin', 'attendence', '', 1, 34, 1, 0, '2017-11-19 17:25:27', 'LIUXU', '2017-11-19 17:25:27', 'LIUXU'),
	(36, '考勤汇总', 'checkin', 'attendence', 'staff', 1, 34, 1, 0, '2017-11-20 21:39:56', 'LIUXU', '2017-11-20 21:39:56', 'LIUXU'),
	(37, '假期设置', 'checkin', 'holiday', '', 1, 24, 1, 0, '2017-11-21 12:29:41', 'LIUXU', '2017-11-21 12:29:41', 'LIUXU'),
	(38, '获取假期详情', 'checkin', 'holiday', 'one', 1, 24, 1, 1, '2017-11-21 12:30:10', 'LIUXU', '2017-11-21 12:30:10', 'LIUXU'),
	(39, '修改假期', 'checkin', 'holiday', 'save', 1, 24, 1, 1, '2017-11-21 12:30:33', 'LIUXU', '2017-11-21 12:30:33', 'LIUXU'),
	(40, '考勤明细', 'checkin', 'attendence', 'detail', 1, 34, 1, 1, '2017-11-21 15:25:26', 'LIUXU', '2017-11-21 17:20:28', 'LIUXU'),
	(41, '补签卡', 'checkin', 'attendence', 'checkin', 1, 34, 1, 1, '2017-11-21 17:19:53', 'LIUXU', '2017-11-21 17:21:08', 'LIUXU'),
	(42, '改为昨日下班卡', 'checkin', 'attendence', 'setcheckdate', 1, 34, 1, 1, '2017-11-22 17:02:11', 'LIUXU', '2017-11-22 17:02:11', 'LIUXU'),
	(43, '导出考勤明细', 'checkin', 'attendence', 'expdata', 1, 34, 1, 1, '2018-01-26 16:21:02', 'LIUXU', '2018-01-26 16:21:02', 'LIUXU'),
	(44, '连班设置', 'checkin', 'addition', '', 1, 24, 1, 0, '2018-03-01 15:59:42', 'LIUXU', '2018-03-01 16:00:01', 'LIUXU'),
	(45, '获取连班详情', 'checkin', 'addition', 'one', 1, 24, 1, 1, '2018-03-01 16:00:57', 'LIUXU', '2018-03-01 16:00:57', 'LIUXU'),
	(46, '修改连班', 'checkin', 'addition', 'save', 1, 24, 1, 1, '2018-03-01 16:01:24', 'LIUXU', '2018-03-01 16:01:24', 'LIUXU'),
	(47, '导出考勤明细', 'checkin', 'attendence', 'expdetail', 1, 34, 1, 1, '2018-03-05 11:47:07', 'LIUXU', '2018-03-05 11:47:07', 'LIUXU'),
	(48, '日报表', 'checkin', 'attendence', 'daysum', 1, 34, 1, 0, '2018-03-05 15:51:52', 'LIUXU', '2018-03-05 15:51:52', 'LIUXU'),
	(49, '集体补卡', 'checkin', 'attendence', 'checkinall', 1, 34, 1, 1, '2018-03-06 14:44:17', 'LIUXU', '2018-03-06 14:44:17', 'LIUXU'),
	(50, '集体班次设置', 'checkin', 'setsche', 'savestaffall', 1, 34, 1, 1, '2018-03-06 15:49:57', 'LIUXU', '2018-03-06 15:52:19', 'LIUXU'),
	(51, '集体连班设置', 'checkin', 'addition', 'saveall', 1, 34, 1, 1, '2018-03-06 16:28:15', 'LIUXU', '2018-03-06 16:28:28', 'LIUXU'),
	(52, '集体假期设置', 'checkin', 'holiday', 'saveall', 1, 34, 1, 1, '2018-03-06 16:45:23', 'LIUXU', '2018-03-06 16:45:23', 'LIUXU'),
	(53, '删除打卡记录', 'checkin', 'attendence', 'delcheck', 1, 34, 1, 1, '2018-03-07 12:34:23', 'LIUXU', '2018-03-07 12:34:23', 'LIUXU'),
	(54, '导出打卡记录', 'checkin', 'attendence', 'expcheckin', 1, 34, 1, 1, '2018-03-08 17:30:11', 'LIUXU', '2018-03-08 17:30:11', 'LIUXU'),
	(55, '导入员工信息', 'organization', 'staff', 'uploadstaff', 1, 14, 1, 1, '2018-03-09 14:55:13', 'LIUXU', '2018-03-09 14:55:13', 'LIUXU'),
	(56, '值班设置', 'checkin', 'duty', '', 1, 24, 1, 0, '2018-03-16 13:50:49', 'LIUXU', '2018-03-16 13:56:20', 'LIUXU'),
	(57, '获取值班详情', 'checkin', 'duty', 'one', 1, 24, 1, 1, '2018-03-16 13:51:11', 'LIUXU', '2018-03-16 13:51:11', 'LIUXU'),
	(58, '修改值班', 'checkin', 'duty', 'save', 1, 24, 1, 1, '2018-03-16 13:51:34', 'LIUXU', '2018-03-16 13:51:34', 'LIUXU'),
	(59, '存为历史数据', 'checkin', 'attendence', 'savehistory', 1, 34, 1, 1, '2018-03-28 15:13:53', 'LIUXU', '2018-03-28 15:13:53', 'LIUXU'),
	(60, '历史考勤数据', 'checkin', 'attendence', 'staffhistory', 1, 34, 1, 0, '2018-03-28 16:41:34', 'LIUXU', '2018-03-28 16:41:45', 'LIUXU'),
	(61, '历史考勤明细', 'checkin', 'attendence', 'detailhistory', 1, 34, 1, 1, '2018-03-28 16:42:10', 'LIUXU', '2018-03-28 16:42:10', 'LIUXU'),
	(62, '导出历史数据', 'checkin', 'attendence', 'exphistory', 1, 34, 1, 1, '2018-03-29 13:46:57', 'LIUXU', '2018-03-29 13:46:57', 'LIUXU'),
	(63, '导出历史详情', 'checkin', 'attendence', 'exphistorydetail', 1, 34, 1, 1, '2018-03-29 13:47:30', 'LIUXU', '2018-03-29 13:47:30', 'LIUXU'),
	(64, '考勤汇总（时间段）', 'checkin', 'attendence', 'staffdate', 1, 34, 1, 0, '2018-10-15 11:12:23', 'LIUXU', '2018-10-15 11:13:40', 'LIUXU'),
	(65, '考勤明细（时间段）', 'checkin', 'attendence', 'detaildate', 1, 34, 1, 1, '2018-10-15 11:13:20', 'LIUXU', '2018-10-15 11:13:20', 'LIUXU'),
	(66, '导出考勤汇总（时间段）', 'checkin', 'attendence', 'expdatadate', 1, 34, 1, 1, '2018-10-15 11:30:10', 'LIUXU', '2018-10-15 11:30:10', 'LIUXU'),
	(67, '导出所有明细', 'checkin', 'attendence', 'expalldetail', 1, 34, 1, 1, '2019-02-20 15:31:29', 'LIUXU', '2019-02-20 15:31:40', 'LIUXU'),
	(68, '导出明细（时间段）', 'checkin', 'attendence', 'expalldetaildate', 1, 34, 1, 1, '2019-09-25 16:22:59', 'LIUXU', '2019-09-25 16:22:59', 'LIUXU'),
	(69, '编辑员工', 'organization', 'staff', 'edit', 1, 14, 1, 1, '2020-09-24 10:56:36', 'LIUXU', '2020-09-24 10:56:36', 'LIUXU'),
	(70, '保存员工', 'organization', 'staff', 'savestaff', 1, 14, 1, 1, '2020-09-24 10:57:07', 'LIUXU', '2020-09-24 10:57:07', 'LIUXU'),
	(71, '多日班次设置', 'checkin', 'setsche', 'savedateall', 1, 24, 1, 1, '2020-09-25 17:14:54', 'LIUXU', '2020-09-25 17:14:54', 'LIUXU'),
	(72, '多日连班设置', 'checkin', 'addition', 'savedateall', 1, 24, 1, 1, '2020-09-25 17:15:29', 'LIUXU', '2020-09-25 17:15:29', 'LIUXU'),
	(73, '多日请假设置', 'checkin', 'holiday', 'savedateall', 1, 24, 1, 1, '2020-10-27 16:57:04', 'LIUXU', '2020-10-27 16:57:04', 'LIUXU'),
	(74, '导出假期', 'checkin', 'holiday', 'expholiday', 1, 24, 1, 1, '2020-10-27 16:57:43', 'LIUXU', '2020-10-27 16:57:43', 'LIUXU'),
	(75, '设置每页行数', 'privilege', 'privilege', 'pagesize', 1, 5, 1, 1, '2020-10-27 17:00:21', 'LIUXU', '2020-10-27 17:00:21', 'LIUXU');
/*!40000 ALTER TABLE `s_menu` ENABLE KEYS */;

-- 导出  表 hrs.s_position 结构
CREATE TABLE IF NOT EXISTS `s_position` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position_name` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '职务名称',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='职务表';


-- 导出  表 hrs.s_queue 结构
CREATE TABLE IF NOT EXISTS `s_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '目标：1部门2员工3全公司4machine_id',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_code` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'staff_code/machine_id',
  `date` date NOT NULL DEFAULT '2000-01-01' COMMENT '假期时间',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用，1是2finished',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  KEY `索引 1` (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=133005 DEFAULT CHARSET=latin1 COMMENT='队列表';



-- 导出  表 hrs.s_queue_staff 结构
CREATE TABLE IF NOT EXISTS `s_queue_staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_code` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'staff_code/machine_id',
  `month` varchar(24) NOT NULL DEFAULT '2000-01' COMMENT '月份',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用，1是2finished',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `索引 2` (`staff_code`,`month`,`is_enable`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=79630 DEFAULT CHARSET=latin1 COMMENT='队列拆分表';






-- 导出  表 hrs.s_staff 结构
CREATE TABLE IF NOT EXISTS `s_staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '考勤机ID',
  `staff_code` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '工号',
  `name` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别:男1女2',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '部门ID',
  `position_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '职务ID',
  `phone` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '电话号码',
  `mobile` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `birthday` date NOT NULL DEFAULT '1970-01-01' COMMENT '生日',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `in_date` date NOT NULL DEFAULT '1970-01-01' COMMENT '入职时间',
  `out_date` date NOT NULL DEFAULT '1970-01-01' COMMENT '离职时间',
  `floor` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '楼层',
  `birthday_date` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '过生日日期',
  `birthday_type` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '生日类型',
  `emergency` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '紧急联系人',
  `emergency_phone` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '紧急联系人电话',
  `identification` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '身份证号',
  `valid_date` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '有效期',
  `id_by` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '发证机关',
  `education` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '学历',
  `salary_type` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '帐套',
  `hometown` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '籍贯',
  `marrige` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '婚否',
  `box` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '工箱柜',
  `ethnicity` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '民族',
  `room` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '宿舍号',
  `contract_from` date NOT NULL DEFAULT '1970-01-01' COMMENT '合同签定日',
  `contract_to` date NOT NULL DEFAULT '1970-01-01' COMMENT '合同终止日',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=932 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='人员表';




-- 导出  表 hrs.s_staff_machine 结构
CREATE TABLE IF NOT EXISTS `s_staff_machine` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '考勤机ID',
  `machine_code` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '考勤机工号',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=1005 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='人员表';




-- 导出  表 hrs.s_staff_sche 结构
CREATE TABLE IF NOT EXISTS `s_staff_sche` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_code` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '员工工号',
  `start_date` date NOT NULL DEFAULT '2000-01-01' COMMENT '开始日期',
  `end_date` date NOT NULL DEFAULT '2000-01-01' COMMENT '结束日期',
  `start_time` time NOT NULL DEFAULT '00:00:00' COMMENT '上班时间',
  `end_time` time NOT NULL DEFAULT '00:00:00' COMMENT '下班时间',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58978 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='员工班次表';





-- 导出  表 hrs.u_check_in_out 结构
CREATE TABLE IF NOT EXISTS `u_check_in_out` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '员工考勤机id',
  `check_time` datetime DEFAULT NULL,
  `check_date` date NOT NULL DEFAULT '2017-11-16' COMMENT '考勤日',
  `sche` tinyint(3) NOT NULL DEFAULT '1' COMMENT '班次（每日第几次上下班）',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SYSTEM' COMMENT '创建人',
  PRIMARY KEY (`id`),
  KEY `check_time` (`check_time`)
) ENGINE=InnoDB AUTO_INCREMENT=510285 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='打卡表';


-- 导出  表 hrs.u_history 结构
CREATE TABLE IF NOT EXISTS `u_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `month` varchar(48) NOT NULL DEFAULT '' COMMENT '月份',
  `department` varchar(48) NOT NULL DEFAULT '' COMMENT '部门',
  `name` varchar(48) NOT NULL DEFAULT '' COMMENT '姓名',
  `staff_code` varchar(48) NOT NULL DEFAULT '' COMMENT '工号',
  `work_day` decimal(10,5) NOT NULL DEFAULT '0.00000' COMMENT '出勤天数',
  `legal_work_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '应出勤时间',
  `work_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '正班时间',
  `over_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '加班时间',
  `off_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '缺勤时间',
  `leave_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '请假时间',
  `holiday_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '放假时间',
  `error_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '旷工时间',
  `late_time` int(11) NOT NULL DEFAULT '0' COMMENT '迟到分钟数',
  `first_late` int(11) NOT NULL DEFAULT '0' COMMENT '第一次迟到',
  `other_late` int(11) NOT NULL DEFAULT '0' COMMENT '其他迟到',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`staff_code`,`month`)
) ENGINE=MyISAM AUTO_INCREMENT=4124 DEFAULT CHARSET=utf8mb4 COMMENT='历史汇总表';




-- 导出  表 hrs.u_history_detail 结构
CREATE TABLE IF NOT EXISTS `u_history_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `month` varchar(48) NOT NULL DEFAULT '' COMMENT '月份',
  `date` date NOT NULL DEFAULT '1970-01-01' COMMENT '日期',
  `department` varchar(48) NOT NULL DEFAULT '' COMMENT '部门',
  `name` varchar(48) NOT NULL DEFAULT '' COMMENT '姓名',
  `staff_code` varchar(48) NOT NULL DEFAULT '' COMMENT '工号',
  `work_day` decimal(10,5) NOT NULL DEFAULT '0.00000' COMMENT '出勤天数',
  `check_in` varchar(255) NOT NULL DEFAULT '' COMMENT '打卡记录（逗号）',
  `legal_work_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '应出勤时间',
  `work_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '正班时间',
  `over_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '加班时间',
  `off_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '缺勤时间',
  `leave_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '请假时间',
  `holiday_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '放假时间',
  `error_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '旷工时间',
  `late_time` int(11) NOT NULL DEFAULT '0' COMMENT '迟到分钟数',
  `first_late` int(11) NOT NULL DEFAULT '0' COMMENT '第一次迟到',
  `other_late` int(11) NOT NULL DEFAULT '0' COMMENT '其他迟到',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`date`,`staff_code`)
) ENGINE=MyISAM AUTO_INCREMENT=125112 DEFAULT CHARSET=utf8mb4 COMMENT='历史汇总表';




-- 导出  表 hrs.u_month_detail 结构
CREATE TABLE IF NOT EXISTS `u_month_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `month` varchar(48) NOT NULL DEFAULT '' COMMENT '月份',
  `date` date NOT NULL DEFAULT '1970-01-01' COMMENT '日期',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '部门ID',
  `department` varchar(48) NOT NULL DEFAULT '' COMMENT '部门',
  `name` varchar(48) NOT NULL DEFAULT '' COMMENT '姓名',
  `staff_code` varchar(48) NOT NULL DEFAULT '' COMMENT '工号',
  `work_day` decimal(10,5) NOT NULL DEFAULT '0.00000' COMMENT '出勤天数',
  `check_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '打卡次数',
  `check_in_ids` varchar(1000) NOT NULL DEFAULT '' COMMENT '打卡记录id（逗号）',
  `check_in` varchar(1000) NOT NULL DEFAULT '' COMMENT '打卡记录（逗号）',
  `in_time` varchar(1000) NOT NULL DEFAULT '' COMMENT '班次',
  `legal_work_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '应出勤时间',
  `work_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '正班时间',
  `over_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '加班时间',
  `off_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '缺勤时间',
  `leave_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '请假时间',
  `holiday_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '放假时间',
  `error_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '旷工时间',
  `late_time` int(11) NOT NULL DEFAULT '0' COMMENT '迟到分钟数',
  `first_late` int(11) NOT NULL DEFAULT '0' COMMENT '第一次迟到',
  `other_late` int(11) NOT NULL DEFAULT '0' COMMENT '其他迟到',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `Index 2` (`date`,`staff_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2909333 DEFAULT CHARSET=utf8mb4 COMMENT='历史汇总表';




-- 导出  表 hrs.u_month_summary 结构
CREATE TABLE IF NOT EXISTS `u_month_summary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `month` varchar(48) NOT NULL DEFAULT '' COMMENT '月份',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '部门ID',
  `department` varchar(48) NOT NULL DEFAULT '' COMMENT '部门',
  `name` varchar(48) NOT NULL DEFAULT '' COMMENT '姓名',
  `staff_code` varchar(48) NOT NULL DEFAULT '' COMMENT '工号',
  `work_day` decimal(10,5) NOT NULL DEFAULT '0.00000' COMMENT '出勤天数',
  `check_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '打卡次数',
  `legal_work_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '应出勤时间',
  `work_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '正班时间',
  `over_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '加班时间',
  `off_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '缺勤时间',
  `leave_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '请假时间',
  `holiday_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '放假时间',
  `error_time` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '旷工时间',
  `late_time` int(11) NOT NULL DEFAULT '0' COMMENT '迟到分钟数',
  `first_late` int(11) NOT NULL DEFAULT '0' COMMENT '第一次迟到',
  `other_late` int(11) NOT NULL DEFAULT '0' COMMENT '其他迟到',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `Index 2` (`staff_code`,`month`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=94769 DEFAULT CHARSET=utf8mb4 COMMENT='历史汇总表';




-- 正在导出表  hrs.u_role 的数据：~1 rows (大约)
DELETE FROM `u_role`;
/*!40000 ALTER TABLE `u_role` DISABLE KEYS */;
INSERT INTO `u_role` (`id`, `role_name`, `is_enable`, `create_time`, `create_user`, `update_time`, `update_user`) VALUES
	(1, '管理员', 1, '2017-11-05 14:41:25', 'LIUXU', '2021-08-13 14:45:16', 'LIUXU'),
	(2, '管理员', 0, '2021-08-13 14:45:34', 'LIUXU', '2021-08-13 14:51:22', 'LIUXU');
/*!40000 ALTER TABLE `u_role` ENABLE KEYS */;



-- 导出  表 hrs.u_role_privilege 结构
CREATE TABLE IF NOT EXISTS `u_role_privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色表id',
  `menu_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '菜单表id',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用，0否1是',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新人',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1852 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色权限表';

-- 正在导出表  hrs.u_role_privilege 的数据：~1,851 rows (大约)
DELETE FROM `u_role_privilege`;
/*!40000 ALTER TABLE `u_role_privilege` DISABLE KEYS */;
INSERT INTO `u_role_privilege` (`id`, `role_id`, `menu_id`, `is_enable`, `create_time`, `create_user`, `update_time`, `update_user`, `is_delete`) VALUES
	(1780, 1, 1, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1781, 1, 2, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1782, 1, 3, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1783, 1, 4, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1784, 1, 5, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1785, 1, 6, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1786, 1, 7, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1787, 1, 8, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1788, 1, 9, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1789, 1, 10, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1790, 1, 11, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1791, 1, 12, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1792, 1, 13, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1793, 1, 75, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1794, 1, 14, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1795, 1, 15, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1796, 1, 16, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1797, 1, 17, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1798, 1, 18, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1799, 1, 19, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1800, 1, 20, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1801, 1, 21, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1802, 1, 22, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1803, 1, 23, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1804, 1, 55, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1805, 1, 69, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1806, 1, 70, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1807, 1, 24, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1808, 1, 28, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1809, 1, 29, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1810, 1, 30, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1811, 1, 31, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1812, 1, 32, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1813, 1, 33, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1814, 1, 37, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1815, 1, 38, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1816, 1, 39, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1817, 1, 44, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1818, 1, 45, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1819, 1, 46, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1820, 1, 56, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1821, 1, 57, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1822, 1, 58, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1823, 1, 71, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1824, 1, 72, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1825, 1, 73, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1826, 1, 74, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1827, 1, 34, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1828, 1, 35, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1829, 1, 36, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1830, 1, 40, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1831, 1, 41, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1832, 1, 42, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1833, 1, 43, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1834, 1, 47, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1835, 1, 48, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1836, 1, 49, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1837, 1, 50, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1838, 1, 51, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1839, 1, 52, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1840, 1, 53, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1841, 1, 54, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1842, 1, 59, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1843, 1, 60, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1844, 1, 61, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1845, 1, 62, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1846, 1, 63, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1847, 1, 64, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1848, 1, 65, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1849, 1, 66, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1850, 1, 67, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0),
	(1851, 1, 68, 1, '2020-10-27 17:00:40', 'LIUXU', '2020-10-27 17:00:40', 'LIUXU', 0);
/*!40000 ALTER TABLE `u_role_privilege` ENABLE KEYS */;

-- 导出  表 hrs.u_user 结构
CREATE TABLE IF NOT EXISTS `u_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `username` varchar(48) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(128) NOT NULL DEFAULT '' COMMENT '登录密码',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_user` varchar(48) NOT NULL DEFAULT '' COMMENT '创建人',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `update_user` varchar(48) NOT NULL DEFAULT '' COMMENT '更新人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `user_name` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- 正在导出表  hrs.u_user 的数据：~0 rows (大约)
DELETE FROM `u_user`;
/*!40000 ALTER TABLE `u_user` DISABLE KEYS */;
INSERT INTO `u_user` (`id`, `user_id`, `role_id`, `username`, `password`, `create_time`, `create_user`, `update_time`, `update_user`) VALUES
	(1, 1, 1, 'LIUXU', '$2y$10$LQuTYCf5O2YRNLQzn7.YkOVBViOgDrQlerMePuOzCfKomWk6mmL5.', '2017-11-03 16:19:51', 'SYSTEM', '2017-11-11 17:28:38', 'SYSTEM');
/*!40000 ALTER TABLE `u_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
