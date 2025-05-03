# 🛡️ API RESTful com Autenticação JWT em PHP (MVC)

[![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)
[![Status](https://img.shields.io/badge/status-em%20desenvolvimento-yellow)]()
[![Author](https://img.shields.io/badge/autor-Mihguel%20Silva-blueviolet)](https://github.com/mihguelsilva)

> Projeto backend em PHP estruturado com MVC, rotas personalizadas, autenticação segura com JWT e proteção de rotas com middleware.

---

## ✨ Funcionalidades

- ✅ Cadastro de usuários
- ✅ Login com geração de token JWT
- ✅ Proteção de rotas com middleware
- ✅ Controle de sessão via Bearer Token
- ✅ Estrutura MVC clara e organizada
- ✅ Autoload com Composer (PSR-4)
- ✅ Testes de requisições via `curl`

---

## 🧱 Estrutura do Projeto

```plaintext
├── public/ # Pasta pública (index.php)
├── src/
│ ├── Controllers/ # Controladores (Home, Auth, Admin)
│ ├── Core/ # Classes centrais (Router, Request, Response, AuthMiddleware, etc)
│ ├── Models/ # Modelos
│ └── Services/ # Serviços auxiliares (JWTService)
├── routes/
│ └── api.php # Definição das rotas
├── .env # Variáveis sensíveis (chave JWT, etc)
└── composer.json # Autoload e dependências
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