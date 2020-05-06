<div class="alert" style="border: 1px solid rgba(0, 188, 212, 0.52); background-color: white;">
    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
    <h6 class="alert-heading font-weight-semibold"><span class="badge bg-blue-400">1 </span>  Hướng dẫn</h6>
    <p> - Nhấn nút "TẢI FILE MẪU" để tải file excel mẫu về máy</p>
    <p> - Nhấn nút "CHOOSE FILE" để chọn file excel nhập dữ liệu</p>
    <p> - Nhấn nút "XEM TRƯỚC" để hiển thị giao diện xem và chỉnh sửa dữ liệu file excel</p>
    <p> - Nhấn nút "NHẬP DỮ LIỆU" để nhập dữ liệu trên trang hiện tại</p>
    <p> - Nhấn nút "NHẬP TẤT CẢ" để nhập toàn bộ dữ liệu từ file excel vào cơ sở dữ liệu</p>
    <br>

    <h6 class="alert-heading font-weight-semibold"><span class="badge bg-blue-400">2 </span>  Format file excel mẫu</h6>
    <p> - Các cột bắt buộc phải có (Tên - mã): </p>
    <p style="margin-left: 2em">+ Quận/huyện - <b>maquan</b></p>
    <p style="margin-left: 2em">+ Phường/xã - <b>maphuong</b></p>
    <p style="margin-left: 2em">+ Địa chỉ khảo sát - <b>diachi</b></p>
    <p style="margin-left: 2em">+ Họ tên chủ hộ - <b>tenchuho</b></p>
    <p style="margin-left: 2em">+ Ngày khảo sát - <b>ngaykhaosat</b></p>
    <p style="margin-left: 2em">+ Lat - <b>lat</b></p>
    <p style="margin-left: 2em">+ Lng - <b>lng</b></p>

    <p> - Tên Quận/Huyện, Phường/Xã: </p>
    <p style="margin-left: 2em"> + Tên Quận/Huyện, Phường/Xã theo tiếng anh </p>
    <p style="margin-left: 2em"> + Tên Quận là số: 01, 02, ... 12</p>
    <p style="margin-left: 2em"> + Tên Quận/Huyện là chữ: THU DUC , BINH CHANH, ...</p>
    <p style="margin-left: 2em"> + Tên Phường/Xã là số: 01, 02,...</p>
    <p style="margin-left: 2em"> + Tên Phường/Xã là chữ: TAN THONG HOI, PHUOC HIEP,</p>
    <p> - Dòng mã bắt buộc là dòng thứ 4 và dữ liệu bắt đầu từ dòng thứ 5</p>
    <p> - Vui lòng kiểm tra lại để đảm bảo tên ý kiến khảo sát trùng với id theo bảng dưới đây:</p>
    <br>
    <table class="table-bordered">
        <tr style="background: #29b6f6; color: #fff;">
            <th width="10%"></th>
            <th width="5%">ID</th>
            <th>Ý kiến khảo sát</th>
        </tr>
        <?php foreach($dsykiens as $id => $yk) : ?>
            <tr>
                <td><?='Ykien_'.$id?></td>
                <td><?=$id?></td>
                <td><?=$yk?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>