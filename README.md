# STS Beer API

Backed Symfony 5 app for importing beers and browsing.

## How to run

To run please use following commands

```
git clone git@github.com:ketele/sts.git
cd sts\docker
docker-compose up
```


## Importing beers and breweries

Command for importing beers and breweries

```
php bin/console app:import
```



## API

The API UI is available under following route

```text
http://localhost/api
```

## ISO country codes

You may filter country by alpha-2 codes (e.g. PL) or alpha-3 codes (e.g. POL).