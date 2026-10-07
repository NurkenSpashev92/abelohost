{extends file="layout.tpl"}

{block name="content"}
    <h1 class="mb-4">{$title}</h1>
    {foreach $categories as $category}
        <section class="mb-5">
            <h2>{$category.name}</h2>
            <div class="row">
                {foreach $category.posts as $post}
                    <div class="col-md-4">
                        <a href="/post/{$post.id}">{$post.title}</a>
                    </div>
                {/foreach}
            </div>
            <a class="btn btn-outline-primary mt-3" href="/category/{$category.id}">Все статьи</a>
        </section>
        {foreachelse}
        <p class="text-muted">Статей пока нет.</p>
    {/foreach}
{/block}
