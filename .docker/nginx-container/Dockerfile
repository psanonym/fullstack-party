FROM nginx:alpine
MAINTAINER PS ANONYM

RUN apk update
RUN apk add vim

### Change Timezone
RUN apk add tzdata
RUN cp /usr/share/zoneinfo/Europe/Vilnius /etc/localtime
RUN echo "Europe/Vilnius" > /etc/timezone

### nginx Configuration
RUN mkdir /etc/nginx/sites-enabled /etc/nginx/global
COPY configs/nginx.conf /etc/nginx/nginx.conf
COPY configs/global-rewrites.conf /etc/nginx/global/rewrites.conf
COPY sites/* /etc/nginx/sites-enabled/

### nginx ssl configuration
RUN mkdir -p /etc/nginx/ssl/{private,certs}
RUN apk add openssl
COPY keys/nginx-private.key /etc/nginx/ssl/private/nginx-private.key
COPY keys/nginx-selfsigned.crt /etc/nginx/ssl/certs/nginx-selfsigned.crt