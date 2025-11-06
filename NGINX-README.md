# Configuração Nginx - Pequenos a Bordo

## 📋 Resumo da Configuração

Esta configuração Nginx garante que:

1. **Front-end Vue.js** seja servido da pasta `/dist/`
2. **Área administrativa** seja servida de `/admin/public/index.php`
3. **API pública** funcione em `/admin/api/produtos`
4. **Imagens** sejam servidas de `/public/images/produtos/`
5. **Segurança, cache e performance** otimizados

## 🔧 Como Aplicar no aaPanel

### Passo 1: Copiar Configuração

1. Acesse: **Website** > **Settings** > **pequenosabordo.com.br**
2. Clique em **Configuration**
3. **Delete TODO o conteúdo** atual
4. **Copie e cole** o conteúdo completo do arquivo `nginx.conf`
5. **Ajuste a versão do PHP** se necessário (linha com `php-cgi-83.sock`)

### Passo 2: Verificar Versão do PHP

No arquivo `nginx.conf`, procure por:
```nginx
fastcgi_pass unix:/tmp/php-cgi-83.sock;
```

Ajuste conforme sua versão PHP:
- PHP 8.1: `php-cgi-81.sock`
- PHP 8.2: `php-cgi-82.sock`
- PHP 8.3: `php-cgi-83.sock`

Para verificar qual socket está disponível:
```bash
ls -la /tmp/php-cgi-*.sock
```

### Passo 3: Testar Configuração

```bash
# Testar sintaxe do Nginx
nginx -t

# Se OK, recarregar
systemctl reload nginx
```

No aaPanel:
1. Clique em **Save** na configuração
2. Nginx será recarregado automaticamente

## 📂 Estrutura de Diretórios Esperada

```
/www/wwwroot/pequenosabordo.com.br/
├── dist/                    # Front-end Vue.js (build)
│   ├── index.html
│   ├── assets/
│   └── images/
│       └── produtos/        # Imagens sincronizadas
├── public/
│   └── images/
│       └── produtos/         # Imagens originais
├── admin/
│   ├── public/
│   │   └── index.php        # Entry point do admin
│   ├── index.php            # Bootstrap principal
│   ├── config/
│   ├── database/
│   ├── src/
│   └── views/
└── nginx.conf               # Este arquivo (referência)
```

## 🔒 Segurança Implementada

- ✅ Headers de segurança (X-Frame-Options, CSP, etc)
- ✅ HTTPS obrigatório
- ✅ Proteção de arquivos sensíveis (.env, .git, etc)
- ✅ Validação de referer para imagens
- ✅ Desabilitado listagem de diretórios
- ✅ Timeout configurado
- ✅ Limite de upload (10MB)

## ⚡ Performance Implementada

- ✅ Cache agressivo para assets estáticos (1 ano)
- ✅ Cache para imagens (30 dias - 1 ano)
- ✅ Cache para fontes (1 ano)
- ✅ Compressão GZIP/Brotli
- ✅ Desabilitado logs para recursos estáticos
- ✅ Cache de sessão SSL otimizado

## 🧪 Testar Após Deploy

1. **Front-end:**
   - Acesse: `https://pequenosabordo.com.br`
   - Deve carregar o site Vue.js
   - Produtos devem aparecer (carregados do banco via API)

2. **Admin:**
   - Acesse: `https://pequenosabordo.com.br/admin/login`
   - Deve carregar a tela de login
   - Faça login e teste CRUD

3. **API:**
   - Acesse: `https://pequenosabordo.com.br/admin/api/produtos`
   - Deve retornar JSON com produtos

4. **Imagens:**
   - Acesse: `https://pequenosabordo.com.br/images/produtos/nome_arquivo.png`
   - Deve carregar a imagem

## 🐛 Troubleshooting

### Erro 502 Bad Gateway

- Verifique se o socket PHP está correto
- Verifique se PHP-FPM está rodando: `systemctl status php-fpm-83`

### Erro 404 no Front-end

- Verifique se `dist/` existe e tem conteúdo
- Verifique se o root aponta para `dist/`
- Execute: `npm run build`

### Erro 404 no Admin

- Verifique se `admin/public/index.php` existe
- Verifique permissões: `chmod 755 admin/public/index.php`
- Verifique logs: `tail -f /www/wwwlogs/pequenosabordo.com.br.error.log`

### Imagens não aparecem

- Verifique se `public/images/produtos/` existe
- Verifique permissões: `chmod -R 775 public/images/produtos`
- Execute: `php admin/scripts/sync-images.php`

## 📝 Notas Importantes

1. **Sempre teste** a configuração antes de salvar: `nginx -t`
2. **Backup** a configuração antiga antes de substituir
3. **Ajuste** a versão do PHP conforme necessário
4. **Monitore** os logs após deploy: `/www/wwwlogs/pequenosabordo.com.br.error.log`

## 🔄 Atualizações Futuras

Se precisar ajustar a configuração:
1. Faça backup da atual no aaPanel
2. Edite diretamente no aaPanel ou via SSH
3. Teste: `nginx -t`
4. Recarregue: `systemctl reload nginx`

