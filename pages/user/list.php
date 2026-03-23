<div class="container">
    <div class="d-flex justify-content-between">
        <h3>User List</h3>
        <a href="./?page=user/create" role="button" class="btn btn-success">
            Create New
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Options</th>
            </tr>
            <?php
            $users = getUsers();
            $count = 1;
            while ($row = $users->fetch_object()) {
                echo '<tr>
                            <td>' . $count . '</td>
                            <td>
                            <img src="' . ($row->photo ?? './assets/images/user.png') . '"
                                class="rounded img-thumbnail" style="max-width:200px"/>
                            </td>
                            <td>' . $row->name . '</td>
                            <td>
                                <a href="./?page=user/update&id=' . $row->id . '" 
                                role="button" class="btn btn-primary">
                                    Edit
                                </a>
                                <a href="./?page=user/delete&id=' . $row->id . '" 
                                role="button" class="btn btn-danger">
                                    Delete
                                </a>
                        </tr>';

                $count++;
            }
            ?>
        </table>
    </div>
</div>