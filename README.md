## Simple OMDB Finder

1. [Description](#description)
2. [Prerequisites](#prerequisites)
3. [Build and install](#build-and-install)
4. [Run](#run)
5. [Unit Tests](#unit-tests)
6. [API docs](#api-docs)

### Description

A simple web app for querying [Open Movie Database API](https://www.omdbapi.com/).
Uses PHP (Silex) for backend and Vue.js for frontend.

### Prerequisites

Requires [Docker](https://docs.docker.com/) to build and run.

### Build and install

Do the following steps in the project root directory:

Build the backend app
``` bash
    docker build --rm -t omdb-finder-backend .
    docker run -it -v $PWD:/app omdb-finder-backend composer install
```

Build the frontend app
``` bash
    cd src/web/front-app # go to frontend app root
    docker build --rm -t omdb-finder-frontend .
    docker run -it -v $PWD:/usr/src/app omdb-finder-frontend npm install
    docker run -it -v $PWD:/usr/src/app omdb-finder-frontend npm run build
```

Symlink (or copy) the built frontend app (`src/web/front-app/dist/build.js`) to the static assets directory (`public/`)
``` bash
    # from src/web/front-app
    ln -sf ../src/web/front-app/dist/build.js ../../../public/build.js
```

### Run

Start the server (the app uses the PHP built-in server):

``` bash
    # from project root
    docker run -it -p 8001:8001 -v $PWD:/app omdb-finder-backend \
        composer run-script start --timeout=0
```

Navigate to `http://localhost:8001/`

### Unit Tests

``` bash
    # from project root
    docker run -it -v $PWD:/app omdb-finder-backend composer run-script test
```

### API docs

The backend app API endpoints are documented in [Swagger](http://editor.swagger.io/) format is in `docs/api/swagger.yml`
