FROM ubuntu:16.04

MAINTAINER Julien Tant <julien@craftyx.fr>

RUN apt-get update \
    && apt-get install --no-install-recommends -y software-properties-common locales supervisor \
    && apt-get update \
    && locale-gen en_US.UTF-8

ENV LANG=en_US.UTF-8
ENV LANGUAGE=en_US:en
ENV LC_ALL=en_US.UTF-8

ARG DOMAIN1

RUN add-apt-repository ppa:nginx/stable \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install --no-install-recommends -y \
        nginx \
        git \
        unzip \
        php7.3-fpm \
        php7.3-cli \
        php7.3-xdebug \
        php7.3-pdo \
        php7.3-pdo-mysql \
        php7.3-sqlite3 \
        php7.3-xml \
        php7.3-mbstring \
        php7.3-tokenizer \
        php7.3-zip \
        php7.3-gd \
        php7.3-curl \
        curl \
    && mkdir /run/php \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    #&& curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    #&& tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    #&& mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    #&& printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > /etc/php/7.1/mods-available/blackfire.ini \
    #&& phpenmod blackfire \
    && apt-get remove -y --purge software-properties-common curl \
    && apt-get clean \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY default /etc/nginx/sites-enabled/default
COPY php.ini /etc/php/7.3/fpm/php.ini
COPY php-fpm.conf /etc/php/7.3/fpm/php-fpm.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY laravel.ini /etc/php/7.3/fpm/conf.d/laravel.ini
#COPY disabled-xdebug.ini /etc/php/7.1/mods-available/xdebug.ini
COPY enabled-xdebug.ini /etc/php/7.3/mods-available/xdebug.ini

RUN /etc/init.d/php7.3-fpm restart

RUN mkdir /tmp/certgen
WORKDIR /tmp/certgen
######################
# Become a Certificate Authority
######################

# Generate private key
RUN openssl genrsa -des3 -passout pass:x -out myCA.key 2048
# Generate root certificate
RUN openssl req -x509 -passin pass:x -new -nodes -key myCA.key -sha256 -days 825 -out myCA.pem -subj "/CN=$DOMAIN1"

######################
# Create CA-signed certs
######################
# Use your own domain name
#ARG NAME=$DOMAIN1
# Generate a private key
RUN openssl genrsa -passout pass:x -out $DOMAIN1.key 2048
# Create a certificate-signing request
RUN openssl req -new -key $DOMAIN1.key -out $DOMAIN1.csr -subj "/CN=$DOMAIN1"
# Create a config file for the extensions
RUN echo 'authorityKeyIdentifier=keyid,issuer\n\
basicConstraints=CA:FALSE\n\
keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment\n\
subjectAltName = @alt_names\n\
[alt_names]\n\
DNS.1 = '"$DOMAIN1"' # Be sure to include the domain name here because Common Name is not so commonly honoured by itself\n\
#DNS.2 = bar.'"$DOMAIN1"' # Optionally, add additional domains (Ive added a subdomain here)\n\
IP.1 = 192.168.1.1 # Optionally, add an IP address (if the connection which you have planned requires it)\n'\
>> $DOMAIN1.ext

# Create the signed certificate
RUN openssl x509 -req -passin pass:x -in $DOMAIN1.csr -CA myCA.pem -CAkey myCA.key -CAcreateserial -out $DOMAIN1.crt -days 825 -sha256 -extfile $DOMAIN1.ext \
&& cp $DOMAIN1.crt /etc/ssl/certs/server.crt \
&& cp $DOMAIN1.key /etc/ssl/private/server.key

#RUN openssl genrsa -des3 -passout pass:x -out server.pass.key 2048 \
#    && openssl rsa -passin pass:x -in server.pass.key -out server.key \
#    && openssl req -new -nodes -key server.key -sha256 -days 1024 -out rootSSL.pem -subj "/CN=site1.local" \
    #&& rm server.pass.key \
#    && openssl req -new -key server.key -out server.csr -subj "/CN=site1.local" \
#    && openssl x509 -req -days 365 -in server.csr -signkey server.key -out server.crt \
#    && cp server.crt /etc/ssl/certs/ \
#    && cp server.key /etc/ssl/private/
    #&& rm -rf /tmp/certgen

EXPOSE 80
EXPOSE 443

WORKDIR /var/www/html

CMD ["supervisord"]
