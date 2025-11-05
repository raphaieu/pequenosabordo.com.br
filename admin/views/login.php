<?php
$title = 'Login - Admin';
ob_start();
?>

<div class="max-w-md mx-auto mt-8 lg:mt-16">
    <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
        <h2 class="text-2xl lg:text-3xl font-heading font-semibold text-center mb-6 text-primary">Login Administrativo</h2>
        
        <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="/admin/login" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Usuário</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                    placeholder="Digite seu usuário"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                    placeholder="Digite sua senha"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors font-medium"
            >
                Entrar
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>

