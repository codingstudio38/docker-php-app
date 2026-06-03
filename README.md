docker php application

docker important commands
--------------------------
Pull new images->docker pull node

To run image and open command prom->docker run -it  --name [container_name]  [image_name] /bin/bash

check image list->docker image list

for pushing the image to docker hub->docker build -t [image_name] .

for managing image version->docker build -t [image_name]:[version] .

for run version manage image ->docker run  --name [my_container_name] -p 5000:5000 [image_name]:[version] / docker run –d  --name [my_container_name] -p 5000:5000 [image_name]:[version](for background running)

for running the container ->docker run -p 5000:5000 [image_name] .

List containers->docker ps, docker ps –a(all containers)

Delete image->docker image rm [image_name], docker image rm [image_name] –f

Stop container->docker stop [my_container_id]

Delete container->docker rm [my_container_id]

Delete all images->docker system prune –a

For run volume image to auto update files on ducker when you change local file
-> docker run --name node-app-test -p 5000:5000 --rm -v C:\vidyut\NodeJs\docker:/var/www/html/node-app -w /var/www/html/node-app my-node-app:v1 npm run start
To run compose.yaml file->docker compose up

FOR FILE PUSH PULL ON DOCKER HUB
---------------------------------

First tag the image for push->docker tag my-node-app:v1 onlinemessages0002/dockernodeapp:v1
Push the tagged image->docker push onlinemessages0002/dockernodeapp:v1
For pull->docker pull onlinemessages0002/dockernodeapp:v1

For open command prom in docker desktop->docker exec -it [container_name] sh (OR) Works with the running container name/id:  docker exec -it 8df5f33858c7 sh



FOR PHP 
-------
For run php application and push local files to docker->docker run –rm --name my-php-app -p 80:80  [localfolder_path]:[docker_work_directory] [image_name]:[image_tage]
docker run --rm --name my-php-app -p 80:80 -v C:\xampp\htdocs\docker-php-app:/var/www/html/php-app php-app:v1

To open mysql -> mysql -u root -p



