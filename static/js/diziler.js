/*
📁 Bölüm: UI (Statik Varlıklar - JS)
📄 Amaç: Dizi listeleme sayfası için JS
🔗 İlişkili: static/css/diziler.css, index.php
⚙️ Özet: Slider ve dizi listesi etkileşimlerini yönetir
*/
/* =========================================================
   1. DEĞİŞKEN TANIMLARI
   ========================================================= */
// Kayan film listesi ve kontrol butonları
const container = document.querySelector(".kayan");
const prevBtn = document.querySelector(".kaydir-btn.onceki");
const nextBtn = document.querySelector(".kaydir-btn.sonraki");

// Kaydırma durum değişkenleri
let scrollAmount = 0;
let cardWidth = 0;
let autoScroll = null;

/* =========================================================
   2. KART GENİŞLİĞİ HESAPLAMA
   ========================================================= */
/**
 * Ekran boyutuna göre film kartının genişliğini hesaplar.
 * Responsive tasarımda kaydırma mesafesinin doğru olmasını sağlar.
 */
function measureCardWidth() {
  const card = document.querySelector(".kayan .yeni-kart");
  cardWidth = card ? card.offsetWidth + 18 : 200;
}

/* =========================================================
   3. SLIDER FONKSİYONLARI
   ========================================================= */
/**
 * Bir sonraki film kartına kaydırma yapar.
 */
function nextSlide() {
  if (!container) return;
  if (scrollAmount < container.scrollWidth - container.clientWidth) {
    scrollAmount += cardWidth;
    container.scrollTo({ left: scrollAmount, behavior: "smooth" });
  } else {
    scrollAmount = 0;
    container.scrollTo({ left: 0, behavior: "smooth" });
  }
}

/**
 * Bir önceki film kartına kaydırma yapar.
 */
function prevSlide() {
  if (!container) return;
  if (scrollAmount > 0) {
    scrollAmount -= cardWidth;
    container.scrollTo({ left: scrollAmount, behavior: "smooth" });
  } else {
    scrollAmount = container.scrollWidth - container.clientWidth;
    container.scrollTo({ left: scrollAmount, behavior: "smooth" });
  }
}

/* =========================================================
   4. OTOMATİK KAYDIRMA (AUTO SCROLL)
   ========================================================= */
/**
 * Otomatik kaydırmayı başlatır.
 */
function startAutoScroll() {
  stopAutoScroll(); // Önce var olanı sıfırla
  autoScroll = setInterval(nextSlide, 5000); // 5 saniyede bir kaydır
}

/**
 * Otomatik kaydırmayı durdurur.
 */
function stopAutoScroll() {
  if (autoScroll) clearInterval(autoScroll);
  autoScroll = null;
}

/* =========================================================
   5. EVENT LİSTENER'LAR
   ========================================================= */

// "Sonraki" butonuna tıklandığında
if (nextBtn) {
  nextBtn.addEventListener("click", () => {
    nextSlide();
    startAutoScroll(); // manuel tıklama sonrası auto-scroll sıfırlanır
  });
}

// "Önceki" butonuna tıklandığında
if (prevBtn) {
  prevBtn.addEventListener("click", () => {
    prevSlide();
    startAutoScroll();
  });
}

// Pencere boyutu değişirse kart genişliği yeniden hesaplanır
window.addEventListener("resize", measureCardWidth);

// Sayfa yüklendiğinde kart genişliği ölçülür ve auto scroll başlatılır
document.addEventListener("DOMContentLoaded", () => {
  measureCardWidth();
  startAutoScroll();
});
const profilMenu = document.querySelector(".profil-menu");
const ikon = document.querySelector(".profil-ikon");

ikon.addEventListener("click", (e) => {
  e.stopPropagation();
  profilMenu.classList.toggle("active");
});

document.addEventListener("click", () => {
  profilMenu.classList.remove("active");
});
