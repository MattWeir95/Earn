
@if(!$historic || !$prediction)
<div>
    <widget>
        <div class="rounded-xl font-semibold border-2 shadow-xl w-full bg-gradient-to-b from-indigo-300 to-indigo-400">
           <div class="text-white text-3xl text-center py-20">No data to display</div>
        </div>
    </widget>
</div>
@else

<div>
    <widget>
        <div class="rounded-xl font-semibold border-2 shadow-xl w-full bg-gradient-to-b from-indigo-300 to-indigo-400">
            <div class="" id=chart> </div>
        </div>
    </widget>
</div>
@endif




<script>
    var options = {
        
        stroke: {
          width: 2,
          curve: 'smooth',
          
        },
        chart: {
            
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        
        dataLabels: {
            background: {
            enabled: false,
        },
            enabled: false,
          
            style: {
            fontSize: '10px',
                colors: ['#FFFFFF'] ,
          },
          
        },
        grid: {
            show: false,
        },
        chart: {
            toolbar: {
                show: false,
            },
            type: 'line',
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: false,

                },
            },
        },
        series: [{
                name: 'Historic',
                data: @json($historic),
                color: '#FFFFFF'
            },
            {
                name: 'Prediction',
                data: @json($prediction),
                color: '#000000'
            },

        ],
        xaxis: {
            labels:{
                style: {
                    colors : ['#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF']
                }
            },
            tickPlacement: 'on',
            categories: @json($months),
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    colors : ['#FFFFFF']
                }
            }
        },
        legend: {
            
            labels: {
                useSeriesColors: true,
            },
       
    }
}


var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
</script>