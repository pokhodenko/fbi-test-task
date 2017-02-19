To run project please clone this repo and run several commands in project root
- composer install
- ./bin/console doctrine:database:create
- ./bin/console doctrine:schema:update --force
- ./bin/console server:start
 
 
Then go to browser and login via any facebook account. 
After login user gets default ROLE_USER.
I have created console command for adding permissions to existing users:
 - ./bin/console user:grant "firstName lastName" worker
 
First argument is username second argument is role name.
