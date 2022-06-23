@extends('user.template.template')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Absen Masuk</h3>
                        </div>
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                        @endif
                        @error('error')
                        <div class="alert alert-danger">
                            <ul>
                            <li>{{ $message}}</li>
                            </ul>
                        </div>
                        @enderror
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('user.absen.process_masuk') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <div class="form-group">
                                            <td><label for="exampleInputEmail1">NAMA</label></td>
                                            <td>:</td>
                                            <td>{{ auth()->user()->name }}</td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="form-group">
                                            <td><label for="exampleInputPassword1">NIP</label></td>
                                            <td>:</td>
                                            <td>{{ auth()->user()->nip }}</td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="form-group">
                                            <td><label for="exampleInputPassword1">TANGGAL SEKARANG</label></td>
                                            <td>:</td>
                                            <td><?php echo date('d / M / y'); ?></span></td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="form-group">
                                            <td><label for="exampleInputPassword1">WAKTU SEKARANG</label></td>
                                            <td>:</td>
                                            <td><span id="time"></span></td>
                                        </div>
                                    </tr>
                                </table>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('js')
    <script type="text/javascript" charset="utf-8">
        let a;
        let time;
        setInterval(() => {
            a = new Date();
            time = a.getHours() + ':' + a.getMinutes() + ':' + a.getSeconds();
            document.getElementById('time').innerHTML = time;
        }, 1000);
    </script>
@endsection
