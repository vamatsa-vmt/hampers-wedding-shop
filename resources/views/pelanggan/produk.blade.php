<section class="px-4 sm:px-6 py-16 bg-[#FDF8F9]">
    <!-- Header -->
    <div class="max-w-5xl mx-auto text-center">
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#B76E79]">
            Rekomendasi Produk
        </h2>
    </div>

    <!-- Kategori Produk -->
    <div id="kategori-produk" class="flex justify-center items-center mt-8">
        <div
            class="bg-white shadow-md rounded-lg p-4 sm:p-6 max-w-4xl grid gap-4 sm:gap-6"
            style="grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));"
        >
            @foreach($kategoriproduks as $kategori)
            <div
                id="{{ strtolower(str_replace(' ', '_', $kategori->NAMA_KATEGORI_PRODUK)) }}"
                class="kategori-produk border border-[#B76E79] rounded-md p-2 sm:p-4 flex items-center space-x-3 sm:space-x-4 cursor-pointer"
                data-category="{{ strtolower(str_replace(' ', '_', $kategori->NAMA_KATEGORI_PRODUK)) }}"
            >
                <img
                    src="{{ asset('storage/' . $kategori->IMAGE_KATEGORI_PRODUK) }}"
                    alt="{{ $kategori->NAMA_KATEGORI_PRODUK }}"
                    class="w-10 sm:w-12 lg:w-14 h-10 sm:h-12 lg:h-14 rounded-md"
                />
                <span
                    class="text-xs sm:text-sm lg:text-base font-bold text-black"
                >
                    {{ $kategori->NAMA_KATEGORI_PRODUK }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Daftar Produk -->
    <div
        id="produk-list"
        class="p-4 sm:p-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 mt-12"
    >
        @foreach($produks as $produk)
        <div
            class="product-card {{ strtolower(str_replace(' ', '_', $produk->kategori->NAMA_KATEGORI_PRODUK)) }} bg-white rounded-lg shadow-md"
            data-category="{{ strtolower(str_replace(' ', '_', $produk->kategori->NAMA_KATEGORI_PRODUK)) }}"
        >
            <div class="relative">
                <img
                    src="{{ asset('storage/' . $produk->IMAGE_PRODUK) }}"
                    class="w-full h-32 sm:h-40 lg:h-48 object-cover rounded-t-lg {{ $produk->STOK == 0 ? 'grayscale' : '' }}"
                />
                <div
                    class="absolute top-2 left-2 bg-[#FFF44F] px-2 sm:px-3 py-1 rounded-md text-xs sm:text-sm font-semibold"
                >
                    {{ $produk->kategori->NAMA_KATEGORI_PRODUK }}
                </div>
                @if($produk->STOK == 0)
                <div
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 bg-white text-red-600 border-2 border-red-600 px-3 py-2 text-xs sm:text-sm lg:text-base font-bold rounded-md"
                >
                    Sold Out
                </div>
                @endif
            </div>
            <div class="p-4">
                <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-black">
                    {{ $produk->NAMA_PRODUK }}
                </h3>
                <p
                    class="text-sm sm:text-base lg:text-lg font-bold text-black"
                >
                    Rp {{ number_format($produk->HARGA, 0, ',', '.') }} | Stok :
                    {{ $produk->STOK }}
                </p>
                @if($produk->STOK > 0)
                <button
                    class="product-modal inline-block w-full text-center mt-4 bg-[#FFF44F] text-black px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm lg:text-base font-semibold hover:bg-[#F6E200]"
                    data-product-id="{{ $produk->id }}"
                    data-product-name="{{ $produk->NAMA_PRODUK }}"
                    data-product-price="{{ $produk->HARGA }}"
                    data-product-stock="{{ $produk->STOK }}"
                    data-product-description="{{ $produk->DESKRIPSI }}"
                    data-product-image="{{ asset('storage/' . $produk->IMAGE_PRODUK) }}"
                >
                    Detail Produk
                </button>
                @else
                <button
                    class="inline-block w-full text-center mt-4 bg-gray-400 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm lg:text-base font-semibold cursor-not-allowed"
                >
                    Stok Habis
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Modal -->
<div id="product-modal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 flex justify-center items-center p-4 sm:p-8">
    <div class="bg-white w-full sm:w-3/4 max-w-2xl p-6 sm:p-8 rounded-lg relative">
        <button id="close-modal" class="absolute top-3 right-4 w-8 h-8 rounded-full flex justify-center items-center bg-[#a05b67] hover:bg-red-900 text-white">
            ×
        </button>
        <div class="flex flex-col sm:flex-row items-center">
            <img id="modal-product-image" src="" alt="" class="w-full sm:w-64 h-auto object-cover rounded-md">
            <div class="sm:ml-6 mt-4 sm:mt-0">
                <h1 id="modal-product-name" class="text-lg sm:text-2xl font-bold"></h1>
                <p id="modal-product-description" class="text-gray-700 text-sm sm:text-base mt-2"></p>
                <p id="modal-product-price" class="text-sm sm:text-lg font-semibold mt-4"></p>
                <form action="{{ route('pelanggan.cart.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="kode_produk" id="modal-product-code">
                    <label for="quantity" class="block text-gray-600 text-sm sm:text-base font-medium">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-14 h-10 px-2 border rounded-md focus:ring-2 focus:ring-[#B76E79] focus:outline-none" required>
                    <button type="submit" class="mt-4 px-4 py-2 bg-[#B76E79] text-white rounded-md hover:bg-[#a05b67]">
                        Tambah ke Keranjang
                    </button>
                </form>                
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.kategori-produk').forEach(category => {
        category.addEventListener('click', function () {
            const selectedCategory = this.dataset.category;
            document.querySelectorAll('.product-card').forEach(card => {
                if (selectedCategory === 'semua') {
                    card.style.display = 'block';
                } else {
                    card.style.display = card.dataset.category === selectedCategory ? 'block' : 'none';
                }
            });
        });
    });

    document.querySelectorAll('.product-modal').forEach(button => {
        button.addEventListener('click', function() {
            const product = this.dataset;
            document.getElementById('modal-product-name').textContent = product.productName;
            document.getElementById('modal-product-description').textContent = product.productDescription;
            document.getElementById('modal-product-price').textContent = 'Rp ' + Number(product.productPrice).toLocaleString();
            document.getElementById('modal-product-image').src = product.productImage;
            document.getElementById('modal-product-code').value = product.productId;
            document.getElementById('product-modal').classList.remove('hidden');
        });
    });

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('product-modal').classList.add('hidden');
    });
</script>
