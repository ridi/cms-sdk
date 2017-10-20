# Ridibooks CMS SDK - Node.js

## Setup

This example requires cms and couchbase servers. There is prebuilt docker environments for these servers.

### Run prebuilt docker environments locally(cms, couchbase)
- Clone cms-bootstrap('https://gitlab.ridi.io/performance/cms-bootstrap').
- Run ```docker-compose up``` in the cloned directory.

### Run the example
- Clone cms-sdk('https://github.com/ridibooks/cms-sdk').
- ```npm install && npm run build```.
- ```node samples/js/index.js```.
- Navigate to ```127.0.0.1:8080``` in the web browser.
