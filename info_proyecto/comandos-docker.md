# Docker

### construir este docker 
docker-compose up --build

### Ver servicio
docker ps
docker ps -a

### Eliminar un docker
docker rm ID

### Detener un docker 
docker stop ID

### Destruir el docker
docker compose down

### Levantar docker
docker compose up				
docker-compose up -d

### Ejecutar comandos desde el contenedor
docker exec -it ID
docker exec -it f30ae8f22bdd bash
bash --basic shell

### Quitar super usuario
##### opcion1
sudo chown -R USER:USER *

##### opcion2
sudo groupadd docker
sudo usermod -aG docker $USER
newgrp docker

---
# SQL

### Entrar a sql
docker exec -it mysql-secure mysql -u root

### Crear usuario
CREATE USER 'pepe_pecas'@'%' IDENTIFIED BY 'adminroot';
GRANT ALL PRIVILEGES ON *.* TO 'pepe_pecas'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

---

# vim
:w guardar
:q salir
/ buscar
