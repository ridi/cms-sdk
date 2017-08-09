    acl is_{SERVICE_NAME} path_beg /{SUB_PATH}/
    use_backend {SERVICE_NAME} if is_{SERVICE_NAME}
