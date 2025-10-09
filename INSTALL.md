# Installation Guide — LiveEvents API

Welcome to the installation guide for **LiveEvents**, a Symfony-based API for managing festivals, tracking ticket sales, and analyzing performance.  
This guide will walk you through the setup process step by step.  

---

## Prerequisites

- PHP **8.2+**
- Composer → [https://getcomposer.org/download/](https://getcomposer.org/download/)
- Symfony CLI → [https://symfony.com/download](https://symfony.com/download)
- Git → [https://learn.microsoft.com/en-us/devops/develop/git/install-and-set-up-git](https://learn.microsoft.com/en-us/devops/develop/git/install-and-set-up-git)
- MySQL (via WAMP, MAMP, or Docker)

---

Check your PHP version:

php -v

## Installation Steps

### 1️⃣ Clone the repository

git clone [https://github.com/arndelp/LiveEvents.git](https://github.com/arndelp/LiveEvents.git)
cd LiveEvents

### 2️⃣ Install dependencies

composer install

### 3️⃣ Configure the environment

DATABASE_URL="mysql://username:password@127.0.0.1:3306/LiveEvents"

🟨 Note: If you’re using WAMP or MAMP, make sure MySQL is running before continuing.

### 4️⃣ Setup the database

symfony console doctrine:database:create
symfony console doctrine:migrations:migrate

🟨 (Optional) Load some sample data:

symfony console doctrine:fixtures:load

### 5️⃣ Generate JWT keys

🟨 Enable the following PHP extensions in your php.ini file:
    sodium
    openssl

mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

🟨 Note: Choose a secure passphrase when prompted.

Add the following line to your .env file:
    JWT_PASSPHRASE=your_passphrase

### 6️⃣ Set up the Mailer (Brevo)

Create an account on [Brevo](https://www.brevo.com/)

Then configure your mailer DSN in the .env file:

MAILER_DSN=smtp://user:password@smtp-relay.brevo.com:587

### 7️⃣ Run the local server

symfony serve --no-tls

Access the API at:  
[http://127.0.0.1:8000](http://127.0.0.1:8000)
