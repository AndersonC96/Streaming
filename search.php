<?php
    if (isset($_GET['query'])) {
        $query = urlencode($_GET['query']);
        $apiKey = 'your_omdb_api_key';
        $url = "http://www.omdbapi.com/?apikey={$apiKey}&s={$query}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if ($data['Response'] == 'True') {
            echo "<h2>Resultados da pesquisa:</h2>";
            echo "<div style='display: flex; flex-wrap: wrap; gap: 20px;'>";
            foreach ($data['Search'] as $item) {
                // Mapear tipo de conteúdo para a URL de redirecionamento
                $type = strtolower($item['Type']);
                $typeMapping = [
                    'movie' => 'filme',
                    'series' => 'serie',
                ];
                if (array_key_exists($type, $typeMapping)) {
                    $mappedType = $typeMapping[$type];
                    $redirectUrl = "https://superflixapi.dev/{$mappedType}/{$item['imdbID']}";
                    echo "<div style='border: 1px solid #ccc; padding: 10px; width: 200px; text-align: center;'>";
                    echo "<a href='{$redirectUrl}' target='_blank' style='text-decoration: none; color: inherit;'>";
                    echo "<img src='{$item['Poster']}' alt='{$item['Title']}' style='width: 100%; height: auto;'>";
                    echo "<h3>{$item['Title']} ({$item['Year']})</h3>";
                    echo "</a>";
                    echo "</div>";
                }
            }
            echo "</div>";
        } else {
            echo "<p>Filme não encontrado.</p>";
        }
    } else {
        echo "<p>Nenhuma consulta fornecida.</p>";
    }