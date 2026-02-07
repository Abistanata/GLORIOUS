@extends('layouts.theme')

@section('title', 'Checkout - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-8">
            <i class="fas fa-credit-card text-primary mr-2"></i> Checkout
        </h1>

        <form action="{{ route('main.checkout.send-wa') }}" method="POST" class="space-y-8">
            @csrf
            <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Data Pemesan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-1">Nama</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', $customerName) }}" required
                            class="w-full bg-dark border border-gray-700 rounded-lg text-white px-4 py-2 focus:ring-2 focus:ring-primary">
                        @error('customer_name')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-1">No. WhatsApp</label>
                        <input type="text" name="customer_whatsapp" value="{{ old('customer_whatsapp', $customerWhatsapp) }}" required placeholder="08xxx"
                            class="w-full bg-dark border border-gray-700 rounded-lg text-white px-4 py-2 focus:ring-2 focus:ring-primary">
                        @error('customer_whatsapp')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-400 text-sm mb-1">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" class="w-full bg-dark border border-gray-700 rounded-lg text-white px-4 py-2 focus:ring-2 focus:ring-primary">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Pesanan Anda</h2>
                <ul class="space-y-3">
                    @foreach($lines as $line)
                        <li class="flex justify-between text-gray-300">
                            <span>{{ $line['product']->name }} x{{ $line['qty'] }}</span>
                            <span>Rp {{ number_format($line['subtotal'], 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <hr class="border-gray-700 my-4">
                <p class="flex justify-between text-lg font-bold text-white">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </p>
            </div>

            <p class="text-gray-400 text-sm">
                Dengan menekan tombol di bawah, Anda akan diarahkan ke WhatsApp untuk mengirim pesanan ke Admin. Pastikan data di atas sudah benar.
            </p>
            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl flex items-center justify-center gap-2">
                <i class="fab fa-whatsapp text-xl"></i> Kirim ke WhatsApp Admin
            </button>
        </form>
    </div>
</div>
@endsection
