# JMI Woocommerce

Levantar instancia local:

´´´
docker-compose up -d
´´´

Respaldar contenido de wordpress a una carpeta local

´´´
docker cp jmimport_wordpress_1:/var/www/html var
´´´

Volver ese respaldo dentro del container

´´´
docker cp var jmimport_wordpress_1:/var/www/html
´´´
