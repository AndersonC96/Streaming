<?php
    use PHPUnit\Framework\TestCase;
    class SearchTest extends TestCase {
        public function testSearchReturnsResults() {
            // Simular um exemplo de chamada à API (pode ser uma função real ou mock)
            $query = 'batman';
            $apiKey = '43550673';
            $url = "http://www.omdbapi.com/?apikey={$apiKey}&s={$query}";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            // Verificar se a resposta contém resultados
            $this->assertTrue($data['Response'] == 'True');
            $this->assertArrayHasKey('Search', $data);
        }
        public function testInvalidQueryReturnsNoResults() {
            $query = 'invalidqueryexample';
            $apiKey = '43550673';
            $url = "http://www.omdbapi.com/?apikey={$apiKey}&s={$query}";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            // Verificar se a resposta não contém resultados
            $this->assertFalse($data['Response'] == 'True');
        }
    }