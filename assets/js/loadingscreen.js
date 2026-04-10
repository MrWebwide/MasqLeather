document.addEventListener("DOMContentLoaded", function() {
    // Sayfa tamamen yüklendiğinde loading screen'i kaldır
    let startTime = performance.now();
    window.addEventListener("load", function() {
        let endTime = performance.now();
        let loadTime = endTime - startTime;

        if (loadTime > 2000) { // 1 saniye eşik
            const loadingScreen = document.getElementById("loading-screen");
            loadingScreen.classList.add("fade-out");
            setTimeout(() => {
                loadingScreen.style.display = "none";
            }, 3500); // Fade out animasyonu süresi ile eşleşmeli
        } else {
            document.getElementById("loading-screen").style.display = "none";
        }
    });
});
