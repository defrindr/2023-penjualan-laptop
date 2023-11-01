# Decision Tree Study Kasus Pembelian Laptop

## Resources

-   [Datasheet](https://github.com/37Degrees/DataSets/blob/master/laptops.csv)
-   [Modifikasi Decision Tree](./documentation/modify-classification.md)

## Deploy

1. Clone this repository

```sh
git clone https://github.com/defrindr/2023-penjualan-laptop.git
```

2. Install dependecies

```sh
composer install
```

3. Copy .env & setup environment

4. Generate key

```sh
php artisan key:generate
```

5. Running migration

```sh
php artisan migrate:fresh --seed
```

6. Ruuning server

```sh
php artisan serve
```
