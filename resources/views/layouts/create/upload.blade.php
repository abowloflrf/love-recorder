<script src="{{asset('js/cos-js-sdk-v4.js')}}"></script>

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
    $(document).ready(function() {
        $('#file-upload').on('change', function(e) {
            //新建cos对象
            var cos = new CosCloud({
                appid: {{env('COS_APPID')}},// APPID 必填参数
                bucket: "{{env('COS_BUCKET')}}",//bucketName 必填参数
                region: 'sh',//地域信息 必填参数 华南地区填gz 华东填sh 华北填tj
                getAppSign: function (callback) {
                    //获取多次签名 必填参数
                    $.ajax({
                        url:'/getToken'
                    }).done(function (data) {
                        callback(data.sign_a);
                    });        
                },
                getAppSignOnce: function (callback) {
                    //单次签名，必填参数，参考上面的注释即可
                    $.ajax({
                        url:'/getToken',
                        data:{file: e.target.files[0].name}
                    }).done(function(data){
                        callback(data.sign_b);
                    });
                }
            }); 
            //开始上传文件
            var successCallBack = function (result) {
                var path=result.data.resource_path;
                var upload_img=path.substring(24);
                $('#upload-img-input').val('https://loverecorder-1251779005.picsh.myqcloud.com'+upload_img);
                $('.img-thumbnail').attr('src','https://loverecorder-1251779005.picsh.myqcloud.com'+upload_img+'/thumb');
            };

            var errorCallBack = function (result) {
                alert(result.message);
            };

            var progressCallBack = function(curr){
                var progress = parseInt(curr * 100, 10);
                $('.progress-bar').css(
                    'width',
                    progress + '%'
                );
            };
            var file = e.target.files[0];
            $.ajax({
                url: "/getToken",
                data:{onlyid:1},
                })
                .done(function(data) {
                    var nextID=data.next_id;
                    var filepath="/record/"+nextID+"/"+file.name;
                    cos.uploadFile(successCallBack, errorCallBack, progressCallBack, "{{env('COS_BUCKET')}}", filepath, file, 1);
                }
            );
            
        });
    });
</script>