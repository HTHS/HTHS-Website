# HTHS Website

**Live: [http://www.hths.mcvsd.org/](http://www.hths.mcvsd.org/)**

#Setup Instructions
Start by cloning the repository:

    git clone https://github.com/hthswebteam/HTHS-Website.git

Then create a new, empty MySQL database. Run the following SQL code to set up the sessions table:

	CREATE TABLE IF NOT EXISTS  `sessions` (
		session_id varchar(40) DEFAULT '0' NOT NULL,
		ip_address varchar(45) DEFAULT '0' NOT NULL,
		user_agent varchar(120) NOT NULL,
		last_activity int(10) unsigned DEFAULT 0 NOT NULL,
		user_data text NOT NULL,
		PRIMARY KEY (session_id),
		KEY `last_activity_idx` (`last_activity`)
	);

Then follow one of the following instructions depending if you are deploying for development or for production.

_Note: The final step, setting up the database, does not currently work while in production mode due to security concerns. For now, first follow the development mode setup and then proceed with the production mode setup._

## Development
1. In `/application/config/`, rename `database.sample.php` to `database.php` and add your database credentials:

		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'username_here';
		$db['default']['password'] = 'password_here';
		$db['default']['database'] = 'database_name_here';
2. Navigate to `http://localhost/HTHS-Website/migration/` to finish setting up the database.

## Production
1. In `/index.php` on line 21 change this:

        define('ENVIRONMENT', 'development');
 to this:

        define('ENVIRONMENT', 'production');
2. In `/application/config/production`, rename `database.sample.php` to `database.php` and add your database credentials:

		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'username_here';
		$db['default']['password'] = 'password_here';
		$db['default']['database'] = 'database_name_here';
3. Again in `/application/config/production`, rename `config.sample.php` to `config.php` and add an [encryption key](http://ellislab.com/codeigniter/user-guide/libraries/encryption.html) on line 237:

        $config['encryption_key'] = 'encryption_key_here';
4. Navigate to `http://localhost/HTHS-Website/migration/` to finish setting up the database. _(does not currently work in production mode, so do this in development mode)_