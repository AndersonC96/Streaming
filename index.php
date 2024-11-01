<?php include('header.php'); ?>
<div class="min-h-screen flex items-center justify-center">
    <form class="flex items-center w-full max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6" action="search.php" method="GET">
        <input type="text" name="query" placeholder="Pesquisar filmes ou séries" class="flex-grow bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        <button type="submit" class="ml-2 bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg px-4 py-2 transition duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 19l-4-4m0 0a7 7 0 1110-10 7 7 0 010 10z"></path>
            </svg>
        </button>
    </form>
</div>
<?php include('footer.php'); ?>