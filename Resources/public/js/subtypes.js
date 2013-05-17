$( document ).ready(function() {
    $(document).on("click", ".add-subtype", addSubtype);
});

function addSubtype () {
    var parent = $(this).parent();
    var points = parent.find("input[name='pointsCount']").val();
    var block = parent.find("input[name='block']").is(':checked')?1:0;
    var restore = parent.find("input[name='restore']").is(':checked')?1:0;
    var typeId = parent.find("input[name='typeId']").val();
    
    var params = {
        pointsCount: points, 
        block: block,
        restore: restore, 
        typeId: typeId
    };
    
    var segment = $(this).parents('.accordion-group');
    var id = segment.data('id'); 
    var href = Routing.generate('save_subtype', {
        id: id
    });
   console.log(params);
    $.ajax({
        url: href,
        data: params,
        type: 'POST',
        dataType: "JSON",
        success: function(data){
            if(data.result == 'success'){
                updateSegmentConfig(segment, '.accordion-body');
            }
        }
    }); 
}


