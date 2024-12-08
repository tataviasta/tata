<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Makan Padang Order</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center py-4">
            <h1 class="text-2xl font-bold">Rumah Makan Padang Order</h1>
        </header>

        <?php
        session_start();

        // Menu data
        $menu = [
            ["name" => "Rendang", "price" => 20000, "stock" => 15, "image" => "https://storage.googleapis.com/a1aa/image/JC69Sf2uhuQaJ69hV3A7RzKubkjfHrpgGAs56y4N2BUkuw4TA.jpg"],
            ["name" => "Ayam Gulai", "price" => 18000, "stock" => 12, "image" => "https://storage.googleapis.com/a1aa/image/1.jpg"],
            ["name" => "Telor Dadar", "price" => 15000, "stock" => 25, "image" => "https://storage.googleapis.com/a1aa/image/2.jpg"],
            ["name" => "Ikan Kembung Bakar", "price" => 18000, "stock" => 8, "image" => "https://storage.googleapis.com/a1aa/image/3.jpg"],
            ["name" => "Ayam Bakar", "price" => 18000, "stock" => 10, "image" => "https://storage.googleapis.com/a1aa/image/4.jpg"],
        ];

        // Initialize cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $itemName = $_POST['name'] ?? null;
            $itemPrice = $_POST['price'] ?? null;
            $itemQuantity = $_POST['quantity'] ?? null;

            if ($itemName && $itemPrice && $itemQuantity > 0) {
                $found = false;

                // Update quantity if item exists in cart
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['name'] === $itemName) {
                        $item['quantity'] += $itemQuantity;
                        $found = true;
                        break;
                    }
                }

                // Add new item to cart
                if (!$found) {
                    $_SESSION['cart'][] = [
                        "name" => $itemName,
                        "price" => $itemPrice,
                        "quantity" => $itemQuantity,
                    ];
                }
            }
        }

        // Remove item from cart
        if (isset($_POST['remove'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) {
                return $item['name'] !== $_POST['remove'];
            });
        }
        ?>

        <!-- Menu Section -->
        <section class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Menu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($menu as $item): ?>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="Image of <?= htmlspecialchars($item['name']) ?>" class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['name']) ?></h3>
                        <p class="text-gray-600">Rp<?= number_format($item['price'], 0, ',', '.') ?></p>
                        <p class="text-gray-600">Stock: <?= $item['stock'] ?></p>
                        <form method="POST" class="mt-4">
                            <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
                            <input type="hidden" name="price" value="<?= $item['price'] ?>">
                            <div class="flex items-center">
                                <input type="number" name="quantity" class="border rounded w-16 text-center" min="1" max="<?= $item['stock'] ?>" value="1">
                                <button type="submit" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add to Cart</button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Cart Section -->
        <section class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Cart</h2>
            <div class="bg-white p-4 rounded-lg shadow">
                <?php if (count($_SESSION['cart']) > 0): ?>
                    <?php $totalPrice = 0; ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['name']) ?></h3>
                                <p class="text-gray-600">Rp<?= number_format($item['price'], 0, ',', '.') ?></p>
                                <p class="text-gray-600">Quantity: <?= $item['quantity'] ?></p>
                            </div>
                            <form method="POST">
                                <button type="submit" name="remove" value="<?= htmlspecialchars($item['name']) ?>" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </form>
                        </div>
                        <?php $totalPrice += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                    <p class="text-lg font-semibold">Total: Rp<?= number_format($totalPrice, 0, ',', '.') ?></p>
                <?php else: ?>
                    <p class="text-gray-600">Your cart is empty.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</body>
</html>

<?php
$host = 'localhost';
$dbname = 'rumah_makan';
$username = 'root'; // Sesuaikan dengan user database Anda
$password = '';     // Sesuaikan dengan password Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>