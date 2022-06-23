  <!-- Button scroll to top -->
  <a href="#" class="to-top">
      <i class="material-icons">arrow_upward</i>
  </a>

  <!-- button to whatsapp -->
  <a href=" https://wa.me/6282313920767?text=Hai+kak+saya+ingin+menanyakan+produk+yang+ada+di+website+official" class="whatsapp_float" target="_blank">
      <i class="fa fa-whatsapp whatsapp-icon"></i></a>

  <!-- Bootstrap core JavaScript -->

  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
      AOS.init();
  </script>
  <script src="/script/navbar-scroll.js"></script>
  <script>
      $(document).ready(function() {
          loadcart();

          $.ajaxSetup({
              headers: {
                  "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
              },
          });

          function loadcart() {
              $.ajax({
                  type: "GET",
                  url: "/load-cart-data",
                  dataType: "",
                  success: function(response) {
                      $(".cart-count").html("");
                      $(".cart-count").html(response.count);

                      // alert(response.count);
                  },
              });
          }
      });
  </script>