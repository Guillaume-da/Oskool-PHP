<div class="container">
<a href="<?= $router->generate('students-add') ?>" class="btn btn-success float-right">Ajouter</a>
<table class="table table-hover mt-4">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Prénom</th>
            <th scope="col">Nom</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $currentStudent) : ?>
        <tr>
            <th scope="row"><?= $currentStudent->getId() ?></th>
            <td><?= $currentStudent->getFirstname() ?></td>
            <td><?= $currentStudent->getLastname() ?></td>
            <td><?= $currentStudent->getStatus() ?></td>
            <td class="text-right">
                <a href="<?=$router->generate('students-update', ['student_id'=>$currentStudent->getId()]) ?>" class="btn btn-sm btn-warning">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=$router->generate('student-delete', ['student_id'=>$currentStudent->getId()]) ?>">Oui, je veux supprimer</a>
                        <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
</div>