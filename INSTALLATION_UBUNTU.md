# Security Guard App - Ubuntu Installation Manual

This guide outlines the step-by-step process to deploy the Security Guard web application on a fresh Ubuntu local server or machine.

## Prerequisites
- Ubuntu OS (22.04 LTS or 24.04 LTS recommended)
- Terminal/SSH access with `sudo` privileges
- Internet connection (for downloading dependencies)

---

## Step 1: Update System Packages
Start by updating your Ubuntu package lists to ensure you install the latest software versions.
```bash
sudo apt update && sudo apt upgrade -y
```

## Step 2: Install PHP and Extensions
Laravel 12 requires PHP 8.2 or higher. We will install PHP 8.4 along with the necessary extensions.
```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.4-cli php8.4-fpm php8.4-pgsql php8.4-mysql php8.4-zip php8.4-gd php8.4-mbstring php8.4-curl php8.4-xml php8.4-bcmath
```

## Step 3: Install Composer (PHP Package Manager)
Composer is required to install Laravel's core dependencies.
```bash
sudo apt install -y unzip curl
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php
```

## Step 4: Install Node.js and NPM
Node.js is used to compile the frontend assets (Tailwind CSS and Vite).
```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

## Step 5: Install and Configure PostgreSQL
Install the PostgreSQL database server:
```bash
sudo apt install -y postgresql postgresql-contrib
```
Log in to the PostgreSQL prompt and create your database and user:
```bash
sudo -u postgres psql
```
Once inside the `postgres=#` prompt, run the following commands (change the password to something secure):
```sql
CREATE DATABASE security_db;
CREATE USER security_user WITH ENCRYPTED PASSWORD 'secure_password';
GRANT ALL PRIVILEGES ON DATABASE security_db TO security_user;
\q
```

## Step 6: Copy application to your server
If you haven't already, transfer your `security-guard-app` folder to your desired directory (e.g., `/var/www/` or your home folder). Navigate to it:
```bash
cd /path/to/your/folder
```

## Step 7: Install Project Dependencies
Run the following commands inside your application's root directory:
```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install JavaScript/CSS dependencies
npm install
```

## Step 8: Environment Configuration
Copy the default environment file and generate a new application key.
```bash
cp .env.example .env
php artisan key:generate
```
Open `.env` using a text editor (like `nano .env`) and configure the settings. Ensure the timezone and database are correct:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-server-ip-address

APP_TIMEZONE=Asia/Manila

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=security_db
DB_USERNAME=security_user
DB_PASSWORD=secure_password
```

## Step 9: Database Migration & Seeding
Run the migrations to build your database tables and insert initial master data.
```bash
# Run the migrations and seed dummy data
php artisan migrate:fresh --seed --force
```

## Step 10: Build Frontend Assets
Compile the Tailwind CSS and Vue/React files for production using Vite.
```bash
npm run build
```


## Step 11: Link Storage (For Uploaded Icons & Backgrounds)
Laravel requires a symbolic link to allow public access to uploaded files (like your Facility Hub icons and backgrounds).
```bash
php artisan storage:link
```

## Step 12: File Permissions
Laravel needs permission to read and write to the `storage` and `bootstrap/cache` directories.
```bash
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Step 13: Serving the Application (Local Network)
If you just want to run this quickly on your internal network without configuring a full Nginx web server:
```bash
# Binds the app to your machine's IP, allowing other PCs on the network to access it
php artisan serve --host=0.0.0.0 --port=8000
```
*Note: Other PCs can now access the app by going to `http://<your-ubuntu-ip>:8000` in their browsers.*

---

### (Optional) Step 14: Production Setup with Nginx
For a permanent background server, install Nginx:
```bash
sudo apt install -y nginx
```
Create a new configuration block for the app:
```bash
sudo nano /etc/nginx/sites-available/security-app
```
Add the following configuration (replace paths/domain as needed):
```nginx
server {
    listen 80;
    server_name your_domain_or_IP;
    root /path/to/your/security-guard-app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
Enable the site and reload Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/security-app /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```
Now the app will continuously load on standard HTTP port 80 on this server.
