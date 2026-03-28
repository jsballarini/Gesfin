# Arquitetura do Projeto (Gesfin)

Este documento descreve as decisões arquiteturais, padrões de design e a estrutura geral do **App Financeiro Simples (Gesfin)**.

## Padrão Arquitetural: MVC (Model-View-Controller)

O projeto adota o padrão **MVC** implementado em **PHP Puro**, sem a dependência de frameworks robustos (como Laravel ou Symfony). Isso garante que o MVP seja leve, de fácil manutenção e sirva como uma base de estudo ou de rápida evolução.

- **Models**: Representam as entidades do domínio de negócio (ex: `Category`, `Entry`, `User`). Geralmente são classes simples de dados (DTOs) ou encapsulam lógicas puras de negócio.
- **Views**: Arquivos `.php` que mesclam HTML com PHP para renderizar a interface de usuário. Utilizam templates (como `layouts/main.php`) para evitar duplicação de código HTML.
- **Controllers**: Recebem as requisições HTTP (via roteador central no `public/index.php`), interagem com os Repositories/Services e retornam a View apropriada ou respostas JSON.

## Padrão de Acesso a Dados: Repository Pattern

Para isolar a lógica de acesso a banco de dados (MySQL) dos Controllers, adotamos o **Repository Pattern**.
- Cada entidade principal possui um repositório (ex: `EntryRepository`, `DashboardRepository`).
- Os repositórios encapsulam as queries SQL (utilizando PDO) e retornam arrays associativos ou objetos Model.
- Isso facilita a testabilidade e a eventual troca de banco de dados ou refatoração de queries.

## Frontend e UI

- **TailAdmin e Tailwind CSS**: O layout administrativo baseia-se no template TailAdmin, que utiliza Tailwind CSS para uma estilização utilitária, garantindo um design responsivo e moderno.
- **Componentização Simples**: Views parciais são carregadas via `require_once` no PHP (ex: `_content.php`, `sidebar.php`, `header.php`) para promover o reuso de código no frontend.
- **ApexCharts**: Biblioteca utilizada para a renderização de gráficos complexos, como a projeção de 12 meses (Previsto vs. Realizado). A lógica de extração de dados fica no backend (`DashboardRepository->getChartData`), que exporta via JSON para o frontend processar.

## Infraestrutura e Deploy

- **Docker**: A aplicação é completamente conteinerizada, facilitando a paridade entre desenvolvimento e produção.
- **Serviços Docker**:
  - `app`: Container PHP-FPM rodando a aplicação.
  - `web`: Servidor Nginx atuando como proxy reverso e servindo arquivos estáticos.
  - `db`: Banco de dados MySQL persistindo dados em volumes Docker.

## Qualidade de Código e Boas Práticas

- **Código Limpo e Modular**: Classes com responsabilidades únicas, métodos curtos e descritivos.
- **Evitar "Magic Numbers"**: Utilização de constantes para status de lançamentos ou configurações fixas.
- **Segurança**: Validação de inputs (via PHP e atributos HTML) e uso massivo de *Prepared Statements* via PDO para prevenir SQL Injection.