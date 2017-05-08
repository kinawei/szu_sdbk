<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<div class="clearfix">
	<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('platform/stat-rule_search', TEMPLATE_INCLUDEPATH)) : (include template('platform/stat-rule_search', TEMPLATE_INCLUDEPATH));?>
		<h4 class="sub-title">详细数据</h4>
		<form action="" method="post" onsubmit="">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>规则名称<i></i></th>
						<th style="width:160px;">模块<i></i></th>
						<th style="width:150px;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($list)) { foreach($list as $row) { ?>
					<tr>
						<td class="row-hover row-first">
							<?php  if(empty($row['id'])) { ?>
								N/A
							<?php  } else { ?>
								<a target="main" href="<?php  echo $row['url'];?>"><?php  echo $row['name'];?></a>
							<?php  } ?>
						</td>
						<td><?php  echo $row['module'];?></td>
						<td>
							<a target="main" href="<?php  echo url('platform/stat/trend', array('id' => $row['id']))?>">使用率走势</a>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
			</table>
		</div>
		</form>
		<?php  echo $pager;?>
	</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
