<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Penjualan Galon</title>
    <!-- Memuat Library Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <style>
        .highcharts-figure, .highcharts-data-table table {
            min-width: 310px; 
            max-width: 1000px;
            margin: 1em auto;
        }
        #container {
            height: 500px;
        }
    </style>
</head>
<body>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description" style="text-align: center;">
        Grafik menunjukkan hubungan antara jumlah galon yang terjual dengan total pendapatan per bulan.
    </p>
</figure>

<script>
    // Data dari query Anda
    // Format: [Tahun, Bulan, Jml Hari, Jml Galon, Total Harga]
    const rawData = [
        { period: 'Sep 2024', days: 2, galon: 110, price: 660000 },
        { period: 'Oct 2024', days: 1, galon: 51, price: 306000 },
        { period: 'Nov 2024', days: 22, galon: 1642,  price: 9852000 },
        { period: 'Dec 2024', days: 14, galon: 930,  price: 5580000 },
        { period: 'Jan 2025', days: 23, galon: 1653,  price: 9918000 },
        { period: 'Feb 2025', days: 24, galon: 1521,  price: 9126000 },
        { period: 'Mar 2025', days: 17, galon: 747,  price: 4482000 },
        { period: 'Apr 2025', days: 10,  galon: 783,   price: 4698000 },
        { period: 'May 2025', days: 26, galon: 1685,  price: 10110000 },
        { period: 'Jun 2025', days: 14,  galon: 918,   price: 5508000 },
        { period: 'Jul 2025', days: 15,  galon: 1013,  price: 6078000 },
        { period: 'Aug 2025', days: 27,  galon: 1852,  price: 11112000 },
        { period: 'Sep 2025', days: 22,  galon: 1483,  price: 8898000 },
        { period: 'Oct 2025', days: 25, galon: 1679, price: 10074000 },
        { period: 'Nov 2025', days: 22, galon: 2423, price: 14538000 },
        { period: 'Dec 2025', days: 14,  galon: 875, price: 5250000 }
    ];

    // Memisahkan data untuk Highcharts
    const categories = rawData.map(d => d.period);
    const dataGalon = rawData.map(d => ({ y: d.galon, customDays: d.days })); // customDays untuk tooltip
    const dataPrice = rawData.map(d => ({ y: d.price, customDays: d.days }));

    Highcharts.chart('container', {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Statistik Penjualan Galon Bulanan Tanjung Laut',
            align: 'center'
        },
        subtitle: {
            text: 'Periode: Sep 2024 - Des 2025',
            align: 'center'
        },
        xAxis: [{
            categories: categories,
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis (Untuk Galon)
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            title: {
                text: 'Jumlah Galon',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            }
        }, { // Secondary yAxis (Untuk Harga)
            title: {
                text: 'Total Harga (Rp)',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            labels: {
                formatter: function() {
                    return 'Rp ' + Highcharts.numberFormat(this.value, 0, ',', '.');
                },
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true,
            formatter: function () {
                let s = '<b>' + this.x + '</b>';
                let days = 0;
                
                this.points.forEach(function (point) {
                    // Ambil customDays dari point pertama yg ditemukan
                    if (point.point.customDays) days = point.point.customDays;
                    
                    let prefix = point.series.name === 'Total Harga' ? 'Rp ' : '';
                    let val = Highcharts.numberFormat(point.y, 0, ',', '.');
                    s += '<br/><span style="color:' + point.color + '">\u25CF</span> ' + 
                         point.series.name + ': <b>' + prefix + val + '</b>';
                });

                // Menambahkan info jumlah hari di bagian bawah tooltip
                s += '<br/>-------------------------';
                s += '<br/>Jumlah Hari Aktif: <b>' + days + ' hari</b>';
                
                return s;
            }
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 50,
            floating: true,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || // theme
                'rgba(255,255,255,0.25)'
        },
        series: [{
            name: 'Jumlah Galon',
            type: 'column',
            yAxis: 0,
            data: dataGalon,
            tooltip: {
                valueSuffix: ' Galon'
            }

        }, {
            name: 'Total Harga',
            type: 'spline',
            yAxis: 1,
            data: dataPrice,
            tooltip: {
                valuePrefix: 'Rp '
            },
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[1],
                fillColor: 'white'
            }
        }]
    });
</script>

</body>
</html>