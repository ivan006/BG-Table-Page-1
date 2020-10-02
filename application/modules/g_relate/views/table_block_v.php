

<?php
if (isset($join)) {
  $editable_rows = $rows["visible"];
  $readable_rows = $join["rows"]["visible"];
  $data_endpoint = $join["data_endpoint"];
  $name["singular"] = $join["name"]["singular"];
} else {
  $editable_rows = $rows["visible"];
  $readable_rows = $rows["visible"];

}
?>

<?php
if (isset($name["type"])) {
  ?>
    <div class="row">
      <div class="col-md-12 mt-5">
        <h2 class="text-center">
          <?php echo $name["singular"]."_(".$name["type"].")"; ?>
        </h2>
        <hr style="background-color: black; color: black; height: 1px;">
      </div>
    </div>
  <?php
}
?>
<div class="row">
  <div class="col-md-12 mt-2">
    <!-- Add Records Modal -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#<?php echo $name["plural"]; ?>_exampleModal">
      Add Records
    </button>

    <!-- Modal -->
    <div class="modal fade" id="<?php echo $name["plural"]; ?>_exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="<?php echo $name["plural"]; ?>_exampleModalLabel">Add Records</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Add Records Form -->
            <form action="" method="post" id="<?php echo $name["plural"]; ?>_form">
              <?php
              foreach ($editable_rows as $key => $value) {
                if ($key !== "id") {
                  ?>
                  <div class="form-group">
                    <label for=""><?php echo $key; ?></label>
                    <input type="<?php echo $key; ?>" id="<?php echo $name["plural"]; ?>_<?php echo $key; ?>" class="form-control">
                  </div>
                  <?php
                }
              }
              ?>
              <!-- <div class="form-group"> -->
              <!-- <label for="">Name</label> -->
              <!-- <input type="text" id="<?php echo $name["plural"]; ?>_name" class="form-control"> -->
              <!-- </div> -->
              <!-- <div class="form-group"> -->
              <!-- <label for="">Event_children</label> -->
              <!-- <input type="event_children" id="<?php echo $name["plural"]; ?>_event_children" class="form-control"> -->
              <!-- </div> -->
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="<?php echo $name["plural"]; ?>_add">Add Records</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 mt-4">
    <div class="table-responsive">
      <table class="table" id="<?php echo $name["plural"]; ?>_records">
        <thead>
          <tr>
            <th>ID</th>
            <?php
            foreach ($readable_rows as $key => $value) {
              if ($key !== "id") {
                ?>
                <th><?php echo $key; ?></th>
                <?php
              }
            }
            ?>
            <!-- <th>Name</th> -->
            <!-- <th>Event_children</th> -->
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


<!-- Edit Record Modal -->
<div class="modal fade" id="<?php echo $name["plural"]; ?>_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo $name["plural"]; ?>_exampleModalLabel">Edit Record Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Edit Record Form -->
        <form action="" method="post" id="<?php echo $name["plural"]; ?>_edit_form">
          <input type="hidden" id="<?php echo $name["plural"]; ?>_edit_record_id" name="edit_record_id" value="">
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              ?>
              <div class="form-group">
                <label for=""><?php echo $key; ?></label>
                <input type="<?php echo $key; ?>" id="<?php echo $name["plural"]; ?>_edit_<?php echo $key; ?>" class="form-control">
              </div>
              <?php
            }
          }
          ?>
          <!-- <div class="form-group">
            <label for="">Name</label>
            <input type="text" id="<?php echo $name["plural"]; ?>_edit_name" class="form-control">
          </div>
          <div class="form-group">
            <label for="">Event_children</label>
            <input type="event_children" id="<?php echo $name["plural"]; ?>_edit_event_children" class="form-control">
          </div> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="<?php echo $name["plural"]; ?>_update">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Records -->
