<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>

  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.10.22/b-1.6.4/sl-1.3.1/datatables.min.css"/>
  <link rel="stylesheet" type="text/css" href="Editor-1.9.5/css/editor.dataTables.css">
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.10.22/b-1.6.4/sl-1.3.1/datatables.min.js"></script>
  <script type="text/javascript" src="Editor-1.9.5/js/dataTables.editor.js"></script> -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />


</head>
<body>

  <div class="container box">
    <h3 align="center"></h3><br />
    <div class="table-responsive">
      <br />
      <table id="user_data" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="">event_children</th>
            <th width="">name</th>
            <th width="">Edit</th>
            <th width="10%">Delete</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <script type="text/javascript" language="javascript" >
  $(document).ready(function(){
    var dataTable = $('#user_data').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url() . 'webslesson/api'; ?>",
        type:"POST"
      },
      "columnDefs":[
      {
        "targets":[0, 3],
        "orderable":false,
      },
      ],
    });
  });
</script>


</body>
</html>
