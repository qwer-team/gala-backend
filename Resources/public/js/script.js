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
    
    $('form.segments_form').on('keyup', 'input[name="length"]', function(){
        onSegmentLength($(this));
    });
    
    $('form.segments_form').on('keyup', 'input[name="percent"]', function(){
        onSegmentPercent($(this));
    });
                
    $('.load-segment-info').on('click',function(){
        var segment = $(this).parents('.accordion-group');
        if(!segment.hasClass('in'))
        {
            updateSegmentConfig(segment)
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