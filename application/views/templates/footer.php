 <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Adol Software <?= date('Y',$user['date_created']); ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.buttons.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/buttons.print.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?= base_url(); ?>assets/js/demo/datatables-demo.js"></script>

  <script>
    $(document).ready(function() {
        var reportTable = $('#reportTable').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax": {
              "url": "<?= site_url('report/get_ajax_sale'); ?>",
              "type": "POST",
              "data": function(data){
                var from_date = $('.date_range_filter').val();
                var to_date = $('.date_range_filter2').val();

                data.searchByFromdate = from_date;
                data.searchByTodate = to_date;
              },
          },
          "columnDefs": [
            {
            "targets": [4,5],
            "className": 'text-right'
            },
            {
            "targets": [6],
            "className": 'text-center'
            }
          ],
            "dom": 'Bfrtip',
            "buttons": [
              {
                extend: 'print',
                footer: true,
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
              }
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                total = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Total over this page
                pageTotal = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $( api.column( 5 ).footer() ).html(
                    'Total Pembayaran: Rp. '+total
                );
            }
          });
          // var arrSalePrice = reportTable.column(1).data();
          // var arrSalePrice = reportTable.column(1, { page: 'current'}).data().reduce( function (a,b) { return a + b;});
          // var totalSalePrice = arrSalePrice.reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
          // console.log(arrSalePrice);

          // $("#reportTable tfoot").find('td').eq(5).text(arrSalePrice);
        });

        $(document).on('click', '#datesearch', function(){
          $('#reportTable').DataTable().destroy();
          $('#reportTable tbody').empty();
          // $('#reportTable tfoot').empty();

          $('#reportTable').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax": {
              "url": "<?= site_url('report/get_ajax_sale'); ?>",
              "type": "POST",
              "data": function(data){
                var from_date = $('.date_range_filter2').val();
                var to_date = $('.date_range_filter').val();

                data.searchByFromdate = from_date;
                data.searchByTodate = to_date;
              },
          },
          "columnDefs": [
            {
            "targets": [4,5],
            "className": 'text-right'
            },
            {
            "targets": [6],
            "className": 'text-center'
            }
          ],
            "dom": 'Bfrtip',
            "buttons": [
              {
                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                }
              }
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                total = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Total over this page
                pageTotal = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $( api.column( 5 ).footer() ).html(
                    // 'Total Pembayaran: '+pageTotal +' ( $'+ total +' total)'
                    'Total Pembayaran: Rp. '+total
                );
            }
          });
        });

        

    $('.custom-file-input').on('change',function(){
      let filename = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass('selected').html(filename);
    });

    $('.form-check-input').on('click',function(){
      const menuId = $(this).data('menu');
      const roleId = $(this).data('role');

      $.ajax({
        url: "<?= base_url('admin/changeaccess'); ?>",
        type: 'post',
        data: {
          menuId: menuId,
          roleId: roleId
        },
        success: function(){
          document.location.href = "<?= base_url('admin/roleaccess/'); ?>"+roleId
        }
      });
    });
  </script>

</body>

</html>
