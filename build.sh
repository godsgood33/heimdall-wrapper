#!/bin/sh

docker build -t heimdall-wrapper .
docker run -d --name heimdall-wrapper $CONTAINER_PORT:80 heimdall-wrapper