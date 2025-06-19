@extends('layouts.header')

@section('container')
<section class="content">
    <div class="container-fluid">
        <h1>Selamat Datang {{ Auth::user()->name }}! <br>Halaman Dashboard</h1>
        <div class="card bg-light">
            <div class="card-body">
                <div class="row">
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection