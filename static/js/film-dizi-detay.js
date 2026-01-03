/*
📁 Bölüm: UI (Statik Varlıklar - JS)
📄 Amaç: Film/Dizi detay sayfası JS
🔗 İlişkili: film-detay.php, dizi-detay.php, static/css/film-dizi-detay.css
⚙️ Özet: Profil dropdown, geri butonu ve kitaplığa ekleme gibi etkileşimleri yönetir
*/
document.addEventListener("DOMContentLoaded", () => {
  // ================== PROFİL DROPDOWN ==================
  const profilMenu = document.querySelector(".profil-menu");
  const profilIkon = document.querySelector(".profil-ikon");
  if (profilIkon && profilMenu) {
    profilIkon.addEventListener("click", (e) => {
      e.stopPropagation();
      profilMenu.classList.toggle("active");
    });
    document.addEventListener("click", () =>
      profilMenu.classList.remove("active")
    );
  }

  // ================== GERİ BUTONU ==================
  const geriBtn = document.getElementById("geriBtn");
  if (geriBtn) {
    geriBtn.addEventListener("click", () => {
      if (window.history.length > 1) window.history.back();
      else window.location.href = "/templates/filmler/filmler.html";
    });
  }

  // ================== KİTAPLIĞA EKLE ==================
  const filmMain = document.getElementById("filmMain");
  const filmId = filmMain?.dataset?.filmId || "film";
  const kitaplikBtn = document.getElementById("kitaplikBtn");

  function kitaplikDurumunuYukle() {
    const ekliMi = localStorage.getItem(`kitaplik_${filmId}`) === "1";
    if (kitaplikBtn) {
      kitaplikBtn.classList.toggle("ekli", ekliMi);
      kitaplikBtn.textContent = ekliMi
        ? "Kitaplıktan Çıkar"
        : "+ Kitaplığa Ekle";
    }
  }
  if (kitaplikBtn) {
    kitaplikDurumunuYukle();
    kitaplikBtn.addEventListener("click", () => {
      const ekliMi = localStorage.getItem(`kitaplik_${filmId}`) === "1";
      if (ekliMi) localStorage.removeItem(`kitaplik_${filmId}`);
      else localStorage.setItem(`kitaplik_${filmId}`, "1");
      kitaplikDurumunuYukle();
    });
  }
  document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll("#inlineStars .fa-star");
    const form = document.getElementById("puanForm");
    const input = document.getElementById("puanInput");

    if (!stars.length) return;

    stars.forEach((star) => {
      star.addEventListener("click", () => {
        const puan = parseInt(star.getAttribute("data-value"), 10);
        input.value = puan;
        form.submit(); // doğrudan PHP'ye gönder
      });

      // Hover efekti (isteğe bağlı)
      star.addEventListener("mouseover", () => {
        const val = parseInt(star.getAttribute("data-value"), 10);
        stars.forEach((s) =>
          s.classList.toggle("hovered", parseInt(s.dataset.value) <= val)
        );
      });

      star.addEventListener("mouseleave", () => {
        stars.forEach((s) => s.classList.remove("hovered"));
      });
    });
  });

  document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("inlineStars");
    if (!container) return;

    const stars = container.querySelectorAll(".fa");
    const form = document.getElementById("puanForm");
    const input = document.getElementById("puanInput");
    const avgEl = document.getElementById("inlineAverage");

    let userRating =
      parseFloat(container.getAttribute("data-user-rating")) || 0;
    let avgRating = parseFloat(container.getAttribute("data-avg")) || 0;

    // Ortalama puanı yaz
    if (avgEl && !Number.isNaN(avgRating)) {
      avgEl.textContent = `(${avgRating.toFixed(1)} / 5)`;
    }

    // Yıldızları boyama fonksiyonu
    function paintStars(value, isHalf = false) {
      stars.forEach((star, idx) => {
        const val = idx + 1;
        star.className = "fa"; // reset
        if (val <= value) {
          star.classList.add("fa-star");
        } else {
          star.classList.add("fa-star-o");
        }
      });
    }

    // Sayfa yüklenince:
    if (userRating > 0) {
      paintStars(userRating);
    } else {
      paintStars(Math.round(avgRating));
    }

    // Hover efekti
    stars.forEach((star) => {
      star.style.cursor = "pointer";

      star.addEventListener("mouseover", () => {
        const val = parseInt(star.getAttribute("data-value"), 10);
        paintStars(val);
      });

      star.addEventListener("mouseleave", () => {
        paintStars(userRating > 0 ? userRating : Math.round(avgRating));
      });

      star.addEventListener("click", (e) => {
        e.preventDefault();
        const val = parseInt(star.getAttribute("data-value"), 10);
        input.value = val;
        userRating = val;
        paintStars(val);
        form.submit();
      });
    });
  });
});
