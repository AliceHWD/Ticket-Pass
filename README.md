# TicketPass
O projeto consiste em um sistema de venda e compra de ingressos para eventos diversos, com ambas as ações feitas pelos usuários. Qualquer usuário pode ser vendedor ou comprador e também negociar os valores entre eles.

## Participantes
● Alice Oliveira - 22302182
● Antônio Mário - 22300520
● Matheus Cavalieri - 22301925
● Samuel Chaves - 22302379
● Mariana Roque - 22302360
● Maurício Miranda - 22300813

## Como rodar o projeto
- PHP 8.1+  
- Composer  
- MySQL  
- Node.js + NPM (opcional para frontend)
- Arquivo .env configurado corretamente
- As variáveis do banco de dados são:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ticketpass
    DB_USERNAME=usuario
    DB_PASSWORD=
- Se atentar a rodar as migrations corretamente

## Soluções desenvolvidas - 01/09
● Login
● Cadastro
● Autenticação
● Página do usuário puxando seus dados
● Update dos dados do usuário
● Deletar dados do usuário
● Listagem dos ingressos na página inicial
● Visualização dos dados do ingresso selecionado
● Sistema de busca por ingressos
● Filtros de ingressos
● Encerrar sessão

## Organização do projeto
O projeto está organizado no padrão MVC (Models, Views e Controllers), dessa maneira seguindo o padrão que é majoritariamente utilizado no mercado de programação e sendo o mais prático de se trabalhar com. O padrão consiste nos seguintes conceitos:

**Model:** é a parte responsável pela lógica dos dados da aplicação. Ele representa os dados em si e as regras de negócio. Tudo que envolve criar, ler, atualizar ou deletar dados acontece aqui. O Model também é responsável por se comunicar com o banco de dados ou outras fontes de informação.

**View:** é a interface com o usuário, ou seja, tudo o que o usuário vê e interage. A View exibe os dados que o Model fornece e envia para o Controller as ações do usuário, como cliques ou formulários preenchidos. Ela não deve conter lógica de negócio, apenas a apresentação dos dados.

**Controller:** atua como intermediário entre o Model e a View. Ele recebe as entradas do usuário (vinda da View), processa essas ações (com a ajuda do Model, se necessário), e então decide qual resposta dar — geralmente atualizando a View. O Controller é onde a lógica de controle da aplicação é centralizada.

A seguir a organização do projeto em um diagrama de classes.
<img width="1050" height="602" alt="Captura de tela 2025-08-17 085333" src="https://github.com/user-attachments/assets/8dc26d2e-0e41-4b77-a7cf-71446ccd6976" />
