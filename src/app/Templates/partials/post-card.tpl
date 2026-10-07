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
