@extends('layout.mainlayout')
 
@section('username',$username)
@section('useravatar',$useravatar)

@section('selectfrom') 
    <option value="1">{{$tinh}}</option>
@endsection

