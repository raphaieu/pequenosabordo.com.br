# Pequenos a Bordo - Site de Aluguel de Produtos Infantis

Projeto completo de site institucional para aluguel de cadeirinhas, carrinhos e produtos infantis em Salvador-BA, com área administrativa integrada.

## 📋 Visão Geral

Este projeto foi completamente refatorado de HTML/CSS/Bootstrap/jQuery para uma arquitetura moderna com:
- **Front-end**: Vue.js 3 + Vite + TailwindCSS (mobile-first)
- **Back-end**: SlimPHP 4 + MySQL
- **Área Admin**: Sistema completo de CRUD com autenticação básica

## 🚀 Tecnologias

### Front-end
- **Vue.js 3** - Framework JavaScript reativo
- **Vite** - Build tool moderna e rápida
- **TailwindCSS** - Framework CSS utility-first (mobile-first)
- **Swiper** - Carrossel de produtos
- **AOS (Animate On Scroll)** - Animações ao rolar a página

### Back-end / Admin
- **SlimPHP 4** - Micro-framework PHP
- **MySQL** - Banco de dados
- **DomPDF** - Geração de PDFs de contratos
- **PDO** - Acesso ao banco de dados
- **PHP Sessions** - Autenticação básica

## 📦 Instalação e Configuração

### Pré-requisitos

- Node.js 18+ e npm
- PHP 8.1+ com extensões: PDO, PDO_MySQL, GD, mbstring
- Composer
- MySQL 5.7+ ou MariaDB 10.3+

### 1. Clonar o Repositório

```bash
git clone <repository-url>
cd pequenosabordo.com.br
```

### 2. Instalar Dependências Front-end

```bash
npm install
```

### 3. Instalar Dependências Back-end

```bash
cd admin
composer install
cd ..
```

### 4. Configurar Banco de Dados

1. Crie o banco de dados MySQL:
```sql
CREATE DATABASE pequenos_a_bordo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Execute o schema SQL:
```bash
cd admin
mysql -u root -p pequenos_a_bordo < database/schema.sql
cd ..
```

### 5. Configurar Variáveis de Ambiente

Crie o arquivo `.env` no diretório `admin/`:

```bash
cd admin
cp .env.example .env
```

Edite o arquivo `.env` com suas credenciais:
```
DB_HOST=localhost
DB_NAME=pequenos_a_bordo
DB_USER=seu_usuario
DB_PASS=sua_senha
```

### 6. Configurar Credenciais de Acesso Admin

Edite `admin/config/auth.php`:
```php
return [
    'username' => 'seu_usuario',
    'password' => 'sua_senha_forte',
];
```

## 🛠️ Desenvolvimento

### Executar Front-end (Vue.js)

```bash
npm run dev
```

O front-end estará disponível em `http://localhost:3000`

### Executar Back-end (SlimPHP)

Em outro terminal:

```bash
cd admin
php -S localhost:8000 -t public
```

Ou use o script do Composer:
```bash
cd admin
composer serve
```

O admin estará disponível em `http://localhost:8000/admin/login`

**Credenciais padrão:**
- Usuário: `admin`
- Senha: `admin123` (altere em `admin/config/auth.php`)

### Como Funciona em Desenvolvimento

1. **Front-end (porta 3000)**: Vite serve o Vue.js com hot-reload
2. **Back-end (porta 8000)**: PHP serve a área administrativa
3. **Proxy**: O Vite faz proxy de `/admin/api/*` para `localhost:8000`
4. **Imagens**: Em desenvolvimento, o admin aponta para `localhost:3000/images/produtos/`

## 📁 Estrutura do Projeto

```
pequenosabordo.com.br/
├── admin/                    # Área administrativa (SlimPHP)
│   ├── config/              # Configurações (banco, auth)
│   │   ├── database.php
│   │   └── auth.php
│   ├── database/            # Scripts SQL
│   │   └── schema.sql
│   ├── public/              # Entry point PHP
│   │   └── index.php
│   ├── scripts/             # Scripts utilitários
│   │   └── sync-images.php  # Sincroniza imagens entre public/dist
│   ├── src/
│   │   ├── Controllers/     # Controladores
│   │   │   ├── AuthController.php
│   │   │   ├── ProdutoController.php
│   │   │   └── ReservaController.php
│   │   ├── Models/          # Models do banco
│   │   │   ├── Produto.php
│   │   │   └── Reserva.php
│   │   ├── Services/        # Serviços
│   │   │   ├── UploadService.php
│   │   │   └── PdfService.php
│   │   └── Middleware/       # Middlewares
│   │       └── AuthMiddleware.php
│   ├── views/               # Views/Templates PHP
│   │   ├── layout.php
│   │   ├── login.php
│   │   ├── dashboard.php
│   │   ├── produtos/
│   │   │   ├── index.php
│   │   │   └── form.php
│   │   └── reservas/
│   │       ├── index.php
│   │       └── form.php
│   ├── composer.json
│   ├── index.php            # Bootstrap principal
│   └── .env                 # Variáveis de ambiente
├── src/                      # Front-end Vue.js
│   ├── components/          # Componentes Vue
│   │   ├── Header.vue
│   │   ├── Hero.vue
│   │   ├── Sobre.vue
│   │   ├── Produtos.vue
│   │   ├── ComoFunciona.vue
│   │   ├── Footer.vue
│   │   ├── Modal.vue
│   │   ├── Preloader.vue
│   │   └── ReservaForm.vue
│   ├── services/            # Serviços API
│   │   └── api.js           # Cliente API para produtos
│   ├── data/                # Dados estáticos (fallback)
│   │   └── produtos.js
│   ├── App.vue
│   ├── main.js
│   └── main.css
├── public/                  # Arquivos públicos (imagens)
│   └── images/
│       └── produtos/        # Imagens dos produtos
├── dist/                    # Build de produção (gerado)
│   └── images/
│       └── produtos/        # Imagens sincronizadas
├── package.json
├── vite.config.js
├── tailwind.config.js
└── README.md
```

