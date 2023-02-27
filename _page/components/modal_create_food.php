<div class="">
    <a href="" class="btn btn-outline-secondary btn-rounded mb-4" data-bs-toggle="modal"
        data-bs-target="#modalLoginFormx">Create
        Food</a>
</div>
<form action="" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="modalLoginFormx" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Create Food</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form ">
                        <input type="text" id="defaultForm-email" name="name" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Name Food</label>
                    </div>
                    <div class="md-form ">
                        <input type="text" id="defaultForm-email" name="price" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Price Food</label>
                    </div>
                    <div class="md-form ">
                        <input type="file" id="defaultForm-email" name="file" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Image Food</label>
                    </div>
                    <div class="md-form ">
                        <select name="type" id="" class="form-control">
                            <option value="" selected>Please Select Type Food</option>
                            <?php 
                                $db_new = new database();
                                $db_new -> select("type_foods","*");

                                while($type_food = $db_new -> query -> fetch_object()){
                        ?>
                            <option value="<?= $type_food -> id_ftype ?>"><?= $type_food -> name_ftype ?></option>
                            <?php } ?>
                        </select>
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Type Food</label>
                    </div>
                </div>
                <div class="modal-footer px-4 d-flex justify-content-between">
                    <button class="btn btn-warning" name="create">create</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>