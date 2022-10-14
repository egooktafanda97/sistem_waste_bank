<script nonce="undefined" src="https://cdn.zingchart.com/zingchart.min.js"></script>
<?php if (!empty($this->session->flashdata("success"))) : ?>
    <script>
        swal({
            title: "Berhasil",
            text: "<?= $this->session->flashdata("success") ?>",
            icon: "success",
            button: "ok",
        });
    </script>
<?php endif ?>
<?php if (!empty($this->session->flashdata("error"))) : ?>
    <script>
        swal({
            title: "Oops!",
            text: "<?= $this->session->flashdata("error") ?>",
            icon: "error",
            button: "ok",
        });
    </script>
<?php endif ?>

<script>
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "b55b025e438fa8a98e32482b5f768ff5"];
    var myConfig = {
        "type": "bar",

        "plot": {
            "aspect": "candlestick",
            "tooltip": {
                "visible": false
            },
            "preview": { //To style the preview chart.
                "type": "area", //"area" (default) or "line"
                "line-color": "#33ccff",
                "line-width": 2,
                "line-style": "dotted",
                "background-color": "#ff3300",
                "alpha": 1,
                "alpha-area": 0.1
            },
            "trend-up": {
                "background-color": "#33ccff",
                "border-color": "#33ccff",
                "line-color": "#33ccff"
            },
            "trend-down": {
                "background-color": "#ff3300",
                "border-color": "#ff3300",
                "line-color": "#ff3300"
            }
        },
        "preview": {

        },
        "scale-x": {
            "min-value": 1420232400000,
            "step": "day",
            "transform": {
                "type": "date",
                "all": "%M %d"
            },
            "item": {
                "font-size": 10
            },
            "max-items": 9,
            "zooming": true,
            "zoom-to-values": [1422910800000, 1430427600000]
        },
        "scale-y": {
            "values": "28:34:1",
            "format": "$%v",
            "item": {
                "font-size": 10
            },
            "guide": {
                "line-style": "dotted"
            }
        },
        "crosshair-x": {
            "plot-label": {
                "text": "Open: $%open<br>",
                "decimals": 2,
                "multiple": true
            },
            "scale-label": {
                "text": "%v",
                "transform": {
                    "type": "date",
                    "all": "%M %d, %Y"
                }
            }
        },
        "crosshair-y": {
            "type": "multiple",
            "scale-label": {
                "visible": false
            }
        },
        "series": [{
            "values": [
                [1420232400000, [31.34]], //01/02/15

                [1420491600000, [31.80]], //01/05/15
                [1420578000000, [32.05]], //01/06/15
                [1420664400000, [32.21]], //01/07/15
                [1420750800000, [32.32]], //01/08/15
                [1420837200000, [32.52]], //01/09/15

            ]
        }]
    };

    zingchart.render({
        id: 'myChart',
        data: myConfig,
        height: 400,
        width: "100%"
    });
</script>