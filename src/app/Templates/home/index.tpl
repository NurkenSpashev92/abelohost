{extends file="layout.tpl"}

{block name="content"}
    <h1 class="mb-4">{$title}</h1>
    {foreach $categories as $category}
        <section class="mb-5">
            <h2>{$category.name}</h2>
            <p class="text-muted">{$category.description}</p>
            <div class="row g-3">
                {foreach $category.posts as $post}
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="/post/{$post.id}">{$post.title}</a>
                                </h5>
                                <p class="card-text">{$post.description}</p>
                            </div>
                            <div class="card-footer text-muted small">
                                {$post.published_at|date_format:'%d.%m.%Y'} · {$post.views} просмотров
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
            <a class="btn btn-outline-primary mt-3" href="/category/{$category.id}">Все статьи</a>
        </section>
    {foreachelse}
        <p class="text-muted">Статей пока нет.</p>
    {/foreach}
{/block}
