{extends file="layout.tpl"}

{block name="content"}
    <div class="error-page">
        <div class="error-code">{$code}</div>
        <p class="fs-4 text-muted mb-4">{$message}</p>
        <a href="/" class="btn-accent">&larr; На главную</a>
    </div>
{/block}
