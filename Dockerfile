FROM alpine:latest
LABEL MAINTAINER="https://github.com/sosuke-d-mahi/mphisher"
WORKDIR /mphisher/
ADD . /mphisher
RUN apk add --no-cache bash ncurses curl unzip wget php 
CMD "./mphisher.sh"

