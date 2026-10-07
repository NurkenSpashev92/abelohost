{extends file="layout.tpl"}

{block name="content"}
    <article class="article">
        <a href="/" class="back-link">&larr; На главную</a>

        {if $post.image}
            <img src="{$post.image}" alt="{$post.title}" class="article-cover">
        {/if}

        <h1>{$post.title}</h1>

        <div class="post-meta">
            <span>{$post.published_at|date_format:'%d.%m.%Y'}</span>
            <span>Просмотры: {$post.views}</span>
        </div>

        <div class="tags">
            {foreach $categories as $category}
                <a href="/category/{$category.id}" class="tag">{$category.name}</a>
            {/foreach}
        </div>

        <p class="article-lead">{$post.description}</p>

        <div class="article-content">{$post.content}</div>
    </article>
    {if $similar}
        <section class="section">
            <div class="section-header">
                <h2>Похожие статьи</h2>
            </div>
            <div class="row g-4">
                {foreach $similar as $item}
                    <div class="col-md-6 col-lg-4">
                        {include file="partials/post-card.tpl" post=$item}
                    </div>
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
