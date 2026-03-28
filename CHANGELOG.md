# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 2026-03-28

### Added
- Gráfico interativo de projeção financeira (12 meses) no Dashboard, exibindo saldos Previsto vs. Realizado.
- Método `getChartData` no `DashboardRepository` para agregar os dados mês a mês.
- Integração da biblioteca ApexCharts via CDN para renderização dos gráficos na view do Dashboard.
- Arquivos de documentação técnica: `ARCHITECTURE.md` e `CHANGELOG.md`.

### Changed
- Atualização do `README.md` com instruções e descrições mais detalhadas do projeto.
- Atualização do `DashboardController` para processar e enviar os dados dinâmicos do gráfico para a View.

## [1.0.0] - 2026-03-01

### Added
- Estrutura inicial do MVP em PHP Puro com arquitetura MVC.
- Ambiente de desenvolvimento conteinerizado com Docker e Docker Compose (Nginx, PHP-FPM, MySQL).
- Layout administrativo responsivo utilizando Tailwind CSS e inspirado no TailAdmin.
- Gestão de Categorias (Criação, listagem, edição, exclusão).
- Gestão de Lançamentos Financeiros (Receitas e Despesas) por competência mensal.
- Suporte a status de pagamento de lançamentos (Pendente/Pago).
- Funcionalidade básica de lançamentos recorrentes.
- Dashboard inicial com resumo financeiro do mês (Receitas, Despesas e Saldo).
- Script de seed inicial para banco de dados (Usuário Administrador padrão).