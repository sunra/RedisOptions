# RedisOptions

Options Tool backed in Redis


## Usage

- In Symfony app

Configure redis connection and options service in config.yml

```yaml
snc_redis:
    clients:
        options:
            type: predis
            alias: options
            dsn: redis://localhost/1
            logging: false

r_options:
    class:        Sunra\RedisOptions
    arguments:    [@snc_redis.options]
```



## Installation

- Use Composer (recommended):

  - add to app's composer.json:
 
```json
"require": {
    "sunra/redis-options":"dev-master"
    },
"repositories": [
        {
            "type": "git",
            "url": "https://github.com/sunra/RedisOptions"
        }
    ],
```


- clone via git