# Área Administrativa - Pequenos a Bordo

Área administrativa desenvolvida com SlimPHP 4, MySQL e TailwindCSS.

## 📋 Requisitos

- PHP 8.1 ou superior
- Composer
- MySQL 5.7 ou superior
- Extensões PHP: PDO, PDO_MySQL, GD, mbstring

## 🚀 Instalação

1. **Instalar dependências do Composer:**
```bash
cd admin
composer install
```

2. **Configurar banco de dados:**
   - Crie o banco de dados MySQL:
   ```sql
   CREATE DATABASE pequenos_a_bordo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
   
   - Execute o schema SQL:
   ```bash
   mysql -u root -p pequenos_a_bordo < database/schema.sql
   ```

3. **Configurar variáveis de ambiente:**
   - Copie `.env.example` para `.env`:
   ```bash
   cp .env.example .env
   ```
   
   - Edite o arquivo `.env` com suas credenciais:
   ```
   DB_HOST=localhost
   DB_NAME=pequenos_a_bordo
   DB_USER=root
   DB_PASS=sua_senha
   ```

4. **Configurar credenciais de acesso:**
   - Edite `config/auth.php` para alterar usuário e senha padrão:
   ```php
   return [
       'username' => 'seu_usuario',
       'password' => 'sua_senha_forte',
   ];
   ```

## 🏃 Executando Localmente

Para desenvolvimento local, execute o servidor PHP:

```bash
cd admin
php -S localhost:8000 -t public
```

Ou use o script do Composer:

```bash
composer serve
```

Acesse: `http://localhost:8000/admin/login`

**Credenciais padrão:**
- Usuário: `admin`
- Senha: `admin123`

## 📁 Estrutura de Pastas

```
admin/
├── config/          # Configurações (banco, autenticação)
├── database/        # Scripts SQL
├── public/          # Arquivos públicos (não usado diretamente)
├── src/
│   ├── Controllers/ # Controladores
│   ├── Models/      # Models do banco
│   ├── Services/    # Serviços (Upload, PDF)
│   └── Middleware/  # Middlewares
└── views/           # Views/Templates PHP
```

## 🔐 Autenticação

O sistema de autenticação é hardcoded no arquivo `config/auth.php`. Não há tabela de usuários no banco de dados.

## 📤 Upload de Imagens

As imagens dos produtos são salvas em:
- `dist/images/produtos/` (se a pasta dist existir)
- `public/images/produtos/` (fallback)

## 📄 Geração de PDF

Os contratos são gerados usando DomPDF. Para gerar um PDF de uma reserva, acesse a lista de reservas e clique em "PDF".

## 🔗 API Pública

Endpoint disponível para o front-end:
- `GET /admin/api/produtos` - Retorna JSON com todos os produtos

## 🛠️ Desenvolvimento

### Front-end Vue.js

O front-end Vue.js está configurado para fazer proxy das requisições para a API durante o desenvolvimento:

```javascript
// vite.config.js
proxy: {
  '/admin/api': {
    target: 'http://localhost:8000',
    changeOrigin: true,
  }
}
```

### Produção

Para produção, configure seu servidor web (nginx/apache) para:
- Servir arquivos estáticos de `dist/` 
- Fazer proxy de `/admin/*` para o PHP-FPM

## 📝 Notas

- As imagens são validadas (JPG, PNG, WEBP) com tamanho máximo de 5MB
- O sistema usa sessões PHP para manter autenticação
- Todos os endpoints administrativos são protegidos por middleware
- O endpoint `/admin/api/produtos` é público (sem autenticação)

