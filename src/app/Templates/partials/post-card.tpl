<article class="post-card">
    {if $post.image}
        <img src="{$post.image}" alt="" class="post-cover" loading="lazy">
    {else}
        <div class="post-cover post-cover--placeholder" style="--hue: {$post.id * 47 % 360}">
            {$post.title|truncate:1:''}
        </div>
    {/if}
    <div class="post-card-body">
        <h3 class="post-card-title">
            <a href="/post/{$post.id}" class="stretched-link">{$post.title}</a>
        </h3>
        <p class="post-card-text">{$post.description}</p>
        <div class="post-meta">
            <span>{$post.published_at|date_format:'%d.%m.%Y'}</span>
            <span>Просмотры: {$post.views}</span>
        </div>
    </div>
</article>
