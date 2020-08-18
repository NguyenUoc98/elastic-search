# Elastic Search

## Cài đặt ElasticSeach

* Download elasticsearch tại: [https://www.elastic.co/fr/downloads/elasticsearch](https://www.elastic.co/fr/downloads/elasticsearch)
* Chạy file elasticsearch.exe đường dẫn C:\Program Files\Elastic\Elasticsearch\7.8.1\bin để khởi chạy server
* Truy cập 127.0.0.1:9200 kiểm tra cấu hình server

## Thư viện Elastic Scout Driver

* composer require babenkoivan/elastic-scout-driver
* Basic use:
    - Tìm thông tin dưới dạng collection sắp xếp theo điểm: $users = Test::search('description:' . $key)->get()
    - Thông tin truyền vào hàm search sử dụng [mini-language syntax](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html#query-string-syntax)
    - Lấy thông tin tìm kiếm được dưới dạng thô: $users = Test::search('description:' . $key)->raw()
    - Tìm kiếm nâng cao sử dụng thêm [Elastic Scout Driver Plus](https://github.com/babenkoivan/elastic-scout-driver-plus):

        $users = Test::rawSearch()
            ->query(['match' => ['description' => $key]])
            ->size(5)
            ->execute()

# Lấy html source và dịch, lấy thông tin bảng kĩ thuật trang web tiếng trung

## Dịch

* Tạo Gtranslate Model: 

Sử dụng curl tạo request lên https://translate.google.com/m để dịch và lấy dữ liệu trả về. Lấy nội dung đã dịch trong thẻ class="t0" trong response.

## Dịch html source

- Dùng file_get_contents lấy nội dung html
- Chuyển nội dung từ GB2312 sang mã UTF-8
- Kiểm tra mỗi dòng nếu có chữ tiếng trung thì dịch dòng đó

## Lấy thông tin bảng thông số kỹ thuật

Sử dụng [PHP Simple HTML DOM Parser](https://sourceforge.net/projects/simplehtmldom/) để bóc tách dữ liệu theo các thẻ html.
- Lấy nội dung html của class="InforBox" (nội dung bảng thông số)
- Gửi request dịch và chuyển respone sang dịnh dạng html do các ký tự html bị dịch thành mã.
- Tách các thẻ <p> trong réponse và lưu vào mảng.
- return json_encode mảng kết quả.