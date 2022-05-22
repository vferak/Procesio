#!/bin/sh

mkdir database
sudo docker-compose build
docker-compose up -d
docker-compose exec backend composer procesio-build
docker-compose run frontend npm run procesio-build
docker-compose down
docker-compose up
