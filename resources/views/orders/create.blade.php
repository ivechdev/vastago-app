@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Nueva Orden - Mesa {{ $table->number }}</h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">Mesa Ocupada</span>
            </div>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="table_id" value="{{ $table->id }}">

                <div class="space-y-6">
                    <div id="order-items">
                        <!-- Los items se agregarán aquí dinámicamente -->
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="button" onclick="addItem()"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            + Agregar Producto
                        </button>
                        <div class="text-xl font-bold">
                            Total: $<span id="total">0</span>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('tables.show', $table) }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Crear Orden
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const products = @json($products);
    let itemCount = 0;

    function addItem() {
        const itemHtml = `
            <div class="border-b pb-4 mb-4" id="item-${itemCount}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Producto</label>
                        <select name="items[${itemCount}][product_id]" onchange="updatePrice(${itemCount})"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Seleccionar producto</option>
                            ${products.map(p => `
                                <option value="${p.id}" data-price="${p.price}">
                                    ${p.name} - $${p.price.toLocaleString('es-CL')}
                                </option>
                            `).join('')}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input type="number" name="items[${itemCount}][quantity]" value="1" min="1"
                            onchange="updatePrice(${itemCount})"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                        <div class="mt-2 text-lg font-semibold">$<span id="subtotal-${itemCount}">0</span></div>
                    </div>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700">Notas</label>
                    <textarea name="items[${itemCount}][notes]" rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        placeholder="Instrucciones especiales..."></textarea>
                </div>
                <button type="button" onclick="removeItem(${itemCount})"
                    class="mt-2 text-red-600 hover:text-red-800">
                    Eliminar
                </button>
            </div>
        `;

        document.getElementById('order-items').insertAdjacentHTML('beforeend', itemHtml);
        itemCount++;
    }

    function removeItem(index) {
        document.getElementById(`item-${index}`).remove();
        calculateTotal();
    }

    function updatePrice(index) {
        const select = document.querySelector(`[name="items[${index}][product_id]"]`);
        const quantity = document.querySelector(`[name="items[${index}][quantity]"]`).value;
        const price = select.options[select.selectedIndex].dataset.price;
        const subtotal = price * quantity;

        document.getElementById(`subtotal-${index}`).textContent = subtotal.toLocaleString('es-CL');
        calculateTotal();
    }

    function calculateTotal() {
        const subtotals = document.querySelectorAll('[id^="subtotal-"]');
        const total = Array.from(subtotals)
            .map(el => parseInt(el.textContent.replace(/\D/g, '')) || 0)
            .reduce((sum, current) => sum + current, 0);

        document.getElementById('total').textContent = total.toLocaleString('es-CL');
    }

    // Agregar primer item al cargar
    addItem();
</script>
@endpush
@endsection
