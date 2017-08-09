backend {SERVICE_NAME}
    option forwardfor
    server {SERVICE_NAME} cms_{SERVICE_NAME}:80
