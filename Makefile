up:     ; docker compose up -d --build
down:   ; docker compose down
logs:   ; docker compose logs -f app
test:   ; docker compose exec app sh -c "composer install --quiet && vendor/bin/phpunit"
