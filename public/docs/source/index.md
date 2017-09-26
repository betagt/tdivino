---
title: API Reference

language_tabs:
- bash
- javascript

includes:
- oauth
- release
- errors

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Informação

Bem vindo a documentação da API do Portal Qimob.
<!-- END_INFO -->

#API Client Token - Backend

Essa API é responsável pelo gerenciamento dos tokens no portal qImob.
Os próximos tópicos apresentara os endpoints de Consulta, Cadastro, Edição e Deleção.
<!-- START_b01e9d0351c8ba4161e07df3a37bda7f -->
## Remover Client Token

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/client/api/revoke/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/client/api/revoke/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/client/api/revoke/{id}`

`HEAD api/v1/admin/client/api/revoke/{id}`


<!-- END_b01e9d0351c8ba4161e07df3a37bda7f -->
<!-- START_2c006597e91c1281150d4fda5ab40d9a -->
## Atualizar Client Token

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/client/api/update_token/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/client/api/update_token/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/client/api/update_token/{id}`

`HEAD api/v1/admin/client/api/update_token/{id}`


<!-- END_2c006597e91c1281150d4fda5ab40d9a -->
<!-- START_bf523de05dc23abfc7c69b824e6ba8b4 -->
## Cadastrar Client Token

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/client" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/client",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/admin/client`


<!-- END_bf523de05dc23abfc7c69b824e6ba8b4 -->
<!-- START_9d00c837fae0254e02b9039019776c6f -->
## Atualizar Client Token

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/client/{client}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/client/{client}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/admin/client/{client}`

`PATCH api/v1/admin/client/{client}`


<!-- END_9d00c837fae0254e02b9039019776c6f -->
<!-- START_66600600f840ed827145748df69aab35 -->
## Deletar Client Token

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/client/{client}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/client/{client}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/admin/client/{client}`


<!-- END_66600600f840ed827145748df69aab35 -->
#API Configuração - Backend

Essa API é responsável pelo gerenciamento da Configuração no portal qImob.
Os próximos tópicos apresentara os endpoints de Consulta, Cadastro, Edição e Deleção.

Class ConfiguracaoController
<!-- START_d804ef610c146f4729669d80fc22b573 -->
## Consulta Configuração

Endpoint para consulta registro

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/configuracao" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/configuracao",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/configuracao`

`HEAD api/v1/admin/configuracao`


<!-- END_d804ef610c146f4729669d80fc22b573 -->
<!-- START_58e4f40890e1182ae38f965358c951b4 -->
## Alterar Configuração

