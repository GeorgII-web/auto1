# AUTO1 project
- Test results
![Test](public/images/test.png?raw=true "Test")

- API documentation
![Request](public/images/swagger.png?raw=true "Docs")

### Features
- User mutable class
- Car class trait for paintable parts
- Mock testing fight service
- Open API documentation for the marketplace

### Development installation instructions

#### Before start (Windows 10)

1. Enable windows subsystem for linux [wsl2 install instructions](https://docs.microsoft.com/ru-ru/windows/wsl/install-win10#step-1---enable-the-windows-subsystem-for-linux)
2. Install [Docker Desktop](https://www.docker.com/products/docker-desktop) (docker install [instructions](https://docs.docker.com/docker-for-windows/wsl/)).

#### Installation

##### 1. Clone repository

```sh
$ git clone https://github.com/GeorgII-web/auto1.git auto1
$ cd auto1
```

##### 2. Copy .env.example to .env
```sh
$ cp .env.example .env
```

##### 3. Docker (php 8.0) "composer install"
Download *vendor* folder.
```sh
$ docker run --rm \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install
```

##### 4. Sail start
- Download docker images for laravel/mysql/redis...
```sh
$ ./vendor/bin/sail up
```
- Sail [instructions](https://laravel.com/docs/8.x/sail#executing-sail-commands)

##### 5. Generate new app key
```sh
$ sail artisan key:generate
```

##### 6. Post install commands
```sh
$ sail artisan optimize
```

##### 7. Test
```sh
$ sail test
```

##### 8. Generate API documentation
```sh
$ sail artisan l5-swagger:generate
```
