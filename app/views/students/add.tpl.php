<div class="container my-4"> <a href="<?= $router->generate('students-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2>Ajouter un étudiant</h2>
    <?php if (isset($errorList)) : ?>
        <?php foreach ($errorList as $error) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <form action="" method="POST" class="mt-5">
        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" value="">
        </div>
        <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" value="">
        </div>
        <div class="form-group">
            <label for="teacher">Prof</label>
            <select name="teacher_id" id="teacherId" class="form-control">
                <option value="0">-</option>
                <option value="1">Prénom Prof - Formateur PHP/MySQL</option>
                <option value="2">Prénom2 Prof2 - Formateur PHP/MySQL</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control">
                <option value="0">-</option>
                <option value="1">actif</option>
                <option value="2">désactivé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>