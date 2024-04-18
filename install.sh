# PHP related
composer install
cp .env.example .env
php artisan key:generate

# Python related
python3 -m venv .venv
source .venv/bin/activate
pip3 install -r requirements.txt
