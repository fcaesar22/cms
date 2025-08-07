-- Seed menus
INSERT INTO `menus` (`id`, `name`, `url`, `icon`, `parent_id`, `sort_order`) VALUES
(1, 'Dashboard', 'dashboard', 'zmdi zmdi-home', NULL, 1),
(2, 'Management Users', '', 'zmdi zmdi-accounts', NULL, 2),
(3, 'Users', 'users', '', 2, 1),
(4, 'Roles', 'roles', '', 2, 2),
(5, 'Permissions', 'permissions', '', 2, 3),
(6, 'Manage Sidebar', 'menus', '', 2, 4);
