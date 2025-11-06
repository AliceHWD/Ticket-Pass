# TicketPass

O projeto consiste em um sistema de venda e compra de ingressos para eventos diversos, com ambas as ações feitas pelos usuários. Qualquer usuário pode ser vendedor ou comprador e também negociar os valores entre eles.

## Participantes

- Alice Oliveira - 22302182
- Antônio Mário - 22300520
- Matheus Cavalieri - 22301925
- Samuel Chaves - 22302379
- Mariana Roque - 22302360
- Maurício Miranda - 22300813

## Pré-requisitos

- PHP 8.1+
- Composer
- MySQL
- Node.js + NPM

## Como rodar o projeto

1. Execute os comandos:
```bash
npm install
composer install
npm run dev
```

2. Configure o arquivo `.env` corretamente com as variáveis do banco de dados:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticketpass
DB_USERNAME=usuario
DB_PASSWORD=
```

3. Execute as migrations:
```bash
php artisan migrate
```

## Soluções desenvolvidas - 01/09

- Login
- Cadastro
- Autenticação
- Página do usuário puxando seus dados
- Update dos dados do usuário
- Deletar dados do usuário
- Listagem dos ingressos na página inicial
- Visualização dos dados do ingresso selecionado
- Sistema de busca por ingressos
- Filtros de ingressos
- Encerrar sessão
- Verificação do tipo de usuário anunciar ingressos
- Cadastro de ingressos
- Cadastro de vendedor
- Mostrar os ingressos disponíveis para determinado evento
- Página do vendedor com seus ingressos
- Adicionar ítens no carrinho
- Finalização de compra
- Fazer cálculos de taxa
- Finalizar pedido

## Organização do projeto

O projeto está organizado no padrão MVC (Models, Views e Controllers), seguindo o padrão majoritariamente utilizado no mercado de programação.

### Conceitos do MVC:

- **Model**: Responsável pela lógica dos dados da aplicação. Representa os dados em si e as regras de negócio. Tudo que envolve criar, ler, atualizar ou deletar dados acontece aqui. Comunica-se com o banco de dados.

- **View**: Interface com o usuário, exibe os dados que o Model fornece e envia para o Controller as ações do usuário. Não contém lógica de negócio, apenas apresentação dos dados.

- **Controller**: Atua como intermediário entre o Model e a View. Recebe as entradas do usuário, processa essas ações e decide qual resposta dar — geralmente atualizando a View.

## Design Pattern

Os padrões de projeto **Composite**, **Decorator** e **Facade** foram implementados com o objetivo de desenvolver um sistema de busca robusto, modular e de fácil manutenção.

- **Composite**: Permite a combinação flexível de múltiplos filtros, tornando possível aplicar diferentes critérios de busca de forma dinâmica.
- **Decorator**: Adiciona novas funcionalidades aos filtros existentes sem alterar sua estrutura base, garantindo extensibilidade e reutilização de código.
- **Facade**: Atua como uma interface simplificada que centraliza as interações entre os componentes de busca, facilitando o uso e a integração com o restante do sistema.

Essa arquitetura garante alta coesão, baixo acoplamento e um fluxo de busca otimizado.

### 🔹 Estrutura de pastas:

```
app/
├── Http/
│   └── Controllers/
│       └── SearchController.php
│
├── Services/
│   └── Search/
│       ├── FilterCategoriaDecorator.php
│       ├── FilterDataDecorator.php
│       ├── FilterDecorator.php
│       ├── FilterLocalizacaoDecorator.php
│       ├── FilterPrecoDecorator.php
│       ├── IFilter.php
│       └── SearchFilterAdapter.php
```

## Diagrama de Classes

<img width="825" height="554" alt="image" src="https://github.com/user-attachments/assets/75ebb7b7-5e82-43ec-a0a8-09258a7ab7f9" />

