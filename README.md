# App Financeiro Simples

Este é o repositório do **App Financeiro Simples**, um MVP focado no controle de receitas e despesas por competência mensal.

## Tecnologias

- **Backend**: PHP 8.x (Puro, sem frameworks)
- **Banco de Dados**: MySQL 8.x
- **Frontend**: HTML, JS, Tailwind CSS, TailAdmin (Layout Administrativo)
- **Infraestrutura**: Docker & Docker Compose

## Como rodar o projeto localmente

1. Certifique-se de ter o Docker e o Docker Compose instalados.
2. Clone o repositório.
3. Suba o ambiente com o comando:
   ```bash
   docker compose up -d --build
   ```
4. Acesse a aplicação no navegador:
   [http://localhost:8000](http://localhost:8000)

## Acesso Inicial (Seed)

Um usuário administrador padrão é criado automaticamente pelo processo de seed do banco de dados.

- **Usuário**: `admin`
- **Senha**: `password`

## Estrutura de Diretórios

- `/app`: Lógica da aplicação (Controllers, Models, Services, Views, etc)
- `/public`: Raiz do servidor web (index.php, assets)
- `/database`: Scripts SQL para schema e seed
- `/docker`: Configurações das imagens Docker (Nginx, PHP)
- `/docs`: Documentação técnica e de negócio do projeto

## Próximos Passos (Fases de Implementação)

Consulte o documento `docs/15_plano_de_implementacao_app_financeiro.md` para visualizar o cronograma e andamento das fases.