@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Nueva Compra</h2>

            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                            <input type="text" name="supplier" value="{{ old('supplier') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('supplier')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">N° Factura</label>
                            <input type="text" name="invoice_number" value="{{ old('invoice_number') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('invoice_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Productos</h3>
                        <div id="purchase-items">
                            <div class="border-b pb-4 mb-4" id="item-0">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Producto</label>
                                        <select name="items[0][product_id]" onchange="updateTotal()"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="">Seleccionar producto</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                                        <input type="number" name="items[0][quantity]" value="1" min="1" step="1"
                                            onchange="updateTotal()"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Precio Unitario</label>
                                        <input type="number" name="items[0][unit_price]" value="0" min="0" step="1"
                                            onchange="updateTotal()"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                </div>
                                <button type="button" onclick="removeItem(0)"
                                    class="mt-2 text-red-600 hover:text-red-800">
                                    Eliminar
                                </button>
                            </div>
                        </div>

                        <button type="button" onclick="addItem()"
                            class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            + Agregar Producto
                        </button>
                    </div>

                    <div class="border-t pt-4 flex justify-between items-center">
                        <div class="text-xl font-bold">
                            Total: $<span id="total">0 CLP</span>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('purchases.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Compra
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let itemCount = 1; // Start from 1 since we already have one item

    function addItem() {
        const itemHtml = `
            <div class="border-b pb-4 mb-4" id="item-${itemCount}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Producto</label>
                        <select name="items[${itemCount}][product_id]" onchange="updateTotal()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input type="number" name="items[${itemCount}][quantity]" value="1" min="1" step="1"
                            onchange="updateTotal()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Precio Unitario</label>
                        <input type="number" name="items[${itemCount}][unit_price]" value="0" min="0" step="1"
                            onchange="updateTotal()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
                <button type="button" onclick="removeItem(${itemCount})"
                    class="mt-2 text-red-600 hover:text-red-800">
                    Eliminar
                </button>
            </div>
        `;

        document.getElementById('purchase-items').insertAdjacentHTML('beforeend', itemHtml);
        itemCount++;
    }

    function removeItem(index) {
        document.getElementById(`item-${index}`).remove();
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        const items = document.querySelectorAll('[id^="item-"]');

        items.forEach(item => {
            const quantity = parseInt(item.querySelector('input[name$="[quantity]"]').value) || 0;
            const unitPrice = parseInt(item.querySelector('input[name$="[unit_price]"]').value) || 0;
            total += quantity * unitPrice;
        });

        document.getElementById('total').textContent = total.toLocaleString('es-CL');
    }
</script>
@endpush
@endsection
