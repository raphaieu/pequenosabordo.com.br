const API_BASE_URL = import.meta.env.VITE_API_URL || '/admin/api'

export const api = {
  async getProdutos() {
    try {
      const response = await fetch(`${API_BASE_URL}/produtos`)
      if (!response.ok) {
        throw new Error('Erro ao buscar produtos')
      }
      return await response.json()
    } catch (error) {
      console.error('Erro na API:', error)
      // Retorna array vazio em caso de erro para não quebrar o front
      return []
    }
  }
}

