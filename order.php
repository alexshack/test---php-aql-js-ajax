<!doctype html>
<html class="no-js" lang="ru">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="none" />
    <title>Новый заказ - Тест Millenium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<?php
include 'inc/inc.php';

$products = (new Products())->getPosts();
$users = (new Users())->getPosts();
?>
<body>

<div class="container">
    <h1>Новый заказ</h1>
    <form class="form" id="order_form" enctype="multipart/form-data">

         <div class="row g-3 my-3">
            <div class="col-12">
                <label for="user_id" class="form-label">Пользователь</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">Выберите пользователя</option>
                    <?php foreach ( $users as $user ) : ?>
                        <option value="<?php echo $user->ID; ?>"><?php echo $user->post->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <label for="product_id" class="form-label">Товары</label>
                <div id="products_input">
                </div>
                <button class="btn btn-success" id="add-product">+ Добавить товар</button>
            </div>
        </div>
        <button class="btn btn-primary" type="submit" id="submit">Сохранить</button>
    </form>
</div>

<script src='/assets/js/main.js'></script>

<script>
    window.onload = TestMillenium.getProducts();
    document.querySelector('#add-product').addEventListener('click', function (event) {
        event.preventDefault();
        TestMillenium.getProducts();
    });
    document.querySelector('#order_form').addEventListener('submit', function (event) {
        event.preventDefault();
        TestMillenium.saveOrder(new FormData(this));
    });
</script>


</body>

</html>