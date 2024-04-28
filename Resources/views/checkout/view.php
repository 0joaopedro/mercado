<div class="container col-8">
    <a href="/" class="btn btn-light mb-3">
        <i class="bi bi-arrow-bar-left"></i> Voltar
    </a>

    <h4>
        Compra #<?= $data['checkout']->id  . ' | Valor total da compra: R$ ' . number_format($data['checkout']->value, 2, ',', '.') . ' | Valor de Impostos: R$ ' . number_format($data['checkout']->value_tax, 2, ',', '.') ?>
    </h4>

    <?php foreach ($data['checkoutProducts']->rows as $product) :
        $productTotal = bcmul($product->value, $product->quantity, 2);
    ?>
        <ul class="list-group my-3">
            <li class="list-group-item">
                <strong>Id do Produto:</strong> <?= $product->id ?>
            </li>

            <li class="list-group-item">
                <strong>Nome do Produto:</strong> <?= $product->name ?> | <strong>Tipo:</strong> <?= $product->product_type_name ?>
            </li>

            <li class="list-group-item">
                <strong>Valor Total:</strong> R$ <?= number_format($productTotal, 2, ',', '.') ?>
                | <strong>Quantidade:</strong> <?= $product->quantity ?>
                | <strong>Valor Unitário:</strong> R$ <?= number_format($product->value, 2, ',', '.') ?>
            </li>

            <?php if ($product->checkoutProductsTaxes) :
                $productTaxTotal = 0;
            ?>
                <li class="list-group-item list-group-item-warning">
                    <h5><strong>Impostos</strong></h5>
                </li>
                <?php foreach ($product->checkoutProductsTaxes as $key => $productTax) :
                    $productTaxTotal = bcadd($productTaxTotal, $productTax->value, 2);
                ?>
                    <li class="list-group-item list-group-item-warning">
                        <strong><?= $productTax->name ?>:</strong> R$ <?= number_format($productTax->value, 2, ',', '.') ?>
                    </li>
                <?php endforeach ?>

                <li class="list-group-item">
                    <strong>Valor Total com Impostos:</strong> R$ <?= number_format(bcadd($productTotal, $productTaxTotal, 2), 2, ',', '.') ?>
                </li>

            <?php endif ?>
        </ul>
    <?php endforeach; ?>
</div>

<script>
    let addProduct = (idProduct) => {
        product = $('#product-' + idProduct);
        quantity = $('#quantity-product-' + idProduct);

        $('#delete-product-' + idProduct).show()
        $('#add-product-' + idProduct).hide()
        quantity.attr('disabled', true)

        $('#cart-products').append(`
            <input
                id="product-added-${idProduct}"
                type=hidden
                name=product[${idProduct}]
                value=${quantity.val()}
            >
        `)
    }

    let deleteProduct = (idProduct) => {
        data = $('#product-' + idProduct);

        $('#delete-product-' + idProduct).hide()
        $('#add-product-' + idProduct).show()
        $('#quantity-product-' + idProduct).attr('disabled', false)
        $('#product-added-' + idProduct).remove()
    }

    let finalizarCompra = () => {
        $.post('/checkout/save', {
            data: $('#cart-products').serialize(),
        }, function(response) {
            console.log(response);
        });
    }
</script>