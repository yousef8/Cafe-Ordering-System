<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="home.css">
    <style>
        .cart-sidebar {
            border: 1px solid brown;
            border-radius: 5px;
            background-color: brown;
            background: beige;
            padding: 10px;
        }

        #cart-items {
            list-style-type: none;
            padding: 0;
        }

        #cart-items li {
            margin-bottom: 5px;
        }

        #cart-total {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
    <title>Home</title>
</head>
<body>
    <?php require_once __DIR__ . '/user_navbar.php'; ?>
    <main class="d-flex min-vh-100">
        <!-- Sidebar -->
        <div class="w-25 p-4">
            <div class="cart-sidebar">
                <h2>Cart</h2>
                <ul id="cart-items"></ul>
                <div id="cart-total">Total: $0</div>
                <button id="checkout-btn" class="btn btn-custom">Checkout</button>
            </div>
        </div>
        <!-- Products -->
        <div class="w-75 p-4">
            <h1 class="text-center p-3 brown">Products</h1>
            <div class="d-flex justify-content-center my-3">
                <input type="text" name="search" placeholder="Search products..." id="search-bar" class="form-control me-2 search-bar">
                <button type="button" id="search-button" class="btn btn-custom">Search</button>
            </div>
            <div class="row gx-3 gy-3" id="products-container">
                <?php
                require_once __DIR__ . '/../../utilities/db_connection.php';
                require_once __DIR__ . '/../../controllers/productController.php';

                $productController = new ProductController($conn);
                $products = $productController->getAllProducts();
                foreach ($products as $product) : ?>
                    <div class="col-md-4 product-card" data-name="<?php echo strtolower($product['name']); ?>">
                        <div class="card">
                            <img src="<?php echo "../../uploads-product/" . $product['image_url']; ?>" alt="Product Image" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                <p class="card-text text-success">$<?php echo $product['price']; ?></p>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-custom" onclick="addToCart('<?php echo $product['name']; ?>', <?php echo $product['price']; ?>)">Add</button>
                                    <div class="input-group ms-3">
                                        <button class="btn btn-outline-secondary" type="button" onclick="removeFromCart(<?php echo $product['id']; ?>,'<?php echo $product['name']; ?>')">-</button>
                                        <span class="input-group-text" id="quantity-<?php echo $product['id']; ?>">0</span>
                                        <button class="btn btn-outline-secondary" type="button" onclick="addToCart(<?php echo $product['id']; ?>,'<?php echo $product['name']; ?>', <?php echo $product['price']; ?>)">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <script>
        var cartItems = [];

        function updateCart() {
            var cartItemsList = document.getElementById('cart-items');
            cartItemsList.innerHTML = '';
            var totalPrice = 0;

            cartItems.forEach(function (item) {
                var li = document.createElement('li');
                li.textContent = item.productName + ' x ' + item.quantity + ' = $' + (item.quantity * item.price);
                cartItemsList.appendChild(li);
                totalPrice += item.quantity * item.price;
            });

            document.getElementById('cart-total').textContent = 'Total: $' + totalPrice.toFixed(2);
        }

        document.getElementById('checkout-btn').addEventListener('click', function () {
   
        });

        function addToCart(productId,productName, price) {
            const item =document.getElementById(`quantity-${productId}`)
            var existingItem = cartItems.find(function (item) {
                return item.id === productId;
            });

            if (existingItem) {
                console.log(existingItem)
                existingItem.quantity++;
        
            item.textContent++ ;
            
            } else {
                item.textContent++ ;
                cartItems.push({ id:productId,productName: productName, price: price, quantity: 1 });
            }

            updateCart();
        }

        function removeFromCart(productId,productName) {
            const itemx =document.getElementById(`quantity-${productId}`)
            var index = cartItems.findIndex(function (item) {
                return item.id === productId;
            });

            if (index !== -1) {
                var item = cartItems[index];
                if (item.quantity > 1) {
                    item.quantity--;
                    itemx.textContent-- ;
                } else {
                    itemx.textContent-- ;
                    cartItems.splice(index, 1);
                }
            }

            updateCart();
        }

        document.getElementById('search-button').addEventListener('click', function () {
            var searchQuery = document.getElementById('search-bar').value.toLowerCase();

            var productCards = document.getElementsByClassName('product-card');
            Array.from(productCards).forEach(function (card) {
                var productName = card.getAttribute('data-name');
                if (productName.includes(searchQuery)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
