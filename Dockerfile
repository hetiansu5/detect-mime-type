FROM tinson/debian8.4-nginx-php7.3

COPY . /var/www/application
RUN touch /tmp/stdout && service nginx start && service php-fpm start
CMD sh -c "tail -f /tmp/stdout"
