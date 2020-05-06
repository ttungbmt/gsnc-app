<div class="alert" style="border: 1px solid rgba(0, 188, 212, 0.52); background-color: white;">
    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
    <h6 class="alert-heading font-weight-semibold"><span class="badge bg-blue-400">1 </span>  Hướng dẫn</h6>
    <p> - Chọn Quy chuẩn tại menu thả xuống bên trái</p>
    <p> - Nhấn nút "TẢI FILE MẪU" để tải file excel mẫu về máy</p>
    <p> - Nhấn nút "CHOOSE FILE" để chọn file excel nhập dữ liệu</p>
    <p> - Nhấn nút "XEM TRƯỚC" để hiển thị giao diện xem và chỉnh sửa dữ liệu file excel</p>
    <p> - Nhấn nút "NHẬP DỮ LIỆU" để nhập dữ liệu trên trang hiện tại vào cơ sở dữ liệu</p>
    <p> - Nhấn nút "NHẬP TẤT CẢ" để nhập toàn bộ dữ liệu từ file excel vào cơ sở dữ liệu</p>
    <br>

    <h6 class="alert-heading font-weight-semibold"><span class="badge bg-blue-400">2 </span>  Format file excel mẫu</h6>
    <p> - Các cột bắt buộc phải có (Tên - mã): </p>
    <p style="margin-left: 2em">+ Quận/huyện - <b>maquan</b></p>
    <p style="margin-left: 2em">+ Phường/xã - <b>maphuong</b></p>
    <p style="margin-left: 2em">+ Địa chỉ lấy mẫu - <b>diachi</b></p>
    <p style="margin-left: 2em">+ Loại mẫu - <b>loaimau_id</b></p>
    <p style="margin-left: 2em">+ Ngày lấy mẫu - <b>ngaynhanmau</b></p>
    <p style="margin-left: 2em">+ Loại ô nhiễm - <b>onhiem_id</b></p>
    <p style="margin-left: 2em">+ Điện thoại - <b>dienthoai</b></p>
    <p style="margin-left: 2em">+ Website - <b>website</b></p>
    <p style="margin-left: 2em">+ Giới thiệu - <b>gioithieu</b></p>
    <p style="margin-left: 2em">+ Loại bệnh viện - <b>loaibv_id</b></p>
    <p style="margin-left: 2em">+ Mã mẫu - <b>mamau</b></p>
    <p style="margin-left: 2em">+ VS - <b>vs</b></p>
    <p style="margin-left: 2em">+ HL (XN) - <b>hl_xn</b></p>
    <p style="margin-left: 2em">+ HL (MT) - <b>hl_mt</b></p>
    <p style="margin-left: 2em">+ VS & HL - <b>hl_vs</b></p>
    <p style="margin-left: 2em">+ Lat - <b>lat</b></p>
    <p style="margin-left: 2em">+ Lng - <b>lng</b></p>

    <p> - Tên Quận/Huyện, Phường/Xã: </p>
    <p style="margin-left: 2em"> + Tên Quận/Huyện, Phường/Xã theo tiếng anh </p>
    <p style="margin-left: 2em"> + Tên Quận là số: 01, 02, ... 12</p>
    <p style="margin-left: 2em"> + Tên Quận/Huyện là chữ: THU DUC , BINH CHANH, ...</p>
    <p style="margin-left: 2em"> + Tên Phường/Xã là số: 01, 02,...</p>
    <p style="margin-left: 2em"> + Tên Phường/Xã là chữ: TAN THONG HOI, PHUOC HIEP,</p>
    <p> - Loại mẫu phải thuộc <a href="/admin/dm-maunc" target="_blank">danh sách</a></p>
    <p> - Loại ô nhiễm phải thuộc <a href="/admin/dm-onhiem" target="_blank">danh sách</a></p>
    <p> - Loại bệnh viện phải thuộc <a href="/admin/dm-loaibv" target="_blank">danh sách</a></p>
    <p> - Dòng mã bắt buộc là dòng thứ 4 và dữ liệu bắt đầu từ dòng thứ 5</p>

    <p> - Vui lòng kiểm tra lại để đảm bảo tên chỉ tiêu trùng với mã theo bảng dưới đây:</p>
    <br>
    <div id="table-qcvn">
        <h2>Danh sách chỉ tiêu của QCVN 28:210/BTNMT</h2>
        <table class="table-bordered" width="100%">
            <tr style="background: #29b6f6; color: #fff;">
                <th width="5%">STT</th>
                <th width="15%">Mã</th>
                <th>Tên chỉ tiêu</th>
            </tr>
           <!-- <?php /*foreach($dschitieu as $ma => $ten) : */?>
                <tr>
                    <td><?/*=!isset($stt) ? $stt = 1 : ++$stt*/?></td>
                    <td><?/*=$ma*/?></td>
                    <td><?/*=$ten*/?></td>
                </tr>
            --><?php /*endforeach; */?>
        </table>
    </div>
</div>