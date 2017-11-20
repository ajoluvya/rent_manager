		
        </section><!-- /.content -->
	</div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          All Rights reserved
        </div>
        <!-- Default to the left -->
        <strong><em>Copyright &copy; <?php echo mdate("%M, %Y");?></em> <a href="http://www.same.co.ug">SAME&reg; Estates Manager Ltd</a></strong>
      </footer>

      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
		<!-- Bootstrap Core JavaScript -->
		<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
		
		<!-- Metis Menu Plugin JavaScript -->
		<script type="text/javascript" src="<?php echo base_url("assets/js/metisMenu.min.js"); ?>"></script>
		<!-- AdminLTE App -->
		<script type="text/javascript" src="<?php echo base_url("assets/js/app.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/js/helpers.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-datepicker.js"); ?>"></script>
    <!-- DataTables -->
		<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.dataTables.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/js/dataTables.bootstrap.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/js/form-validator/jquery.form-validator.min.js"); ?>"></script>
		<script>
			$.validate();
			$('.datepicker').datepicker({
				format: 'dd-mm-yyyy',
				startDate: '-3d'
			});
		  $(document).ready(function () {
			  $('table.dynamicTables').DataTable({
					  "paging": true,
					  "lengthChange": true,
					  "searching": true,
					  "ordering": true,
					  "info": true,
					  "autoWidth": false
				});
			 });
		</script>
	</body>
</html>