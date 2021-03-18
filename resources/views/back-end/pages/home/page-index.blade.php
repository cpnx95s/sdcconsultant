<div>
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Simple Line Chart"
            },
            data: [{
                type: "line",
                indexLabelFontSize: 16,
                dataPoints: [{
                        y: 450
                    },
                    {
                        y: 414
                    },
                    {
                        y: 520,
                        indexLabel: "\u2191 highest",
                        markerColor: "red",
                        markerType: "triangle"
                    },
                    {
                        y: 460
                    },
                    {
                        y: 450
                    },
                    {
                        y: 500
                    },
                    {
                        y: 480
                    },
                    {
                        y: 480
                    },
                    {
                        y: 410,
                        indexLabel: "\u2193 lowest",
                        markerColor: "DarkSlateGrey",
                        markerType: "cross"
                    },
                    {
                        y: 500
                    },
                    {
                        y: 480
                    },
                    {
                        y: 510
                    }
                ]
            }]
        });
        chart.render();

    }
</script>