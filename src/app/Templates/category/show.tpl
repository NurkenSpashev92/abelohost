{extends file="layout.tpl"}

{block name="content"}
    <a href="/" class="d-inline-block mb-3">&larr; На главную</a>
    <h1>{$category.name}</h1>
    <p class="text-muted">{$category.description}</p>
    <div class="btn-group mb-4">
        {foreach $sorts as $s}
            <a href="/category/{$category.id}?sort={$s->value}"
               class="btn btn-sm {if $s === $sort}btn-primary{else}btn-outline-primary{/if}">{$s->label()}</a>
        {/foreach}
    </div>
    <div class="row g-3">
        {foreach $posts as $post}
            <div class="col-md-4">
                {include file="partials/post-card.tpl" post=$post}
            </div>
            {foreachelse}
            <p class="text-muted">В этой категории пока нет статей.</p>
        {/foreach}
    </div>
    {if $pages > 1}
        <nav class="mt-4">
            <ul class="pagination">
                <li class="page-item {if $page <= 1}disabled{/if}">
                    <a class="page-link"
                       href="/category/{$category.id}?sort={$sort->value}&page={$page - 1}">&laquo;</a>
                </li>
                {for $p = 1 to $pages}
                    <li class="page-item {if $p === $page}active{/if}">
                        <a class="page-link" href="/category/{$category.id}?sort={$sort->value}&page={$p}">{$p}</a>
                    </li>
                {/for}
                <li class="page-item {if $page >= $pages}disabled{/if}">
                    <a class="page-link"
                       href="/category/{$category.id}?sort={$sort->value}&page={$page + 1}">&raquo;</a>
                </li>
            </ul>
        </nav>
    {/if}
{/block}
