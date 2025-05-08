$(document).ready(function () {
    var originalSelectOptions = $('#mySelect').html();
  
    $('#mySelect').change(function () {
       
      $('.text-box').hide();
  
       
      var selectedValue = $(this).val();
  

      $('#' + selectedValue + 'Options').show();
  
      
      $('#myNewSelect').val($('#myNewSelect option:first').val());
    });
  
   
    $('.list-choice').append('<select id="myNewSelect">' + originalSelectOptions + '</select>');
  });
  