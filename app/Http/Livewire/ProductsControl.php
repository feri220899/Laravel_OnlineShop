<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Products;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductsControl extends Component
{
    use WithFileUploads;

    public $product_id;
    public $product_name;
    public $category;
    public $description;
    public $price;
    public $stock;
    public $image;
    public $file_import;
    public $getproducts;
    public $key_products;

    public function render()
    {
        $this->getProducts();
        return view('livewire.products-control');
    }

    protected $rules = [
        'product_name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048',
    ];

    public function getProducts()
    {
        $this->getproducts = Products::all();
    }

    public function createProducts()
    {
        $this->validate();
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->storeAs('products', $this->image->getClientOriginalName(), 'public');
            $livewire_tmp_file = 'livewire-tmp/' . $this->image->getFileName();
            Storage::delete($livewire_tmp_file);
        }
        Products::create([
            'product_name' => $this->product_name,
            'category' => $this->category,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $imagePath,
        ]);
        $this->flashMessage('Product added successfully.', 'success');
        $this->getProducts();
        $this->reset();
    }

    public function setProduct($key)
    {
        $this->key_products = $key;
        $product = $this->getproducts[$key];
        $this->product_name = $product->product_name;
        $this->product_id = $product->id;
        $this->category = $product->category;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->image = $product->image;
    }

    public function updateProduct()
    {
        if ($this->image && $this->image != $this->getproducts[$this->key_products]->image) {
            Storage::delete('public/' . $this->getproducts[$this->key_products]->image);
            $imagePath = $this->image->storeAs('products', $this->image->getClientOriginalName(), 'public');
            $livewire_tmp_file = 'livewire-tmp/' . $this->image->getFileName();
            Storage::delete($livewire_tmp_file);
        } else {
            $imagePath = $this->image;
        }

        Products::where('id', $this->product_id)->update([
            'product_name' => $this->product_name,
            'category' => $this->category,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $imagePath,
        ]);
        $this->flashMessage('Product updated successfully.', 'warning');
        $this->getProducts();
        $this->reset();
    }

    public function deleteProduct()
    {
        Products::where('id', $this->product_id)->delete();
        Storage::delete('public/' . $this->getproducts[$this->key_products]->image);
        $this->flashMessage('Product deleted successfully.', 'danger');
        $this->getProducts();
        $this->reset();
    }

    public function importProduct()
    {
        $this->validate([
            'file_import' => 'required|mimes:xlsx,xls,ods|max:10240', // 10MB maximum file size
        ]);
        $livewire_tmp_file = 'livewire-tmp/' . $this->file_import->getFileName();
        $spreadsheet = IOFactory::load(storage_path('app/' . $livewire_tmp_file));
        $sheet = $spreadsheet->getActiveSheet();

        $data = [];
        foreach ($sheet->getRowIterator() as $row) {
            $rowData = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }
        foreach ($data as $row) {
            Products::create([
                'product_name' => $row[0],
                'category' => $row[1],
                'description' => $row[2],
                'price' => (float) $row[3],
                'stock' => (int) $row[4],
                'image' => $row[5].$row[6].$row[7] ?? null,
            ]);
        }
        Storage::delete($livewire_tmp_file);
    }

    public function flashMessage($message, $message_type)
    {
        session()->flash('message', $message);
        session()->flash('message_type', $message_type);
    }
}
