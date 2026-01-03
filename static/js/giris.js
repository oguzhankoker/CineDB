/*
📁 Bölüm: UI (Statik Varlıklar - JS)
📄 Amaç: Giriş sayfası JS animasyonları ve basit doğrulama
🔗 İlişkili: giris.php, static/css/giris.css
⚙️ Özet: Intro animasyonu ve giriş formunun istemci tarafı kontrolünü sağlar
*/
/* =========================================================
   INTRO ANİMASYONU
   ========================================================= */
/**
 * Sayfa ilk yüklendiğinde Cine.DB intro ekranını gösterir,
 * 1.5 saniye sonra gizler.
 */
window.addEventListener("load", () => {
  const intro = document.getElementById("intro");
  setTimeout(() => {
    if (intro) intro.style.display = "none";
  }, 1500);
});

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const user = document.getElementById("username").value.trim();
    const pass = document.getElementById("password").value.trim();

    if (!user || !pass) {
      alert("Lütfen tüm alanları doldurun!");
      return;
    }

    // Şimdilik sahte yönlendirme
    alert(`Hoş geldin, ${user}!`);
    window.location.href = "/filmler"; // örnek yönlendirme
  });
});
