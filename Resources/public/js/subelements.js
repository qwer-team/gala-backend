$( document ).ready(function() {
    
    $(".accordion-group").on("keydown", ".subelements-form input[name='percent']", function(event){
        validateInput(event);
        if(!event.isDefaultPrevented()){
            onSubelementPercent($(this));
        }
    });
    $(".accordion-group").on("keydown", ".subelements-form input[name='prizeCount']", function(event){
        validateInput(event);
        if(!event.isDefaultPrevented()){
            onSubelementPoints($(this));
        }
        
    });
    $(".accordion-group").on("keyup", ".subelements-form input[name='percent']", function(event){
        validateInput(event);
        if(!event.isDefaultPrevented()){
            onSubelementPercent($(this));
        }
    });
    $(".accordion-group").on("keyup", ".subelements-form input[name='prizeCount']", function(event){
        validateInput(event);
        if(!event.isDefaultPrevented()){
            onSubelementPoints($(this));
        }
        
    });
    $(".accordion-group").on("change", ".subelements-form input[name='percent']", function(event){
        validateInput(event);
        if(!event.isDefaultPrevented()){
            onSubelementPercent($(this));
        }
    });
    $(".accordion-group").on("change", ".subelements-form input[name='prizeCount']", function(event){
        validateInput(event);
        if(!event.isDefaultPrevented()){
            onSubelementPoints($(this));
        }
        
    });
    $(".accordion-group").on("change", ".subelements-form select[name='prize']", function(){
        getPrizeElements($(this));
    });
    $("#loadPrize").on("change", "tr select[name='prize']", function(){
        loadPrize($(this));
    });
    $(".accordion-group").on("click", ".add-subelement", function(){
        saveSubelement('new_subelement', $(this))
    });
    $(".accordion-group").on("click", ".update-subelement",function(){
        saveSubelement('update_subelement', $(this))
    });
    $(".accordion-group").on("click", ".remove-subelement",function(){
        removeSubelement($(this))
    });
});

function loadPrize(obj){
    prizeId = obj.val();
    elements = prizes[prizeId];
    var tr = obj.parents('#loadPrize');
    options = tr.find("select[name='element']").find('option').remove().end();
    for(i = 0; i < elements.length; i++){
        options.append('<option value='+elements[i].id+'>'+elements[i].name+'</option>')
    }
}

function getPrizeElements(obj){
    prizeId = obj.val();
    elements = prizes[prizeId];
    var segment = obj.parents('.accordion-group');
    options = segment.find("select[name='element']").find('option').remove().end();
    for(i = 0; i < elements.length; i++){
        options.append('<option value='+elements[i].id+'>'+elements[i].name+'</option>')
    }
}

function onSubelementPercent(obj){
    var segment = obj.parents('.accordion-group');
    var pointsCount = parseInt(segment.find("input[name='length']").val());
    var value = Math.round( ( pointsCount/100 ) * obj.val());
    var pointInput = obj.parent().find('input[name="prizeCount"]');
    checkSegmentPrizecount(segment);
    pointInput.val(value);
    
}

function onSubelementPoints(obj){
    var segment = obj.parents('.accordion-group');
    var pointsCount = parseInt(segment.find("input[name='length']").val());
    var value = (( obj.val() / pointsCount ) * 100)
    var percentInput = obj.parent().find('input[name="percent"]');
    checkSegmentPrizecount(segment);
    percentInput.val(value);
}

function checkSegmentPrizecount(segment){
    var pointsCount = parseInt(segment.find("input[name='length']").val());
    
    var subtypesPoints = 0;
    segment.find("input[name='prizeCount']").each(function(){
        var val = $(this).val();
        subtypesPoints += (val == ''? 0: parseInt(val));
    });
    segment.find("#allPointsCount").val(subtypesPoints);
    percent = subtypesPoints / pointsCount;
    segment.find("#allPointsPercent").val(percent);
    var buttons = segment.find(".add-subelement, .update-subelement");
    if(subtypesPoints > pointsCount){
        buttons.attr('disabled', 'disabled');
    } else {
        buttons.removeAttr('disabled');
    }
}

function saveSubelement(routing, obj){
    var parent = obj.parent();
    var subelementId = parent.find("input[name='id']").val();
    var prizeCount = parent.find("input[name='prizeCount']").val();
    var restore = parent.find("input[name='restore']").is(':checked')?1:undefined;
    var elementId = parent.find("select[name='element']").val();
    
    var params = {
        id: subelementId,
        prizeCount: prizeCount, 
        restore: restore, 
        elementId: elementId
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
                updatePrizeSegmentConfig(segment, '.subelements-form');
            }
        }
    });
}

function removeSubelement(obj){
    var parent = obj.parent();
    var subelementId = parent.find("input[name='id']").val();
    console.log(subelementId);
    var href = Routing.generate('remove_subelement', {
        id: subelementId
    });
    var segment = obj.parents('.accordion-group');
    $.ajax({
        url: href,
        dataType: "JSON",
        success: function(data){
            if(data.result == 'success'){
                updatePrizeSegmentConfig(segment, '.subelements-form');
            }
        }
    }); 
}