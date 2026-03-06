## Minecraft Bedrock Addons Manager

Đây là một công cụ giúp quản lý **addons cho Minecraft Bedrock Server** một cách dễ dàng. Nó cho phép xem thông tin addon, thêm hoặc xóa addon, sắp xếp thứ tự và xuất gói addon để sử dụng cho world.

> Hiện tại công cụ này đang trong quá trình xây dựng
>
> Bản cập nhật gần nhất: Ngày 6 tháng 3 năm 2026

## 🍀 Tính năng nổi bật

* Xem thông tin chi tiết của từng addon
* Thêm hoặc xóa addon nhanh chóng
* Sắp xếp thứ tự addon linh hoạt
* Xem thông tin các resource pack


## ⚙️ Cài đặt

### Yêu cầu

Trước khi sử dụng cần có:

* PHP
* Quyền sử dụng Terminal hoặc Command Prompt trong thư mục dự án


### Thiết lập

Tải mã nguồn:

```
git clone https://github.com/rintarytaziru/MinecraftMiniManager/
```

Sau đó mở file `configs.json` và chỉnh sửa cấu hình theo nhu cầu.


### Chạy server

Chạy lệnh sau trong thư mục dự án:

```
php -S 0.0.0.0:8080
```

Sau khi chạy xong, mở trình duyệt và truy cập:

```
http://localhost:8080
```


## Thêm Addon

Đặt các addon vào các thư mục sau:

```
./behavior_packs
./resource_packs
```


## Xuất gói addon

Chạy lệnh:

```
php ./api/package_export.php
```

Các file được xuất sẽ nằm trong thư mục:

```
exports/
```

Cấu trúc thư mục:

```
exports/
 ├─ behavior_packs/
 ├─ resource_packs/
 ├─ world_behavior_packs.json
 └─ world_resource_packs.json
```


## Sử dụng cho Minecraft Bedrock Server

Sau khi xuất xong, tải các thư mục và file này lên thư mục world của server Minecraft Bedrock. Thông thường đường dẫn sẽ là:

```
/container/worlds/Bedrock Dedicated/
```

Hoặc đường dẫn world tùy chỉnh mà máy chủ của bạn đang sử dụng.


## Lưu ý

Giao diện được tối ưu cho máy tính. Trên thiết bị di động có thể hiển thị không đầy đủ.


## Phiên bản

Index: **1.0.1 (beta)**


## Tài nguyên

* Icons: [https://www.flaticon.com/free-icon-font/](https://www.flaticon.com/free-icon-font/)
* Icons: [https://fonts.google.com/icons](https://fonts.google.com/icons)
* Notification: [https://www.jsdelivr.com/package/npm/notyf](https://www.jsdelivr.com/package/npm/notyf)
* UI Framework: [https://tailwindcss.com](https://tailwindcss.com)
