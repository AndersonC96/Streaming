<?php
    include('header.php');
    include('config.php'); // Importar a chave da API
    echo "<form method='GET' action='' class='mb-8'>
            <input type='text' name='query' placeholder='Pesquise um filme ou série' value='" . (isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '') . "' class='bg-gray-100 border border-gray-300 text-gray-900 rounded-lg w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500' required>
            <button type='submit' class='mt-2 bg-blue-700 text-white rounded-lg px-4 py-2 hover:bg-blue-800'>Pesquisar</button>
        </form>";
    if (isset($_GET['query'])) {
        $query = urlencode($_GET['query']);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página atual, padrão é 1
        $itemsPerPage = 14; // Número de itens por página
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
include('footer.php');