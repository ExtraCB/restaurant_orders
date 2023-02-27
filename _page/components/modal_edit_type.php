<div class="">
    <a href="" class="btn btn-default btn-rounded mb-4" data-bs-toggle="modal"
        data-bs-target="#modalLoginForm<?= $type_food->id_ftype ?>">Edit</a>
</div>
<form action="" method="post">
    <div class="modal fade" id="modalLoginForm<?= $type_food->id_ftype ?>" data-bs-keyboard="false"
        data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit Type</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form ">
                        <input type="text" value="<?= $type_food -> name_ftype?>" id="defaultForm-email"
                            name="name_type" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Name Type</label>
                        <input type="hidden" name="id_type" value="<?=  $type_food -> id_ftype?>">
                    </div>
                </div>
                <div class="modal-footer px-4 d-flex justify-content-between">
                    <button class="btn btn-warning" name="edit">Edit</button>
                    <button class="btn btn-danger" name="delete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>