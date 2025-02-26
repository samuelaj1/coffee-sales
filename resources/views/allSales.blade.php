<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Sales</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CDN for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vue 2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
<body>
<div class="container mt-5" id="app">
    <h2>New ☕ Sales</h2>
    <div class="row">
        <div class="col-12 my-4 text-end">
            <a href="{{route('sales')}}">Switch To Gold Coffee</a>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label for="product">Product</label>
                <select id="product" v-model="selectedProduct" class="form-control" required>
                    <option v-for="product in products" :key="product.id" :value="product.id">
                        [[ product.name ]]
                    </option>
                </select>

            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label for="quantity">Quantity</label>
                <input id="quantity" type="number" class="form-control" v-model.number="quantity">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label for="unit_cost">Unit Cost (£)</label>
                <input id="unit_cost" type="number" class="form-control" v-model.number="unitCost">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <div><strong>Selling Price</strong></div>
                <div><strong>£[[ sellingPrice.toFixed(2) ]]</strong></div>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" @click="recordSale">Record Sale</button>

        </div>
    </div>

    <h3 class="mt-5">Previous Sales</h3>
    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Cost</th>
            <th>Selling Price</th>
            <th>Sold at</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(sale,i) in sales" :key="i">
            <td>[[ sale.product?.name ]]</td>
            <td>[[ sale.quantity ]]</td>
            <td>£[[ sale.unit_cost.toFixed(2) ]]</td>
            <td>£[[ sale.selling_price.toFixed(2) ]]</td>
            <td>[[ sale.created_at ]]</td>
        </tr>
        </tbody>
    </table>
</div>

<script>
    new Vue({
        el: "#app",
        delimiters: ['[[', ']]'],
        data: {
            quantity: 1,
            unitCost: 10,
            profitMargin: 0.25,
            shippingCost: 10.00,
            sales: [],
            selectedProduct: "",
            products: @json($products ?? [])
        },
        computed: {
            sellingPrice() {
                let cost = this.quantity * this.unitCost;
                return (cost / (1 - this.profitMargin)) + this.shippingCost;
            }
        },
        watch: {
            selectedProduct(newProductId) {
                const selected = this.products.find(product => product.id === newProductId);
                if (selected) {
                    this.profitMargin = selected.profit_margin / 100;
                }
            }
        },

        methods: {
            recordSale() {
                if (this.quantity > 0 && this.unitCost > 0) {
                    const saleData = {
                        quantity: this.quantity,
                        unit_cost: this.unitCost,
                        product_id: this.selectedProduct
                        // selling_price: this.sellingPrice
                    };

                    // Send POST request to backend
                    axios.post('/sales/store', saleData)
                        .then(response => {
                            const data= response.data['data']
                            this.sales.unshift(data);

                            // Reset input fields
                            this.quantity = 1;
                            this.unitCost = 10;
                        })
                        .catch(error => {
                            const err = error.response ? error.response.data : error
                            console.error('Error recording sale:', error.response ? error.response.data : error);
                            alert(err.message);

                        });
                } else {
                    alert("Please enter valid values for quantity and unit cost.");
                }
            },
            getSales() {
                axios.get('/fetch-sales')
                    .then(response => {
                        this.sales = response.data['data']
                    })
                    .catch(error => {
                        const err = error.response ? error.response.data : error
                        console.error('Error recording sale:', error.response ? error.response.data : error);
                        alert(err.message);

                    });
            }
        },
        created() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (this.products.length > 0) {
                this.selectedProduct = this.products[0].id; // Set the first product as selected
                this.profitMargin = this.products[0].profit_margin / 100; // Set initial profit margin
            }
            this.getSales();
            console.log('Vue is running!');
        }
    });
</script>

</body>
</html>
