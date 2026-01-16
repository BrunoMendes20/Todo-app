# 📝 Todo App – Laravel + JavaScript Puro

Aplicação de gerenciamento de tarefas desenvolvida com **Laravel** no backend e **JavaScript puro** no frontend, com foco em **fundamentos**, **boas práticas** e **interações sem recarregamento de página**.

O projeto simula um sistema real, com autenticação e CRUD completo.

---

## 🚀 Funcionalidades

### 🔐 Autenticação

-   Cadastro de usuários
-   Login
-   Logout
-   Proteção de rotas
-   Cada usuário acessa apenas suas próprias tarefas

### ✅ Tarefas (CRUD)

-   Criar tarefas
-   Listar tarefas
-   Editar tarefas
-   Remover tarefas (Soft Delete)
-   Marcar tarefa como concluída
-   Estado visual para tarefas finalizadas

### 🔎 Busca e Filtro

-   Busca por título em tempo real
-   Filtro por status:
    -   Todas
    -   Concluídas
    -   A fazer

### ⚡ Experiência do Usuário

-   Operações via **AJAX (Fetch API)**
-   Sem recarregar a página
-   Feedback visual para erros
-   Mensagens reutilizáveis com auto-close
-   Formulários de criação e edição alternados dinamicamente

---

## 🧠 Destaques Técnicos

-   **JavaScript puro**
    -   Event delegation
    -   Manipulação de DOM
    -   Controle de estado no frontend
-   **Laravel**
    -   Validação backend
    -   Soft Delete (`SoftDeletes`)
    -   Relacionamentos Eloquent
    -   Proteção com `Auth`
-   **Arquitetura**
    -   Separação de responsabilidades
    -   `tasks.js` focado em regras de negócio
    -   `messages.js` responsável apenas por feedback visual
-   **Validação dupla**
    -   Frontend (UX)
    -   Backend (segurança)

---

## 🛠️ Tecnologias Utilizadas

-   PHP 8+
-   Laravel
-   Blade
-   JavaScript (ES6+)
-   Fetch API
-   MySQL
-   HTML5 / CSS3
-   Bootstrap
-   Fontawesome

---

## 📂 Estrutura Geral

resources/
├─ views/
│ ├─ auth/
│ ├─ tasks/
│ └─ layouts/
└─ js/
├─ tasks.js
└─ messages.js

app/
├─ Models/
│ └─ Task.php
└─ Http/
└─ Controllers/

🧪 Comportamentos Implementados

● Impede criação/edição de tarefas vazias

● Validação de mínimo de caracteres

● Mensagens de erro sem alert()

● Auto fechamento de mensagens

● Sincronização entre frontend e backend

🎯 Objetivo do Projeto

● Este projeto foi desenvolvido com foco em aprendizado prático, reforçando:

● Fundamentos de Laravel

● Fundamentos de JavaScript

● Integração frontend + backend

● Boas práticas de organização

● Comportamento de aplicações reais

📌 Observações

● O projeto não utiliza frameworks JS propositalmente

● O foco está em compreender o funcionamento do DOM, HTTP e validações

● Ideal como projeto de estudo e portfólio inicial

👤 Autor

Desenvolvido por Bruno Mendes
