# HTHS Website

**Live: [http://www.hths.mcvsd.org/](http://www.hths.mcvsd.org/)**

#Setup Instructions
Start by cloning the repository:

        git clone https://github.com/hthswebteam/HTHS-Website.git

Then follow one of the following instructions depending if you are deploying for development or for production.

Note: There is an extra step involving database setup before the site will run normally. This is partially implemented in a migration controller, but is not yet tested or documented.

## Development
1. In `/application/config/`, rename `database.sample.php` to `database.php` and add your database credentials:

		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'username_here';
		$db['default']['password'] = 'password_here';
		$db['default']['database'] = 'database_name_here';

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