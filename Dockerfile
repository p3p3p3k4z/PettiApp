# Cargar una imagen de Ubuntu
FROM ubuntu:24.10

ENV DEBIAN_FRONTEND=noninteractive

# Descarga de paquetes
RUN apt-get update && \
    apt-get install -y \
    curl gnupg ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Descarga de Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_23.x | bash

# Instalación de Node.js y otras utilidades
RUN apt-get update && \
    apt-get install -y \
    nodejs nano neofetch tree aptitude nala git vim openssh-server \
    && rm -rf /var/lib/apt/lists/*

# Revisión de la versión de Node.js
RUN node --version && npm --version

# Permite que al editar el código, se transpile y cargue automáticamente
RUN npm install -g nodemon

# Establece el shell por defecto
CMD ["bash"]
