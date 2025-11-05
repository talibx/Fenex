<!-- resources/views/inventory/index.blade.php -->
@extends('layouts.fenex')
<style>
    .pagination {
           display: inline-block;
           padding-left: 0;
           margin: 20px 0;
           border-radius: 4px;
           justify-content: center;
       }
</style>

@section('title', 'inventories')
@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h4 class="mb-2 mb-md-0">Inventories ({{$total_inventory}})</h4>
        <div class="text-center mb-2 mb-md-0">
            Products ( {{count($products)}} ) | Total Cost : {{$total_cost}} AED
        </div>
        <a href="{{ route('inventories.create') }}" class="btn btn-sm btn-success">Add New Inventory Item</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead class="table-success">
                        <tr>
                            <th>Product</th>
                            <!-- <th>Product Image</th>   -->
                            <th>Inventory Actions</th>
                            <th>Quantity</th>
                            <th>Condition</th>
                            <th>Photos</th>

                            <th style="width: 20%">Details</th>
                           
                            <th><a href="{{ route('inventories.index', ['sort' => 'created_at']) }}">Created At</a></th>
                            <th><a href="{{ route('inventories.index', ['sort' => 'updated_at']) }}">Updated At</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventories as $inventory)
                        <tr class="{{ $inventory->inventory_actions == 'add to inventory' ? 'text-success-row' : 'text-danger-row' }}">
                            
                            <td>
                                @if($inventory->product->main_photo)
                                <a href="{{ route('products.show', $inventory->product) }}" target="_blank">
                                    <img src="{{ asset('storage/app/public/' . $inventory->product->main_photo) }}" alt="{{ $inventory->product->name }}" class="img-thumbnail" style="max-width: 75px;max-width: 100px;">
                                </a>   
                                <br>  
                                @else       
                                    No photo available
                                @endif

                                <span id="product_name" data-fulltext="{{ $inventory->product->name }}" data-limit="30">
                                    {{ $inventory->product->name }}
                                </span>
                            </td>
                            
                            <td>{{ ucfirst($inventory->inventory_actions) }}</td>

                            @if($inventory->quantity <= 0)  
                                <td style='color: red !important;font-weight:bold'>
                                    {{ $inventory->quantity }}
                                </td>    
                            @else
                                <td style='color: green !important;font-weight:bold'>
                                    {{ $inventory->quantity }}
                                </td>  
                            @endif  

                            <td>{{ ucfirst($inventory->condition) }}</td>
                            <td>
                                @include('components.photo-display', ['photos' => $inventory->photos])
                            </td>

                            {{-- <td>{{ ucfirst($inventory->details) }}</td> --}}

                            <td>
                                <span id="details" data-fulltext="{{$inventory->details}}" data-limit="30">
                                    {{$inventory->details}}
                                </span>
                            </td>
                        
                            <td>{{ $inventory->created_at->format('M d, Y') }}</td>
                            <td>{{ $inventory->updated_at->diffForHumans() }}</td>
                            <td class="text-center">
                                <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="bi bi-pencil"></i>Edit</a>
                                <form action="{{ route('inventories.destroy', $inventory) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Inventory?')" title="Delete"><i class="bi bi-trash"></i>Delete</button>
                                </form>
                            </td>
                        </>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>
    <div class="pagination">
                    <!-- want more detial see this : https://stackoverflow.com/questions/17159273/laravel-pagination-links-not-including-other-get-parameters -->
        {{ $inventories->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
    </div>

    <!-- <div class="mt-4">
        {{ $inventories->appends(request()->except('page'))->links() }}
    </div> -->
</div>
@include('components.photo-modal')
                            
@endsection