## 🏗️ Build para Produção

### Build do Front-end

```bash
npm run build
```

Este comando:
1. Compila o Vue.js para produção (pasta `dist/`)
2. Executa o script `admin/scripts/sync-images.php` para sincronizar imagens entre `public/images/produtos/` e `dist/images/produtos/`

### Arquivos Gerados

- `dist/index.html` - HTML principal
- `dist/assets/` - JavaScript e CSS minificados
- `dist/images/produtos/` - Imagens dos produtos

## 🚢 Deploy em Produção (VPS Hostinger com aaPanel)

### 1. Preparação no Servidor

#### Via aaPanel:

1. **Criar Site:**
   - Acesse: `Website` > `Add Site`
   - Domínio: `pequenosabordo.com.br` (ou seu domínio)
   - Document Root: `/www/wwwroot/pequenosabordo.com.br`
   - PHP Version: 8.1 ou superior

2. **Configurar PHP:**
   - Acesse: `Website` > `PHP Settings`
   - Instale/extensões necessárias: `PDO`, `PDO_MySQL`, `GD`, `mbstring`

3. **Criar Banco de Dados:**
   - Acesse: `Database` > `Add Database`
   - Database Name: `pequenos_a_bordo`
   - Username e Password: anote as credenciais

4. **PHPMyAdmin:**
   - Acesse o banco criado
   - Execute o SQL: `admin/database/schema.sql`

### 2. Clonar e Configurar o Projeto

#### Via SSH:

```bash
# Navegar para o diretório do site
cd /www/wwwroot/pequenosabordo.com.br

# Clonar o repositório (ou fazer upload via FTP/SFTP)
git clone <repository-url> .

# Ou fazer upload do projeto via aaPanel File Manager
```

### 3. Instalar Dependências

```bash
# Instalar dependências front-end
npm install

# Build do front-end
npm run build

# Instalar dependências back-end
cd admin
composer install --no-dev --optimize-autoloader
cd ..
```

### 4. Configurar Variáveis de Ambiente

```bash
cd admin
cp .env.example .env
nano .env  # ou use o editor do aaPanel
```

Configure com as credenciais do banco criado:
```
DB_HOST=localhost
DB_NAME=pequenos_a_bordo
DB_USER=usuario_do_banco
DB_PASS=senha_do_banco
```

### 5. Configurar Credenciais Admin

```bash
nano admin/config/auth.php
```

Altere para credenciais seguras:
```php
return [
    'username' => 'seu_usuario_seguro',
    'password' => 'senha_forte_e_complexa',
];
```

### 6. Configurar Nginx/Apache (aaPanel)

#### Via aaPanel - Configuração do Site:

1. Acesse: `Website` > `Settings` > `pequenosabordo.com.br`

2. **Configuração Nginx (Recomendado):**

Clique em `Configuration` e adicione:

```nginx
# Serve arquivos estáticos do dist
location / {
    try_files $uri $uri/ /index.html;
    root /www/wwwroot/pequenosabordo.com.br/dist;
    index index.html;
}

# Admin - Proxy para PHP-FPM
location /admin {
    try_files $uri $uri/ /admin/index.php?$query_string;
    root /www/wwwroot/pequenosabordo.com.br;
}

location ~ ^/admin/.*\.php$ {
    fastcgi_pass unix:/tmp/php-cgi-81.sock;  # Ajuste versão PHP
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}

# Imagens dos produtos
location /images/produtos/ {
    alias /www/wwwroot/pequenosabordo.com.br/public/images/produtos/;
    expires 1y;
    add_header Cache-Control "public, immutable";
}

# API pública
location /admin/api {
    try_files $uri /admin/index.php?$query_string;
}
```

