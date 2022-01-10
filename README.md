# LARAVEL REST API

## Výpis všech zákazníků

```
GET http://127.0.0.1:8000/api/customers HTTP/1.1
```

## Výpis konkretního zákazníka

```
GET http://127.0.0.1:8000/api/customers/1 HTTP/1.1
```

## Vytvoření nového zákazníka

```
POST http://127.0.0.1:8000/api/customers HTTP/1.1
Content-Type: application/json

{
    "first_name": "Jan",
    "last_name": "Novak",
    "email": "jan@novak.cz"
}
```

```
POST http://127.0.0.1:8000/api/customers HTTP/1.1
Content-Type: application/json

{
    "first_name": "Jan",
    "last_name": "Novak",
    "email": "jan@novak.cz",
    "groups": [
        {
            "name": "Testovací skupina 1"
        },
        {
            "name": "Testovací skupina 2"
        }
    ]
}
```

## Editace zakazníka

```
PUT http://127.0.0.1:8000/api/customers/4 HTTP/1.1
Content-Type: application/json

{
    "first_name": "Jan",
    "last_name": "Novak",
    "email": "jan@novak.cz",
    "groups": [
        {
            "name": "Testovací skupina 10"
        }
    ]
}
```

## Odstranění zákazníka

```
DELETE http://127.0.0.1:8000/api/customers/1 HTTP/1.1
```