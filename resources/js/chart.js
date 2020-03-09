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
            labels: [...thirtyDaysLabels],
            datasets: [
                {
                    fill: false,
                    label: "Price in Euro €",
                    borderColor: "#FFDF00",
                    borderWidth: 2,
                    lineTension: 0.2,
                    data: [...thirtyDays]
                }
            ]
        },
        options: {
            responsive: true,
            legend: { display: false },
            title: {
                display: true,
                text: `${currentCryptoName} price last 30 days`
                // text: " price last 30 days"
            },
            scales: {
                yAxes: [{
                    display: false
                }],
                xAxes: [{
                    display: false
                }]
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
