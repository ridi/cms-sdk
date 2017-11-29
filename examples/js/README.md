# Ridibooks CMS SDK sample - Node.js

## Setup

- Add host `127.0.0.1 admin.dev.ridi.com`
- `make install`
- Open a new console and run CMS server on Docker
  - `make cms-up`
- In the previouse console, migrate the sample DB.
  - `make -C cms-bootstrap migrate-samples`
- Run the example: `node index.js`
- `open http://admin.dev.ridi.com/example/home`
