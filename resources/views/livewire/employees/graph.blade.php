<div>
    <widget>
        <div class="rounded-xl font-semibold shadow-xl w-full bg-gradient-to-b from-indigo-300 to-indigo-400 min-h-full">
            <div class="mr-2" id=chart> </div>
        </div>
        
    </widget>
</div>




<script>
    var options = {
        noData: {
  text: "No Sales History",
  align: 'center',
  verticalAlign: 'middle',
  offsetX: 0,
  offsetY: 0,
  style: {
    color: '#FFFFFF',
    fontSize: '14px',
    
  },
},
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
                color: '#4f46e5'
            },

        ],
        xaxis: {
            labels: {
                style: {
                    colors : '#FFFFFF'
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
            tickAmount:5,
            showForNullSeries: false,
            labels: {
                show: true,
                style: {
                    colors : '#FFFFFF'
                },
                formatter: function (value) {
      return   "$" + value;
    }
            },
        },
        legend: {
            onItemClick: {
          toggleDataSeries: false
      },
            itemMargin: {
          horizontal: 30,
          vertical: 10,
      },
            position: 'top',
            
            labels: {
                useSeriesColors: true,
            },
       
    }
}


var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
</script>