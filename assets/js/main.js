(function(){
    const data = new FormData();
    data.append('action', 'ls_wp_analytics');
    data.append('is_home', ls_wp_analytics.is_home);
    data.append('is_archive', ls_wp_analytics.is_archive);
    data.append('slug', ls_wp_analytics.slug);
    fetch(ls_wp_analytics.url,{
        body:data,
        method: 'POST'
    });
})();