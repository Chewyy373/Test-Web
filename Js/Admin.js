/* ============================================================
   Helper
============================================================ */
async function getJSON(url) {
    const res = await fetch(url);
    return await res.json();
}

/* ============================================================
   ON PAGE LOADED
============================================================ */
document.addEventListener("DOMContentLoaded", async () => {

    /* ============================================================
       1. TAB PANEL SWITCHER
    ============================================================ */
    const buttons = document.querySelectorAll(".tab-btn");
    const panels = document.querySelectorAll(".panel");

    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            buttons.forEach(b => b.classList.remove("active"));
            panels.forEach(p => p.classList.add("hidden"));

            btn.classList.add("active");
            document.getElementById(btn.dataset.target).classList.remove("hidden");
        });
    });

    /* ============================================================
       2. ORDER STATUS UPDATE (PAID / CANCEL)
    ============================================================ */
    async function updateOrderStatus(row, action) {
        const id = row.dataset.id;

        try {
            const response = await fetch("Backend/update_order_status.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: id, action: action })
            });

            const result = await response.json();

            if (result.status === "success") {

                if (action === "paid") {
                    row.querySelector("td:last-child").innerHTML =
                        `<span style="color:green;font-weight:bold;">Lunas</span>`;
                } else if (action === "cancel") {
                    row.querySelector("td:last-child").innerHTML =
                        `<span style="color:red;font-weight:bold;">Dibatalkan</span>`;
                }

                if (result.updatedStocks) {
                    result.updatedStocks.forEach(stock => {
                        const prodRow = document.querySelector(
                            `tr[data-product-name="${stock.name}"] .stock`
                        );
                        if (prodRow) {
                            prodRow.textContent = stock.new_stock;
                        }
                    });
                }
            } else {
                alert("Gagal memperbarui status pesanan.");
            }
        } catch (err) {
            alert("Terjadi kesalahan koneksi ke server.");
        }
    }

    document.querySelectorAll(".btn-paid").forEach(btn => {
        btn.addEventListener("click", async () => {
            const row = btn.closest("tr");
            await updateOrderStatus(row, "paid");
        });
    });

    document.querySelectorAll(".btn-cancel").forEach(btn => {
        btn.addEventListener("click", async () => {
            if (!confirm("Yakin ingin membatalkan pesanan ini?")) return;
            const row = btn.closest("tr");
            await updateOrderStatus(row, "cancel");
        });
    });

    /* ============================================================
       3. SUMMARY (Revenue, Customers, Orders, Conversion)
    ============================================================ */
    const summary = await getJSON("Backend/summary.php");

    document.getElementById("rev").innerText =
        "Rp " + summary.totalRevenue.toLocaleString();
    document.getElementById("cust").innerText = summary.totalCustomers;
    document.getElementById("orders").innerText = summary.totalOrders;
    document.getElementById("conv").innerText = summary.conversion + "%";

    /* ============================================================
       4. BEST SELLING PRODUCTS
    ============================================================ */
    const best = await getJSON("Backend/bestSelling.php");
    const bestBox = document.getElementById("bestProducts");

    best.forEach(p => {
        bestBox.innerHTML += `
        <div class="product">
            <img src="${p.image}">
            <div>
                <b>${p.item_name}</b><br>
                <span>${p.total_qty} Pcs Sold</span>
            </div>
        </div>`;
    });

    /* ============================================================
       5. RECENT ORDERS
    ============================================================ */
    /* ============================================================
       6. CHART (Revenue + Orders)
    ============================================================ */
    const chartData = await getJSON("Backend/chartData.php");

    const ctx = document.getElementById("summaryChart").getContext("2d");

    const chart = new Chart(ctx, {
        type: "line",
        data: {
            labels: chartData.labels,
            datasets: []
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    function updateChart(type) {
        chart.data.datasets = [];

        if (type === "revenue" || type === "both") {
            chart.data.datasets.push({
                label: "Revenue",
                data: chartData.revenue,
                borderColor: "#4CAF50",
                borderWidth: 2,
                tension: 0.3
            });
        }

        if (type === "order" || type === "both") {
            chart.data.datasets.push({
                label: "Orders",
                data: chartData.orders,
                borderDash: [5, 3],
                borderWidth: 2,
                tension: 0.3
            });
        }

        chart.update();
    }

    updateChart("both");

    document.getElementById("chartType").addEventListener("change", e => {
        updateChart(e.target.value);
    });

});
