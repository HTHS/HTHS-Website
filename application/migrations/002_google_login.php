<?php if (!defined('BASEPATH')) {exit("No direct script access allowed");}

class Migration_Google_login extends CI_Migration {

    public function up() {
        $query1 = 'CREATE TABLE `google_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `gid` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;';

        $query2 = 'CREATE TABLE `google_users_privileges` (
  `id` int(11) NOT NULL,
  `privilege` varchar(16) NOT NULL,
  UNIQUE KEY `id` (`id`,`privilege`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;';

        $this->db->query($query1);
        $this->db->query($query2);
    }

    public function down() {
        $this->dbforge->drop_table('google_users');
        $this->dbforge->drop_table('google_users_privileges');
    }

}