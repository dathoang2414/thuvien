<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trả lại sách
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li>Giao dịch</li>
        <li class="active">Trả lại</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          ?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i> Lỗi!</h4>
                <ul>
                <?php
                  foreach($_SESSION['error'] as $error){
                    echo "
                      <li>".$error."</li>
                    ";
                  }
                ?>
                </ul>
            </div>
          <?php
          unset($_SESSION['error']);
        }

        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Thành công!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Trả lại</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Thời gian</th>
                  <th>Mã SV</th>
                  <th>Tên</th>
                  <th>Mã sách</th>
                  <th>Tiêu đề</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT *, students.student_id AS stud FROM returns LEFT JOIN students ON students.id=returns.student_id LEFT JOIN books ON books.id=returns.book_id ORDER BY date_return DESC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      if($row['status']){
                        $status = '<span class="label label-danger">Mượn</span>';
                      }
                      else{
                        $status = '<span class="label label-success">Trả lại</span>';
                      }
                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".date('M d, Y', strtotime($row['date_return']))."</td>
                          <td>".$row['stud']."</td>
                          <td>".$row['firstname'].' '.$row['lastname']."</td>
                          <td>".$row['isbn']."</td>
                          <td>".$row['title']."</td>
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/return_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
 function rem_select(){
    $('[name="isbn[]"]').change(function(){
      if($(this).val() == '<rem>'){
        $(this).closest('.form-group').remove()
      }
    })
  }
$(function(){
  $(document).on('click', '#append', function(e){
    e.preventDefault();
    var books = '<?php echo json_encode($brows) ?>';
    var _s = $('<select class="form-control" name="isbn[]"></select>')
    var _tmp = $('<div></div>')
    var option = '';
        option += '<option value="" selected disabled>Please Select Book here.</option>';
        option += '<option value="<rem>" >< remove select></option>';
        books = JSON.parse(books)
        if(books.length > 0){
          Object.keys(books).map(k=>{
            option  += '<option value="'+books[k].isbn+'">'+books[k].title+' ['+books[k].isbn+']'+'</option>'
          })
        }
        _s.append(option)
        _tmp.append(_s)
    
    // $('#append-div').append(
    //   '<div class="form-group"><label for="" class="col-sm-3 control-label">ISBN</label><div class="col-sm-9"><input type="text" class="form-control" name="isbn[]"></div></div>'
    // );
    $('#append-div').append(
      '<div class="form-group"><label for="" class="col-sm-3 control-label">ISBN</label><div class="col-sm-9">'+_tmp.html()+'</div></div>'
    );
    rem_select()
  });
});
</script>
</body>
</html>
