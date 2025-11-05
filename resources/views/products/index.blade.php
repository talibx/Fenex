@extends('layouts.fenex')

@section('title', 'Products')

@section('content')
<style>
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
        justify-content: center;
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h4 class="mb-2 mb-md-0">Products ({{ $products->total() }})</h4>
        <div class="text-center mb-2 mb-md-0">
            All items: {{ $total_inventory }} | Total Cost: {{ number_format($total_cost, 2) }} AED
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">Add New Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Product</th>
                            <!-- <th>Main</th> -->
                            <th>Photos</th>
                            <th>Cost of Goods</th>
                            <th>Weight</th>
                            <th>new</th>
                            <th>used</th>
                            <th>d/bag</th>
                            <th>no/bag</th>
                            <th>d/all</th>
                            <th>replaced</th>
                            <th><a href="{{ route('products.index', ['sort' => 'created_at']) }}">Created At</a></th>
                            <th><a href="{{ route('products.index', ['sort' => 'updated_at']) }}">Updated At</a></th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            

                            <td>
                                @if($product->main_photo)
                                    <a href="{{ route('products.show', $product) }}" target="_blank">  
                                        <img class="img-thumbnail" style="max-width: 75px;max-width: 100px;" src="{{ asset('storage/app/public/' . $product->main_photo) }}"
                                            alt="Main Photo"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; cursor: pointer;"
                                            onclick="showPhotoModal('{{ asset('storage/app/public/' . $product->main_photo) }}')">
                                    </a>    
                                    <br>

                                @else
                                    <span class="text-muted">—</span>
                                @endif
                                <span id="product_name" data-fulltext="{{$product->name}}" data-limit="30">
                                    {{$product->name}}
                                </span>
                            </td>


                            {{-- Use shared photo-display component for consistent UI --}}
                            <td>
                                @include('components.photo-display', ['photos' => $product->photos])
                            </td>

                            <td>{{ number_format($product->cost_of_goods, 2) }} AED</td>
                            <td>{{ number_format($product->weight, 2) }} KG</td>

                            <td>{{ $product->inventory_quantities['new'] ?? 0 }}</td>
                            <td>{{ $product->inventory_quantities['used in good condition'] ?? 0 }}</td>
                            <td>{{ $product->inventory_quantities['damaged bag'] ?? 0 }}</td>
                            <td>{{ $product->inventory_quantities['without bag'] ?? 0 }}</td>
                            <td>{{ $product->inventory_quantities['damaged product'] ?? 0 }}</td>
                            <td>{{ $product->inventory_quantities['replaced'] ?? 0 }}</td>

                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                            <td>{{ $product->updated_at->diffForHumans() }}</td>

                            <td class="text-center">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-success btn-sm me-2" title="Show"><i class="bi bi-eye"></i> Show</a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="bi bi-pencil"></i> Edit</a>
                                {{-- Deleting is optional; keep it commented if you prefer to control deletes elsewhere --}}
                                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product? This will delete its photos from storage.')" title="Delete"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="text-center">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="pagination d-flex justify-content-center mt-3">
        {{ $products->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
    </div>
</div>

@include('components.photo-modal')

    <script>
        function toggleReadMore(link) {
            const span = link.previousElementSibling;
            const fullText = span.innerText;
            const shortText = fullText.substring(0, 25) + '...';
    
            if (link.innerText === "Read More") {
                span.innerText = span.dataset.fulltext;     // Show full text
                link.innerText = "Read Less";   // Toggle link text
            } else {
                span.innerText = shortText;     // Show truncated text
                link.innerText = "Read More";   // Toggle link text back
            }
        }
    
        // Initial setup for truncation
        document.querySelectorAll('#product_name').forEach(span => {
            const fullText = span.innerText;
            if (fullText.length > 25) {
                span.innerText = fullText.substring(0, 25) + '...';
            }else{
                span.innerText = fullText;
                span.nextElementSibling.style.display = 'none';
            }
        });
    </script>
                            
@endsection
