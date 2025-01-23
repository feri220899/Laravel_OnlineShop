<div>
    <div class="row">
        <div class="col-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Product</h3>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-{{ session('message_type') }}">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form wire:submit.prevent="createProducts">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" id="product_name" wire:model="product_name"
                                class="form-control form-control-sm" placeholder="Enter Product Name">
                            @error('product_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" wire:model="category"
                                class="form-control form-control-sm" placeholder="Enter Category">
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" wire:model="description" class="form-control form-control-sm"
                                placeholder="Enter Description"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" id="price" wire:model="price" class="form-control form-control-sm"
                                placeholder="Enter Price">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" wire:model="stock" class="form-control form-control-sm"
                                placeholder="Enter Stock Quantity">
                            @error('stock')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" wire:model="image" class="form-control form-control-sm"
                                placeholder="Enter image">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button type="button" wire:click='createProducts()' class="btn btn-primary btn-sm">
                                <i class="fas fa-save mr-1"></i> Save
                            </button>
                            <a class="btn btn-default btn-sm" data-toggle="modal" data-target="#OpenModalUpload">
                                <i class="fas fa-upload mr-1"></i> Import
                            </a>
                            <button type="button" wire:click='updateProduct()' class="btn btn-warning btn-sm">
                                <i class="fas fa-pen mr-1"></i> Update
                            </button>
                            <button type="button" wire:click='deleteProduct()' class="btn btn-danger btn-sm">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </div>
                        @error('file_import')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="modal fade" id="OpenModalUpload" tabindex="-1" role="dialog" aria-hidden="true"
                            wire:ignore.self>
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>File Import
                                                    </label>
                                                    <input type="file" class="form-control form-control"
                                                        wire:model='file_import'>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click='importProduct()' data-dismiss="modal">Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Product List</h3>
                </div>
                <div class="card-body table-responsive px-2 py-0" style="height: 600px;">
                    <table class="table table-sm table-bordered table-hover table-head-fixed p-3 text-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th class="text-center">img</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getproducts as $key => $product)
                                <tr wire:click="setProduct('{{ $key }}')" style="cursor: pointer;">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td class="text-center">
                                        <a href="#" class="text-sm" data-toggle="modal"
                                            data-target="#OpenModal{{ $key }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    <div class="modal fade" id="OpenModal{{ $key }}" tabindex="-1"
                                        role="dialog" aria-hidden="true" wire:ignore.self>
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row justify-content-center">
                                                        <div class="col-12 text-center">
                                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                                alt="" class="img-fluid max-img-size">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
