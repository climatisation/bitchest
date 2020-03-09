// table select
// function toggleSelected(e) {
//     e.classList.add('selected');
// }

// charts
const ctx = document.getElementById("myChart");
// test chart (single crypto 30 days)
if (typeof thirtyDaysLabels !== 'undefined' && thirtyDaysLabels !== '') {
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
}

// test multiple crypto's multiple charts
const niceColors = ['#97e9c8', '#f72f18', '#7e7ba2', '#21fffc', '#e66b51', '#f9b619', '#8CDEFF', '#FF5977', '#FFF873', '#59FFA4', '#7A73FF'];
let clr = 0;
for (const item in allCryptosData) {
    const ctx30 = document.getElementById(allCryptosData[item].symbol + '-30');
    new ChartJs(ctx30, {
        type: "line",
        data: {
            labels: Array.from({ length: allCryptosData[item].data.length }).map((it, ind) => ind.toString()),
            datasets: [
                {
                    fill: false,
                    // backgroundColor: niceColors[clr],
                    // backgroundColor: '#f72f18',
                    borderColor: niceColors[clr],
                    borderWidth: 2,
                    data: [...allCryptosData[item].data],
                    pointRadius: 0,
                    lineTension: 0.3
                }
            ]
        },
        options: {
            events: [],
            tooltips: {
                enabled: false
            },
            responsive: true,
            scales : {
                yAxes: [{
                    display: false
                }],
                xAxes: [{
                    display: false
                }]
            },
            legend: { display: false },
            title: {
                display: false
            }
        }
    });
    clr++;
}
