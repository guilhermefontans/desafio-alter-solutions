FROM php:7.4-cli

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
CMD tail -f /dev/null