TicketPass
O projeto consiste em um sistema de venda e compra de ingressos para eventos diversos, com ambas as ações feitas pelos usuários. Qualquer usuário pode ser vendedor ou comprador e também negociar os valores entre eles.

Participantes
● Alice Oliveira - 22302182 ● Antônio Mário - 22300520 ● Matheus Cavalieri - 22301925 ● Samuel Chaves - 22302379 ● Mariana Roque - 22302360 ● Maurício Miranda - 22300813

Como rodar o projeto
PHP 8.1+
Composer
MySQL
Node.js + NPM 

Comandos:
npm install
composer install

Arquivo .env configurado corretamente
As variáveis do banco de dados são: DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=ticketpass DB_USERNAME=usuario DB_PASSWORD=

Se atentar a rodar as migrations corretamente com o comando:
php artisan migrate

Soluções desenvolvidas - 01/09
● Login ● Cadastro ● Autenticação ● Página do usuário puxando seus dados ● Update dos dados do usuário ● Deletar dados do usuário ● Listagem dos ingressos na página inicial ● Visualização dos dados do ingresso selecionado ● Sistema de busca por ingressos ● Filtros de ingressos ● Encerrar sessão ● Verificação do tipo de usuário anunciar ingressos ● Cadastro de ingressos ● Cadastro de vendedor ● Mostrar os ingressos disponíveis para determinado evento ● Página do vendedor com seus ingressos ● Adicionar ítens no carrinho ● Finalização de compra ● Fazer cálculos de taxa ● Finalizar pedido

Organização do projeto
O projeto está organizado no padrão MVC (Models, Views e Controllers), dessa maneira seguindo o padrão que é majoritariamente utilizado no mercado de programação e sendo o mais prático de se trabalhar com. O padrão consiste nos seguintes conceitos:

Model: é a parte responsável pela lógica dos dados da aplicação. Ele representa os dados em si e as regras de negócio. Tudo que envolve criar, ler, atualizar ou deletar dados acontece aqui. O Model também é responsável por se comunicar com o banco de dados ou outras fontes de informação.

View: é a interface com o usuário, ou seja, tudo o que o usuário vê e interage. A View exibe os dados que o Model fornece e envia para o Controller as ações do usuário, como cliques ou formulários preenchidos. Ela não deve conter lógica de negócio, apenas a apresentação dos dados.

Controller: atua como intermediário entre o Model e a View. Ele recebe as entradas do usuário (vinda da View), processa essas ações (com a ajuda do Model, se necessário), e então decide qual resposta dar — geralmente atualizando a View. O Controller é onde a lógica de controle da aplicação é centralizada.

Design Pattern
Os padrões de projeto Composite, Decorator e Facade foram implementados com o objetivo de desenvolver um sistema de busca robusto, modular e de fácil manutenção.

O padrão Composite permite a combinação flexível de múltiplos filtros, tornando possível aplicar diferentes critérios de busca de forma dinâmica.
O padrão Decorator adiciona novas funcionalidades aos filtros existentes sem alterar sua estrutura base, garantindo extensibilidade e reutilização de código.
Por fim, o padrão Facade atua como uma interface simplificada que centraliza as interações entre os componentes de busca, facilitando o uso e a integração com o restante do sistema.

Essa arquitetura garante alta coesão, baixo acoplamento e um fluxo de busca otimizado.

🔹 Estrutura de pastas:
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


A seguir a organização do projeto em um diagrama de classes. Captura de tela 2025-08-17 085333
