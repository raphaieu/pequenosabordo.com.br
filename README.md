# Pequenos a Bordo - Vue.js + TailwindCSS

Este projeto foi refatorado de HTML/CSS/Bootstrap/jQuery para Vue.js 3 com TailwindCSS.

## 🚀 Tecnologias

- **Vue.js 3** - Framework JavaScript reativo
- **Vite** - Build tool moderna e rápida
- **TailwindCSS** - Framework CSS utility-first
- **Swiper** - Carrossel de produtos
- **AOS (Animate On Scroll)** - Animações ao rolar a página

## 📦 Instalação

1. Instale as dependências:
```bash
npm install
```

## 🛠️ Desenvolvimento

Execute o servidor de desenvolvimento:
```bash
npm run dev
```

O projeto estará disponível em `http://localhost:3000`

## 🏗️ Build para Produção

Para gerar os arquivos de produção:
```bash
npm run build
```

Os arquivos serão gerados na pasta `dist/`

## 📁 Estrutura do Projeto

```
pequenosabordo.com.br/
├── src/
│   ├── components/       # Componentes Vue
│   │   ├── Header.vue
│   │   ├── Hero.vue
│   │   ├── Sobre.vue
│   │   ├── Produtos.vue
│   │   ├── ComoFunciona.vue
│   │   ├── Footer.vue
│   │   ├── Modal.vue
│   │   ├── Preloader.vue
│   │   └── ReservaForm.vue
│   ├── data/             # Dados estáticos
│   │   └── produtos.js
│   ├── App.vue           # Componente principal
│   ├── main.js           # Entrada da aplicação
│   └── main.css          # Estilos globais Tailwind
├── images/               # Imagens do projeto
├── index.html            # HTML de entrada
├── package.json
├── vite.config.js
├── tailwind.config.js
└── postcss.config.js
```

## ✨ Funcionalidades

- ✅ Componentes Vue reativos
- ✅ Formulário de reserva com validação
- ✅ Carrossel de produtos com Swiper
- ✅ Animações ao rolar (AOS)
- ✅ Modal para termos e privacidade
- ✅ Design responsivo com TailwindCSS
- ✅ Navegação suave entre seções
- ✅ Integração com WhatsApp

## 🎨 Personalização

### Cores

As cores podem ser personalizadas em `tailwind.config.js`:
- `primary`: #D16806
- `secondary`: #F9F6F3
- `dark`: #353535
- `black`: #1A1A1A

### Fontes

As fontes são configuradas via Google Fonts:
- **Heading**: Cormorant Upright
- **Body**: Sora

## 📝 Notas

- O projeto mantém a mesma estrutura visual do HTML original
- Todas as funcionalidades jQuery foram convertidas para Vue reativo
- Bootstrap foi completamente substituído por TailwindCSS
- As imagens devem estar na pasta `public/images/` (ou `images/` na raiz)

## 🔧 Próximos Passos

1. Mover imagens para a pasta `public/images/`
2. Ajustar caminhos de imagens se necessário
3. Testar todas as funcionalidades
4. Otimizar imagens para produção

