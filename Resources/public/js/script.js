$( document ).ready(function() {
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
    var points = 1000000000;
    var length = "galaxy_BackendBundle_form_space_segmenttype_length";
    var percent = "galaxy_BackendBundle_form_space_segmenttype_percent";
                
    function seeTotal(){
        var totalPoints = total($("form.segments_form #"+length),true)  
        $('.totalPoints').val(totalPoints);
        chengeClass(parseInt(totalPoints), points, $(".control-group").has('.totalPoints'));
        
        var totalProcent =  total($("form.segments_form #"+percent),false)
        $('.totalProcent').val(totalProcent+'%');
        chengeClass(parseFloat(totalProcent), 100, $(".control-group").has('.totalProcent'));
    }
    function chengeClass(nowHas, need, object){
        if(nowHas!=need){
            object.removeClass('success');
            object.addClass('error');
        }
        else{
            object.removeClass('error');
            object.addClass('success');
        }
    }
    seeTotal();
                
    $('form.segments_form').on('change', 'input', function(){
        var segment = $('form.segments_form').has(this);

        var lengthInp = segment.children().find("#"+length);
        var percentInp = segment.children().find("#"+percent);
                   
        if($(this).attr('id') == length){
            percentInp.val((($(this).val()/points)*100).toFixed(2));
        }
        if($(this).attr('id') == percent){
            lengthInp.val(Math.round((points/100)*$(this).val()));
        }
        seeTotal();
    });

                
    function total(bloks, integer){
        var total = 0;
        for(var i=0; i<bloks.size();i++){
            if(integer==true)
                total += parseInt(bloks.eq(i).val());
            else
                total += parseFloat(bloks.eq(i).val());
        }
        return total;
    }
                
    $('.load-segment-info').on('click',function(){
        var id = $(this).data('id'); 
        
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
                
});

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