# Ridibooks CMS SDK
[![Packagist](https://img.shields.io/packagist/v/ridibooks/cms-sdk.svg)](https://packagist.org/packages/ridibooks/cms-sdk)

## Usage

1. Install cms-sdk as a dependency using Composer.
```
curl -sS https://getcomposer.org/installer | php
php composer.phar require ridibooks/cms-sdk
```



## cms-bootstrap

cms-sdk has a command line tool, `cms-bootstrap`.
It helps building local dev environment using `docker-composer`. (should be installed)
See [docker-compose.yml](bootstrap/docker-compose.yml) for detail.

#### Directory
```
cms-sdk
├──bin
│   └── cms-bootstrap
├──bootstrap
│   ├── cms
│   ├── haproxy
│   ├── couchbase
│   ├── custom
│   │   └── (... your services here ...)
│   ├── template
│   ├── example
│   └── docker-compose.yml
...
```

Run cms-bootstrap from your project:
```
vendor/bin/cms-bootstap list
```



## Start with cms-bootstrap

Assume that you set an alias `admin.dev.ridi.com` for localhost. (For example, write it to /etc/hosts)

1. Write cms configuration at vendor/ridibooks/cms-sdk/bootstrap/cms/.env
    ```
    DEBUG=1
    TEST_ID=<your test account in db>
    SESSION_DOMAIN=admin.dev.ridi.com
    COUCHBASE_HOST=couchbase
    
    MYSQL_HOST=<mysql host>
    MYSQL_USER=<mysql user>
    MYSQL_PASSWORD=<mysql password>
    MYSQL_DATABASE=<mysql db>
    ```

2. Write your service at the docker-composer.yml and haproxy.cfg.
    ```
    vendor/bin/cms-bootstap service:add my-service test
    ```
    When prompted, set a service directory with the default value. (It's the path of your project.)

3. You can check if the command succeed. 
    ```
    vendor/bin/cms-bootstap service:list
    ```

4. Copy example codes to the service.
    ```
    vendor/bin/cms-bootstap service:example
    ```

5. Run docker-compose.
    ```
    vendor/bin/cms-bootstap docker:up
    ```

6. Setup Couchbase (**Only first time**)
    - Configure Couchbase at http://admin.dev.ridi.com:8091.
    - Create `session` bucket. 
    - See https://developer.couchbase.com/documentation/server/4.5/install/init-setup.html

7. Open `http://admin.dev.ridi.com` with a browser.

8. Clean docker containers and networks.
    ```
    vendor/bin/cms-bootstrap docker:down
    ```
