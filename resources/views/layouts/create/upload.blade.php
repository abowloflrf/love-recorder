<script src="{{asset('js/jquery.ui.widget.js')}}"></script>
<script src="{{asset('js/jquery.fileupload.js')}}"></script>
<script src="{{asset('js/jquery.fileupload-process.js')}}"></script>
<script src="{{asset('js/jquery.fileupload-validate.js')}}"></script>

<div class="form-group">
    <label class="custom-file">
        <input type="file" id="file-upload" name="file" class="custom-file-input" accept="image/*" multiple>
        <span class="custom-file-control"></span>
    </label>
    <div class="progress mt-3">
        <div class="progress-bar" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <img src="{{asset('img/image.svg')}}" alt="upload" class="img-thumbnail mt-3 d-block" style="width:200px">
</div>

<script>
    $(function () {
        $('#file-upload').fileupload({
            url:'/records/create/upload-img',
            type:'POST',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 10000000,
            dataType: 'json',
            formData:{
                '_token':'{{csrf_token()}}'
            },
            done: function (e, data) {
                console.log(data);
                if(data.result.message=="SUCCESS"){
                    var upload_img=data.result.saveKey;
                    $('#upload-img-input').val('https://loverecorder-1251779005.image.myqcloud.com'+upload_img);
                    $('.img-thumbnail').attr('src','https://loverecorder-1251779005.image.myqcloud.com'+upload_img+'/thumb');
                }else{
                    alert("Upload failed!\n"+data.result.message);
                }

            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.progress-bar').css(
                    'width',
                    progress + '%'
                );
            },
            processfail: function (e, data) {
                alert(data.files[data.index].name + "\n" + data.files[data.index].error);
            }
        });
    });
</script>