Endpoint para alterar configuração

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/configuracao" \
-H "Accept: application/json" \
    -d "titulo"="perspiciatis" \
    -d "email"="malika72@example.com" \
    -d "url_site"="http://www.rippin.biz/ab-et-tempore-unde-earum-ratione-dignissimos-sunt.html" \
    -d "telefone"="perspiciatis" \
    -d "horario_atendimento"="perspiciatis" \
    -d "endereco"="perspiciatis" \
    -d "rodape"="perspiciatis" \
    -d "facebook"="perspiciatis" \
    -d "twitter"="perspiciatis" \
    -d "google_plus"="perspiciatis" \
    -d "youtube"="perspiciatis" \
    -d "instagram"="perspiciatis" \
    -d "palavra_chave"="perspiciatis" \
    -d "descricao_site"="perspiciatis" \
    -d "og_tipo_app"="perspiciatis" \
    -d "og_titulo_site"="perspiciatis" \
    -d "od_url_site"="http://www.rippin.biz/ab-et-tempore-unde-earum-ratione-dignissimos-sunt.html" \
    -d "od_autor_site"="perspiciatis" \
    -d "facebook_id"="perspiciatis" \
    -d "token"="perspiciatis" \
    -d "analytcs_code"="73660" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/configuracao",
    "method": "PUT",
    "data": {
        "titulo": "perspiciatis",
        "email": "malika72@example.com",
        "url_site": "http:\/\/www.rippin.biz\/ab-et-tempore-unde-earum-ratione-dignissimos-sunt.html",
        "telefone": "perspiciatis",
        "horario_atendimento": "perspiciatis",
        "endereco": "perspiciatis",
        "rodape": "perspiciatis",
        "facebook": "perspiciatis",
        "twitter": "perspiciatis",
        "google_plus": "perspiciatis",
        "youtube": "perspiciatis",
        "instagram": "perspiciatis",
        "palavra_chave": "perspiciatis",
        "descricao_site": "perspiciatis",
        "og_tipo_app": "perspiciatis",
        "og_titulo_site": "perspiciatis",
        "od_url_site": "http:\/\/www.rippin.biz\/ab-et-tempore-unde-earum-ratione-dignissimos-sunt.html",
        "od_autor_site": "perspiciatis",
        "facebook_id": "perspiciatis",
        "token": "perspiciatis",
        "analytcs_code": 73660
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
`PUT api/v1/admin/configuracao`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    titulo | string |  required  | Maximum: `255`
    email | email |  required  | 
    url_site | url |  required  | 
    telefone | string |  required  | Maximum: `255`
    horario_atendimento | string |  required  | Maximum: `255`
    endereco | string |  required  | Maximum: `255`
    rodape | string |  required  | Maximum: `255`
    facebook | string |  required  | Maximum: `255`
    twitter | string |  required  | Maximum: `255`
    google_plus | string |  required  | Maximum: `255`
    youtube | string |  required  | Maximum: `255`
    instagram | string |  required  | Maximum: `255`
    palavra_chave | string |  required  | Maximum: `255`
    descricao_site | string |  required  | Maximum: `255`
    og_tipo_app | string |  required  | Maximum: `255`
    og_titulo_site | string |  required  | Maximum: `255`
    od_url_site | url |  required  | 
    od_autor_site | string |  required  | Maximum: `255`
    facebook_id | string |  required  | Maximum: `255`
    token | string |  required  | Maximum: `255`
    analytcs_code | integer |  required  | 

<!-- END_58e4f40890e1182ae38f965358c951b4 -->
#API Permissão de Usuários - Backend

Essa API é responsável pelo gerenciamento de Permissão de Usuários no portal qImob.
Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
<!-- START_b689c6600d2e83d17dd5324be00f2a94 -->
## Revogar Permissões

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/revogar_permissoes/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/revogar_permissoes/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/permissao/revogar_permissoes/{id}`

`HEAD api/v1/admin/permissao/revogar_permissoes/{id}`


<!-- END_b689c6600d2e83d17dd5324be00f2a94 -->
<!-- START_02e86544aac787b55102c55e355e12d6 -->
## Listar todas permissões do grupo.

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/lista_de_permissao_regra/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/lista_de_permissao_regra/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/permissao/lista_de_permissao_regra/{id}`

`HEAD api/v1/admin/permissao/lista_de_permissao_regra/{id}`


<!-- END_02e86544aac787b55102c55e355e12d6 -->
<!-- START_15a1f06c3078d61af1a9daef8b0f17ae -->
## Listar todas permissões do usuário.

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/lista_de_permissao_usuario/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/lista_de_permissao_usuario/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/permissao/lista_de_permissao_usuario/{id}`

`HEAD api/v1/admin/permissao/lista_de_permissao_usuario/{id}`


<!-- END_15a1f06c3078d61af1a9daef8b0f17ae -->
<!-- START_b9cc6e6b079933ffce8473ba4b43c92c -->
## Listar tipos de permissões de requisições

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/list_slugs" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/list_slugs",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/permissao/list_slugs`

`HEAD api/v1/admin/permissao/list_slugs`


<!-- END_b9cc6e6b079933ffce8473ba4b43c92c -->
<!-- START_c076cbeaa1f1ff901053947cfce5866d -->
## Associar Permissão a Regra

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/associar_permissao_regra" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/associar_permissao_regra",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/admin/permissao/associar_permissao_regra`


<!-- END_c076cbeaa1f1ff901053947cfce5866d -->
<!-- START_362ffeb48e15b3d864b5c69b3562f687 -->
## Criar uma permissão para um unico usuário.

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/criar_permissao_usuario" \
-H "Accept: application/json" \
    -d "inherit_id"="957" \
    -d "name"="ad" \
    -d "slug"="ad" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/criar_permissao_usuario",
    "method": "POST",
    "data": {
        "inherit_id": 957,
        "name": "ad",
        "slug": "ad"
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
`POST api/v1/admin/permissao/criar_permissao_usuario`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    inherit_id | numeric |  optional  | 
    name | string |  required  | 
    slug | array |  optional  | 

<!-- END_362ffeb48e15b3d864b5c69b3562f687 -->
<!-- START_ffc2118dbcdae15e22ed790e3946b7b0 -->
## Consultar Permissão

Endpoint para consulta de permissão cadastrados paginadas

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/permissao`

`HEAD api/v1/admin/permissao`


<!-- END_ffc2118dbcdae15e22ed790e3946b7b0 -->
<!-- START_17f27e1aa27d71f9c5cc71184c2ebe64 -->
## Cadastrar Permissão

Endpoint para cadastrar permissão usuário

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao" \
-H "Accept: application/json" \
    -d "inherit_id"="1" \
    -d "name"="explicabo" \
    -d "slug"="explicabo" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao",
    "method": "POST",
    "data": {
        "inherit_id": 1,
        "name": "explicabo",
        "slug": "explicabo"
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
`POST api/v1/admin/permissao`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    inherit_id | numeric |  optional  | 
    name | string |  required  | 
    slug | array |  optional  | 

<!-- END_17f27e1aa27d71f9c5cc71184c2ebe64 -->
<!-- START_0bca080d39c2c041e3ec3a11239aa59b -->
## Consultar Permissão por ID

Endpoint para consultar permisão passando o ID como parametro

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/{permissao}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/{permissao}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/permissao/{permissao}`

`HEAD api/v1/admin/permissao/{permissao}`


<!-- END_0bca080d39c2c041e3ec3a11239aa59b -->
<!-- START_546b69fb3c5dac7b4e50acaaef4c48b7 -->
## Alterar Permissão por ID

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/{permissao}" \
-H "Accept: application/json" \
    -d "inherit_id"="805731" \
    -d "name"="harum" \
    -d "slug"="harum" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/{permissao}",
    "method": "PUT",
    "data": {
        "inherit_id": 805731,
        "name": "harum",
        "slug": "harum"
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
`PUT api/v1/admin/permissao/{permissao}`

`PATCH api/v1/admin/permissao/{permissao}`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    inherit_id | numeric |  optional  | 
    name | string |  required  | 
    slug | array |  optional  | 

<!-- END_546b69fb3c5dac7b4e50acaaef4c48b7 -->
<!-- START_36b808b68ba449c685e06a455cfd6a1a -->
## Deletar Permissão

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/permissao/{permissao}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/permissao/{permissao}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/admin/permissao/{permissao}`


<!-- END_36b808b68ba449c685e06a455cfd6a1a -->
#API Plano de Anúncio - Backend

*Essa API é responsável pelo gerenciamento de planos de anúncio no portal qImob.
Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
Class PlanoController
<!-- START_e93b905843b0e8e829d334bb917c389f -->
## Cadastrar Tabela Preço

Endpoint para cadastrar tabela de preço de plano

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano/tabela_preco" \
-H "Accept: application/json" \
    -d "id"="288649472" \
    -d "plano_id"="288649472" \
    -d "estado_id"="288649472" \
    -d "cidade_id"="288649472" \
    -d "valor"="288649472" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano/tabela_preco",
    "method": "POST",
    "data": {
        "id": 288649472,
        "plano_id": 288649472,
        "estado_id": 288649472,
        "cidade_id": 288649472,
        "valor": 288649472
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
`POST api/v1/admin/plano/tabela_preco`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    id | integer |  optional  | 
    plano_id | integer |  required  | 
    estado_id | integer |  required  | 
    cidade_id | integer |  required  | 
    valor | numeric |  required  | 

<!-- END_e93b905843b0e8e829d334bb917c389f -->
<!-- START_606f5e61b283ccac6b4f64fd4f2fa4f3 -->
## Alterar Tabela de Preço

Endpoint para alterar tabela de preço

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano/tabela_preco/{tabela_preco}" \
-H "Accept: application/json" \
    -d "id"="7379600" \
    -d "plano_id"="7379600" \
    -d "estado_id"="7379600" \
    -d "cidade_id"="7379600" \
    -d "valor"="7379600" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano/tabela_preco/{tabela_preco}",
    "method": "PUT",
    "data": {
        "id": 7379600,
        "plano_id": 7379600,
        "estado_id": 7379600,
        "cidade_id": 7379600,
        "valor": 7379600
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
`PUT api/v1/admin/plano/tabela_preco/{tabela_preco}`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    id | integer |  optional  | 
    plano_id | integer |  required  | 
    estado_id | integer |  required  | 
    cidade_id | integer |  required  | 
    valor | numeric |  required  | 

<!-- END_606f5e61b283ccac6b4f64fd4f2fa4f3 -->
<!-- START_033bf91b17d5af22abbf85a1d6b62cfc -->
## Deletar Tabela de Preço

Endpoint para deletar tabela de preço passando o ID

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano/tabela_preco/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano/tabela_preco/{id}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/admin/plano/tabela_preco/{id}`


<!-- END_033bf91b17d5af22abbf85a1d6b62cfc -->
<!-- START_b90e885f988c471a3d4e7919938b868e -->
## Consulta Tabelas de Preco

Endpoint para consulta as tabelas de preço passando o ID do Plano como parametro

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano/tabela_preco/{plano}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano/tabela_preco/{plano}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/plano/tabela_preco/{plano}`

`HEAD api/v1/admin/plano/tabela_preco/{plano}`


<!-- END_b90e885f988c471a3d4e7919938b868e -->
<!-- START_4097e15e8b1d7c18b497969a14b64ae9 -->
## Consulta Planos

Endpoint para consultar todos os planos cadastrados

Nessa consulta pode ser aplicado os seguintes filtros:

 - Consultar Normal:
  <br> - Não passar parametros

 - Consultar por Cidade:
  <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/plano`

`HEAD api/v1/admin/plano`


<!-- END_4097e15e8b1d7c18b497969a14b64ae9 -->
<!-- START_47c021e4b53fc23a2cb85319cf602627 -->
## Cadastrar Plano

Endpoint para cadastrar plano

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano" \
-H "Accept: application/json" \
    -d "id"="862074916" \
    -d "nome"="sint" \
    -d "dias"="862074916" \
    -d "qtde_destaque"="862074916" \
    -d "qtde_anuncio"="862074916" \
    -d "valor"="862074916" \
    -d "tipo"="qimob-erp" \
    -d "status"="1" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano",
    "method": "POST",
    "data": {
        "id": 862074916,
        "nome": "sint",
        "dias": 862074916,
        "qtde_destaque": 862074916,
        "qtde_anuncio": 862074916,
        "valor": 862074916,
        "tipo": "qimob-erp",
        "status": true
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
`POST api/v1/admin/plano`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    id | integer |  optional  | 
    nome | string |  required  | Maximum: `255`
    dias | integer |  required  | 
    qtde_destaque | integer |  required  | 
    qtde_anuncio | integer |  required  | 
    valor | numeric |  required  | 
    tipo | string |  required  | `anunciante`, `imobiliaria` or `qimob-erp`
    status | boolean |  required  | 

<!-- END_47c021e4b53fc23a2cb85319cf602627 -->
<!-- START_727ea85f9528490b1c2ce368a60cd078 -->
## Consulta Plano por ID

Endpoint para consulta plano passando o ID como parametro

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano/{plano}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano/{plano}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/plano/{plano}`

`HEAD api/v1/admin/plano/{plano}`


<!-- END_727ea85f9528490b1c2ce368a60cd078 -->
<!-- START_eadef47e67a689587ace339ae9067ce3 -->
## Alterar Plano

Endpoint para alterar plano

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano/{plano}" \
-H "Accept: application/json" \
    -d "id"="26" \
    -d "nome"="fugit" \
    -d "dias"="26" \
    -d "qtde_destaque"="26" \
    -d "qtde_anuncio"="26" \
    -d "valor"="26" \
    -d "tipo"="anunciante" \
    -d "status"="1" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano/{plano}",
    "method": "PUT",
    "data": {
        "id": 26,
        "nome": "fugit",
        "dias": 26,
        "qtde_destaque": 26,
        "qtde_anuncio": 26,
        "valor": 26,
        "tipo": "anunciante",
        "status": true
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
`PUT api/v1/admin/plano/{plano}`

`PATCH api/v1/admin/plano/{plano}`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    id | integer |  optional  | 
    nome | string |  required  | Maximum: `255`
    dias | integer |  required  | 
    qtde_destaque | integer |  required  | 
    qtde_anuncio | integer |  required  | 
    valor | numeric |  required  | 
    tipo | string |  required  | `anunciante`, `imobiliaria` or `qimob-erp`
    status | boolean |  required  | 

<!-- END_eadef47e67a689587ace339ae9067ce3 -->
<!-- START_5e8417980b6843806a6a00b2b08466ba -->
## Deletar Plano

Endpoint para deletar plano passando o ID

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/plano/{plano}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/plano/{plano}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/admin/plano/{plano}`


<!-- END_5e8417980b6843806a6a00b2b08466ba -->
#API Plano de Anúncio - Frontend

Essa API é responsável pelo gerenciamento de planos de anúncio no portal qImob.
Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.

Class PlanoController
<!-- START_96b8f7dd0605b8e2c77e91d5254fb478 -->
## Consulta Planos

Endpoint para consulta de planos no frontend.

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/plano/consulta/{tipo_anunciante}/{estado}/{cidade}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/plano/consulta/{tipo_anunciante}/{estado}/{cidade}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/v1/front/plano/consulta/{tipo_anunciante}/{estado}/{cidade}`

`HEAD api/v1/front/plano/consulta/{tipo_anunciante}/{estado}/{cidade}`


<!-- END_96b8f7dd0605b8e2c77e91d5254fb478 -->
#API Página - Backend

Essa API é responsável pelo gerenciamento de Página no portal qImob.
Os próximos tópicos apresentara os endpoints de Consulta, Cadastro, Edição e Deleção.
<!-- START_f7a0ef7009e5dde51b815eb746e7dc03 -->
## Consulta Todas a Páginas

Endpoint para consulta todas as páginas cadastradas paginadas em 25 por páginas

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/pagina" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/pagina",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/pagina`

`HEAD api/v1/admin/pagina`


<!-- END_f7a0ef7009e5dde51b815eb746e7dc03 -->
<!-- START_6f5f4cdfbf52d4e99851a3b304e4c137 -->
## Cadastrar Página

Endpoint para cadastrar página

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/pagina" \
-H "Accept: application/json" \
    -d "id"="5249690" \
    -d "titulo"="quo" \
    -d "slug"="quo" \
    -d "descricao"="quo" \
    -d "resumo"="quo" \
    -d "status"="0" \
    -d "parent_id"="5249690" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/pagina",
    "method": "POST",
    "data": {
        "id": 5249690,
        "titulo": "quo",
        "slug": "quo",
        "descricao": "quo",
        "resumo": "quo",
        "status": "0",
        "parent_id": 5249690
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
`POST api/v1/admin/pagina`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    id | integer |  optional  | 
    titulo | string |  required  | Maximum: `255`
    slug | string |  optional  | Maximum: `255`
    descricao | string |  required  | 
    resumo | string |  optional  | Maximum: `500`
    status | boolean |  required  | `1` or `0`
    parent_id | integer |  optional  | 

<!-- END_6f5f4cdfbf52d4e99851a3b304e4c137 -->
<!-- START_286bab265bf05759e421da352c0ed2b2 -->
## Consulta Página por ID

Endpoint para consulta página passando o ID como parametro

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/pagina/{pagina}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/pagina/{pagina}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/pagina/{pagina}`

`HEAD api/v1/admin/pagina/{pagina}`


<!-- END_286bab265bf05759e421da352c0ed2b2 -->
<!-- START_404b5f1cdfc3c551792b1caee7385310 -->
## Alterar Página

Endpoint para alterar página

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/pagina/{pagina}" \
-H "Accept: application/json" \
    -d "id"="92" \
    -d "titulo"="quia" \
    -d "slug"="quia" \
    -d "descricao"="quia" \
    -d "resumo"="quia" \
    -d "status"="1" \
    -d "parent_id"="92" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/pagina/{pagina}",
    "method": "PUT",
    "data": {
        "id": 92,
        "titulo": "quia",
        "slug": "quia",
        "descricao": "quia",
        "resumo": "quia",
        "status": "1",
        "parent_id": 92
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
`PUT api/v1/admin/pagina/{pagina}`

`PATCH api/v1/admin/pagina/{pagina}`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    id | integer |  optional  | 
    titulo | string |  required  | Maximum: `255`
    slug | string |  optional  | Maximum: `255`
    descricao | string |  required  | 
    resumo | string |  optional  | Maximum: `500`
    status | boolean |  required  | `1` or `0`
    parent_id | integer |  optional  | 

<!-- END_404b5f1cdfc3c551792b1caee7385310 -->
<!-- START_0807f279d14bb37ded4552661845eac1 -->
## Deletar Página

Endpoint para deletar página passando o ID

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/pagina/{pagina}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/pagina/{pagina}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/admin/pagina/{pagina}`


<!-- END_0807f279d14bb37ded4552661845eac1 -->
#API Página - Frontend

Essa API é responsável pelo gerenciamento de Página no portal qImob.
Os próximos tópicos apresentara os endpoints de Consulta, Cadastro, Edição e Deleção.
<!-- START_f5af7dd636deaedcc6cb5cce8fa6de9c -->
## Consulta Página por SLUG

Endpoint para consulta página passando o SLUG como parametro

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/pagina/conteudo/{slug}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/pagina/conteudo/{slug}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/front/pagina/conteudo/{slug}`

`HEAD api/v1/front/pagina/conteudo/{slug}`


<!-- END_f5af7dd636deaedcc6cb5cce8fa6de9c -->
#API Regras de Acesso - Backend

Essa API é responsável pelo gerenciamento de regras de Usuários no portal qImob.
Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
<!-- START_5c8d868fd6c76c794eb056308cfdf85b -->
## Remover Todas Regras Usuário

Revogar todas as regras de um usuário

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra/revogar_todas_regras_usuario/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra/revogar_todas_regras_usuario/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/regra/revogar_todas_regras_usuario/{id}`

`HEAD api/v1/admin/regra/revogar_todas_regras_usuario/{id}`


<!-- END_5c8d868fd6c76c794eb056308cfdf85b -->
<!-- START_941682ae8bf6fac66c31b5777d5dc85b -->
## Sicronizar Permissões p/ Regra

Sicronizar todas as permissões para um role(perfil)

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra/sincronizar_regra_permissoes" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra/sincronizar_regra_permissoes",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/admin/regra/sincronizar_regra_permissoes`


<!-- END_941682ae8bf6fac66c31b5777d5dc85b -->
<!-- START_c45f5ad0d65ba794b8c60534a6178ea6 -->
## Remover Regra

Revogar todas as regras

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra/revogar_regra_usuario" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra/revogar_regra_usuario",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/admin/regra/revogar_regra_usuario`


<!-- END_c45f5ad0d65ba794b8c60534a6178ea6 -->
<!-- START_c509f3c67ab354c8d17e2a312815a608 -->
## Associar Regra ao Usuário

Endpoint para associar um regra a um usuário

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra/associar_regra_usuario" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra/associar_regra_usuario",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/admin/regra/associar_regra_usuario`


<!-- END_c509f3c67ab354c8d17e2a312815a608 -->
<!-- START_703dac6b1b1af6d804f192984c8949ac -->
## Consultar Regras

Endpoint para consulta de regras cadastrados paginadas

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/regra`

`HEAD api/v1/admin/regra`


<!-- END_703dac6b1b1af6d804f192984c8949ac -->
<!-- START_e1f8271725d941d8d8eb0b3307f837b1 -->
## Cadastrar Regra

Endpoint para cadastrar regra de usuário

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra" \
-H "Accept: application/json" \
    -d "name"="neque" \
    -d "slug"="neque" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra",
    "method": "POST",
    "data": {
        "name": "neque",
        "slug": "neque"
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
`POST api/v1/admin/regra`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | 
    slug | string |  required  | 

<!-- END_e1f8271725d941d8d8eb0b3307f837b1 -->
<!-- START_0c1fd4368a5725c2149a0e09a8fe1b03 -->
## Consultar Regra por ID

Endpoint para consultar regras passando o ID como parametro

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra/{regra}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra/{regra}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/regra/{regra}`

`HEAD api/v1/admin/regra/{regra}`


<!-- END_0c1fd4368a5725c2149a0e09a8fe1b03 -->
<!-- START_c7b5f1b1151bfdd3898bcd779ae073dd -->
## Alterar Regra por ID

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra/{regra}" \
-H "Accept: application/json" \
    -d "name"="dolorem" \
    -d "slug"="dolorem" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra/{regra}",
    "method": "PUT",
    "data": {
        "name": "dolorem",
        "slug": "dolorem"
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
`PUT api/v1/admin/regra/{regra}`

`PATCH api/v1/admin/regra/{regra}`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | 
    slug | string |  required  | 

<!-- END_c7b5f1b1151bfdd3898bcd779ae073dd -->
<!-- START_f33ac83a93535afae3668add35852ac2 -->
## Deletar Regra

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra/{regra}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra/{regra}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/admin/regra/{regra}`


<!-- END_f33ac83a93535afae3668add35852ac2 -->
<!-- START_cc5575cc1bbfa4b79c4de6cf37078000 -->
## Regra do Usuário

Busca todos os perfis do usuário

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/regra/regras_do_usuario/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/regra/regras_do_usuario/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/regra/regras_do_usuario/{id}`

`HEAD api/v1/admin/regra/regras_do_usuario/{id}`


<!-- END_cc5575cc1bbfa4b79c4de6cf37078000 -->
#API Usuário - Backend

Essa API é responsável pelo gerenciamento de Usuários no portal qImob.
Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
<!-- START_fe194054ff0707a4f414fc4784856959 -->
## Alterar Senha

Enviar dados para alterar a senha

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user/password/change" \
-H "Accept: application/json" \
    -d "old_password"="expedita" \
    -d "new_password"="expedita" \
    -d "new_password_confirmation"="expedita" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user/password/change",
    "method": "PATCH",
    "data": {
        "old_password": "expedita",
        "new_password": "expedita",
        "new_password_confirmation": "expedita"
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
`PATCH api/v1/admin/user/password/change`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    old_password | string |  required  | 
    new_password | string |  required  | Minimum: `8`
    new_password_confirmation | string |  required  | 

<!-- END_fe194054ff0707a4f414fc4784856959 -->
<!-- START_12644025c84b0cfcae51a274bd988c25 -->
## Solicitar Nova Senha

Enviar email com link para usuário recuperar senha

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user/password/reset" \
-H "Accept: application/json" \
    -d "email"="doyle.michele@example.com" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user/password/reset",
    "method": "POST",
    "data": {
        "email": "doyle.michele@example.com"
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
`POST api/v1/admin/user/password/reset`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | email |  required  | 

<!-- END_12644025c84b0cfcae51a274bd988c25 -->
<!-- START_d306844a0e0ad535a93450ffbed15a63 -->
## Criar Nova Senha

Enviar dados para criar a nova senha solicitada pelo usuário

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user/password/reset/change" \
-H "Accept: application/json" \
    -d "token"="deleniti" \
    -d "email"="francisco.nitzsche@example.org" \
    -d "password"="deleniti" \
    -d "password_confirmation"="deleniti" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user/password/reset/change",
    "method": "POST",
    "data": {
        "token": "deleniti",
        "email": "francisco.nitzsche@example.org",
        "password": "deleniti",
        "password_confirmation": "deleniti"
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
`POST api/v1/admin/user/password/reset/change`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    token | string |  required  | 
    email | email |  required  | 
    password | string |  required  | Minimum: `8`
    password_confirmation | string |  required  | 

<!-- END_d306844a0e0ad535a93450ffbed15a63 -->
<!-- START_f5f22ae9e44c966f3c7e3f04151335f0 -->
## Consultar Usuários

Endpoint para consulta de usuários cadastrados

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/user`

`HEAD api/v1/admin/user`


<!-- END_f5f22ae9e44c966f3c7e3f04151335f0 -->
<!-- START_a8f2cd73f7f241bac59f75ba0b3cb4bd -->
## Cadastrar Usuário

Endpoint para cadastrar página usuário

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user" \
-H "Accept: application/json" \
    -d "name"="odit" \
    -d "email"="nikolaus.omari@example.com" \
    -d "email_confirmation"="nikolaus.omari@example.com" \
    -d "email_alternativo"="nikolaus.omari@example.com" \
    -d "password"="odit" \
    -d "password_confirmation"="odit" \
    -d "sexo"="odit" \
    -d "imagem"="odit" \
    -d "chk_newsletter"="1" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user",
    "method": "POST",
    "data": {
        "name": "odit",
        "email": "nikolaus.omari@example.com",
        "email_confirmation": "nikolaus.omari@example.com",
        "email_alternativo": "nikolaus.omari@example.com",
        "password": "odit",
        "password_confirmation": "odit",
        "sexo": "odit",
        "imagem": "odit",
        "chk_newsletter": true
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
`POST api/v1/admin/user`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Minimum: `2`
    email | email |  required  | 
    email_confirmation | email |  required  | 
    email_alternativo | email |  optional  | 
    password | string |  required  | Minimum: `8`
    password_confirmation | string |  required  | 
    sexo | string |  required  | 
    imagem | string |  optional  | Allowed mime types: `jpg`, `jpeg`, `bmp` or `png`
    chk_newsletter | boolean |  required  | 

<!-- END_a8f2cd73f7f241bac59f75ba0b3cb4bd -->
<!-- START_fc0a1657760526f0d0ae3e27f3841175 -->
## Consultar Usuário por ID

Endpoint para consultar usuário passando o ID como parametro

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user/{user}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user/{user}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/admin/user/{user}`

`HEAD api/v1/admin/user/{user}`


<!-- END_fc0a1657760526f0d0ae3e27f3841175 -->
<!-- START_c71eaa496598da79351787e83c914857 -->
## Alterar Usuário por ID

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user/{user}" \
-H "Accept: application/json" \
    -d "name"="aperiam" \
    -d "email"="hirthe.kaley@example.net" \
    -d "email_confirmation"="hirthe.kaley@example.net" \
    -d "email_alternativo"="hirthe.kaley@example.net" \
    -d "password"="aperiam" \
    -d "password_confirmation"="aperiam" \
    -d "sexo"="aperiam" \
    -d "imagem"="aperiam" \
    -d "chk_newsletter"="1" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user/{user}",
    "method": "PUT",
    "data": {
        "name": "aperiam",
        "email": "hirthe.kaley@example.net",
        "email_confirmation": "hirthe.kaley@example.net",
        "email_alternativo": "hirthe.kaley@example.net",
        "password": "aperiam",
        "password_confirmation": "aperiam",
        "sexo": "aperiam",
        "imagem": "aperiam",
        "chk_newsletter": true
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
`PUT api/v1/admin/user/{user}`

`PATCH api/v1/admin/user/{user}`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Minimum: `2`
    email | email |  required  | 
    email_confirmation | email |  required  | 
    email_alternativo | email |  optional  | 
    password | string |  required  | Minimum: `8`
    password_confirmation | string |  required  | 
    sexo | string |  required  | 
    imagem | string |  optional  | Allowed mime types: `jpg`, `jpeg`, `bmp` or `png`
    chk_newsletter | boolean |  required  | 

<!-- END_c71eaa496598da79351787e83c914857 -->
<!-- START_39030d4123dd93a737e9138267bccff9 -->
## Deletar Usuário

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user/{user}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user/{user}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/admin/user/{user}`


<!-- END_39030d4123dd93a737e9138267bccff9 -->
<!-- START_18c0daaa944277731d963421fa03222e -->
## Alterar Imagem Usuário logado

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user/alterar_imagem" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user/alterar_imagem",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/admin/user/alterar_imagem`


<!-- END_18c0daaa944277731d963421fa03222e -->
<!-- START_74bafbfc9f0c8de5b39ff70fb1c92f01 -->
## Alterar Imagem Administrativo

> Example request:

```bash
curl "http://localhost:8000/api/v1/admin/user/alterar_imagem_admin/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/admin/user/alterar_imagem_admin/{id}",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/admin/user/alterar_imagem_admin/{id}`


<!-- END_74bafbfc9f0c8de5b39ff70fb1c92f01 -->
#API Usuário - Frontend

Essa API é responsável pelo gerenciamento de Usuários no portal qImob.
Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
<!-- START_88b3c3f6ff8e5ad60333c8c566fd3a5b -->
## Consultar Perfil Usuário

Endpoint para consultar perfil do usuário passando o ID como parametro

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/user/perfil" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/user/perfil",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/front/user/perfil`

`HEAD api/v1/front/user/perfil`


<!-- END_88b3c3f6ff8e5ad60333c8c566fd3a5b -->
<!-- START_b9f88368d38464eaead1aeff2b56b4b8 -->
## Alterar Imagem Anunciante logado

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/user/alterar_imagem" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/user/alterar_imagem",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/front/user/alterar_imagem`


<!-- END_b9f88368d38464eaead1aeff2b56b4b8 -->
<!-- START_8bd10fb95bd577211a7fd4a183a2bbc3 -->
## Alterar Senha

Enviar dados para alterar a senha

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/user/password/change" \
-H "Accept: application/json" \
    -d "old_password"="doloremque" \
    -d "new_password"="doloremque" \
    -d "new_password_confirmation"="doloremque" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/user/password/change",
    "method": "PATCH",
    "data": {
        "old_password": "doloremque",
        "new_password": "doloremque",
        "new_password_confirmation": "doloremque"
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
`PATCH api/v1/front/user/password/change`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    old_password | string |  required  | 
    new_password | string |  required  | Minimum: `8`
    new_password_confirmation | string |  required  | 

<!-- END_8bd10fb95bd577211a7fd4a183a2bbc3 -->
<!-- START_92a4e91df78f75c83aa0d15fbafa0f07 -->
## Cadastrar Anunciante

Endpoint para cadastrar página Anunciante

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/user/registrar" \
-H "Accept: application/json" \
    -d "name"="quae" \
    -d "email"="bednar.yasmine@example.com" \
    -d "email_confirmation"="bednar.yasmine@example.com" \
    -d "email_alternativo"="bednar.yasmine@example.com" \
    -d "password"="quae" \
    -d "password_confirmation"="quae" \
    -d "sexo"="quae" \
    -d "imagem"="quae" \
    -d "chk_newsletter"="1" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/user/registrar",
    "method": "POST",
    "data": {
        "name": "quae",
        "email": "bednar.yasmine@example.com",
        "email_confirmation": "bednar.yasmine@example.com",
        "email_alternativo": "bednar.yasmine@example.com",
        "password": "quae",
        "password_confirmation": "quae",
        "sexo": "quae",
        "imagem": "quae",
        "chk_newsletter": true
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
`POST api/v1/front/user/registrar`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Minimum: `2`
    email | email |  required  | 
    email_confirmation | email |  required  | 
    email_alternativo | email |  optional  | 
    password | string |  required  | Minimum: `8`
    password_confirmation | string |  required  | 
    sexo | string |  required  | 
    imagem | string |  optional  | Allowed mime types: `jpg`, `jpeg`, `bmp` or `png`
    chk_newsletter | boolean |  required  | 

<!-- END_92a4e91df78f75c83aa0d15fbafa0f07 -->
<!-- START_1b5885f19c805758488ca08b2677d6e0 -->
## Solicitar Nova Senha

Enviar email com link para Anunciante recuperar senha

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/user/password/reset" \
-H "Accept: application/json" \
    -d "email"="cummings.nyasia@example.com" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/user/password/reset",
    "method": "POST",
    "data": {
        "email": "cummings.nyasia@example.com"
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
`POST api/v1/front/user/password/reset`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | email |  required  | 

<!-- END_1b5885f19c805758488ca08b2677d6e0 -->
<!-- START_1821cba24c89c339d3f8564e16fd53af -->
## Criar Nova Senha

Enviar dados para criar a nova senha solicitada pelo Anunciante

> Example request:

```bash
curl "http://localhost:8000/api/v1/front/user/password/reset/change" \
-H "Accept: application/json" \
    -d "token"="qui" \
    -d "email"="kenyon.haag@example.com" \
    -d "password"="qui" \
    -d "password_confirmation"="qui" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/front/user/password/reset/change",
    "method": "POST",
    "data": {
        "token": "qui",
        "email": "kenyon.haag@example.com",
        "password": "qui",
        "password_confirmation": "qui"
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
`POST api/v1/front/user/password/reset/change`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    token | string |  required  | 
    email | email |  required  | 
    password | string |  required  | Minimum: `8`
    password_confirmation | string |  required  | 

<!-- END_1821cba24c89c339d3f8564e16fd53af -->
#general
<!-- START_d298d929f54b176615acf9017a72d25a -->
## Authorize a client to access the user&#039;s account.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/authorize" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/authorize",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "unsupported_grant_type",
    "message": "The authorization grant type is not supported by the authorization server.",
    "hint": "Check the `grant_type` parameter"
}
```

### HTTP Request
`GET api/v1/oauth/authorize`

`HEAD api/v1/oauth/authorize`


<!-- END_d298d929f54b176615acf9017a72d25a -->
<!-- START_6b403095ecffdbbf500e4223269d0984 -->
## Approve the authorization request.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/authorize" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/authorize",
    "method": "POST",
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


<!-- END_6b403095ecffdbbf500e4223269d0984 -->
<!-- START_2b99f43bcd080588f98474ee696ace74 -->
## Deny the authorization request.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/authorize" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/authorize",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/oauth/authorize`


<!-- END_2b99f43bcd080588f98474ee696ace74 -->
<!-- START_082270de255b970cfc68ebc1ca1261c7 -->
## Authorize a client to access the user&#039;s account.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/token" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/token",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/oauth/token`


<!-- END_082270de255b970cfc68ebc1ca1261c7 -->
<!-- START_f7c889d2010652778bba402c86821bed -->
## Get all of the authorized tokens for the authenticated user.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/tokens" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/tokens",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/oauth/tokens`

`HEAD api/v1/oauth/tokens`


<!-- END_f7c889d2010652778bba402c86821bed -->
<!-- START_4e1d8ca8cf7990aa05930bdaf2b73a9a -->
## Delete the given token.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/tokens/{token_id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/tokens/{token_id}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/oauth/tokens/{token_id}`


<!-- END_4e1d8ca8cf7990aa05930bdaf2b73a9a -->
<!-- START_30389561b7c7ec6b1f6a55aa378412b3 -->
## Get a fresh transient token cookie for the authenticated user.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/token/refresh" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/token/refresh",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/oauth/token/refresh`


<!-- END_30389561b7c7ec6b1f6a55aa378412b3 -->
<!-- START_a75109045a9890deba4290040b3702b8 -->
## Get all of the clients for the authenticated user.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/clients" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/clients",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/oauth/clients`

`HEAD api/v1/oauth/clients`


<!-- END_a75109045a9890deba4290040b3702b8 -->
<!-- START_70b60149da1587bf078ad3a8505f4b54 -->
## Store a new client.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/clients" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/clients",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/oauth/clients`


<!-- END_70b60149da1587bf078ad3a8505f4b54 -->
<!-- START_c1b686a35009ac85fab096e598f5c4b3 -->
## Update the given client.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/clients/{client_id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/clients/{client_id}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/oauth/clients/{client_id}`


<!-- END_c1b686a35009ac85fab096e598f5c4b3 -->
<!-- START_9cbd37fbef6fa18e0630d9613222a7a7 -->
## Delete the given client.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/clients/{client_id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/clients/{client_id}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/oauth/clients/{client_id}`


<!-- END_9cbd37fbef6fa18e0630d9613222a7a7 -->
<!-- START_1ee5ecce1140d3351636eeb52d07977b -->
## Get all of the available scopes for the application.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/scopes" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/scopes",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/oauth/scopes`

`HEAD api/v1/oauth/scopes`


<!-- END_1ee5ecce1140d3351636eeb52d07977b -->
<!-- START_c48387272661e6169062399666856bc0 -->
## Get all of the personal access tokens for the authenticated user.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/personal-access-tokens" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/personal-access-tokens",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET api/v1/oauth/personal-access-tokens`

`HEAD api/v1/oauth/personal-access-tokens`


<!-- END_c48387272661e6169062399666856bc0 -->
<!-- START_daadea0d7a284c73cbae122ca9c9b1a4 -->
## Create a new personal access token for the user.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/personal-access-tokens" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/personal-access-tokens",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/oauth/personal-access-tokens`


<!-- END_daadea0d7a284c73cbae122ca9c9b1a4 -->
<!-- START_04ccd4592f8f76c24fb02ebdec805ce2 -->
## Delete the given token.

> Example request:

```bash
curl "http://localhost:8000/api/v1/oauth/personal-access-tokens/{token_id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/oauth/personal-access-tokens/{token_id}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/oauth/personal-access-tokens/{token_id}`


<!-- END_04ccd4592f8f76c24fb02ebdec805ce2 -->