<script>
  $(document).on("click", "#<?php echo $name["plural"]; ?>_add", function(e){
    e.preventDefault();

    <?php
    foreach ($editable_rows as $key => $value) {
      if ($key !== "id") {
        ?>
        var <?php echo $key; ?> = $("#<?php echo $name["plural"]; ?>_<?php echo $key; ?>").val();
        <?php
      }
    }
    ?>
    // var name = $("#<?php echo $name["plural"]; ?>_name").val();
    // var event_children = $("#<?php echo $name["plural"]; ?>_event_children").val();

    // if (name == "")
    if (1 !== 1) {
      alert("Both field is required");
    }else{
      $.ajax({
        url: "<?php echo base_url(); ?>g_relate/api/table/t/<?php echo $name["plural"]; ?>/insert",
        type: "post",
        dataType: "json",
        data: {
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              ?>
              <?php echo $key; ?>: <?php echo $key; ?>,
              <?php
            }
          }
          ?>
          // name: name,
          // event_children: event_children
        },
        success: function(data){
          if (data.responce == "success") {
            $('#<?php echo $name["plural"]; ?>_records').DataTable().destroy();
            <?php echo $name["plural"]; ?>_fetch();
            $('#<?php echo $name["plural"]; ?>_exampleModal').modal('hide');
            toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }

        }
      });

      $("#<?php echo $name["plural"]; ?>_form")[0].reset();

    }

  });

  // Fetch Records

  function <?php echo $name["plural"]; ?>_fetch(){
    $.ajax({
      url: "<?php echo base_url(); ?>g_relate/api/table/t/<?php echo $name["plural"]; ?>/<?php echo $data_endpoint; ?>",
      type: "post",
      dataType: "json",
      success: function(data){
        if (data.responce == "success") {

          var i = "1";
          $('#<?php echo $name["plural"]; ?>_records').DataTable( {
            "data": data.posts,
            // "responsive": true,
            dom:
            "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
            'copy', 'excel', 'pdf'
            ],
            "columns": [
            { "render": function(){
              return a = i++;
            } },
            <?php
            foreach ($readable_rows as $key => $value) {
              if ($key !== "id") {
                ?>
                { "data": "<?php echo $key; ?>" },
                <?php
              }
            }
            ?>
            // { "data": "name" },
            // { "data": "event_children" },
            { "render": function ( data, type, row, meta ) {
              var a = `
              <a href="#" value="${row.id}" id="<?php echo $name["plural"]; ?>_del" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
              <a href="#" value="${row.id}" id="<?php echo $name["plural"]; ?>_edit" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
              <a href="/g_relate/record/t/<?php echo $name["plural"]; ?>/r/${row.id}" class="btn btn-sm btn-outline-primary">View</a>
              `;
              return a;
            } }
            ]
          } );
        }else{
          toastr["error"](data.message);
        }

      }
    });

  }

  <?php echo $name["plural"]; ?>_fetch();

  // Delete Record

  $(document).on("click", "#<?php echo $name["plural"]; ?>_del", function(e){
    e.preventDefault();

    var del_id = $(this).attr("value");

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger mr-2'
      },
      buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {

        $.ajax({
          url: "<?php echo base_url(); ?>g_relate/api/table/t/<?php echo $name["plural"]; ?>/delete",
          type: "post",
          dataType: "json",
          data: {
            del_id: del_id
          },
          success: function(data){
            if (data.responce == "success") {
              $('#<?php echo $name["plural"]; ?>_records').DataTable().destroy();
              <?php echo $name["plural"]; ?>_fetch();
              swalWithBootstrapButtons.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
              );
            }else{
              swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your imaginary file is safe :)',
              'error'
              );
            }

          }
        });



      } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
        'Cancelled',
        'Your imaginary file is safe :)',
        'error'
        )
      }
    });

  });

  // Edit Record

  $(document).on("click", "#<?php echo $name["plural"]; ?>_edit", function(e){
    e.preventDefault();

    var edit_id = $(this).attr("value");

    $.ajax({
      url: "<?php echo base_url(); ?>g_relate/api/table/t/<?php echo $name["plural"]; ?>/edit",
      type: "post",
      dataType: "json",
      data: {
        edit_id: edit_id
      },
      success: function(data){
        if (data.responce == "success") {
          $('#<?php echo $name["plural"]; ?>_edit_modal').modal('show');
          $("#<?php echo $name["plural"]; ?>_edit_record_id").val(data.post.id);
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              ?>
              $("#<?php echo $name["plural"]; ?>_edit_<?php echo $key; ?>").val(data.post.<?php echo $key; ?>);
              <?php
            }
          }
          ?>
          // $("#<?php echo $name["plural"]; ?>_edit_name").val(data.post.name);
          // $("#<?php echo $name["plural"]; ?>_edit_event_children").val(data.post.event_children);
        }else{
          toastr["error"](data.message);
        }
      }
    });

  });

  // Update Record

  $(document).on("click", "#<?php echo $name["plural"]; ?>_update", function(e){
    e.preventDefault();

    var edit_record_id = $("#<?php echo $name["plural"]; ?>_edit_record_id").val();
    <?php
    foreach ($editable_rows as $key => $value) {
      if ($key !== "id") {
        ?>
        var edit_<?php echo $key; ?> = $("#<?php echo $name["plural"]; ?>_edit_<?php echo $key; ?>").val();
        <?php
      }
    }
    ?>

    // var edit_name = $("#<?php echo $name["plural"]; ?>_edit_name").val();
    // var edit_event_children = $("#<?php echo $name["plural"]; ?>_edit_event_children").val();

    // if (edit_record_id == "" || edit_name == "")
    if (1 !== 1) {
      alert("Both field is required");
    }else{
      $.ajax({
        url: "<?php echo base_url(); ?>g_relate/api/table/t/<?php echo $name["plural"]; ?>/update",
        type: "post",
        dataType: "json",
        data: {
          edit_record_id: edit_record_id,
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              ?>
              edit_<?php echo $key; ?>: edit_<?php echo $key; ?>,
              <?php
            }
          }
          ?>
          // edit_name: edit_name,
          // edit_event_children: edit_event_children
        },
        success: function(data){
          if (data.responce == "success") {
            $('#<?php echo $name["plural"]; ?>_records').DataTable().destroy();
            <?php echo $name["plural"]; ?>_fetch();
            $('#<?php echo $name["plural"]; ?>_edit_modal').modal('hide');
            toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }
        }
      });

    }

  });
</script>
