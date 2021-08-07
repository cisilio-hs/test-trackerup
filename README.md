
# Tarefa

Crie uma aplicação *REST API* em *PHP* que forneça endpoints para *inclusão*, *alteração*, *exclusão*, *consulta* e *listagem* de **peças**.
Dentre os *atributos* das peças estão sua **categoria** e seu **identificador** único, *informado manualmente durante a inclusão*.
A consulta pode ser *realizada pelo* ***identificador*** e a *listagem pode ser filtrada por* ***categorias***.
Sua API deve *realizar apenas exclusões lógicas* dos dados, nunca exclusões físicas.
Desejável a implementação de um frontend para exibição da listagem.

# Modelo
## Peça
### Campos
- __**id**__: campo de identificação do BD
- __**codigo**__: campo único e obrigatório informado na criação
- __**categoria**__: campo obrigatório informado na criação
- __**nome**__: campo string, pode ser nulo
- __**descricao**__: campo texto, pode ser nulo
- __**created_at**__: campo do Laravel para data de criação
- __**updated_at**__: campo do Laravel para data de edição
- __**deleted_at**__: campo do Laravel para tratamento do *soft delete*

### Comentário
Foi requisitado apenas os campos *identificador* e *categoria*, porém não seria trivial a manutenção das informações sem um campo em texto livre pra que o usuário possa identificar corretamente da item, então foram adicionados os campos *nome* e *descricao*; os campos foram adicionas como nullable, podendo não ser utilizado caso não seja necessário.

Devido a boas práticas e afim de evitar insersão do usuário em uma *chave primária*  o campo ID foi mantido e foi criado o campo *codigo*.

O campo *categoria* também foi requisitado como editável via API de peças, o campo foi criado como texto, porém o ideal seria que esse campo fosse outra tabela com o celacionamento com a tabela de peças.


# Inicialização
A aplicação foi construida utilizado Docker fornecido pelo Laravel Sail.
Dentro da pasta do projeto rodar o comando de inicialização para subir os containers:
`./vendor/bin/sail up -d`

Rodar o comando de atualização do NPM:
`./vendor/bin/sail npm i`

Rodar as migrations:
`./vendor/bin/sail php artisan migrate --step`

Para parar os contnainers utilize o comando:
`./vendor/bin/sail down`


# API
### Authenticação
Foi utilizado o *jetstream* e o *sanctum* para proteção das rotas.
Foi adicionado parâmetro **API_AUTH** no arquivo *.env* . Caso seja definido como *true* será necessário passar o token de autenticação no cabeçalho da requisição; caso seja definido como *false* as rotas da API aceitará qualquer requisição e o token não será necessário.
O token deve ser criado após o registro do usuário, no canto superior direito, no menu *API Tokens*.

Ex: *API_AUTH=false*
```
curl --location --request GET 'http://localhost/api/pecas' \
```

Ex: *API_AUTH=true*
```
curl --location --request GET 'http://localhost/api/pecas' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```


### Lista
URL: /api/pecas
Metodo: GET
Parametros: categoria

Ex: 
```
curl --location --request GET 'http://localhost/api/pecas' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Lista todas as peças

Ex: 
```
curl --location --request GET 'http://localhost/api/pecas?categoria=teste' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Lista as peças da categoria *teste*

Dependendo da quantidade de registros a lista poderia ser paginada.


### Consulta
URL: /api/pecas/{peca_id}
Metodo: GET
Ex: 
```
curl --location --request GET 'http://localhost/api/pecas/1' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Consulta da peça com ID *1*

URL: /api/pecas/{peca_codigo}/codigo
Metodo: GET
Ex: 
```
curl --location --request GET 'http://localhost/api/pecas/teste/codigo' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Consulta da peça com Código *'teste'*

### Criar
URL: /api/pecas
Metodo: POST

Ex:
```
curl --location --request POST 'http://localhost/api/pecas' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk' \
--form 'codigo="teste codigo"' \
--form 'categoria="teste categoria"' \
--form 'nome="test nome"' \
--form 'descricao="teste descrição"'
```

Cadastra uma Peça, os campos *nome* e *descricao* não são obrigatórios e podem ser omitidos.

### Editar
URL: /api/pecas/{peca_id}
Metodo: POST

Ex:
```
curl --location --request POST 'http://localhost/api/pecas/1' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk' \
--form 'codigo="novo codigo teste"' \
--form 'categoria="nova categoria teste"' \
--form 'nome="Novo nome teste"' \
--form 'descricao="nova descricao teste"'
```

Edita Peça com ID *1*, não há campos obrigatórios, os campos não informados não serão alterados.


URL: /api/pecas/{peca_codigo}/codigo
Metodo: POST

Ex:
```
curl --location --request POST 'http://localhost/api/pecas/teste/codigo' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk' \
--form 'codigo="novo codigo teste"' \
--form 'categoria="nova categoria teste"' \
--form 'nome="Novo nome teste"' \
--form 'descricao="nova descricao teste"'
```

Edita Peça com Codigo *teste*, não há campos obrigatórios, os campos não informados não serão alterados.


#### Deletar
URL: /api/pecas/{peca_id}
Metodo: DELETE

Ex:
```
curl --location --request DELETE 'http://localhost/api/pecas/1' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Deleta a Peça com ID *1*.

URL: /api/pecas/{peca_codigo}/codigo
Metodo: DELETE

Ex:
```
curl --location --request DELETE 'http://localhost/api/pecas/teste/codigo' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Deleta a Peça com Codigo *teste*.


#### Listar Excluidos
URL: /api/trash/pecas
Metodo: GET
Parametros: categoria

Ex: 
```
curl --location --request GET 'http://localhost/api/trash/pecas' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Lista todas as peças excluidas.

Ex: 
```
curl --location --request GET 'http://localhost/api/trash/pecas?categoria=teste' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Lista as peças excluidas da categoria *teste*.

Dependendo da quantidade de registros a lista poderia ser paginada.

#### Restaurar
URL: /api/trash/pecas/{peca_id}/restore
Metodo: POST

Ex:
```
curl --location --request POST 'http://localhost/api/trash/pecas/1/restore' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Restaura a Peça Excluída com ID *1*.

URL: /api/pecas/{peca_codigo}/codigo/restore
Metodo: POST

Ex:
```
curl --location --request POST 'http://localhost/api/trash/pecas/teste/codigo/restore' \
--header 'Authorization: Bearer 9kHosKJtaWWTzCYPoa7QiDCFiy59uuj7GDUBmomk'
```

Restaura a Peça Excluída com Codigo *teste*.



# Tela
Ex: 'http://localhost/pecas'
Foi adicionada tela em '/pecas' utilizando o *Vue* e o *Inertia*. 
Funcionalidades:
- listar
- filtrar por categoria
- cadastrar
- editar
- excluir

Não pude realizar as tratativas das validações, por exemplo caso seja enviado formulário de cadastro sem o *código* ou sem a *categoria*.
Também não pude ajustar a responsividade do layout.

