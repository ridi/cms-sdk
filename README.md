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
It helps building local dev environment using `docker-compose`. (should be installed)
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
│   ├── template
│   ├── example
│   └── docker-compose.yml
...
```

Run cms-bootstrap from your project:
```
vendor/bin/cms-bootstrap list
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

2. Write your service at the docker-compose.yml and haproxy.cfg.
    ```
    vendor/bin/cms-bootstrap service:add my-service test
    ```
    When prompted, set a service directory with the default value. (It's the path of your project.)

3. You can check if the command succeed. 
    ```
    vendor/bin/cms-bootsrtap service:list
    ```

4. Copy example codes to the service.
    ```
    vendor/bin/cms-bootsrtap service:example
    ```

5. Run docker-compose.
    ```
    vendor/bin/cms-bootstrap docker:up -d
    ```

6. Open `http://admin.dev.ridi.com/test/home` with a browser.

7. Clean docker containers and networks.
    ```
    vendor/bin/cms-bootstrap docker:down
    ```
