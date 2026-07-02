# Guia de Deploy - Pequenos a Bordo

## Deploy via Coolify (Docker) — Recomendado

O projeto inclui `Dockerfile` e `docker-compose.yaml` para deploy automatizado via Git no Coolify (Oracle VPS).

### Arquitetura

- **app**: nginx + PHP 8.3-FPM (front-end Vue compilado + admin Slim)
- **db**: MySQL 8 com volume persistente
- **uploads_produtos**: volume para imagens enviadas pelo admin
- SSL e domínio são gerenciados pelo Traefik do Coolify

### 1. Configurar no Coolify

1. Crie um recurso do tipo **Docker Compose**
2. Conecte o repositório Git e selecione a branch de produção
3. Defina o caminho do compose: `docker-compose.yaml` (raiz do projeto)
4. Configure as variáveis de ambiente (veja `.env.example`):

| Variável | Descrição |
|----------|-----------|
| `DB_NAME` | Nome do banco (padrão: `pequenos_a_bordo`) |
| `DB_USER` | Usuário do banco |
| `DB_PASS` | Senha do banco |
| `MYSQL_ROOT_PASSWORD` | Senha root do MySQL |
| `ADMIN_USER` | Usuário do painel admin |
| `ADMIN_PASS` | Senha do painel admin |

5. No serviço **app**, configure o domínio (`pequenosabordo.com.br`) na porta **80**
6. Confirme que os volumes `uploads_produtos` e `mysql_data` estão como **Persistent Storage**
7. Habilite **Auto Deploy** no push para a branch de produção

### 2. Testar localmente antes do deploy

```bash
cp .env.example .env
cp docker-compose.override.example.yml docker-compose.override.yml
# Edite .env com senhas seguras

docker compose up --build -d

# Verificar
curl -s -o /dev/null -w "%{http_code}" http://localhost:8080/          # 200
curl -s -o /dev/null -w "%{http_code}" http://localhost:8080/admin/login  # 200
curl -s http://localhost:8080/admin/api/produtos | head -c 100           # JSON
```

> **Coolify:** o `docker-compose.yaml` não expõe porta no host (evita conflito com 8080). O Traefik do Coolify roteia o domínio para o container na porta 80 interna.

### 3. Migrar dados da VPS antiga (aaPanel)

#### Banco de dados

O repositório já inclui o dump de produção em `db/init/01-dump.sql` (com `USE pequenos_a_bordo;` no início). Esse script roda automaticamente na **primeira** subida do MySQL, quando o volume `mysql_data` está vazio.

Para atualizar os dados no futuro, gere um novo dump na VPS antiga:

```bash
mysqldump -u root -p pequenos_a_bordo > dump.sql
```

**Opção A — Antes do primeiro deploy:** substitua o conteúdo de `db/init/01-dump.sql` (mantendo `USE pequenos_a_bordo;` na primeira linha) e faça commit.

**Opção B — Volume MySQL já existente** (import manual):

```bash
docker compose exec -T db mysql -u root -p"$MYSQL_ROOT_PASSWORD" pequenos_a_bordo < dump.sql
```

#### Imagens de produtos

Coloque os arquivos em `public/images/produtos/` no repositório. No build da imagem, elas entram como seed e populam o volume `uploads_produtos` na subida do container (sem sobrescrever uploads novos feitos pelo admin).

O repositório já contém as 44 imagens de produção. Para copiar de outra VPS:

```bash
# Na VPS antiga
tar -czf uploads_produtos.tar.gz -C /caminho/public/images/produtos .

# Extraia em public/images/produtos/ antes do deploy, ou copie direto no volume via Coolify
```

### 4. Verificar deploy

1. `https://pequenosabordo.com.br` — front-end Vue
2. `https://pequenosabordo.com.br/admin/login` — painel admin
3. `https://pequenosabordo.com.br/admin/api/produtos` — API JSON
4. Teste login, CRUD de produtos e upload de imagem

### 5. Atualizações (auto-deploy)

Com Auto Deploy habilitado, cada `git push` na branch configurada dispara rebuild e redeploy automático no Coolify. O volume de uploads e o banco são preservados entre deploys.

### 6. Backup

```bash
# Backup do banco
docker compose exec db mysqldump -u root -p"$MYSQL_ROOT_PASSWORD" pequenos_a_bordo > backup_$(date +%Y%m%d).sql

# Backup das imagens de produtos
docker run --rm -v pequenosabordo_uploads_produtos:/data -v $(pwd):/backup alpine \
  tar -czf /backup/uploads_$(date +%Y%m%d).tar.gz -C /data .
```

### Troubleshooting (Docker)

| Problema | Solução |
|----------|---------|
| Erro de conexão com banco | Verifique `DB_PASS` e `MYSQL_ROOT_PASSWORD` no Coolify; aguarde o healthcheck do `db` |
| Imagens não aparecem | Confirme que o volume `uploads_produtos` está montado; reinicie o `app` |
| Admin retorna 502 | Verifique logs: `docker compose logs app` |
| `port is already allocated` (8080) | Remova `ports` do compose principal; no Coolify não é necessário bind de porta |
| Init SQL não rodou | Scripts em `db/init/` só executam com volume MySQL vazio; use import manual (Opção B) |

---

## Deploy legado (aaPanel) — Referência


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

