import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'
import { copyFileSync, mkdirSync, readdirSync, existsSync } from 'fs'
import { join } from 'path'

// Plugin para copiar pasta images/ para dist/images/
function copyImagesPlugin() {
  return {
    name: 'copy-images',
    closeBundle() {
      // Executa após o build estar completo
      const imagesSource = fileURLToPath(new URL('./images', import.meta.url))
      const imagesDest = fileURLToPath(new URL('./dist/images', import.meta.url))
      
      function copyRecursive(src, dest) {
        if (!existsSync(src)) {
          console.warn(`⚠️  Pasta ${src} não encontrada`)
          return 0
        }
        
        // Cria diretório destino se não existir
        if (!existsSync(dest)) {
          mkdirSync(dest, { recursive: true })
        }
        
        const entries = readdirSync(src, { withFileTypes: true })
        let copiedCount = 0
        
        for (const entry of entries) {
          const srcPath = join(src, entry.name)
          const destPath = join(dest, entry.name)
          
          if (entry.isDirectory()) {
            // Ignora node_modules e outras pastas desnecessárias
            if (entry.name === 'node_modules' || entry.name === '.git' || entry.name === 'chocolat') {
              continue
            }
            const subCopied = copyRecursive(srcPath, destPath)
            copiedCount += subCopied || 0
          } else {
            // Copia arquivo (sobrescreve se existir)
            try {
              copyFileSync(srcPath, destPath)
              copiedCount++
            } catch (error) {
              console.error(`✗ Erro ao copiar ${entry.name}:`, error.message)
            }
          }
        }
        
        return copiedCount
      }
      
      console.log('📁 Copiando imagens da pasta images/ para dist/images/...')
      const totalCopied = copyRecursive(imagesSource, imagesDest)
      console.log(`✅ ${totalCopied} arquivo(s) copiado(s) com sucesso!`)
    }
  }
}

export default defineConfig({
  plugins: [vue(), copyImagesPlugin()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  server: {
    port: 3000,
    open: true,
    proxy: {
      '/admin/api': {
        target: 'http://localhost:8000',
        changeOrigin: true,
        secure: false
      },
      '/avaliar': {
        target: 'http://localhost:8000',
        changeOrigin: true,
        secure: false
      }
    }
  }
})

