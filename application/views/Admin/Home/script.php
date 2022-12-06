<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url("assets/js/node_modules/hammerjs/hammer.js") ?>"></script>
<script src="<?= base_url("assets/js/node_modules/chartjs-plugin-zoom/dist/chartjs-plugin-zoom.min.js") ?>"></script>

<script>
    const interpolateBetweenColors = (
        fromColor,
        toColor,
        percent
    ) => {
        const delta = percent / 100;
        const r = Math.round(toColor.r + (fromColor.r - toColor.r) * delta);
        const g = Math.round(toColor.g + (fromColor.g - toColor.g) * delta);
        const b = Math.round(toColor.b + (fromColor.b - toColor.b) * delta);

        return `rgba(${r}, ${g}, ${b},.8)`;
    };

    $(".__tgl_label").html(`Rekap Pembelian Sampah ${moment(`<?= date("Y-m") ?>`).locale('ID').format('MMMM YYYY')}`);
    const ___data = {
        "label": [],
        "saldo": [],
    };

    const config = {
        type: 'bar',
        data: {
            labels: ___data.label,
            datasets: [{
                label: 'Total Berat',
                data: ___data.saldo,
                backgroundColor: 'rgba(134,159,152, 1)',
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            plugins: {
                zoom: {
                    zoom: {
                        wheel: {
                            enabled: false,
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'xy',
                    }
                }
            }
        }
    };

    const ctx = document.getElementById('Graph').getContext('2d');
    var myChart = new Chart(ctx, config);

    const initDataChart = async (tanggal = "") => {
        const gets = await axios.get("<?= base_url("RekapAdmin/chart_BankRekap?tahun=2022") ?>").catch(() => {
            console.log("error");
        });
        if (gets?.status ?? 400 == 200) {
            const dataMain = gets?.data?.result;
            const labels = [];
            const totals = [];
            dataMain?.map((x) => {
                labels.push(x.bank?.nama_bank);
                totals.push(x?.total?.KG)
            })
            var colors2 = totals.map((inc) => interpolateBetweenColors({
                    r: 0,
                    g: 255,
                    b: 0
                }, {
                    r: 255,
                    g: 0,
                    b: 0
                },
                inc
            ));
            // console.log(gets);

            myChart.data.labels = labels;
            myChart.data.datasets[0].data = totals;
            myChart.data.datasets[0].backgroundColor = colors2

            myChart.update();
        }
    }
    initDataChart();
</script>