<?php
    include('header.php');
    include('config.php'); // Importar a chave da API
    // Barra de pesquisa personalizada
    echo "<form class='flex items-center max-w-lg mx-auto mb-8' method='GET' action=''>
            <label for='voice-search' class='sr-only'>Search</label>
            <div class='relative w-full'>
                <div class='absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none'>
                    <svg class='w-4 h-4 text-gray-500 dark:text-gray-400' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 21 21'>
                        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11.15 5.6h.01m3.337 1.913h.01m-6.979 0h.01M5.541 11h.01M15 15h2.706a1.957 1.957 0 0 0 1.883-1.325A9 9 0 1 0 2.043 11.89 9.1 9.1 0 0 0 7.2 19.1a8.62 8.62 0 0 0 3.769.9A2.013 2.013 0 0 0 13 18v-.857A2.034 2.034 0 0 1 15 15Z'/>
                    </svg>
                </div>
                <input type='text' id='voice-search' name='query' class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' required>
                <button type='button' id='voice-search-button' class='absolute inset-y-0 end-0 flex items-center pe-3'>
                    <svg class='w-4 h-4 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 16 20'>
                        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 7v3a5.006 5.006 0 0 1-5 5H6a5.006 5.006 0 0 1-5-5V7m7 9v3m-3 0h6M7 1h2a3 3 0 0 1 3 3v5a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V4a3 3 0 0 1 3-3Z'/>
                    </svg>
                </button>
            </div>
            <button type='submit' class='ml-2 bg-blue-700 text-white rounded-lg px-4 py-2 hover:bg-blue-800'>Search</button>
        </form>";
    if (isset($_GET['query'])) {
        $query = urlencode($_GET['query']);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página atual, padrão é 1
        $itemsPerPage = 10; // Número de itens por página
        $url = "http://www.omdbapi.com/?apikey={$apiKey}&s={$query}&page={$currentPage}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if ($data['Response'] == 'True') {
            $totalResults = (int)$data['totalResults'];
            $totalPages = ceil($totalResults / $itemsPerPage);
            echo "<h2 class='text-xl font-semibold mb-4'>Resultados da pesquisa:</h2>";
            echo "<div class='grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6'>";
            foreach ($data['Search'] as $item) {
                $type = strtolower($item['Type']);
                $typeMapping = [
                    'movie' => 'filme',
                    'series' => 'serie',
                ];
                if (array_key_exists($type, $typeMapping)) {
                    $mappedType = $typeMapping[$type];
                    $redirectUrl = "https://superflixapi.dev/{$mappedType}/{$item['imdbID']}";
                    echo "<div class='bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden'>
                            <a href='{$redirectUrl}' target='_blank' class='block'>
                                <img src='{$item['Poster']}' alt='{$item['Title']}' class='w-full h-48 object-cover'>
                                <div class='p-4'>
                                    <h3 class='text-md font-bold mb-1'>{$item['Title']} ({$item['Year']})</h3>
                                </div>
                            </a>
                        </div>";
                }
            }
            echo "</div>";
            // Paginação estilizada com Tailwind
            echo "<nav aria-label='Page navigation' class='mt-6 flex justify-center'>";
            echo "<ul class='inline-flex items-center space-x-2 border rounded-lg p-2 bg-gray-50 dark:bg-gray-800'>";
            if ($currentPage > 1) {
                $prevPage = $currentPage - 1;
                echo "<li class='page-item'><a href='?query={$_GET['query']}&page={$prevPage}' class='page-link px-3 py-2 text-sm font-medium text-blue-500 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md'>Anterior</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link px-3 py-2 text-sm font-medium text-gray-400 rounded-md'>Anterior</span></li>";
            }
            $paginationLimit = 5; // Número máximo de páginas exibidas
            $startPage = max(1, $currentPage - floor($paginationLimit / 2));
            $endPage = min($totalPages, $startPage + $paginationLimit - 1);
            if ($endPage - $startPage + 1 < $paginationLimit) {
                $startPage = max(1, $endPage - $paginationLimit + 1);
            }
            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $currentPage) {
                    echo "<li class='page-item'><span class='page-link px-3 py-2 text-sm font-bold text-white bg-blue-500 rounded-md'>{$i}</span></li>";
                } else {
                    echo "<li class='page-item'><a href='?query={$_GET['query']}&page={$i}' class='page-link px-3 py-2 text-sm font-medium text-blue-500 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md'>{$i}</a></li>";
                }
            }
            if ($currentPage < $totalPages) {
                $nextPage = $currentPage + 1;
                echo "<li class='page-item'><a href='?query={$_GET['query']}&page={$nextPage}' class='page-link px-3 py-2 text-sm font-medium text-blue-500 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md'>Próxima</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link px-3 py-2 text-sm font-medium text-gray-400 rounded-md'>Próxima</span></li>";
            }
            echo "</ul>";
            echo "</nav>";
        } else {
            echo "<p class='text-red-500'>Filme não encontrado.</p>";
        }
    } else {
        echo "<p class='text-gray-500'>Nenhuma consulta fornecida.</p>";
    }
    // Script JavaScript para ativar a pesquisa por voz
    echo "<script>
        const voiceSearchButton = document.getElementById('voice-search-button');
        const voiceSearchInput = document.getElementById('voice-search');
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (SpeechRecognition) {
            const recognition = new SpeechRecognition();
            recognition.lang = 'pt-BR'; // Defina o idioma de acordo com suas necessidades
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
    </script>";
include('footer.php');