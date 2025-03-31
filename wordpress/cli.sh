COPY --from=wordpress:cli-2.11.0-php8.3 /usr/local/bin/wp /usr/local/bin/wp

RUN wp core install \
  --path=/var/www/html \
  --url=${WORDPRESS_URL} \
  --title=${WORDPRESS_TITLE} \
  --admin_user=${WORDPRESS_ADMIN_USER} \
  --admin_password=${WORDPRESS_ADMIN_PASSWORD} \
  --admin_email=${WORDPRESS_ADMIN_EMAIL} \
  --skip-email \
  --skip-packages \
  --skip-plugins \
  --skip-themes
