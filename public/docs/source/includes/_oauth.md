#API Oauth

*Essa API é responsável pelo gerenciamento de geração de token no portal qImob.

<!-- START_e93b905843b0e8e829d334bb917c389f12 -->
## Gerar Token de Acesso

Endpoint para gerar token de acesso

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano/tabela_preco" \
-H "Accept: application/json" \
    -d "grant_type"="password" \
    -d "username"="user1@teste.com" \
    -d "password"="secret" \
    -d "client_id"= 1 \
    -d "client_secret"="2CcBq8WSjeHb5IZj5y9lngVxSumInevAd1TemAeJ" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano/tabela_preco",
    "method": "POST",
    "data": {
        "grant_type": "password",
        "username": "user1@teste.com",
        "password": "secret",
        "client_id": 1,
        "client_secret": "2CcBq8WSjeHb5IZj5y9lngVxSumInevAd1TemAeJ"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/oauth/authorize`

#### Parameters

Parameter     | Type    | Status     | Description
---------     | ------- | -------    | ------- | -----------
grant_type    | string |  required  | 
  username    | string |  required  | 
  password    | string |  required  | 
 client_id    | integer |  required  | 
client_secret | string |  required  | 

<!-- END_e93b905843b0e8e829d334bb917c389f12 -->


<!-- START_e93b905843b0e8e829d334bb917c389f121 -->
## Autenticação com Token

Endpoint descrevendo como fazer a autenticação para realizar uma requisição.

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/plano/consulta/anunciante/TO/Palmas" \
-H "Accept: application/json Authorization: Bearer {Token} Content-Type: application/x-www-form-urlencoded"

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/plano/consulta/anunciante/TO/Palmas",
    "method": "GET",
    "headers": {
        "Accept": "application/json",
        "Authorization": "Bearer {Token}",
        "Content-Type": "application/x-www-form-urlencoded",
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

```


### HTTP Request
`http://localhost:8000/api/v1/front/plano/consulta/anunciante/TO/Palmas`

#### Parameters Headers

Parameter     | Type    | Status     | Value
---------     | ------- | -------    | ------- | -----------
Accept    | string |  required  | application/json
  Authorization    | string |  required  | Bearer {Token}
 Content-Type   | integer |  required  | application/x-www-form-urlencoded

<!-- END_e93b905843b0e8e829d334bb917c389f121 -->