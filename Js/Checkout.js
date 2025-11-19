// Ambil data keranjang dari sessionStorage
const cart = JSON.parse(sessionStorage.getItem('cart')) || [];
const tbody = document.querySelector('#checkoutTable tbody');
let total = 0;

// 🔹 1. Tampilkan isi keranjang di tabel checkout
cart.forEach(item => {
  const subtotal = item.qty * item.price;
  total += subtotal;
  const row = `
    <tr>
      <td>${item.name}</td>
      <td>Rp ${item.price.toLocaleString('id-ID')}</td>
      <td>${item.qty}</td>
      <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
    </tr>
  `;
  tbody.innerHTML += row;
});

document.getElementById('totalHarga').textContent = `Total: Rp ${total.toLocaleString('id-ID')}`;

// 🔹 2. Fungsi pembantu untuk ambil teks pesanan
function getOrderText() {
  let pesan = "";
  document.querySelectorAll("#checkoutTable tbody tr").forEach(row => {
    const nama = row.children[0].textContent;
    const jumlah = row.children[2].textContent;
    pesan += `- ${nama} x${jumlah}\n`;
  });
  return pesan;
}

// 🔹 3. Saat tombol "Bayar via WA" ditekan
document.getElementById('bayarWA').addEventListener('click', async () => {
  if (cart.length === 0) return alert('Tidak ada pesanan.');

  // Ambil data nama dan alamat
  const nama = document.getElementById("nama").value.trim();
  const alamat = document.getElementById("alamat").value.trim();

  if (!nama || !alamat) {
    alert("Harap isi nama dan alamat sebelum melanjutkan pembayaran.");
    return;
  }

  // 🔹 4. Update stok di database
  try {
    const response = await fetch('Backend/update_stock.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify(cart)
    });
    const result = await response.json();

    if (result.status !== 'success') {
      alert('Gagal memperbarui stok: ' + result.message);
      return;
    }
  } catch (error) {
    alert('Terjadi kesalahan koneksi ke server.');
    return;
  }

  // 🔹 5. Setelah stok berhasil dikurangi, buat pesan WhatsApp
  let pesan = `Halo! Saya ingin memesan makanan:%0A`;
  cart.forEach(i => {
    pesan += `- ${i.name} x${i.qty} = Rp ${(i.price * i.qty).toLocaleString('id-ID')}%0A`;
  });

  let total = cart.reduce((acc, i) => acc + (i.qty * i.price), 0);
  pesan += `%0ATotal: Rp ${total.toLocaleString('id-ID')}`;
  
  const kode = "ORD" + Math.floor(Math.random() * 100000);
  pesan += `%0AKode Pesanan: ${kode}`;
  pesan += `%0A%0ANama: ${nama}%0AAlamat: ${alamat}`;

  // 🔹 5b. Simpan pesanan ke database
try {
  const saveOrder = await fetch('Backend/save_order.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      customer_name: nama,
      alamat: alamat,
      items: cart,
      total_price: total
    })
  });
  const saveResult = await saveOrder.json();

  if (saveResult.status !== 'success') {
    alert('Gagal menyimpan pesanan ke database.');
    return;
  }
} catch (error) {
  alert('Terjadi kesalahan saat menyimpan pesanan.');
  return;
}

  // 🔹 6. Arahkan ke WhatsApp (ubah nomor WA sesuai kebutuhan)
  const waLink = `https://wa.me/6287897966270?text=${pesan}`;
  window.location.href = waLink;

  // 🔹 7. Bersihkan keranjang
  sessionStorage.removeItem('cart');
});
