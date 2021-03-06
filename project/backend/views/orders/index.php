<form method="GET" action="">
    <div class="row filter__form--by-member">
        <div class="form-group col-md-4">
            <label for="order-id">Mã đơn hàng</label>
            <input type="number" min="0" name="order_id" id="order-id"
                   value="<?php echo isset($_GET['order_id']) ? $_GET['order_id'] : '' ?>" class="form-control"/>
        </div>
        <div class="form-group col-md-4">
            <label for="product-name">Tên sản phẩm</label>
            <input type="text" name="product_name" id="product-name"
                   value="<?php echo isset($_GET['product_name']) ? $_GET['product_name'] : '' ?>" class="form-control"/>
        </div>
        <div class="form-group col-md-4">
            <label for="customer-name">Tên khách hàng</label>
            <input type="text" name="customer_name" id="customer-name"
                   value="<?php echo isset($_GET['customer_name']) ? $_GET['customer_name'] : '' ?>" class="form-control"/>
        </div>
    </div>
    <input type="hidden" name="controller" value="order"/>
    <input type="hidden" name="action" value="index"/>
    <div class="form-group">
        <input type="submit" value="Tìm kiếm" name="search" class="btn btn-primary"/>
    </div>
</form>

<h2>Thống kê đơn hàng</h2>
<table id="orders-table" class="table table-bordered order-list-table">
    <thead>
    <tr>
        <th style="width: 4%">ID</th>
        <th style="width: 6%">Mã khách hàng</th>
        <th style="width: 10%">Tên khách hàng</th>
        <th>SĐT</th>
        <th>Địa chỉ</th>
        <th>Email</th>
        <th style="width: 12%">Tên sản phẩm</th>
        <th style="width: 6%;">Biến thể sản phẩm</th>
        <th style="width: 8%">Tổng tiền</th>
        <th style="width: 6%">Trạng thái đơn hàng</th>
        <th style="width: 14%">Ghi chú</th>
        <th style="width: 4%;">Amount</th>
        <th style="width: 6%">Phương thức thanh toán</th>
        <th style="width: 8%">Tạo lúc</th>
        <th style="width: 8%">Cập nhật lúc</th>
        <th style="width: 6%"></th>
    </tr>
    </thead>
    <?php if (!empty($orders)): ?>
        <tbody>
            <form class="form-orders" action="" method="post">
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id'] ?></td>
                    <td><?php echo $order['customer_id'] ?></td>
                    <td><?= $order['fullname']?></td>
                    <td><?= $order['phone_number']?></td>
                    <td><?= $order['address']?></td>
                    <td><?= $order['email']?></td>
                    <td><?= $order['product_name']?></td>
                    <td><?= strtoupper($order['value'])?></td>
                    <td><?php echo number_format($order['price_total']) ?>đ</td>
                    <td>
                        <?php
                        $status_text = 'Chờ xử lý';
                        $disabled_button = '';
                        if ($order['order_status'] == 1) {
                            $status_text = 'Đã xử lý';
                            $disabled_button = 'disabled="true"';
                        }
                        echo $status_text;
                        ?>
                    </td>
                    <td><?php echo $order['note'] ?></td>
                    <td><?= $order['amount']?></td>
                    <td><?= strtoupper($order['payment_methods'])?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
                    <td><?php echo !empty($order['updated_at']) ? date('d-m-Y H:i:s', strtotime($order['updated_at'])) : '' ?></td>
                    <?php
                    $url_delete = "index.php?controller=order&action=delete&id=".$order['id'];
                    $url_handle = "index.php?controller=order&action=handle&order_id=".$order['id'];

                    $disabled_member = '';
                    if (isset($_SESSION['manager'])) {
                        if ($_SESSION['manager']['level'] == 1) {
                            $disabled_member = 'class="hidden"';
                        }
                    }
                    ?>
                    <td>
                        <a href="<?= $url_handle?>" class="btn btn-outline-info btn__handle-orders" <?= $disabled_button?>>Xử lý</a>
                        <a <?= $disabled_member?> title="Xóa đơn hàng" href="<?= $url_delete?>" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')"><i
                                    class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </form>
        </tbody>
    <?php else: ?>
        <tr>
            <td colspan="10">Không tìm thấy dữ liệu</td>
        </tr>
    <?php endif; ?>
</table>