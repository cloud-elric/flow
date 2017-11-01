// animisition: http://git.blivesta.com/animsition/
// ladda: http://msurguy.github.io/ladda-bootstrap/

$(document).ready(function() {
    // Animación entre pantallas
      $(".animsition").animsition({
        transition: function(url){},
        loading : false
      });
      
      $('.animsition').on('animsition.inStart', function() {
        $(".animsition-loading").hide();
      });
    
      $('.animsition').on('animsition.outStart', function() {
        $(".animsition-loading").show();
      });
  
      // Cargador en todos los botones con la clase ladda
      // $(".ladda-button").on("click", function(e){
      //    var l = Ladda.create(this);
      //    l.start();
      //   // Para deternerlo usar
      //   // var l = Ladda.create(this);
      //   // l.stop();
      // });
  
      Ladda.bind( '.ladda-button' );
  
      $('#form-ajax').on('ajaxComplete', function (e, jqXHR, textStatus) {
        var l = Ladda.create($("#form-ajax button[type=submit]").get(0));
        l.stop();
        return true;
      });
  
      $(".input-number").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
  
  
      
  });
  
  // Lanza la animación siempre que se cambie las pantallas
  window.onbeforeunload = function(){
    $('.animsition').animsition('out', $('.animsition'), '');
  }
  
  
  