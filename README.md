# PettiApp
Esta es una aplicacion web dedicada a administrar la lista de insumos para la cafeteria Petirrojo. En donde los trabajadores podran enlistas los insumos faltantes, consultar los insumos actuales, checar los detalles de los insumos.
Asi mismo este es un proyecto para las materias de Ing.Software/ProgramacionWeb.


#### Docker
Realizar esta serie de pasos para poder ejecutar el contenedor
1.  Descarga docker
Recomiendo checar la documentacion dada por OpenSuse, ya que asi evitamos posibles errores, solo es seguir la serie de comandos dados. Sustituir el zypper por apt.
<https://en.opensuse.org/Docker>

2. Crear el contenedor
Para construir la imagen desde cero
```bash
docker-compose up --build -d
```

Para borrar todo lo creado en el contenedor
```bash
docker-compose down -v
```

En caso de hacer modificaciones al proyecto, debes ejecutar estos comandos. Porque asi reiniciamos el contenedor.

Si llegas a presentar errores a la hora de construir el docker muy probablemente tengas conflictos con tus imagenes.

checa que no se este ejecutando ningun servicio de docker
```bash
docker ps
```

en caso de que si deten los servicion y borralos
```
docker stop ID
docker rm ID
```

ahora tienes que ver todas las imagenes que haz creado. Ya que proablemente tenga conflicto con alguna de ellas. Si detectas donde esta la image del problema solo borra esa, sino borra todo lo de la lista
```
docker images
docker rmi -f ID
```
