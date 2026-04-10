<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $(function(){
                $(".silmeAlani").click(function(e){
                    e.preventDefault();
                    var yonlenecekAdres=e.currentTarget.getAttribute("href");
                    
                    swal({
                      title: "Kaldırmak İstediğinizden emin misiniz?",
                      text: "Bu veriyi sildiğinizde bir daha geri alamayacaksınız!",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    })
                     .then((willDelete) => {
                        if (willDelete) {
                          window.location.href=yonlenecekAdres;
                        } else {
                          swal("Processiniz başarıyla iptal edildi.");
                        }
                      });
                });
                
                
                
                
            });
        </script>