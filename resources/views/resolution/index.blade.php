
<div class="kb-view">
    
<div class="page-content kb-partial">
    <div class="kb-hero">
        <div class="kb-eyebrow">AI RESOLUTION LIBRARY</div>
        <h2>Resolution Knowledge Base</h2>
        <p>Premium library of reusable, AI-cleaned resolutions, ranked by usage, success rate, and learning score.</p>
    </div>

    <div class="kb-body">
        
<div class="app">
    

    
        

        <div class="page-content">
            
            
<div class="page-content">
    
    

<div class="app">
    

    
        

        
<div class="kb-panel">
    
    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="eyebrow">
                        <span class="eyebrow-dot"></span>
                        AI Resolution Library
                    </div>
                    
                    <p>
                        Premium library of reusable, AI-cleaned resolutions, ranked by usage, success rate, and learning score.
                    </p>
                </div>

                <div class="hero-actions">
                    
                </div>
            </div>
        </div>

        <div class="surface">
            <form method="GET" action="/resolution-library" class="search-bar">
                <input class="input" type="text" name="q" value="{{ $q }}" placeholder="Search title, category, symptom, or AI summary...">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Preview</th>
                            <th>Title</th>
                            <th>AI Summary</th>
                            <th>Category</th>
                            <th>Learning</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>
                                    @if($item->images->first())
                                        <img class="preview" src="{{ url('/storage/' . $item->images->first()->image_path) }}" alt="KB Image">
                                    @else
                                        <div class="preview" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:12px;">No Image</div>
                                    @endif
                                </td>

                                <td>
                                    <div class="title-main">{{ $item->displayTitle() }}</div>
                                    <div class="title-sub">{{ $item->title }}</div>
                                </td>

                                <td>
                                    <div class="summary">{{ $item->displaySummary() }}</div>
                                </td>

                                <td>
                                    <span class="pill pill-slate">{{ $item->displayCategory() }}</span>
                                </td>

                                <td>
                                    <div>
                                        <span class="pill pill-blue">Usage {{ $item->usage_count }}x</span>
                                        <span class="pill pill-green">Success {{ $item->success_count }}x</span>
                                        <span class="pill pill-slate">Score {{ number_format($item->learning_score ?? 0, 2) }}</span>
                                    </div>
                                </td>

                                <td>
                                    <div class="action-stack">
                                        <a href="{{ route('resolution-library.show', $item) }}" class="btn-lite">Open</a>
                                        @if(in_array(auth()->user()->role ?? '', ['admin']))
                                            <a href="{{ route('resolution-library.edit', $item) }}" class="btn-lite btn-dark">Edit</a>
                                        @endif
                                    
                                        @if(in_array(auth()->user()->role ?? '', ['admin']))
                                            <form method="POST"
                                                  action="{{ route('resolution-library.destroy', $item) }}"
                                                  onsubmit="return confirm('Delete this knowledge base item?');"
                                                  style="display:inline-flex;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-lite" style="border:1px solid #fecaca; background:#fef2f2; color:#b91c1c;">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty">No reusable resolutions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

    
</div>



<script>
document.querySelectorAll('[data-toggle]').forEach(function(btn){
    btn.addEventListener('click', function(){
        var group = btn.closest('[data-group]');
        if (group) group.classList.toggle('is-open');
    });
});

function toggleSidebar(){
    const sb = document.getElementById('sidebar');
    const main = document.getElementById('main');
    if (!sb || !main) return;
    sb.classList.toggle('collapsed');
    main.classList.toggle('collapsed');
    localStorage.setItem('sidebar', sb.classList.contains('collapsed') ? '1' : '0');
}

(function(){
    const sb = document.getElementById('sidebar');
    const main = document.getElementById('main');
    if (!sb || !main) return;
    if(localStorage.getItem('sidebar') === '1'){
        sb.classList.add('collapsed');
        main.classList.add('collapsed');
    }
})();
</script>


</div>

        </div>
    
</div>

<script>
document.querySelectorAll('[data-toggle]').forEach(function(btn){
    btn.addEventListener('click', function(){
        var group = btn.closest('[data-group]');
        if (group) group.classList.toggle('is-open');
    });
});

function toggleSidebar(){
    const sb = document.getElementById('sidebar');
    const main = document.getElementById('main');
    if (!sb || !main) return;
    sb.classList.toggle('collapsed');
    main.classList.toggle('collapsed');
    localStorage.setItem('sidebar', sb.classList.contains('collapsed') ? '1' : '0');
}

(function(){
    const sb = document.getElementById('sidebar');
    const main = document.getElementById('main');
    if (!sb || !main) return;
    if(localStorage.getItem('sidebar') === '1'){
        sb.classList.add('collapsed');
        main.classList.add('collapsed');
    }
})();
</script>

    </div>
</div>

</div>
