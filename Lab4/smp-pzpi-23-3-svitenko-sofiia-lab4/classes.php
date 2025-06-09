<?php
class Product {
    public function __construct(
        public int $id,
        public string $name,
        public float $price
    ) {}
}

class GroceryStore {
    public array $products = [];

    public function __construct($database) {
        $this->loadProducts($database);
    }

    private function loadProducts($database): void {
        $databaseData = $database->fetchAll("SELECT * FROM products");

        foreach ($databaseData as $productData) {
            $this->products[] = new Product($productData['id'], $productData['name'], $productData['price']);
        }
    }
}