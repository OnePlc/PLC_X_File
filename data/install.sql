--
-- Base Table
--
CREATE TABLE `file` (
  `File_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `file`
  ADD PRIMARY KEY (`File_ID`);

ALTER TABLE `file`
  MODIFY `File_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\File\\Controller\\FileController', 'Add', '', '', 0),
('edit', 'OnePlace\\File\\Controller\\FileController', 'Edit', '', '', 0),
('index', 'OnePlace\\File\\Controller\\FileController', 'Index', 'Files', '/file', 1),
('list', 'OnePlace\\File\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\File\\Controller\\FileController', 'View', '', '', 0),
('dump', 'OnePlace\\File\\Controller\\ExportController', 'Excel Dump', '', '', 0),
('index', 'OnePlace\\File\\Controller\\SearchController', 'Search', '', '', 0);
('save', 'OnePlace\\File\\Controller\\SearchController', 'Save Search', '', '', 0, 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('file-single', 'File', 'OnePlace\\File\\Model\\File', 'OnePlace\\File\\Model\\FileTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('file-index', 'file-single', 'File Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('file-base', 'file-single', 'File', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save File', 'fas fa-save', 'Save File', '#', 'primary saveForm', '', 'file-single', 'link', '', ''),
(NULL, 'Edit File', 'fas fa-edit', 'Edit File', '/file/edit/##ID##', 'primary', '', 'file-view', 'link', '', ''),
(NULL, 'Add File', 'fas fa-plus', 'Add File', '/file/add', 'primary', '', 'file-index', 'link', '', ''),
(NULL, 'Export Files', 'fas fa-file-excel', 'Export Files', '/file/export', 'primary', '', 'file-index', 'link', '', ''),
(NULL, 'Find Files', 'fas fa-search', 'Find Files', '/file/search', 'primary', '', 'file-index', 'link', '', ''),
(NULL, 'Export Files', 'fas fa-file-excel', 'Export Files', '#', 'primary initExcelDump', '', 'file-search', 'link', '', ''),
(NULL, 'New Search', 'fas fa-search', 'New Search', '/file/search', 'primary', '', 'file-search', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'file-base', 'file-single', 'col-md-3', '/file/view/##ID##', '', 0, 1, 0, '', '', '');

--
-- User XP Activity
--
INSERT INTO `user_xp_activity` (`Activity_ID`, `xp_key`, `label`, `xp_base`) VALUES
(NULL, 'file-add', 'Add New File', '50'),
(NULL, 'file-edit', 'Edit File', '5'),
(NULL, 'file-export', 'Edit File', '5');

COMMIT;