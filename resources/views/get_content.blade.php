@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/21.0.0/classic/ckeditor.js"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Get Content</div>

                <div class="card-body text-center">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form class="form-inline d-flex justify-content-center" action="{{ route('get-content') }}">
                        <div class="form-group mx-sm-3 mb-2 w-100">
                            <input type="text" class="form-control w-100 mt-2" id="inputUrl" name="url" value="{{ old('url') }}" placeholder="Nhập url">

                            <select class="form-control mt-2 mx-auto" id="type" name="type">
                                <option value="parameter">Thông số kĩ thuật</option>
                                <option value="content">Nội dung bài viết</option>
                            </select>

                            <select class="form-control mt-2 mx-auto" id="html-tag" name="html_tag">
                                <option value="div">{{ '<div>' }}</option>
                                <option value="table">{{ '<table>' }}</option>
                                <option value="ul">{{ '<ul>' }}</option>
                                <option value="p">{{ '<p>' }}</option>
                                <option value="unknown">Chưa biết</option>
                            </select>

                            <select class="form-control mx-auto mt-2" id="name-tag" name="name_tag">
                                <option value="class">Class</option>
                                <option value="id">Id</option>
                            </select>

                            <input type="text" class="form-control mt-2 mx-auto" id="inputName" name="name" value="{{ old('name') }}" placeholder="Tên">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Get content</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 mt-4">
            <div class="card p-3">
                <div id="posts"></div>
            </div>
        </div>

        @if(isset($result) && count($result) != 0)
        <div class="col-md-8 mt-4">
            <div class="card p-3">
                <h3>THÔNG TIN KỸ THUẬT</h3>
                <table class="table table-bordered">
                    <tbody>
                        @foreach($result as $field => $param)
                        <tr>
                            <th scope="row">{{ $field }}</th>
                            <td>{{ $param }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if(isset($content))
        <div class="col-md-8 mt-4">
            <div class="card p-3">
                <h3>Nội dung lấy được</h3>
                <div id="editor">
                    {!! $content !!}
                </div>
                <a id="push-post" class="btn btn-primary mb-2 ml-2">Đăng bài viết</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

<script type="text/javascript">
    let editor;
    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>

@if(isset($content))
<script type="text/javascript">
    $(document).ready(function() {
        $('#push-post').click(function() {
            $.ajax({
                method: "POST",
                url: 'http://wordpress.test.vn/wp-json/wp/v2/posts',
                data: {
                    title: '{{ $title }}',
                    content: '{{ $content }}',
                    type: 'post',
                    status: 'publish',
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Basic ' + "{{ base64_encode('bitran:uocnv1998') }}");
                },
                success: function(response) {
                    alert('Đã đăng bài: ' + response.link);
                },
                error: function(request, status, error) {
                    alert(error);
                }
            });
        });
    });
</script>
@endif