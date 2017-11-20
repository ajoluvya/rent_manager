<h2><?php echo $title; ?></h2>

<div class="row">
	<div class="col-lg-8">
        <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
			<!-- Search form -->
			<form action="<?php echo current_url();?>" method="post">
				<div class="col-md-4"><input type="text" name="search" id="search" class="form-control" title="Search by bank or account name" placeholder="Search by house or estate"/></div>
				<div class="col-md-1"><input type="submit" value="Search" class="btn"/></div>
			</form>
		<table class="table table-striped table-condensed table-hover dataTables">
            <thead>
                <tr>
                    <th>Account number</th>
                    <th>Account name(s)</th>
                    <th>Bank</th>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
                    <th colspan="2">Action</th>
					<?php } ?>
                </tr>
            </thead>
            <tbody>
			<?php if(empty($accounts)): ?>
			<tr><td colspan="5">No accounts data in database</td></tr>
			<?php else:?>
			<?php foreach($accounts as $account): ?>
                <tr>
					<td><?php echo $account['acc_no']; ?></td>
					<td><?php echo $account['acc_name']; ?></td>
					<td><?php echo $account['bank_name']; ?> Bank</td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("account/del_acc/{$account['acc_id']}"); ?>" onclick="return confirm_delete('<?php echo "the account ".$account['acc_name'] . ", " . $account['acc_no']; ?>');" title="Delete"><span class="fa fa-trash"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("account/update/{$account['acc_id']}"); ?>" title='Update'><span class="fa fa-edit"></span></a>
					</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>
			<?php endif;?>
			</tbody>
		</table>
			<?php echo $pag_links; ?>
	</div>
	</div><!-- /.box -->
</div>