<div class="container col-3">
    <a href="/" class="btn btn-light mb-3">
        <i class="bi bi-arrow-bar-left"></i> Voltar
    </a>

    <form action="/product-type/save" method="POST" class="bg-secondary p-2" style="border-radius:1rem;">
        <h4>Cadastro de Tipo de Produto</h4>

        <?= isset($data['productType']->id) ? '<input type="hidden" name="id" value="' . $data['productType']->id . '">' : null ?>

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="<?= $data['productType']->name ?? null ?>" class="form-control" maxlength="50" required>
        </div>

        <?php foreach ($data['taxes']->rows as $tax) : ?>
            <div class="custom-control p-1">
            </div>
            <div class="form-check">
                <input type="checkbox" name="taxes[][<?= $tax->id ?>]" id="taxes_<?= $tax->id ?>" <?= isset($tax->checked) ? 'checked' : null ?> class="form-check-input">
                <label class="form-check-label" for="taxes_<?= $tax->id ?>">
                    <?= $tax->name . ' - ' . $tax->value ?>%
                </label>
            </div>
        <?php endforeach; ?>

        <div id="container-inputs"></div>

        <button type="submit" class="btn btn-success mt-1" id="submit">
            <i class="bi bi-save"></i>
            Salvar
        </button>
    </form>
</div>