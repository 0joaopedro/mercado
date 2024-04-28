<div class="container-fluid row">
    <div class="col-3">
        <div class="d-flex flex-column">
            <a href="/product/form" class="btn btn-primary">
                <i class="bi bi-collection"></i>
                Criar Produto
            </a>

            <h2>Produtos</h2>

            <ul class="list-group">
                <?php foreach ($data['products']->rows as $product) : ?>
                    <li class="list-group-item d-flex">
                        <span class="flex-grow-1">
                            <?= $product->id ?>

                            | <?= $product->name ?>

                            | R$ <?= number_format($product->value, 2, ',', '.') ?>
                        </span>

                        <div>
                            <a href="/product/form?id=<?= $product->id ?>" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <div class="d-flex flex-column">
            <a href="/product-type/form" class="btn btn-primary">
                <i class="bi bi-grid-3x2-gap-fill"></i>
                Criar Tipo de Produto
            </a>

            <h2>Tipo de Produto</h2>
            <ul class="list-group">
                <?php foreach ($data['productsType']->rows as $productType) : ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="flex-grow-1">
                            <?= $productType->id ?>

                            | <?= $productType->name ?>
                        </span>

                        <div>
                            <a href="/product-type/form?id=<?= $productType->id ?>" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <div class="d-flex flex-column">
            <a href="/tax/form" class="btn btn-primary">
                <i class="bi bi-percent"></i>
                Criar Imposto
            </a>

            <h2>Impostos</h2>

            <ul class="list-group">
                <?php foreach ($data['taxes']->rows as $tax) : ?>
                    <li class="list-group-item d-flex ">
                        <span class="flex-grow-1">
                            <?= $tax->id ?>

                            | <?= $tax->name ?>

                            | <?= $tax->value ?>%
                        </span>

                        <div>
                            <a href="tax/form?id=<?= $tax->id ?>" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <div class="d-flex flex-column">
            <a href="/checkout/form" class="btn btn-primary">
                <i class="bi bi-cart"></i>
                Comprar Produtos
            </a>

            <h2>Compras</h2>

            <ul class="list-group">
                <?php foreach ($data['checkout']->rows as $checkout) : ?>
                    <li class="list-group-item d-flex">
                        <span class="flex-grow-1">Compra #<?= $checkout->id ?></span>


                        <a href="checkout/view?id=<?= $checkout->id ?>" class="btn btn-warning">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>