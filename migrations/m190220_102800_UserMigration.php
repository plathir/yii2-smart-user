<?php

use yii\db\Migration;

/**
 * Class m190210_141936_BaseMigration
 */
class m190220_102800_UserMigration extends Migration {

    public function up() {


        $this->CreateUserTable();
        $this->CreateUserProfileTable();

        $this->CreateAuthTable();
        $this->CreateAuthRuleTable();
        $this->CreateAuthItemTable();
        $this->CreateAuthItemChildTable();
        $this->CreateAuthAssingmentTable();
        $this->CreateMenuTable();
    }

    public function down() {

        $this->dropIfExist('menu');
        $this->dropIfExist('auth_assignment');
        $this->dropIfExist('auth_item_child');
        $this->dropIfExist('auth_item');
        $this->dropIfExist('auth_rule');
        $this->dropIfExist('auth');
        $this->dropIfExist('user_profile');
        $this->dropIfExist('user');
    }

    public function CreateUserTable() {
        $this->dropIfExist('user');

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'timezone' => $this->string(40)->notNull(),
            'activate_token' => $this->string(255)->notNull(),
            'status' => $this->integer(6)->defaultValue(10),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'last_visited' => $this->integer(11)->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    public function CreateUserProfileTable() {
        $this->dropIfExist('user_profile');

        $this->createTable('user_profile', [
            'id' => $this->integer(11)->notNull(),
            'first_name' => $this->string(40)->notNull(),
            'last_name' => $this->string(40)->notNull(),
            'gender' => $this->integer(6)->notNull(),
            'birth_date' => $this->date()->notNull(),
            'profile_image' => $this->string()->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'updated_by' => $this->integer(11)->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_user_id', 'user_profile', ['id']);
        //  Add foreing key
        $this->addForeignKey('fk_user_id', 'user_profile', 'id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function CreateAuthTable() {
        $this->dropIfExist('auth');

        $this->createTable('auth', [
            'id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'source' => $this->string(255)->notNull(),
            'source_id' => $this->string(255)->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_auth_user_id', 'auth', ['id']);
        $this->addForeignKey('fk_auth_user_id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function CreateAuthItemTable() {
        $this->dropIfExist('auth_item');

        $this->createTable('auth_item', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->integer(11)->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->text(),
            'created_at' => $this->integer(11)->defaultValue(NULL),
            'updated_at' => $this->integer(11)->defaultValue(NULL),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_auth_assin', 'auth_item', ['name']);

        $this->createIndex('idx_rule_name', 'auth_item', ['rule_name'], false);
        $this->createIndex('idx_type', 'auth_item', ['type'], false);
    }

    public function CreateAuthItemChildTable() {
        $this->dropIfExist('auth_item_child');

        $this->createTable('auth_item_child', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('fk_auth_item_child', 'auth_item_child', ['parent', 'child']);
        $this->addForeignKey('auth_item_child_ibfk_1', 'auth_item_child', 'parent', 'auth_item', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('auth_item_child_ibfk_2', 'auth_item_child', 'child', 'auth_item', 'name', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_child', 'auth_item_child', ['child'], false);
    }

    public function CreateAuthAssingmentTable() {
        $this->dropIfExist('auth_assignment');

        $this->createTable('auth_assignment', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('fk_auth_assin', 'auth_assignment', ['item_name', 'user_id']);
        $this->addForeignKey('auth_assignment_ibfk_1', 'auth_assignment', 'item_name', 'auth_item', 'name', 'CASCADE', 'CASCADE');
    }

    public function CreateAuthRuleTable() {
        $this->dropIfExist('auth_rule');

        $this->createTable('auth_rule', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('fk_auth_rule', 'auth_rule', ['name']);
        //$this->addForeignKey('auth_item_ibfk_1', 'auth_rule', 'name', 'auth_item', 'name', 'CASCADE', 'CASCADE');
    }

    public function CreateMenuTable() {
        $this->dropIfExist('menu');

        $this->createTable('menu', [
            'id' => $this->PrimaryKey(),
            'name' => $this->string(128)->notNull(),
            'parent' => $this->integer(11),
            'route' => $this->string(255),
            'order' => $this->integer(11),
            'data' => $this->text(),
            'app' => $this->string(50)->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_parent', 'menu', 'parent', 'menu', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_child', 'menu', ['parent'], false);
    }

    public function dropIfExist($tableName) {
        if (in_array($tableName, $this->getDb()->schema->tableNames)) {
            $this->dropTable($tableName);
        }
    }

}

//
//--
//-- Table structure for table `auth_item`
//--
//
//CREATE TABLE IF NOT EXISTS `auth_item` (
//  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
//  `type` int(11) NOT NULL,
//  `description` text CHARACTER SET latin1,
//  `rule_name` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
//  `data` text CHARACTER SET latin1,
//  `created_at` int(11) DEFAULT NULL,
//  `updated_at` int(11) DEFAULT NULL,
//  PRIMARY KEY (`name`),
//  KEY `rule_name` (`rule_name`),
//  KEY `type` (`type`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//-- --------------------------------------------------------
//
//--
//-- Table structure for table `auth_item_child`
//--
//
//CREATE TABLE IF NOT EXISTS `auth_item_child` (
//  `parent` varchar(64) CHARACTER SET latin1 NOT NULL,
//  `child` varchar(64) CHARACTER SET latin1 NOT NULL,
//  PRIMARY KEY (`parent`,`child`),
//  KEY `child` (`child`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//-- --------------------------------------------------------
//
//--
//-- Table structure for table `auth_rule`
//--
//
//CREATE TABLE IF NOT EXISTS `auth_rule` (
//  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
//  `data` text CHARACTER SET latin1,
//  `created_at` int(11) DEFAULT NULL,
//  `updated_at` int(11) DEFAULT NULL,
//  PRIMARY KEY (`name`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//-- --------------------------------------------------------
//
//--
//-- Table structure for table `menu`
//--
//
//CREATE TABLE IF NOT EXISTS `menu` (
//  `id` int(11) NOT NULL AUTO_INCREMENT,
//  `name` varchar(128) NOT NULL,
//  `parent` int(11) DEFAULT NULL,
//  `route` varchar(256) DEFAULT NULL,
//  `order` int(11) DEFAULT NULL,
//  `data` text,
//  `app` varchar(50) NOT NULL,
//  PRIMARY KEY (`id`),
//  KEY `parent` (`parent`)
//) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=157 ;
//
//-- --------------------------------------------------------
//
//--
//-- Table structure for table `user`
//--
//
//CREATE TABLE IF NOT EXISTS `user` (
//  `id` int(11) NOT NULL AUTO_INCREMENT,
//  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
//  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
//  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
//  `activate_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `status` smallint(6) NOT NULL DEFAULT '10',
//  `created_at` int(11) NOT NULL,
//  `updated_at` int(11) NOT NULL,
//  `last_visited` int(11) NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=71 ;
//
//-- --------------------------------------------------------
//
//--
//-- Table structure for table `user_profile`
//--
//
//CREATE TABLE IF NOT EXISTS `user_profile` (
//  `id` int(11) NOT NULL,
//  `first_name` varchar(40) NOT NULL,
//  `last_name` varchar(40) NOT NULL,
//  `gender` smallint(6) NOT NULL,
//  `birth_date` date NOT NULL,
//  `profile_image` tinytext NOT NULL,
//  `created_at` int(11) NOT NULL,
//  `updated_at` int(11) NOT NULL,
//  `updated_by` int(11) NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//--
//-- Constraints for dumped tables
//--
//
//--
//-- Constraints for table `auth`
//--
//ALTER TABLE `auth`
//  ADD CONSTRAINT `fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
//
//--
//-- Constraints for table `auth_assignment`
//--
//ALTER TABLE `auth_assignment`
//  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
//
//--
//-- Constraints for table `auth_item`
//--
//ALTER TABLE `auth_item`
//  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;
//
//--
//-- Constraints for table `auth_item_child`
//--
//ALTER TABLE `auth_item_child`
//  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
//  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
//
//--
//-- Constraints for table `menu`
//--
//ALTER TABLE `menu`
//  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
//
///*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
///*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
///*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;