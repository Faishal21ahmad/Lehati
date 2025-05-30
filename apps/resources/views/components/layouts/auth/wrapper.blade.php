@props([
    'title' => ''
])
<!-- component/layouts/auth/wrapper.blade.php -->
@extends('components.layouts.base.main') <!-- Pakai template dasar -->
@section('title', $title) 

@section('content') <!-- Isi konten utama -->
<div class="">
  {{ $slot }} <!-- Tempat Livewire menyisipkan konten -->
</div>
@endsection