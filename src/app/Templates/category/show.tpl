{extends file="layout.tpl"}

{block name="content"}
    <a href="/" class="back-link">&larr; На главную</a>
    <div class="page-header">
        <h1>{$category->name}</h1>
        <p class="text-muted fs-5 mb-0">{$category->description}</p>
    </div>
    <nav class="segmented" aria-label="Сортировка">
        {foreach $sorts as $s}
            <a href="/category/{$category->id}?sort={$s->value}" {if $s === $sort}class="active"
               aria-current="true"{/if}>{$s->label()}</a>
        {/foreach}
    </nav>
    <div class="row g-4">
        {foreach $posts as $post}
            <div class="col-md-6 col-lg-4">
                {include file="partials/post-card.tpl" post=$post}
            </div>
            {foreachelse}
            <div class="col-12">
                <div class="empty-state">В этой категории пока нет статей.</div>
            </div>
        {/foreach}
    </div>
    {if $pages > 1}
        <nav aria-label="Страницы">
            <ul class="pager">
                <li {if $page <= 1}class="disabled"{/if}>
                    {if $page > 1}
                        <a href="/category/{$category->id}?sort={$sort->value}&page={$page - 1}" aria-label="Назад">&larr;</a>
                    {else}
                        <span>&larr;</span>
                    {/if}
                </li>
                {for $p = 1 to $pages}
                    <li {if $p === $page}class="active"{/if}>
                        {if $p === $page}
                            <span aria-current="page">{$p}</span>
                        {else}
                            <a href="/category/{$category->id}?sort={$sort->value}&page={$p}">{$p}</a>
                        {/if}
                    </li>
                {/for}
                <li {if $page >= $pages}class="disabled"{/if}>
                    {if $page < $pages}
                        <a href="/category/{$category->id}?sort={$sort->value}&page={$page + 1}" aria-label="Вперёд">&rarr;</a>
                    {else}
                        <span>&rarr;</span>
                    {/if}
                </li>
            </ul>
        </nav>
    {/if}
{/block}
