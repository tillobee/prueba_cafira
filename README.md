El proyecto esta desarrollado en la version 12 de Laravel la cual corresponde a la más reciente del framework.

Para el almacenamiento persistente de datos utilicé PostgreSQL, por lo cual se debe crear una base de datos llamada "agenda" y seguido de esto crear un usuario con todos
los permisos sobre esta BD que acabamos de crear.

Hay que configurar en el .ENV el tipo de conexión a base de datos utilizando el controlador respectivo que en este caso es PGSQL, seguido del host, el puerto que para PotsgreSQL es el 5432,
el usuario y la contraseña que creamos en el motor de base de datos, para que Laravel pueda interactuar este por medio de ese usuario.

Seguido de esto para la creación de la tabla que utilicé, hay que ejecutar las migraciones y estas las van a generar de manera automatica para que el proyecto funcione correctamente, la tabla
tiene el nombre de "contacto".

Se tiene que instalar VueJS utilizando NPM en caso de que este no este acondicionado en el proyecto.

Una vez acondicionado se ejecuta el proyecto utilizando el comando PHP ARTISAN SERVE para levantar el servidor local de Laravel y seguido de esto de forma paralela se tiene que ejecutar VITE
para VueJS utilizando el comando NPM RUN DEV.

Una vez realizado todo lo anterior el proyecto deberia funcionar de manera correcta.
