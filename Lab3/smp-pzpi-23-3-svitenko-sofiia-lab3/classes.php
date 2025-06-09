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

    public function __construct(private string $filePath = 'task3-products.json') {
        $this->loadProducts();
    }

    private function loadProducts(): void {
        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true);
        foreach ($data['Items'] as $id => $item) {
            $this->products[] = new Product((int)$id, $item['name'], $item['price']);
        }
    }
}