# 🛡️ API RESTful com Autenticação JWT em PHP (MVC)

[![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)
[![Status](https://img.shields.io/badge/status-em%20desenvolvimento-yellow)]()
[![Author](https://img.shields.io/badge/autor-Mihguel%20Silva-blueviolet)](https://github.com/mihguelsilva)

> Projeto backend em PHP estruturado com MVC, rotas personalizadas, autenticação segura com JWT e proteção de rotas com middleware.

---

## ✨ Funcionalidades

- ✅ Estrutura MVC modular e organizada
- ✅ Geração e validação de tokens JWT
- ✅ Autenticação segura de usuários
- ✅ Manipulação de requisições via JSON e `x-www-form-urlencoded`
- ✅ Sanitização e validação de entrada (anti-XSS, anti-injeção)
- ✅ Arquitetura flexível, preparada para evolução e testes

## 🛡️ Segurança Aplicada

- 🔒 Filtro contra XSS via classe `Sanitize`
- 🔒 Validação avançada via classe `Validator`
- 🔒 Suporte para filtros por tipo (`email`, `integer`, `min`, `max`, etc.)
- 🔒 Preparação para evitar SQL Injection
- 🔒 Separação de rotas entre API e HTML

## ⚙️ Tecnologias e Padrões

- 🧩 PHP 8.2+
- 🗂️ MVC Puro
- 📦 PSR-4 (autoload via Composer)
- 🪝 JWT Authentication
- 📄 application/json e application/x-www-form-urlencoded
- 🧪 Arquitetura testável e extensível

---

## 🧱 Estrutura do Projeto

```plaintext
App/
│
├── Core/            # Classes base (Request, Response, Router, Validator, etc.)
├── Controllers/     # Controladores da aplicação
├── Models/          # Modelos de dados
├── Views/           # Páginas HTML (se aplicável)
├── Middlewares/     # (Em breve)
└── public/          # Ponto de entrada (index.php)

```

---

## 🧪 Como testar a API

### 🔐 Login para obter o token

```bash
curl -X POST http://seu-dominio/login \
-H "Content-Type: application/json" \
-d '{"email": "usuario@example.com", "senha": "senha"}'
```

### 📡 Acessar rota protegida /admin
```bash
curl -X GET http://seu-dominio/admin \
-H "Content-Type: application/json" \
-H "Authorization: Bearer SEU_TOKEN_AQUI"
```

## 🔐 Segurança

-Tokens JWT com expiração 
- Validação de token via middleware personalizado
- .env para separar dados sensíveis
- Arquitetura desacoplada e testável

## 📜 Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

---

## 👨‍💻 Autor

**Mihguel da Silva Santos Tavares de Araujo**  
🔗 [LinkedIn](https://www.linkedin.com/in/mihguel-da-silva-santos-tavares-de-araujo)  
🐙 [GitHub](https://github.com/mihguelsilva)

---

> 📚 Este projeto é parte de um aprendizado contínuo sobre arquitetura MVC, segurança em APIs RESTful e boas práticas em PHP moderno.  
> Estou muito feliz com meu progresso e este é apenas o começo! 💙
> 🧪 Pronto para o próximo nível: Laravel, APIs mais complexas, autenticação via sessão, ACL, permissões, testes e muito mais.