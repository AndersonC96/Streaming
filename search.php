<?php
    if(isset($_GET['query'])){
        $query = urlencode($_GET['query']);
        $apiKey = 'e9e1d5e5';
        $url = "http://www.omdbapi.com/?apikey={$apiKey}&t={$query}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if($data['Response'] == 'True'){
            $imdbID = $data['imdbID'];
            $type = strtolower($data['Type']);
            $typeMapping = [
                'movie' => 'filme',
                'series' => 'serie',
            ];
            if(array_key_exists($type, $typeMapping)){
                $mappedType = $typeMapping[$type];
                $redirectUrl = "https://superflixapi.dev/{$mappedType}/{$imdbID}";
                header("Location: {$redirectUrl}");
                exit();
            }else{
                echo "Tipo de conteúdo inválido.";
            }
        }else{
            echo "Filme não encontrado.";
        }
    }else{
        echo "Nenhuma consulta fornecida.";
    }
?>