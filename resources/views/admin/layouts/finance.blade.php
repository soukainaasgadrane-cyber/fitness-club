@extends('admin.layouts.app')

@section('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .stat-icon {
        font-size: 40px;
        opacity: 0.8;
    }
    .stat-number {
        font-size: 32px;
        font-weight: bold;
    }
    .stat-label {
        font-size: 14px;
        opacity: 0.9;
    }
    .filter-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endsection