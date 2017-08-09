  {SERVICE_NAME}:
    image: ridibooks/performance-apache-base:latest
    volumes:
      - {SERVICE_DIR}:/var/www/html
    environment:
      APACHE_DOC_ROOT: /var/www/html/web
      XDEBUG_ENABLE: 1
    ports:
      - 0:80
    networks:
      back-tier:
        aliases:
          - cms_{SERVICE_NAME}
