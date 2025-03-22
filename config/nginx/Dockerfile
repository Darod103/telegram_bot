FROM nginx:latest


RUN apt-get update && \
    apt-get install -y certbot python3-certbot-nginx && \
    apt-get clean

COPY ./config/nginx/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www

CMD ["nginx", "-g", "daemon off;"]