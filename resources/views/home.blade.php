@extends('layouts.app')
@section('title')
    Home
@endsection
@section('content')
    <div class="row">
        <div class="col"></div>
        <div class="col-3">
            <?php
            echo date('m/d/Y', time());
			echo ' - ';
            echo date('m/d/Y', strtotime('-30 days'));
            ?>
        </div>
        <div class="col"></div>
    </div>
@endsection
