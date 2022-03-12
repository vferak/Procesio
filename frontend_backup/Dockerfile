FROM node:14-alpine

WORKDIR /var/www

COPY ./frontend/package*.json ./

RUN apk add --no-cache --virtual .gyp \
        python2 \
        make \
        g++ \
    && npm install \
    && apk del .gyp

EXPOSE 8080

CMD ["npm", "run", "serve"]
