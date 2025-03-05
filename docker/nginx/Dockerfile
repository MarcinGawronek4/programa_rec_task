# Configure and start Nginx
FROM nginx
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
ADD ./docker/nginx/conf.d/server.conf /etc/nginx/conf.d/default.conf

RUN apt-get update -y && apt-get install apt-file -y && apt-file update && apt-get install vim -y

#ADD ./cashlib /var/www/html