# App Financeiro Simples (Gesfin)

Este é o repositório do **App Financeiro Simples (Gesfin)**, um MVP focado no controle de receitas e despesas por competência mensal. A aplicação visa fornecer uma interface limpa e objetiva para acompanhamento financeiro, incluindo projeções de caixa e gestão de lançamentos recorrentes.

## Principais Funcionalidades

- **Dashboard Financeiro**: Visão geral de receitas, despesas e saldo mensal. Inclui gráfico interativo de 12 meses (Previsto vs. Realizado).
- **Gestão de Categorias**: Organização de entradas e saídas.
- **Lançamentos**: Registro de transações financeiras com status de pagamento (Pendente/Pago).
- **Recorrência**: Suporte a lançamentos recorrentes.
- **Controle por Competência**: Foco na visualização e organização financeira baseada no mês de competência.

*(Nota: O MVP atual não possui suporte a múltiplas contas bancárias ou múltiplos cartões de crédito.)*

## Tecnologias

- **Backend**: PHP 8.x (Puro, sem frameworks MVC pesados, utilizando arquitetura MVC customizada).
- **Banco de Dados**: MySQL 8.x
- **Frontend**: HTML, JS puro, Tailwind CSS, TailAdmin (Layout Administrativo), ApexCharts (Gráficos).
- **Infraestrutura**: Docker & Docker Compose (Nginx + PHP-FPM + MySQL).

## Como rodar o projeto localmente

1. Certifique-se de ter o Docker e o Docker Compose instalados em sua máquina.
2. Clone o repositório.
3. Suba o ambiente com o comando:
   ```bash
   docker compose up -d --build
   ```
4. Acesse a aplicação no navegador:
   [http://localhost:8000](http://localhost:8000)

## Acesso Inicial (Seed)

Um usuário administrador padrão é criado automaticamente pelo processo de seed do banco de dados na primeira execução.

- **Usuário**: `admin`
- **Senha**: `password`

## Estrutura de Diretórios

- `/app`: Lógica da aplicação (Controllers, Models, Repositories, Views).
- `/public`: Raiz do servidor web (`index.php`, arquivos estáticos e assets).
- `/database`: Scripts SQL para criação do schema e população inicial (seed).
- `/docker`: Configurações das imagens Docker (Nginx, PHP).
- `/docs`: Documentação técnica e de negócio do projeto.

## Documentação Adicional

- Para detalhes sobre a arquitetura do projeto e padrões de projeto, consulte o arquivo [ARCHITECTURE.md](ARCHITECTURE.md).
- Para o histórico de versões e atualizações, consulte o [CHANGELOG.md](CHANGELOG.md).