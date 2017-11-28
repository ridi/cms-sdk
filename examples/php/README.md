# Ridibooks CMS SDK sample - PHP

## Setup

- Add host `127.0.0.1 admin.dev.ridi.com`
- `make install`
- Open a new console and run CMS server on Docker
  - `make cms-up`
- In the previouse console, migrate the sample DB.
  - `cd cms-bootstrap && make migrate-samples`
- Run the example: `php -S 127.0.0.1:8080 -t web/`
- `open http://admin.dev.ridi.com/example/home`
