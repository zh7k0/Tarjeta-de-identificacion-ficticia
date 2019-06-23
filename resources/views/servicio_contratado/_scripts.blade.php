<script>

$(document).ready(function (){
    $('.facturar').click(function (e){
        return;
        e.preventDefault();
        console.log('Prevented!!');
        console.log(this.href);
        $.ajax({
            url: this.href,
            method: 'post',
            data: {!! json_encode(['_token' =>  csrf_token()])!!},
            dataType: 'html',
            success : function(data){
                $('#iframe').html(data);
            },
            error : function(data){
                $('#iframe').html(data);
            }
        })
    })
})
</script>