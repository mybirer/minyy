$(function() {
    $('select[name="limit"]').on("change",function(){
        var hash = window.location.search;
        var tt=hash.split("&");
        var route="";
        $.each(tt,function(i,t){
            var q=t.split("=");
            if(q[0]!="limit" && q[0]!="page"){
                route+=t+"&";
            }
        });
        route+="limit="+encodeURIComponent($(this).val());
        location.href=route;
    })
    $('#search-form').on("submit",function(){
        var hash = window.location.search;
        var tt=hash.split("&");
        var route="";
        $.each(tt,function(i,t){
            var q=t.split("=");
            if(q[0]!="search_term" && q[0]!="page"){
                route+=t+"&";
            }
        });
        route+="search_term="+encodeURIComponent($('input[name="table_search"]').val());
        location.href=route;
        return false;
    });
    $('[data-toggle="openModal"]').on('click',function(){
        $($(this).data("target")).modal('show');
        return false;
    });
    $('td.has-link').on('click',function(){
        window.location.href = "index.php?controller=module&action=medias&do=show&id=" + $(this).parent().data("id");
        return false;
    });
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
});