<?php if (!defined('BASEPATH')) {exit("No direct script access allowed");}

class Migration_Initialize extends CI_Migration {
    
    public function up() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `admin` (`id` int(11) NOT NULL AUTO_INCREMENT, `hash` text NOT NULL, `salt` text NOT NULL, `username` text NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=6;");
        $this->db->query(<<<'EOD'
INSERT INTO `admin` (`id`, `hash`, `salt`, `username`) VALUES
(2, 'd7ba8addfb1c95e2699fdc85e83fe72e', 'NV6PLm3VIYDKIubV', 'DSimon'),
(4, '4b98ef320f20adaa8f4afbd738ca01dd', 'xpUq3hvO9wkCoxlo', 'JMooneyham'),
(5, '1c8f85fa9c2aa3d024f3ea641596dfd8', '3VTaiIKIViT7dGWD', 'ZLiu');
EOD
        );
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `captcha` (  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,  `captcha_time` int(10) unsigned NOT NULL,  `ip_address` varchar(16) NOT NULL DEFAULT '0',  `word` varchar(20) NOT NULL,  PRIMARY KEY (`captcha_id`),  KEY `word` (`word`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `email_flood` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `ip_address` text NOT NULL,  `time` int(11) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `email_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `target_teacher_id` int(11) NOT NULL,  `email_address` text NOT NULL,  `ip_address` text NOT NULL,  `subject` text NOT NULL,  `contents` text NOT NULL,  `time` int(11) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `forms` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` text NOT NULL,  `filename` text NOT NULL,  `time` int(11) NOT NULL,  `archived` tinyint(1) NOT NULL,  `type` int(11) NOT NULL,  `download_count` int(11) NOT NULL,  `filesize` int(11) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `form_types` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `type` text NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `mentorship_logs` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL,  `date` int(11) NOT NULL,  `in_time` text NOT NULL,  `out_time` text NOT NULL,  `activities` text NOT NULL,  `comments` text NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `mentorship_schedule_dates` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `date` int(11) NOT NULL,  `time` text NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `mentorship_settings` (  `setting_name` text NOT NULL,  `setting_value` text NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
        $this->db->query(<<<'EOD'
INSERT INTO `mentorship_settings` (`setting_name`, `setting_value`) VALUES
('year', '2012'),
('semester', '2'),
('schedule_open', '1');
EOD
        );
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `mentorship_users` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` text NOT NULL,  `username` text NOT NULL,  `email` text NOT NULL,  `hash` text NOT NULL,  `salt` text NOT NULL,  `firm` text NOT NULL,  `mentor` text NOT NULL,  `tags` text NOT NULL,  `site_visit` text NOT NULL,  `schedule_date` int(11) NOT NULL,  `semester` tinyint(1) NOT NULL,  `year` int(4) NOT NULL,  `private_key` int(11) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `news` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `title` text NOT NULL,  `contents` text NOT NULL,  `start` int(11) NOT NULL,  `expires` int(11) NOT NULL,  `urgent` tinyint(1) NOT NULL DEFAULT '0',  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `pages` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `last_updated` int(11) NOT NULL,  `url` text NOT NULL,  `title` text NOT NULL,  `contents` text NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `parent_emails` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `email_address` text NOT NULL,  `ip_address` text NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `sessions` (  `session_id` varchar(40) NOT NULL DEFAULT '0',  `ip_address` varchar(16) NOT NULL DEFAULT '0',  `user_agent` varchar(120) NOT NULL,  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',  `user_data` text NOT NULL,  PRIMARY KEY (`session_id`),  KEY `last_activity_idx` (`last_activity`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `site_settings` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `setting_name` text NOT NULL,  `setting_type` text NOT NULL,  `setting_description` text NOT NULL,  `setting_value` text NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;");
        $this->db->query(<<<'EOD'
INSERT INTO `site_settings` (`id`, `setting_name`, `setting_type`, `setting_description`, `setting_value`) VALUES
(1, 'online', 'boolean', 'Sets whether the site is visible to the public. ', '1'),
(2, 'offline_message', 'input', 'Create an offline message to display to visitors when the site is set to offline. ', 'We''re working on setting up the new site right now! Please check back shortly.'),
(3, 'menu', 'text', 'A serialized PHP array containing the main menu of the site. ', '[[{"title":"Home","url":""}],[{"title":"About","url":"#"},{"title":"Overview","url":"pages/overview"},{"title":"MCVSD Links","url":"pages/mcvsd-links"},{"title":"HTHS Mission Statement","url":"pages/hths_mission_statement"},{"title":"HTHS History","url":"pages/hths_history"},{"title":"Facility","url":"pages/facility"},{"title":"Accreditation","url":"pages/accreditation"},{"title":"Awards","url":"pages/awards"}],[{"title":"Academics","url":"#"},{"title":"Curriculum","url":"pages/curriculum"},{"title":"Faculty Directory","url":"teachers"},{"title":"Mentorship","url":"pages/mentorship"}],[{"title":"Clubs","url":"pages/clubs"}],[{"title":"Guidance","url":"#"},{"title":"Guidance Blog","url":"http://www.mcvsd.org/weblog/lgueren/"},{"title":"Guidance Forms","url":"downloads#category_guidance"},{"title":"Career Information","url":"pages/career_information"},{"title":"College Information","url":"pages/college_information"},{"title":"Personality/Interest Tests","url":"pages/personality_tests"},{"title":"SAT/ACT Prep Information","url":"pages/test_prep"},{"title":"Naviance","url":"https://connection.naviance.com/fc/signin.php?hsid=hightechhs"}],[{"title":"PFA","url":"#"},{"title":"PFA Mission Statement","url":"pages/pfa/mission_statement"},{"title":"PFA History","url":"pages/pfa/history"},{"title":"PFA Committees","url":"pages/pfa/committees"},{"title":"PFA Scholarship Awards","url":"pages/pfa/scholarship_awards"},{"title":"PFA Newsletters","url":"downloads#category_pfa_newsletters"}],[{"title":"Downloads","url":"downloads"}],[{"title":"Resources","url":"#"},{"title":"FirstClass Email","url":"https://hths.mcvsd.org/"},{"title":"Random Group Generator","url":"home/groups"}]]'),
(4, 'version', 'int', 'Current verison of the site, used in fetchiung updates.', '1.4'),
(5, 'portals', 'text', 'A serialized PHP array containing the portals list on the front page of the site. ', '[[{"title":"Prospective Students","url":"http://www.hths.mcvsd.org/pages/prospective"},{"title":"Summer Programs","url":"http://www.hths.mcvsd.org/pages/summer_programs"},{"title":"Alumni","url":"http://hthsalumni.org/"},{"title":"PFA Newsletter","url":"http://www.hths.mcvsd.org/downloads_files/PFA_Newsletter_Apr_May_2012_web.pdf"}]]');
EOD
        );
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `teacher` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `first_name` text NOT NULL,  `last_name` text NOT NULL,  `prefix` text NOT NULL,  `suffix` text NOT NULL,  `email` text NOT NULL,  `hash` text NOT NULL,  `salt` text NOT NULL,  `username` text NOT NULL,  `subject` text NOT NULL,  `voicemail` text NOT NULL,  `mentorship_admin` tinyint(1) NOT NULL DEFAULT '0',  `description` text NOT NULL,  `blog` text NOT NULL,  `email_display_allowed` tinyint(1) NOT NULL DEFAULT '1',  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `teacher_pages` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `teacher_id` int(11) NOT NULL,  `page_url` text NOT NULL,  `page_title` text NOT NULL,  `page_contents` text NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
    }
    
    public function down() {
        $this->load->dbforge();
        $drop = array('admin', 'captcha', 'email_flood', 'email_log', 'forms', 'form_types', 'mentorship_logs', 'mentorship_schedule_dates', 'mentorship_settings', 'mentorship_users', 'news', 'pages', 'parent_emails', 'sessions', 'site_settings', 'teacher', 'teacher_pages');
        foreach ($drop as $table) {
            $this->dbforge->drop_table($table);
        }
    }
    
}
