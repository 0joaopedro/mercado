<div class="container col-4">
    <a href="/" class="btn btn-light mb-3">
        <i class="bi bi-arrow-bar-left"></i> Voltar
    </a>

    <form action="/product/save" method="POST" class="bg-secondary p-2" style="border-radius:1rem;">
        <h4>Cadastro de Produto</h4>

        <?= isset($data['product']->id) ? '<input type="hidden" name="id" value="' . $data['product']->id . '">' : null ?>

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="<?= $data['product']->name ?? null ?>" class="form-control" maxlength="50" required>
        </div>

        <label for="value">Preço:</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="text" name="value" id="value" value="<?= $data['product']->value ? number_format($data['product']->value, 2, ',', '.') : null ?>" class="form-control" aria-describedby="money-sign" required>
        </div>

        <div class="form-group">
            <label for="id-product-type">Tipo de Produto:</label>
            <select name="id_product_type" id="id-product-type" class="form-select" required>
                <?php foreach ($data['productsType']->rows as $productType) : ?>
                    <option value="<?= $productType->id ?>" <?= isset($productType->selected) && $productType->selected ? 'selected' : null ?>>
                        <?= $productType->name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3" id="submit">
            <i class="bi bi-save"></i>
            Salvar
        </button>
    </form>
</div>

<script>
    const maskCurrency = (valor, locale = 'pt-BR', currency = 'BRL') => {
        return new Intl.NumberFormat(locale, {
            style: 'currency',
            currency
        }).format(valor)
    }

    $(document).ready(function() {
        $('#value').on('input', function() {
            value = $(this).val().replace('.', '').replace(',', '').replace(/\D/g, '')

            if (!value) {
                $(this).val('0,00')
                return false
            }

            const result = new Intl.NumberFormat('pt-BR', {
                minimumFractionDigits: 2
            }).format(
                parseFloat(value) / 100
            )

            $(this).val(result)
        });
    })
</script>