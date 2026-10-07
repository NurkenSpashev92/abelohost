{extends file="layout.tpl"}

{block name="content"}
    {foreach $categories as $category}
        <section class="section">
            <div class="section-header">
                <div>
                    <h2>{$category.name}</h2>
                    <p class="text-muted">{$category.description}</p>
                </div>
                <a class="btn-ghost" href="/category/{$category.id}">Все статьи <span class="arrow">&rarr;</span></a>
            </div>
            <div class="row g-4">
                {foreach $category.posts as $post}
                    <div class="col-md-6 col-lg-4">
                        {include file="partials/post-card.tpl" post=$post}
                    </div>
                {/foreach}
            </div>
        </section>
        {foreachelse}
        <div class="empty-state">Статей пока нет.</div>
    {/foreach}
{/block}
