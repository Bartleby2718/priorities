<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items page</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Simple CSS file to verify that it works -->
    <link rel="stylesheet" href="index.css" />
</head>

<body>
    <?php
    // Import functions
    require('item-db.php');

    // Get information from cookie
    $email = array_key_exists('email', $_COOKIE) ? $_COOKIE['email'] : 'email not found in cookie';
    $workspace_name = array_key_exists('workspace_name', $_COOKIE) ? $_COOKIE['workspace_name'] : 'workspace_name not found in cookie';
    $list_ID = array_key_exists('list_ID', $_COOKIE) ? $_COOKIE['list_ID'] : 'list_ID not found in cookie';

    echo 'email in the cookie: ', $email, '<br>';
    echo 'list_ID in the cookie: ', $list_ID, '<br>';

    echo '<br>';
    echo 'Show all items in a given list:', '<br>';
    $items = getItems($list_ID);
    ?>

    <h4>Items for List ID <?php echo $list_ID; ?></h4>
    <table class="table table-striped table-bordered" id="myTable">
        <!-- Headers -->
        <tr class="text-center">
            <th>Item ID</th>
            <th>Description</th>
            <th>Date Created</th>
            <th>Date Due (optional)</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <!-- Existing items -->
        <?php foreach ($items as $list) : ?>
        <tr>
            <form action="items-update.php" method="post">
                <td class="text-center">
                    <?php echo $list['item_ID']; ?>
                </td>
                <td>
                    <input type="text" name="description" value="<?php echo $list['description']; ?>" class="form-control" />
                </td>
                <td class="text-center">
                    <?php echo $list['date_time_created']; ?>
                </td>
                <td>
                    <!-- no due date -->
                    <?php if ($list['date_time_due'] === null) : ?>
                    <input type='date' name='date_time_due'>
                    <!-- has due date -->
                    <?php else :
                            $formatted_date = Date('Y-m-d', strtotime($list['date_time_due']));
                            echo
                                '<input type="date" name="date_time_due" value="',
                                $formatted_date,
                                '" class="form-control"';
                        endif; ?>
                </td>
                <td class="text-center">
                    <input type="hidden" name="item_ID" value="<?php echo $list['item_ID'] ?>" />
                    <input type="submit" value="Update" class="btn btn-info" />
                </td>
            </form>
            <td class="text-center">
                <form action="items-delete.php" method="post">
                    <input type="hidden" name="item_ID" value="<?php echo $list['item_ID'] ?>" />
                    <input type="submit" value="Remove" class="btn btn-danger" />
                </form>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#assignModal" data-item="<?php echo $list['item_ID']; ?>">Assign</button>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#unassignModal" data-item="<?php echo $list['item_ID']; ?>">Unassign</button>
            </td>
        </tr>
        <?php endforeach; ?>
        <!-- New item -->
        <form action="items-create.php" method="post">
            <tr>
                <td class="text-center">
                    <!-- "item_ID" is automatically added later.-->
                    Create a new item!
                </td>
                <td>
                    <input type="text" name="description" placeholder="What do you need to do?" class="form-control" required>
                </td>
                <td class="text-center">
                    <!-- "Date Created" is automatically added later.-->
                    -
                </td>
                <td>
                    <!-- TODO: Improve date widget later -->
                    <input type="date" name="date_time_due" class="form-control">
                </td>
                <td class="text-center">
                    <input type="hidden" name="list_ID" value="<?php echo $list_ID ?>" />
                    <input type="submit" value="Create" class="btn btn-primary" />
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
            </tr>
        </form>
    </table>

    <!-- Assign modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Assign this item to someone else!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="asd">
                </div>
                <form method="post" action="item-assign.php">
                    <div class="modal-body">
                        <div class="form-group" id="assign-form">
                            <label for="assignee-email" class="col-form-label">Add assignee:</label>
                            <input type="email" name="email" class="form-control" id="assignee-email">
                            <input type="hidden" name="item_ID" id="item-to-assign">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Assign Item" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Unassign modal -->
    <div class="modal fade" id="unassignModal" tabindex="-1" role="dialog" aria-labelledby="unassignModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unassignModalLabel">Who should be unassigned?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="item-unassign.php">
                    <div class="modal-body">
                        <div class="form-group" id="unassign-form">
                            <label for="assignee-email" class="col-form-label">Email of the person to unassign:</label>
                            <select name="email" id="assignees" class="form-control">
                            </select>
                            <input type="hidden" name="item_ID" id="item-to-unassign">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Unassign Item" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Assignment -->
    <script>
    $('#assignModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let item_ID = button.data('item');
        let modal = $(this)
        $('#item-to-assign').val(item_ID);
    })
    </script>

    <!-- Unassignment -->
    <script>
    $('#unassignModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let item_ID = button.data('item');
        let modal = $(this);
        jQuery.get("item-assignees.php", {
            'item_ID': item_ID,
        }, function(data, status) {
            $('#assignees').empty();
            $.each(data.assignments, function(i, record) {
                $('#assignees').append($('<option>', {
                    value: record.email,
                    text: record.email
                }));
            });
        });
        $('#item-to-unassign').val(item_ID);
    })
    </script>
</body>

</html>
