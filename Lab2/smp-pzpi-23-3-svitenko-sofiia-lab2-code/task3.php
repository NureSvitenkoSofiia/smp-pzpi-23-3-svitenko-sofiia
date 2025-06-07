#!/usr/bin/env php
<?php

class Product {
    public function __construct(
        public int $id,
        public string $name,
        public float $price
    ) {}
}

class GroceryStore {
    private array $products = [];
    private ?string $username = null;
    private ?int $userAge = null;

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

    private function strLen($str)
    {
        $chars = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
        return count($chars);
    }

    private function getMaxNameLength(): int {
        return max(array_map(fn($p) => $this->strLen($p->name), $this->products));
    }

    private function showMenu(): void {
        echo "################################\n";
        echo "# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n";
        echo "################################\n";
        echo "1 Вибрати товари\n";
        echo "2 Отримати підсумковий рахунок\n";
        echo "3 Налаштувати свій профіль\n";
        echo "0 Вийти з програми\n";
    }

    private function showProducts(): void {
        $maxLen = $this->getMaxNameLength();
        echo "№  НАЗВА" . str_repeat(" ", $maxLen - 5) . "  ЦІНА\n";
        foreach ($this->products as $p) {
            echo $p->id . "  " . $p->name . str_repeat(" ", $maxLen - $this->strLen($p->name)) . "  " . $p->price . "\n";
        }
        echo "-----------------\n0  ПОВЕРНУТИСЯ\n";
    }

    private function showCart(array $cart): void {
        $maxLen = $this->getMaxNameLength();
        echo "У КОШИКУ:\nНАЗВА" . str_repeat(" ", $maxLen - 5) . "  КІЛЬКІСТЬ\n";
        foreach ($this->products as $i => $p) {
            if ($cart[$i] > 0) {
                echo $p->name . str_repeat(" ", $maxLen - $this->strLen($p->name)) . "  " . $cart[$i] . "\n\n";
            }
        }
    }

    private function configureProfile(): void
    {
        $firstTry = true;
        do {
            if (!$firstTry) {
                echo "Імʼя користувача не може бути порожнім і повинно містити хоча б одну літеру.\n";
            }
            $name = readline("Ваше імʼя: ");
            $firstTry = false;
        } while (!preg_match('/\p{L}/u', $name));

        $this->username = $name;

        $firstTry = true;
        do {
            if (!$firstTry) {
                echo "Користувач не може бути молодшим 7-ми або старшим 150-ти років\n";
            }
            $age = (int)readline("Ваш вік: ");
            $firstTry = false;
        } while ($age < 7 || $age > 150);

        $this->userAge = $age;
        echo "Профіль встановлено: {$this->username}, {$this->userAge} років\n\n";
    }

    private function checkout(array $cart): void {
        $maxLen = $this->getMaxNameLength();
        $total = 0;
        echo "№  НАЗВА" . str_repeat(" ", $maxLen - 5) . "  ЦІНА  КІЛЬКІСТЬ  ВАРТІСТЬ\n";
        $n = 1;
        foreach ($this->products as $i => $p) {
            if ($cart[$i] > 0) {
                $qty = $cart[$i];
                echo "$n  " . $p->name . str_repeat(" ", $maxLen - $this->strLen($p->name)) . "  ";
                echo $this->products[$i]->price . str_repeat(" ", 4 - $this->strLen($this->products[$i]->price)) . "  ";
                echo $cart[$i] . str_repeat(" ", 9 - $this->strLen($cart[$i])) . "  ";
                echo $qty * $p->price . "\n";
                $total += $qty * $p->price;
                $n++;
            }
        }
        echo "РАЗОМ ДО СПЛАТИ: $total\n\n";
    }

    public function run(): void {
        $cart = array_fill(0, count($this->products), 0);
        while (true) {
            $this->showMenu();
            $choice = readline("Введіть команду: ");

            switch ((int)$choice) {
                case 1:
                    while (true) {
                        $this->showProducts();
                        $itemId = (int)readline("Виберіть товар: ");
                        if ($itemId === 0) break;

                        if ($itemId < 1 || $itemId > count($this->products)) {
                            echo "ПОМИЛКА! Неправильний номер товару\n";
                            continue;
                        }

                        $amount = (int)readline("Введіть кількість, штук: ");
                        if ($amount < 0 || $amount > 100) {
                            echo "ПОМИЛКА! Невірна кількість\n";
                            continue;
                        }

                        $index = $itemId - 1;
                        $cart[$index] = $amount;
                        if ($amount === 0) {
                            echo "ВИДАЛЯЮ З КОШИКА\n";
                        } else {
                            $this->showCart($cart);
                        }
                    }
                    break;

                case 2:
                    $this->checkout($cart);
                    break;

                case 3:
                    $this->configureProfile();
                    break;

                case 0:
                    echo "До побачення!\n";
                    return;

                default:
                    echo "ПОМИЛКА! Введіть правильну команду\n";
            }
        }
    }
}

$app = new GroceryStore();
$app->run();