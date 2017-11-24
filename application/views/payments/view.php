          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-house"></i> <?php echo $house['estate_name']; ?>
                <small class="pull-right">Date: <?php echo mdate("%d/%M/%Y");?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <address>
                <strong> <?php echo $house['estate_name']; ?></strong><br/>
                <?php echo $house['address']; ?><br>
                Phone: <?php echo $house['phone']; ?><br>
                Phone: <?php echo isset($tenant['phone2'])?$house['phone2']:""; ?><br>
                Email: info@sameestates.com
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <strong>Customer:</strong>
              <address>
                <strong><?php echo $tenant[0]['names']; ?></strong><br>
                <?php echo $tenant[0]['home_address']; ?><br>
                Phone: <?php echo $tenant[0]['phone1']; ?><?php echo isset($tenant['phone2'])?", " . $tenant['phone2']:""; ?><br>
                Email: <?php echo $tenant[0]['names']; ?>@sameestates.com
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>Payment Receipt #000<?php echo $payment['payment_id']; ?></b><br>
              <br>
              <b>House No:</b> <?php echo $tenant[0]['house_no']; ?><br>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                  <tr>
                    <th>Towards payment of:</th>
                    <td><?php echo $payment['particulars']; ?></td>
                  </tr>
                  <tr>
                    <th>Amount paid:</th>
                    <td>UGX <?php echo number_format($payment['amount']); ?></td>
                  </tr>
                  <tr>
                    <th>Payment Date:</th>
                    <td><?php echo mdate("%d/%M/%Y", $payment['payment_date']); ?></td>
                  </tr>
                  <tr>
                    <th>Received By:</th>
                    <td><?php echo $staff_detail['fname']; ?> <?php echo $staff_detail['lname']; ?></td>
                  </tr>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="javascript:window.print()" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
              <a href="<?php echo site_url("payment/pdf/{$payment['payment_id']}"); ?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</a>
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
