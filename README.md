# Projeto de Pesquisa com API OMDB

Este projeto consiste em uma aplicação web que permite aos usuários pesquisar filmes e séries usando a API OMDB. O resultado da pesquisa é redirecionado para uma URL específica com base no tipo de conteúdo encontrado.

## Tecnologias Utilizadas

- HTML
- PHP
- Tailwind CSS
- API OMDB
- JavaScript (para reconhecimento de voz)

## Funcionalidades

- Pesquisar filmes e séries por nome.
- Suporte a pesquisa por voz.
- Redirecionamento baseado no tipo de conteúdo (filme ou série).

## Estrutura do Projeto

.

├── index.html

└── search.php

## Configuração e Uso

### Pré-requisitos

- Um servidor web com suporte a PHP (por exemplo, Apache, Nginx).
- Chave de API da OMDB.

### Passo a Passo

1. Clone o repositório ou baixe os arquivos.

    ```bash
    git clone https://github.com/AndersonC96/Streaming
    ```

2. Substitua `'your_omdb_api_key'` no arquivo `search.php` pela sua chave de API da OMDB.

3. Coloque os arquivos no diretório raiz do seu servidor web.

4. Acesse `index.html` no seu navegador.

## Como Funciona

1. **Formulário de Pesquisa**: O formulário HTML permite que o usuário insira o nome de um filme ou série.
2. **Pesquisa por Voz**: O botão de pesquisa por voz permite que o usuário use reconhecimento de fala para preencher o campo de pesquisa.
3. **Processamento em PHP**: O arquivo `search.php` recebe a pesquisa, faz uma requisição à API OMDB, valida o tipo de conteúdo e redireciona o usuário para a URL apropriada.

### Exemplos de Redirecionamento

- Filmes são redirecionados para URLs do tipo `https://superflixapi.dev/filme/{imdbID}`
- Séries são redirecionadas para URLs do tipo `https://superflixapi.dev/serie/{imdbID}`