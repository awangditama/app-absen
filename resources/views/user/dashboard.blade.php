@extends('user.template.template')
@section('subpage','Dashboard')
@section('content')
 <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
          <div>
            <table>
              <tr>
                       <td>NAMA</td>
                      <td>:</td>
                      <td>{{ auth()->user()->name }}</td>
              </tr>
              <tr>
                       <td>NIP</td>
                      <td>:</td>
                      <td>{{ auth()->user()->nip }}</td>
                  
              </tr>
            
            </table>
          </div>  
          
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Grafik Status Absensi</h3>
          
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="chart">
                            <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                          </div>
                        </div>
                        <!-- /.card-body -->
                    </div>  
                    </div>
                      <!-- /.card -->
          
                      <!-- DONUT CHART -->
                      
                      <!-- PIE CHART -->
                    </div>
                      <!-- /.card -->
          
                     
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Record Absensi</h3>
                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table id="myTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Absen Masuk</th>
                                        <th>Jam Absen Pulang</th>
                                        <th>Status Absen Masuk</th>
                                        <th>Status Absen Pulang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $data)
                                        <tr>
                                            <td>{{ $data->tanggal }}</td>
                                            <td>{{ $data->jam_masuk }}
                                            </td>
                                            <td>{{ $data->jam_keluar }}</td>
                                            <td> @if ($data->status_masuk === 2)
                                                Terlambat
                                             @else
                                                Tepat waktu
                                            @endif
                                            </td>
                                            <td>@if ($data->status_keluar === 2)
                                                Pulang Cepat
                                             @elseif ($data->status_keluar === 1)
                                                Pulang Normal
                                             @else
                                                Belum Absen Pulang   
                                            @endif</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        $(function () {
            var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
      
          var areaChartData = {
            labels  : ['Datang Tepat Waktu', 'Terlambat', 'Pulang Normal', 'Pulang Cepat'],
            datasets: [
              {
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : [{{ $grafik->tepat_waktu }}, {{ $grafik->terlambat }}, {{ $grafik->pulang_normal }}, {{ $grafik->pulang_cepat }}]
              }
              
            ]
          }
      
          var areaChartOptions = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
              display: false
            },
            scales: {
              xAxes: [{
                gridLines : {
                  display : true,
                }
              }],
              yAxes: [{
                gridLines : {
                  display : true,
                }
              }]
            }
          }
      
          // This will get the first returned node in the jQuery collection.
          new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
          })
      
        })
      </script>
@endsection
