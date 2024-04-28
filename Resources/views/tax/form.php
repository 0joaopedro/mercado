<style>
    #value:invalid {
        border: solid red 3px;
    }
</style>

<div class="container col-3">
    <a href="/" class="btn btn-light mb-3">
        <i class="bi bi-arrow-bar-left"></i> Voltar
    </a>

    <form action="/tax/save" method="POST" class="bg-secondary p-2" style="border-radius:1rem;">
        <h4>Cadastro Imposto</h4>

        <?= isset($data->id) ? '<input type="hidden" name="id" value="' . $data->id . '">' : null ?>

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="<?= $data->name ?? null ?>" class="form-control" maxlength="50" required>
        </div>

        <label for="value">Percentual:</label>
        <div class="input-group">
            <input type="number" name="value" id="value" value="<?= $data->value ?? null ?>" class="form-control" step="0.01" max="100.00" min="0.01" required>
            <span class="input-group-text">%</span>
        </div>

        <button type="submit" class="btn btn-success mt-3" id="submit">
            <i class="bi bi-save"></i>
            Salvar
        </button>
    </form>
</div>