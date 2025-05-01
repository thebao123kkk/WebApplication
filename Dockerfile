FROM php:8.2-apache

# Cài mysqli và các phần mở rộng cần thiết
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy code
COPY public/ /var/www/html/

# Cấp quyền cho Apache
RUN chown -R www-data:www-data /var/www/html

# Mở cổng 80
EXPOSE 80
