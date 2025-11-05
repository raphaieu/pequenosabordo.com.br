<template>
  <Teleport to="body">
    <Transition name="modal">
      <div v-if="show" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 1rem; background-color: rgba(0, 0, 0, 0.4);" @click="closeOnBackdrop">
        <div style="background-color: white; width: 100%; max-width: 42rem; padding: 1.25rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); position: relative; max-height: 90vh; overflow-y: auto;" @click.stop class="modal-content-wrapper">
          <button 
            type="button"
            class="close-button"
            style="position: absolute; top: 1rem; right: 1rem; color: #9ca3af; font-size: 1.875rem; font-weight: bold; cursor: pointer; line-height: 1; width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; background: none; border: none; padding: 0;"
            @click="close"
            aria-label="Fechar modal"
          >
            ×
          </button>
          <div style="margin-top: 0.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: normal; margin-bottom: 1rem; padding-right: 2rem;">{{ title }}</h2>
            <div style="font-size: 1rem; line-height: 1.75; white-space: pre-line;">{{ content }}</div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script>
import { watch, onUnmounted } from 'vue'

export default {
  name: 'Modal',
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    content: {
      type: String,
      default: '',
    },
    title: {
      type: String,
      default: '',
    },
  },
  emits: ['close'],
  setup(props, { emit }) {
    const close = () => {
      emit('close')
    }

    const closeOnBackdrop = (event) => {
      // Verificar se o clique foi no backdrop (elemento com bg-black/40)
      if (event.target === event.currentTarget) {
        close()
      }
    }

    // Fechar modal com ESC
    const handleEscape = (event) => {
      if (event.key === 'Escape' && props.show) {
        close()
      }
    }

    // Adicionar/remover listener quando o modal abre/fecha
    watch(() => props.show, (isOpen) => {
      if (isOpen) {
        window.addEventListener('keydown', handleEscape)
        // Prevenir scroll do body quando modal está aberto
        document.body.style.overflow = 'hidden'
        document.body.style.paddingRight = '0px' // Prevenir shift quando scrollbar desaparece
      } else {
        window.removeEventListener('keydown', handleEscape)
        // Restaurar scroll do body quando modal fecha
        document.body.style.overflow = ''
        document.body.style.paddingRight = ''
      }
    }, { immediate: false })

    onUnmounted(() => {
      window.removeEventListener('keydown', handleEscape)
    })

    return {
      close,
      closeOnBackdrop,
    }
  },
}
</script>

<style>
/* Transições do modal */
.modal-enter-active {
  transition: opacity 0.3s ease;
}

.modal-leave-active {
  transition: opacity 0.2s ease;
}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

/* Animação do conteúdo do modal */
.modal-enter-active .modal-content-wrapper {
  animation: slideDown 0.3s ease;
}

.modal-leave-active .modal-content-wrapper {
  animation: slideUp 0.2s ease;
}

.close-button {
  transition: color 0.2s ease;
}

.close-button:hover {
  color: #000 !important;
}

@keyframes slideDown {
  from {
    transform: translateY(-30px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    transform: translateY(0);
    opacity: 1;
  }
  to {
    transform: translateY(-30px);
    opacity: 0;
  }
}
</style>


