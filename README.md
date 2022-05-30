<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# API - Controle de Venda

## 🔗 REDES SOCIAIS
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/gustavo3g/)
[![instagram](https://img.shields.io/badge/instagram-1DA1F2?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/gutzbs/)




## Documentação

## Rodando localmente

Clone o projeto

```bash
$ git clone https://github.com/Gustavo3g/controle-de-venda-api
```

Entre no diretório do projeto

```bash
$ cd controle-de-venda-api
```

Instale as dependências

```bash
$ composer install
```

Edite o arquivo .env

```bash
$ touch .env
```

Rode as migrações

```bash
$ php artisan migrate
```


Inicie o servidor

```bash
$ php artisan serve
```



## USUARIOS

#### CRIAR USUARIO

```http
  POST /api/auth/register
```

```JSON
{
    "name": "User name",
    "email": "email@email.com",
    "cpf": "12345678912",
    "password": "password"
}
```

#### AUTENTICAR USUARIO

```http
  POST /api/auth/login
```

```JSON
{
    "email": "email@email.com",
    "password": "password"
}
```
```JSON
Retorno:
{
"success": true,
"bearer_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTY1MzkxODg2NywiZXhwIjoxNjUzOTIyNDY3LCJuYmYiOjE2NTM5MTg4NjcsImp0aSI6IkpaSklPUlhCQlhrbWNrT2UiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.RQLA6XbZQBpRX5Sliko3Eg1Z-BloJr405nVxhWmQ8l8",
"expires_in": 3600
}
```
``
BEARER_TOKEN É ULTILIZADO PARA ACESSAR AS ROTAS A SEGUIR:``
#### LISTAR TODOS OS USUARIOS

```http
  GET /api/v1/users
```
#### LISTAR UM USUARIO ESPECIFICO

```http
  GET /api/v1/users/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do usuario |


#### ATUALIZAR USUARIO
```http
PUT /api/v1/users/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `int` | **Obrigatório**. O ID do usuario |

```JSON
{
    "name": "User name",
    "email": "email@email.com",
    "cpf": "12345678912",
    "password": "password"
}
```
#### EXCLUIR USUARIO

```http
DELETE /api/v1/users/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do usuario |






---
## CLIENTES

#### CRIAR UM CLIENTE

```http
  POST api/v1/clients
```

```JSON
{
    "name": "Gustavo client de Sousa",
    "cpf": "25874123654",
    "birth_date": "1999-02-11"
}
```

#### LISTAR TODOS OS CLIENTES

```http
  GET /api/v1/clients
```
#### LISTAR UM CLIENTE ESPECIFICO

```http
  GET /api/v1/clients/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do cliente |


---










## PEDIDOS

#### CRIAR PEDIDO

```http
  POST /api/v1/orders
```
importante: O valor total é tratado no backend;
```JSON
{
    "user_id": "id do vendedor/usuario",
    "client_id": "id do cliente",
    "items_id": "id dos produtos separados por virgula. ex: 1,2,3,6"
}

```

#### LISTAR TODOS OS PEDIDOS

```http
  GET /api/v1/orders
```

#### ATUALIZAR PEDIDO

```http
  PUT /api/v1/orders/${id}
```
| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do pedido |

```JSON
{
    "user_id": 1,
    "client_id": 1,
    "items_id": "1,2,3",
    "total_amount": 160
}
```

#### LISTAR UM PEDIDO ESPECIFICO

```http
  GET /api/v1/orders/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do pedido |


#### EXCLUIR PEDIDO

```http
DELETE /api/v1/orders/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do pedido |

---

---








## LOTES

#### CRIAR UM LOTE

```http
  POST /api/v1/lotes
```

```JSON
{
    "products": [
        {
            "name": "Produto 1",
            "color": "blue",
            "description": "Iphone 8",
            "value": 17.00,
        },
        {
            "name": "Produto 2",
            "color": "blue",
            "description": "Iphone 9",
            "value": 17.00,
        },
        {
            "name": "Produto 10",
            "color": "blue",
            "description": "Xiaomi Redmi note 10",
            "value": 17.00,
        }

    ]
}

```

#### LISTAR TODOS OS LOTES

```http
  GET /api/v1/lotes
```


#### LISTAR UM LOTE ESPECIFICO

```http
  GET /api/v1/lotes/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do lote |


#### EXCLUIR LOTE

```http
DELETE /api/v1/lotes/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do lote |

---






## PRODUTOS

#### CRIAR UM PRODUTO

```http
  POST /api/v1/products
```

```JSON
{
    "name": "Produto 12",
    "color": "red",
    "description": "Iphone seminovo",
    "value": 1500.00,
    "lote_id": id do lote
}

```


#### LISTAR TODOS OS PRODUTOS

```http
  GET /api/v1/products
```
#### LISTAR UM PRODUTO ESPECIFICO

```http
  GET /api/v1/products/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do produto |


#### ATUALIZAR PRODUTO
```http
PUT /api/v1/products/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `int` | **Obrigatório**. O ID do produto |

```JSON
{
    "name": "Produto 12",
    "color": "blue",
    "description": "Iphone novo",
    "value": 1600.00,
    "lote_id": id do lote
}

```
#### EXCLUIR PRODUTO

```http
DELETE /api/v1/products/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`        | `int`     | **Obrigatório**. O ID do produto |
----

## POPULAR BANCO DE DADOS [FACTORYS E SEEDS]

### RUN

Criar lotes e produtos respectivamente.
```bash
$ php artisan db:seed --class=ProductSeeder
```


Criar clientes e pedidos respectivamente (com pedidos já existentes)
```bash
$ php artisan db:seed --class=ClientSeeder
```
