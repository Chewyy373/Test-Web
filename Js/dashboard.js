async function getJSON(url) {
    const res = await fetch(url);
    return await res.json();
}

document.addEventListener("DOMContentLoaded", async () => {

    // ===== Summary =====
    const summary = await getJSON("Backend/summary.php");
    document.getElementById("rev").innerText =
        "Rp " + summary.totalRevenue.toLocaleString();
    document.getElementById("cust").innerText = summary.totalCustomers;
    document.getElementById("orders").innerText = summary.totalOrders;
    document.getElementById("conv").innerText = summary.conversion + "%";

    // ===== Best Selling =====
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

    // ===== Recent Orders =====
    const recent = await getJSON("Backend/recentOrders.php");
    const table = document.getElementById("recentOrders");

    recent.forEach(o => {
        table.innerHTML += `
        <tr>
            <td>${o.kode}</td>
            <td>${o.customer_name}</td>
            <td>Rp ${Number(o.total).toLocaleString()}</td>
            <td>${o.created_at}</td>
            <td><span class="status ${o.status.toLowerCase()}">${o.status}</span></td>
        </tr>`;
    });

    // ===== Chart =====
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
                tension: .3,
                borderWidth: 2
            });
        }

        if (type === "order" || type === "both") {
            chart.data.datasets.push({
                label: "Orders",
                data: chartData.orders,
                borderDash: [5, 3],
                tension: .3,
                borderWidth: 2
            });
        }

        chart.update();
    }

    updateChart("both");

    document.getElementById("chartType").addEventListener("change", e => {
        updateChart(e.target.value);
    });

});
