<?php include('header.php'); ?>
<div class="min-h-screen flex items-center justify-center">
    <form class="flex items-center max-w-lg mx-auto w-full" action="search.php" method="GET">
        <label for="voice-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.15 5.6h.01m3.337 1.913h.01m-6.979 0h.01M5.541 11h.01M15 15h2.706a1.957 1.957 0 0 0 1.883-1.325A9 9 0 1 0 2.043 11.89 9.1 9.1 0 0 0 7.2 19.1a8.62 8.62 0 0 0 3.769.9A2.013 2.013 0 0 0 13 18v-.857A2.034 2.034 0 0 1 15 15Z" />
                </svg>
            </div>
            <input type="text" id="voice-search" name="query" placeholder="Search Mockups, Logos, Design Templates..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            <button type="button" id="voice-search-button" class="absolute inset-y-0 end-0 flex items-center pe-3">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7v3a5.006 5.006 0 0 1-5 5H6a5.006 5.006 0 0 1-5-5V7m7 9v3m-3 0h6M7 1h2a3 3 0 0 1 3 3v5a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V4a3 3 0 0 1 3-3Z" />
                </svg>
            </button>
        </div>
        <button type='submit' class='ml-2 bg-blue-700 text-white rounded-lg px-4 py-2 hover:bg-blue-800'>Search</button>
    </form>
</div>
<!-- Script para pesquisa por voz -->
<script>
    const voiceSearchButton = document.getElementById('voice-search-button');
    const voiceSearchInput = document.getElementById('voice-search');
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (SpeechRecognition) {
        const recognition = new SpeechRecognition();
        recognition.lang = 'pt-BR'; // Defina o idioma conforme necessário
        recognition.onresult = function(event) {
            voiceSearchInput.value = event.results[0][0].transcript;
        };
        recognition.onerror = function(event) {
            console.error('Erro no reconhecimento de voz: ' + event.error);
            alert('Ocorreu um erro no reconhecimento de voz. Por favor, tente novamente.');
        };
        voiceSearchButton.addEventListener('click', function() {
            recognition.start();
        });
    } else {
        console.log('API de reconhecimento de voz não é suportada neste navegador.');
        alert('A funcionalidade de reconhecimento de voz não é suportada neste navegador.');
    }
</script>
<?php include('footer.php'); ?>