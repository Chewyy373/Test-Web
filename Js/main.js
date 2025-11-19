function animateFlyToCart(imgElement) {
  const checkout = document.getElementById('checkoutBtn');
  if (!checkout) return;

  // ambil posisi gambar di card
  const imgRect = imgElement.getBoundingClientRect();
  const checkoutRect = checkout.getBoundingClientRect();

  // clone gambar
  const flyImg = imgElement.cloneNode(true);
  flyImg.classList.add('fly-img');
  document.body.appendChild(flyImg);

  // set posisi awal
  flyImg.style.left = imgRect.left + "px";
  flyImg.style.top = imgRect.top + "px";

  setTimeout(() => {
    flyImg.style.transform = `
      translate(${checkoutRect.left - imgRect.left}px, 
                ${checkoutRect.top - imgRect.top}px)
      scale(0.2)
    `;
    flyImg.style.opacity = "0";
  }, 10);

  // hapus setelah animasi selesai
  setTimeout(() => flyImg.remove(), 900);
}

document.addEventListener('click', function(e) {
  // Jika tombol harga ditekan
  if (e.target.classList.contains('price-btn') && !e.target.classList.contains('active')) {
    const btn = e.target;
    const id = btn.dataset.id;
    const name = btn.dataset.name;
    const price = btn.dataset.price;

    const cardImg = btn.closest('.food-card').querySelector('img');
    animateFlyToCart(cardImg);

    // ubah tombol harga jadi kontrol jumlah
    btn.outerHTML = `
      <div class="qty-control" data-id="${id}" data-name="${name}" data-price="${price}">
        <button class="minus">-</button>
        <span class="qty">1</span>
        <button class="plus">+</button>
      </div>
    `;
  }

  // tombol tambah
  if (e.target.classList.contains('plus')) {
    const qtyElem = e.target.parentElement.querySelector('.qty');
    qtyElem.textContent = parseInt(qtyElem.textContent) + 1;
  }

  // tombol kurang
  if (e.target.classList.contains('minus')) {
    const container = e.target.parentElement;
    const qtyElem = container.querySelector('.qty');
    const newQty = parseInt(qtyElem.textContent) - 1;

    if (newQty <= 0) {
      // kalau 0, kembalikan ke tombol harga semula
      const price = container.dataset.price;
      const name = container.dataset.name;
      const id = container.dataset.id;

      container.outerHTML = `
        <button class="price-btn"
                data-id="${id}"
                data-name="${name}"
                data-price="${price}">
          Rp.${parseInt(price).toLocaleString('id-ID')}
        </button>
      `;
    } else {
      qtyElem.textContent = newQty;
    }
  }
});

document.getElementById('checkoutBtn').addEventListener('click', () => {
  const items = [];

  // Ambil semua item yang memiliki qty-control
  document.querySelectorAll('.qty-control').forEach(el => {
    const id = el.dataset.id;
    const name = el.dataset.name;
    const price = parseInt(el.dataset.price);
    const qty = parseInt(el.querySelector('.qty').textContent);
    items.push({ id, name, price, qty });
  });

  if (items.length === 0) {
    alert("Pilih setidaknya satu makanan sebelum checkout!");
    return;
  }

  // Simpan ke sessionStorage (agar bisa diakses di halaman checkout.php)
  sessionStorage.setItem('cart', JSON.stringify(items));

  // Arahkan ke halaman checkout
  window.location.href = 'Checkout.php';
});