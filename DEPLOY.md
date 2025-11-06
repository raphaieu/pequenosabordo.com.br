# Guia de Deploy - Pequenos a Bordo

## 📋 Checklist de Deploy

### 1. Preparação no Servidor (aaPanel)

- [ ] PHP 8.3+ instalado com extensões: PDO, PDO_MySQL, GD, mbstring
- [ ] MySQL/MariaDB instalado
- [ ] Node.js 18+ instalado (para build)
- [ ] Composer instalado
- [ ] Site criado no aaPanel apontando para `/www/wwwroot/pequenosabordo.com.br`

### 2. Clone e Build

```bash
# 1. Clonar repositório
cd /www/wwwroot
git clone <repository-url> pequenosabordo.com.br
cd pequenosabordo.com.br

# 2. Instalar dependências front-end
npm install

# 3. Build do front-end
npm run build

# 4. Instalar dependências back-end
cd admin
composer install --no-dev --optimize-autoloader
cd ..

# 5. Configurar .env
cd admin
cp .env.example .env
nano .env  # Configure credenciais do banco
cd ..

# 6. Configurar auth.php
nano admin/config/auth.php  # Configure credenciais admin
```

### 3. Configurar Banco de Dados

```bash
# Via aaPanel ou linha de comando
mysql -u root -p

CREATE DATABASE pequenos_a_bordo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pequenos_a_bordo;
source /www/wwwroot/pequenosabordo.com.br/admin/database/schema.sql;
exit;
```

### 4. Configurar Nginx

No aaPanel:
1. Acesse: **Website** > **Settings** > **pequenosabordo.com.br**
2. Clique em **Configuration**
3. Substitua TODO o conteúdo pelo arquivo `nginx.conf` fornecido
4. Ajuste a versão do PHP se necessário (linha `fastcgi_pass unix:/tmp/php-cgi-83.sock;`)
5. Salve e recarregue Nginx

### 5. Configurar Permissões

```bash
cd /www/wwwroot/pequenosabordo.com.br

# Definir proprietário
chown -R www:www .

# Permissões de diretórios
find . -type d -exec chmod 755 {} \;

# Permissões de arquivos
find . -type f -exec chmod 644 {} \;

# Permissões especiais para uploads
chmod -R 775 public/images/produtos
chmod -R 775 dist/images/produtos
chmod 755 admin/public
```

### 6. SSL/HTTPS

No aaPanel:
1. Acesse: **Website** > **Settings** > **pequenosabordo.com.br**
2. Clique em **SSL**
3. Selecione **Let's Encrypt**
4. Configure e ative

### 7. Verificar Deploy

1. Acesse: `https://pequenosabordo.com.br` - Front-end deve carregar
2. Acesse: `https://pequenosabordo.com.br/admin/login` - Admin deve carregar
3. Teste login e CRUD de produtos

## 🔧 Ajustes Pós-Deploy

### Verificar Versão do PHP

No arquivo `nginx.conf`, ajuste se necessário:
```nginx
fastcgi_pass unix:/tmp/php-cgi-83.sock;  # 83 = PHP 8.3
```

Para outras versões:
- PHP 8.1: `php-cgi-81.sock`
- PHP 8.2: `php-cgi-82.sock`
- PHP 8.3: `php-cgi-83.sock`

### Verificar Caminho do Sock PHP

No aaPanel:
1. Acesse: **Website** > **Settings** > **pequenosabordo.com.br**
2. Clique em **PHP Settings**
3. Verifique o caminho do socket (ex: `/tmp/php-cgi-83.sock`)

### Testar Configuração Nginx

```bash
# Testar sintaxe
nginx -t

# Recarregar Nginx
systemctl reload nginx
```

## 🚨 Troubleshooting

### Erro 404 no Front-end

- Verifique se `dist/` existe e tem conteúdo
- Verifique se o root no Nginx aponta para `dist/`
- Verifique permissões: `chmod -R 755 dist`

### Erro 404 no Admin

- Verifique se `admin/public/index.php` existe
- Verifique se o alias no Nginx está correto
- Verifique permissões: `chmod 755 admin/public/index.php`

### Imagens não aparecem

- Verifique se `public/images/produtos/` existe
- Verifique permissões: `chmod -R 775 public/images/produtos`
- Verifique se as imagens foram sincronizadas com `npm run build`

### Erro de conexão com banco

- Verifique credenciais no `.env`
- Verifique se o banco existe
- Teste conexão: `mysql -u usuario -p pequenos_a_bordo`

## 📊 Otimizações Aplicadas

### Performance
- ✅ Cache agressivo para assets estáticos (1 ano)
- ✅ Compressão GZIP/Brotli
- ✅ Cache de imagens (30 dias)
- ✅ Cache de fontes (1 ano)
- ✅ Desabilitado logs para recursos estáticos

### Segurança
- ✅ Headers de segurança (X-Frame-Options, CSP, etc)
- ✅ HTTPS obrigatório
- ✅ Proteção de arquivos sensíveis
- ✅ Validação de referer para imagens
- ✅ Desabilitado listagem de diretórios

### SEO
- ✅ Cache para HTML configurado
- ✅ Compressão de conteúdo
- ✅ Headers otimizados

## 🔄 Atualizações Futuras

### Atualizar Front-end

```bash
cd /www/wwwroot/pequenosabordo.com.br
git pull
npm install
npm run build
```

### Atualizar Back-end

```bash
cd /www/wwwroot/pequenosabordo.com.br/admin
git pull
composer install --no-dev --optimize-autoloader
```

### Backup

Via aaPanel:
1. **Database** > **Backup** - Backup do banco
2. **Files** > **Backup** - Backup dos arquivos

Ou via linha de comando:
```bash
# Backup do banco
mysqldump -u root -p pequenos_a_bordo > backup_$(date +%Y%m%d).sql

# Backup dos arquivos
tar -czf backup_files_$(date +%Y%m%d).tar.gz /www/wwwroot/pequenosabordo.com.br
```

