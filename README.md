Clone the repository with git clone
Back-end
Go to the sub-folder cd api
Copy .env.example file to .env and edit database credentials there
Add correct value of your domain for front URL in this variable: FRONTPAGE_VERIFY_URL=[your_domain]/verify/
Run composer install
Run php artisan key:generate
Run php artisan migrate --seed (it has some seeded data for your testing)
Run php artisan passport:install
Front-end

Go to the sub-folder cd front
Copy .env.local.example to .env.local and edit URL of your API
Run npm install
Run npm run serve
That's it: launch the URL that appears in the terminal - could be http://localhost:8080


Creds
Email: admin@admin.com
Password: "password"

install node version
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
nvm -v
nvm ls-remote
nvm install node
nvm install v16.20.2 
nvm ls
nvm use v16.20.2 

