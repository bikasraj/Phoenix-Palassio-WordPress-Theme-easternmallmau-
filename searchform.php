<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url('/') ); ?>">
    <div style="display:flex;gap:0;max-width:500px;">
        <input type="search"
               class="search-field"
               placeholder="<?php esc_attr_e('Search&hellip;', 'phoenix-palassio'); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s"
               style="flex:1;padding:12px 20px;border:2px solid #ddd;border-right:none;border-radius:4px 0 0 4px;font-size:0.9rem;outline:none;"
        />
        <button type="submit" class="search-submit" style="background:var(--gold);color:#fff;padding:12px 20px;border:none;border-radius:0 4px 4px 0;cursor:pointer;font-weight:700;">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
</form>