3. **Configuração Apache (Alternativa):**

Se usar Apache, adicione no `.htaccess` na raiz:

```apache
# Rewrite para Vue Router
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^index\.html$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.html [L]
</IfModule>
```

### 7. Permissões de Arquivos

```bash
# Definir permissões corretas
chown -R www:www /www/wwwroot/pequenosabordo.com.br
chmod -R 755 /www/wwwroot/pequenosabordo.com.br
chmod -R 775 /www/wwwroot/pequenosabordo.com.br/public/images/produtos
chmod -R 775 /www/wwwroot/pequenosabordo.com.br/dist/images/produtos
```

### 8. SSL/HTTPS (Opcional mas Recomendado)

No aaPanel:
1. Acesse: `Website` > `Settings` > `pequenosabordo.com.br`
2. Clique em `SSL`
3. Selecione `Let's Encrypt` e configure

### 9. Verificar Deploy

1. Acesse: `https://pequenosabordo.com.br` - Front-end deve carregar
2. Acesse: `https://pequenosabordo.com.br/admin/login` - Admin deve carregar
3. Faça login e teste CRUD de produtos e reservas

## 📝 Funcionalidades

### Front-end
- ✅ Site institucional responsivo (mobile-first)
- ✅ Carrossel de produtos com Swiper
- ✅ Integração com API para buscar produtos do banco
- ✅ Fallback para produtos estáticos se API falhar
- ✅ Formulário de reserva
- ✅ Animações ao rolar (AOS)
- ✅ Modal para termos e privacidade
- ✅ Integração com WhatsApp

### Área Administrativa
- ✅ Autenticação básica (hardcoded)
- ✅ Dashboard com estatísticas
- ✅ CRUD completo de produtos
- ✅ CRUD completo de reservas
- ✅ Upload de imagens (validação: JPG, PNG, WEBP, máx 5MB)
- ✅ Geração de PDF de contratos (DomPDF)
- ✅ Interface responsiva com TailwindCSS
- ✅ API pública para produtos: `GET /admin/api/produtos`

## 🔐 Segurança

### Em Produção:

1. **Altere as credenciais padrão** em `admin/config/auth.php`
2. **Use senhas fortes** para o banco de dados
3. **Configure SSL/HTTPS** (Let's Encrypt via aaPanel)
4. **Proteja o arquivo `.env`** (não versionar)
5. **Limite permissões** de arquivos (755 para diretórios, 644 para arquivos)
6. **Mantenha PHP atualizado** via aaPanel

## 🔄 Atualizações e Manutenção

### Atualizar Front-end

```bash
git pull
npm install
npm run build
```

### Atualizar Back-end

```bash
cd admin
git pull
composer install --no-dev --optimize-autoloader
```

### Backup

Via aaPanel:
1. Acesse: `Database` > `Backup` - Faça backup do banco
2. Acesse: `Files` > `Backup` - Faça backup dos arquivos

## 📚 Estrutura de Banco de Dados

### Tabela: `produtos`
- `id`, `nome`, `imagem`, `marca`, `tipoInstalacao`, `orientacao`
- `precoCurto`, `precoLongo`, `descricao`
- `criado_em`, `atualizado_em`

### Tabela: `reservas`
- `id`, `produto_id`, `nome_completo`, `cpf`, `endereco`
- `data_inicio`, `data_fim`
- `criado_em`, `atualizado_em`

## 🎨 Personalização

### Cores

Edite `tailwind.config.js`:
```javascript
colors: {
  primary: '#D16806',
  secondary: '#F9F6F3',
  dark: '#353535',
  black: '#1A1A1A',
}
```

### Fontes

Configuradas via Google Fonts:
- **Heading**: Cormorant Upright
- **Body**: Sora

## 🐛 Troubleshooting

### Imagens não aparecem no admin

- Verifique se as imagens existem em `public/images/produtos/`
- Em desenvolvimento, confirme que o Vite está rodando na porta 3000
- Verifique permissões: `chmod -R 775 public/images/produtos`

### Erro de conexão com banco

- Verifique credenciais no `.env`
- Confirme que o banco existe e está acessível
- Verifique extensões PHP: `php -m | grep pdo`

### Erro 404 no admin

- Verifique configuração do Nginx/Apache
- Confirme que o `index.php` está em `admin/public/`
- Verifique permissões de arquivos

### Build não funciona

- Verifique Node.js: `node -v` (deve ser 18+)
- Limpe cache: `rm -rf node_modules dist && npm install`
- Execute: `npm run build`

## 📞 Suporte

Para dúvidas ou problemas:
1. Verifique os logs do PHP (aaPanel > Logs)
2. Verifique os logs do Nginx/Apache
3. Verifique o console do navegador (F12)

## 📄 Licença

Este projeto é proprietário.

---

**Desenvolvido com ❤️ para Pequenos a Bordo**
