/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
  $('.default').each(function(){
    var defaultVal = $(this).attr('title');
    $(this).focus(function(){
      if ($(this).val() == defaultVal){
        $(this).removeClass('active').val('');
      }
    })
    .blur(function(){
      if ($(this).val() == ''){
        $(this).addClass('active').val(defaultVal);
      }
    })
    .blur().addClass('active');
  });
});

