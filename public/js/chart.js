function showYearlyChart(yearlyChart) {
    const lineLabels = yearlyChart.labels;
    const lineData = {
        labels: lineLabels,
        datasets: yearlyChart.dataset
    };
    const lineConfig = {
        type: 'line',
        data: lineData,
    };
    let lineChart = new Chart(
        document.getElementById('lineChart'), lineConfig);
}

function showPieChart(repairedChart) {
    const pieData = {
        labels: repairedChart.labels,
        datasets: repairedChart.dataset,
    };
    console.log(pieData);
    const pieConfig = {
        type: 'pie',
        data: pieData,
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(item) {
                            const reducer = (total, i) => total + i;
                            const total = item.parsed / item.dataset.data.reduce(reducer);
                            return item.label + ` ${Math.round(total*10000)/100}%`;
                        }
                    }
                }
            }
        }
    };
    let pieChart = new Chart(
        document.getElementById('pieChart'),
        pieConfig
    );
}

function showMonthlyChart(monthlyChart) {
    const line2Labels = monthlyChart.labels;
    const line2Data = {
        labels: line2Labels,
        datasets: monthlyChart.dataset
    };
    const line2Config = {
        type: 'line',
        data: line2Data,
    };
    var line2Chart = new Chart(
        document.getElementById('line2Chart'),
        line2Config
    );
}
