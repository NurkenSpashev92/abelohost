<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:'Блог'}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lora:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
<header class="site-header">
    <div class="container py-3">
        <a href="/" class="site-logo">Блог <span>AbeloHost</span></a>
    </div>
</header>

<main class="container py-5">
    {block name="content"}{/block}
</main>

<footer class="site-footer">
    <div class="container py-4">© {$smarty.now|date_format:'%Y'} Блог</div>
</footer>
</body>
</html>
