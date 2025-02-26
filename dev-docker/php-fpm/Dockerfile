FROM webdevops/php-nginx-dev:8.2

RUN echo date.timezone = "Europe/Budapest" >> /opt/docker/etc/php/php.ini

RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource.gpg.key | apt-key add -
RUN echo "deb https://deb.nodesource.com/node_20.x focal main" > /etc/apt/sources.list.d/nodesource.list
RUN echo "deb-src https://deb.nodesource.com/node_20.x focal main" >> /etc/apt/sources.list.d/nodesource.list
RUN apt-get update

RUN apt-get install -y nodejs

RUN node -v
RUN npm -v

WORKDIR "/app"
COPY . /app

RUN chown -R application:application /app
