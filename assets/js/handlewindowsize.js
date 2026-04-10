
function handleWindowSizeChange() {
    var navTab = document.getElementById("nav-tab");
    var links = navTab.querySelectorAll("a");

    // Ekran genişliği 768px'den küçükse
    if (window.innerWidth <= 768) {
        // İlk bağlantının active sınıfını kaldır
       
        links[2].style.display = "none";
        // İkinci bağlantıya active sınıfını ekle
       
    } else {
        // Ekran genişliği 768px'den büyükse, sınıfları varsayılan hale getir
      
        links[2].style.display = "flex";
    }

   
     // ID'si "info" olan div'i kontrol et
        var infoDiv = document.getElementById("info");
        var sheetDiv = document.getElementById("sheet");
      

        if (window.innerWidth <= 768){
        // ID'si "info" olan div'in sınıflarından "show" ve "active" sınıflarını kaldır
        infoDiv.classList.remove("show", "active");

        // ID'si "sheet" olan div'in sınıflarına "show" ve "active" sınıflarını ekle
        sheetDiv.classList.add("show", "active");
    } else {
        sheetDiv.classList.add("show", "active");
        infoDiv.classList.remove("show", "active");

    }
}

// Sayfa yüklendiğinde ve pencere boyutu değiştiğinde çalışacak
window.onload = handleWindowSizeChange;
window.onresize = handleWindowSizeChange;