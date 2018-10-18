
  $(function () {

    $('#choose-offer-form').on('click', '#addOffer', function() {
      
      var data = $("#choose-offer-form").serialize();
      // quantity = $('.item-count').val();

      $.ajax({
        type : 'POST',
        url  : '/new-offer.php',
        data : data,      
        success:function (data) { 

         if(data=="ok")
         {
            alert('ok');            
         }
        
        }
      });
      // alert(id);
      return false;

    });

  });