$( document ).ready(function() {
    $('.updateCoords').submit(function() { 
        try{
            $(this).ajaxSubmit(); 
        } catch(err) {
            console.log(err);
        }
        return false; 
    });
    $('#myTab a').click(function (e) {
        if($(this).attr('href').charAt(0)=='#')
        {
            e.preventDefault();
            $(this).tab('show');
        }
    });
    $('#myTab2 a').click(function (e) {
        if($(this).attr('href').charAt(0)=='#')
        {
            e.preventDefault();
            $(this).tab('show');
        }
    });
    $('#myTab3 a').click(function (e) {
        if($(this).attr('href').charAt(0)=='#')
        {
            e.preventDefault();
            $(this).tab('show');
        }
    });
    
    $('form.segments_form').on('keydown', 'input[name="length"]', function(event){
        validateInput(event);
        if(!event.isDefaultPrevented()){
            onSegmentLength($(this));
        }
    });
    
    $('form.segments_form').on('keydown', 'input[name="percent"]', function(event){
        validateInput(event);
        if(!event.isDefaultPrevented()){
            onSegmentPercent($(this));
        }
    });
                
    $('.load-segment-info').on('click',function(){
        var segment = $(this).parents('.accordion-group');
        if(!segment.hasClass('in'))
        {
            updateSegmentConfig(segment)
        }     
    })
    $('.load-prize-segment-info').on('click',function(){
        var segment = $(this).parents('.accordion-group');
        if(!segment.hasClass('in'))
        {
            updatePrizeSegmentConfig(segment)
        }     
    })   
                
    $('body').delegate(".ajaxForm a#sendAjaxForm", "click", function(){
        $('.ajaxForm').has(this).ajaxSubmit({
            'success' : function( data ){
                if(data['result']=='success'){
                    $('#hiddenMassageSuccess').clone().prependTo('.ajaxForm[id = '+data['id']+']').show();
                }
                else{
                    $('#hiddenMassageError').clone().prependTo('.ajaxForm[id = '+data['id']+']').show(); 
                }
            }
        });
    });
    segmentsTotal();
});

function validateInput(event){
    // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 116 || event.keyCode == 13 || 
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode!=190) {
                event.preventDefault(); 
            }   
        }
    
}

var points = 10000000;//00;
var length = "length";
var percent = "percent";
                
                
function segmentsTotal(){
    var totalPoints = 0;
    $('form.segments_form input[name="length"]').each(function(){
        totalPoints += parseInt($(this).val()); 
    });
    $('.totalPoints').val(totalPoints);
    
    var totalPercent = 0;
    $('form.segments_form input[name="percent"]').each(function(){
        totalPercent += parseFloat($(this).val()); 
    });
    $('.totalPercent').val(totalPercent+'%');
    
    var remove, add;
    if(totalPoints != points){
        remove = "success";
        add = "error";
    } else {
        remove = "error";
        add = "success";
    }
    $.each(['.totalPoints', '.totalPercent'], function(i, v){
        var obj = $(".control-group").has(v);
        obj.removeClass(remove)
        obj.addClass(add);
    });
}

function onSegmentLength(obj){
    var form = obj.parents('.segments_form');
    var percent = form.find('input[name="percent"]');
    var value = (( obj.val() / points ) * 100)
    percent.val(value.toFixed(2));
    segmentsTotal();
}
function onSegmentPercent(obj){
    var form = obj.parents('form');
    var lenInp = form.find('input[name="length"]');
    var value = Math.round( points / 100 * obj.val());
    lenInp.val(value.toFixed(0));
    segmentsTotal();
}
    
function updateSegmentConfig(segment, body){
    body = body || '.accordion-inner';
    var id = segment.data('id'); 
    var href = Routing.generate('segment_config', {
        id: id
    });
    $.ajax({
        url: href,
        success: function(html){
            segment.find(body).replaceWith(html);
        }
    }); 
    
}
function updatePrizeSegmentConfig(segment, body){
    body = body || '.accordion-inner';
    var id = segment.data('id'); 
    var href = Routing.generate('prize_segment_config', {
        id: id
    });
    $.ajax({
        url: href,
        success: function(html){
            segment.find(body).replaceWith(html);
        }
    }); 
    
}