$( document ).ready(function() {
    $(".accordion-group").on("click", ".add-subtype", function(){saveSubtype('new_subtype', $(this))});
    $(".accordion-group").on("click", ".update-subtype",function(){saveSubtype('update_subtype', $(this))});
    $(".accordion-group").on("click", ".remove-subtype",function(){removeSubtype($(this))});
});

function saveSubtype(routing, obj){
    var parent = obj.parent();
    var subtypeId = parent.find("input[name='id']").val();
    var points = parent.find("input[name='pointsCount']").val();
    var block = parent.find("input[name='block']").is(':checked')?1:undefined;
    var restore = parent.find("input[name='restore']").is(':checked')?1:undefined;
    var typeId = parent.find("input[name='typeId']").val();
    
    var params = {
        id: subtypeId,
        pointsCount: points, 
        block: block,
        restore: restore, 
        typeId: typeId
    };
    
    var segment = obj.parents('.accordion-group');
    var id = segment.data('id'); 
    var href = Routing.generate(routing, {
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
                updateSegmentConfig(segment, '.subtypes-form');
            }
        }
    }); 
}

function removeSubtype(obj){
    var parent = obj.parent();
    var subtypeId = parent.find("input[name='id']").val();
    var href = Routing.generate('remove_subtype', {
        id: subtypeId
    });
    var segment = obj.parents('.accordion-group');
    $.ajax({
        url: href,
        dataType: "JSON",
        success: function(data){
            if(data.result == 'success'){
                updateSegmentConfig(segment, '.subtypes-form');
            }
        }
    }); 
}