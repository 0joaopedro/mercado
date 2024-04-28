<div class="container col-9">
    <a href="/" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-bar-left"></i> Voltar
    </a>

    <h4>Compra de Produtos</h4>

    <ul class="list-group">
        <?php foreach ($data['products']->rows as $product) : ?>
            <li id="<?= $product->id ?>" class="list-group-item d-flex align-items-center">
                <div class="flex-grow-1">
                    <?= $product->id ?>

                    | <?= $product->name ?>

                    | R$ <?= number_format($product->value, 2, ',', '.') ?>

                    <?php foreach ($product->taxProductType->rows as $key => $taxProductType) : ?>
                        | <?= $taxProductType->name; ?>:
                        <?= $taxProductType->value; ?>%
                    <?php endforeach; ?>
                </div>

                <div class="d-flex flex-column">
                    <div class="form-group">
                        <label for="name">Quantidade:</label>
                        <input id="quantity-product-<?= $product->id ?>" type="number" min="1" step="1" name="quantity" class="form-control" required>
                        <label id="quantity-error-<?= $product->id ?>" class="text-danger" style="display: none;">Digite uma quantidade</label>
                    </div>

                    <button id="add-product-<?= $product->id ?>" type="button" class="btn btn-success mt-1" onclick="addProduct(<?= $product->id ?>)">
                        <i class="bi bi-save"></i>
                        Adicionar
                    </button>

                    <button id="delete-product-<?= $product->id ?>" type="button" class="btn btn-danger mt-1" onclick="deleteProduct(<?= $product->id ?>)" style="display:none">
                        Remover <i class="bi bi-trash3"></i>
                    </button>
                </div>

            </li>
        <?php endforeach ?>
    </ul>

    <button id="finish" type="button" class="btn btn-success my-4" onclick="finishCart()">
        <i class="bi bi-bag-check-fill"></i> Finalizar Compra
    </button>

    <span id="form-error" class="text-danger" style="display: none;">Preencha um campo de quantidade</span>
</div>

<form id="cart-products"></form>

<script>
    let addProduct = (idProduct) => {
        product = $('#product-' + idProduct)
        quantity = $('#quantity-product-' + idProduct)

        if (!quantity.val()) {
            $("#quantity-error-" + idProduct).show()
            return
        }

        $("#quantity-error-" + idProduct).hide()

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
        data = $('#product-' + idProduct)

        $('#delete-product-' + idProduct).hide()
        $('#add-product-' + idProduct).show()
        $('#quantity-product-' + idProduct).attr('disabled', false)
        $('#product-added-' + idProduct).remove()
    }

    let finishCart = () => {
        data = $('#cart-products').serialize();

        if (!data) {
            $("#form-error").show()
            return
        }

        $("#form-error").hide()

        $.post('/checkout/save', {
            data: data,
        }, function(response) {
            location.href = response
        })
    }
</script>