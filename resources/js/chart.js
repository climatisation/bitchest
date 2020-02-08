const ctx = document.getElementById("myChart");
// test chart
new ChartJs(ctx, {
    type: "line",
    data: {
        // labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
        labels: [...thirtyDaysLabels],
        datasets: [
            {
                label: "Price in Euro €",
                backgroundColor: [
                    "#3e95cd",
                    "#8e5ea2",
                    "#3cba9f",
                    "#e8c3b9",
                    "#c45850"
                ],
                data: [...thirtyDays]
            }
        ]
    },
    options: {
        legend: { display: false },
        title: {
            display: true,
            text: `${currentCryptoName} price last 30 days`
            // text: " price last 30 days"
        }
    }
});
