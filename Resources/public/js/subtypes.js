$( document ).ready(function() {
    $(".accordion-group").on("click", ".add-subtype", function(){
        saveSubtype('new_subtype', $(this))
    });
    $(".accordion-group").on("click", ".update-subtype",function(){
        saveSubtype('update_subtype', $(this))
    });
    $(".accordion-group").on("click", ".remove-subtype",function(){
        removeSubtype($(this))
    });
    $(".accordion-group").on("change", ".subtypes-form input[name='percent']", function(){
        onSubtypePercent($(this));
    });
    $(".accordion-group").on("change", ".subtypes-form input[name='pointsCount']", function(){
        onSubtypePoints($(this));
    });
});

function onSubtypePercent(obj){
    var segment = obj.parents('.accordion-group');
    var pointsCount = parseInt(segment.find("input[name='length']").val());
    var value = Math.round( ( pointsCount/100 ) * obj.val());
    var pointInput = obj.parent().find('input[name="pointsCount"]');
    checkSegmentPointcount(segment);
    pointInput.val(value);
    
}

function onSubtypePoints(obj){
    var segment = obj.parents('.accordion-group');
    var pointsCount = parseInt(segment.find("input[name='length']").val());
    var value = (( obj.val() / pointsCount ) * 100)
    var percentInput = obj.parent().find('input[name="percent"]');
    checkSegmentPointcount(segment);
    percentInput.val(value);
}

function checkSegmentPointcount(segment){
    var pointsCount = parseInt(segment.find("input[name='length']").val());
    
    var subtypesPoints = 0;
    segment.find("input[name='pointsCount']").each(function(){
        var val = $(this).val();
        subtypesPoints += (val == ''? 0: parseInt(val));
    });
    $("#allPointsCount").val(subtypesPoints);
    percent = subtypesPoints / pointsCount;
    $("#allPointsPercent").val(percent);
    console.log(subtypesPoints);
    var buttons = segment.find(".add-subtype, .update-subtype");
    if(subtypesPoints > pointsCount){
        buttons.attr('disabled', 'disabled');
    } else {
        buttons.removeAttr('disabled');
    }
}

function saveSubtype(routing, obj){
    var parent = obj.parent();
    var subtypeId = parent.find("input[name='id']").val();
    var points = parent.find("input[name='pointsCount']").val();
    var block = parent.find("input[name='block']").is(':checked')?1:undefined;
    var restore = parent.find("input[name='restore']").is(':checked')?1:undefined;
    var typeId = parent.find("input[name='typeId']").val();
    var parameter = parent.find("input[name='parameter']").val();
    
    var params = {
        id: subtypeId,
        pointsCount: points, 
        block: block,
        restore: restore, 
        typeId: typeId,
        parameter: parameter
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