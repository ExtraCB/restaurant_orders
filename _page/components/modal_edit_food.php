<div class="">
    <a href="" class="btn btn-outline-secondary btn-rounded mb-4" data-bs-toggle="modal"
        data-bs-target="#modalLoginFormx<?= $fetch_food -> id_f ?>">Edit
        Food</a>
</div>
<form action="" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="modalLoginFormx<?= $fetch_food -> id_f ?>" data-bs-keyboard="false"
        data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit Food</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form ">
                        <input type="text" id="defaultForm-email" name="name" class="form-control validate"
                            value="<?= $fetch_food -> name_f ?>">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Name Food</label>
                    </div>
                    <div class="md-form ">
                        <input type="text" id="defaultForm-email" name="price" class="form-control validate"
                            value="<?= $fetch_food -> price_f ?>">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Price Food</label>
                    </div>
                    <div class="md-form ">
                        <input type="file" id="defaultForm-email" name="file" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Image Food</label>
                        <input type="hidden" name="fileold" value="<?= $fetch_food -> file_f ?>">
                        <input type="hidden" name="id_f" value="<?= $fetch_food -> id_f ?>">
                    </div>
                    <div class=" md-form ">
                        <select name=" type" id="" class="form-control">
                            <option value="" selected>Please Select Type Food</option>
                            <?php 
                                $db_new = new database();
                                $db_new -> select("type_foods","*");

                                while($type_food = $db_new -> query -> fetch_object()){
                        ?>
                            <option value="<?= $type_food -> id_ftype ?>"
                                <?= ( $type_food -> id_ftyp = $fetch_food -> type_f) ? "selected" : "" ?>>
                                <?= $type_food -> name_ftype ?>
                            </option>
                            <?php } ?>
                        </select>
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Type Food</label>
                    </div>
                </div>
                <div class="modal-footer px-4 d-flex justify-content-between">
                    <button class="btn btn-warning" name="edit">edit</button>
                    <?php if($fetch_food -> status_f == 0){ ?>
                    <button class="btn btn-success" name="active">Active</button>
                    <?php } else { ?>
                    <button class="btn btn-secondary" name="disabled">Disbaled</button>
                    <?php  }?>
                </div>
            </div>
        </div>
    </div>
</form>
</div>